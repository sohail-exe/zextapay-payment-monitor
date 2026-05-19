<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class ZextaPay_Core {

    private static $instance = null;

    public static function get_instance() {
        if ( is_null( self::$instance ) ) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
        $this->load_dependencies();
    }

    private function load_dependencies() {
        require_once ZEXTAPAY_PLUGIN_DIR . 'includes/class-pgm-database.php';
        require_once ZEXTAPAY_PLUGIN_DIR . 'includes/class-pgm-error-parser.php';
        require_once ZEXTAPAY_PLUGIN_DIR . 'api/class-pgm-rest-api.php';
        require_once ZEXTAPAY_PLUGIN_DIR . 'admin/class-pgm-admin.php';
    }

    public function init() {
        add_action( 'woocommerce_payment_complete', [ $this, 'handle_successful_payment' ] );
        add_action( 'woocommerce_order_status_failed', [ $this, 'handle_failed_payment' ], 10, 2 );

        if ( ! wp_next_scheduled( 'zextapay_daily_pruning' ) ) {
            wp_schedule_event( time(), 'daily', 'zextapay_daily_pruning' );
        }
        add_action( 'zextapay_daily_pruning', [ 'ZextaPay_Database', 'prune_logs' ] );

        ZextaPay_REST_API::init();
        ZextaPay_Admin::init();
    }

    public function handle_successful_payment( $order_id ) {
        $order = wc_get_order( $order_id );
        if ( ! $order ) return;

        $log_data = [
            'order_id'         => $order_id,
            'gateway_id'       => $order->get_payment_method(),
            'status'           => 'success',
            'error_type'       => null,
            'error_code'       => null,
            'error_message'    => null,
            'order_total'      => $order->get_total(),
            'customer_country' => $order->get_billing_country(),
        ];
        ZextaPay_Database::log_transaction( $log_data );
    }

    public function handle_failed_payment( $order_id, $order = null ) {
        if ( ! $order ) {
            $order = wc_get_order( $order_id );
        }
        if ( ! $order ) return;

        $gateway_id    = $order->get_payment_method();
        $error_message = 'Payment failed during checkout.';
        $error_code    = 'unknown_failure';

        $notes = wc_get_order_notes( [ 'order_id' => $order_id, 'limit' => 1 ] );
        if ( ! empty( $notes ) ) {
            $error_message = $notes[0]->content;
            if ( stripos( $error_message, 'declined' ) !== false ) $error_code = 'card_declined';
            if ( stripos( $error_message, 'expired' ) !== false )  $error_code = 'expired_card';
            if ( stripos( $error_message, 'funds' ) !== false )    $error_code = 'insufficient_funds';
        }

        $error_type = ( in_array( $error_code, [ 'card_declined', 'expired_card', 'insufficient_funds' ] ) )
            ? 'customer_error'
            : 'system_error';

        $log_data = [
            'order_id'         => $order_id,
            'gateway_id'       => $gateway_id,
            'status'           => 'failed',
            'error_type'       => $error_type,
            'error_code'       => $error_code,
            'error_message'    => $error_message,
            'order_total'      => $order->get_total(),
            'customer_country' => $order->get_billing_country(),
        ];
        ZextaPay_Database::log_transaction( $log_data );
    }
}