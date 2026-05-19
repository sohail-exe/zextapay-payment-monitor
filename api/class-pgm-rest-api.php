<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class ZextaPay_REST_API {

    public static function init() {
        add_action( 'rest_api_init', [ __CLASS__, 'register_routes' ] );
    }

    public static function register_routes() {
        $namespace = 'zextapay/v1';

        register_rest_route( $namespace, '/stats', [
            'methods'             => 'GET',
            'callback'            => [ __CLASS__, 'get_stats' ],
            'permission_callback' => [ __CLASS__, 'check_permission' ],
        ] );

        register_rest_route( $namespace, '/logs', [
            'methods'             => 'GET',
            'callback'            => [ __CLASS__, 'get_logs' ],
            'permission_callback' => [ __CLASS__, 'check_permission' ],
        ] );

        register_rest_route( $namespace, '/settings', [
            'methods'             => 'GET',
            'callback'            => [ __CLASS__, 'get_settings' ],
            'permission_callback' => [ __CLASS__, 'check_permission' ],
        ] );

        register_rest_route( $namespace, '/settings', [
            'methods'             => 'POST',
            'callback'            => [ __CLASS__, 'update_settings' ],
            'permission_callback' => [ __CLASS__, 'check_permission' ],
        ] );
    }

    public static function check_permission() {
        return current_user_can( 'manage_woocommerce' );
    }

    public static function get_stats() {
        global $wpdb;

        $stats = get_transient( 'zextapay_dashboard_stats' );

        if ( false === $stats ) {
            $total_failures = $wpdb->get_var( $wpdb->prepare( // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
                "SELECT COUNT(*) FROM {$wpdb->prefix}zextapay_transaction_logs WHERE status = %s",
                'failed'
            ) );
            $total_success = $wpdb->get_var( $wpdb->prepare( // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
                "SELECT COUNT(*) FROM {$wpdb->prefix}zextapay_transaction_logs WHERE status = %s",
                'success'
            ) );
            $revenue_at_risk = $wpdb->get_var( $wpdb->prepare( // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
                "SELECT SUM(order_total) FROM {$wpdb->prefix}zextapay_transaction_logs WHERE status = %s",
                'failed'
            ) );
            $recoverable_revenue = $wpdb->get_var( $wpdb->prepare( // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
                "SELECT SUM(order_total) FROM {$wpdb->prefix}zextapay_transaction_logs WHERE status = %s AND error_type = %s",
                'failed',
                'system_error'
            ) );

            $stats = [
                'total_failures'      => (int) $total_failures,
                'total_success'       => (int) $total_success,
                'revenue_at_risk'     => (float) ( $revenue_at_risk ?: 0 ),
                'recoverable_revenue' => (float) ( $recoverable_revenue ?: 0 ),
            ];

            set_transient( 'zextapay_dashboard_stats', $stats, 5 * MINUTE_IN_SECONDS );
        }

        return new WP_REST_Response( $stats, 200 );
    }

    public static function get_logs() {
        global $wpdb;

        $logs = get_transient( 'zextapay_recent_logs' );

        if ( false === $logs ) {
            $logs = $wpdb->get_results( // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
                "SELECT * FROM {$wpdb->prefix}zextapay_transaction_logs ORDER BY created_at DESC LIMIT 20",
                ARRAY_A
            );
            set_transient( 'zextapay_recent_logs', $logs, 1 * MINUTE_IN_SECONDS );
        }

        return new WP_REST_Response( $logs, 200 );
    }

    public static function get_settings() {
        return new WP_REST_Response( [
            'plan'            => 'free',
            'primary_gateway' => get_option( 'zextapay_primary_gateway', '' ),
            'backup_gateway'  => get_option( 'zextapay_backup_gateway', '' ),
        ], 200 );
    }

    public static function update_settings( $request ) {
        $params = $request->get_json_params();
        if ( ! $params ) {
            $params = $request->get_params();
        }

        $fields = [ 'primary_gateway', 'backup_gateway' ];

        foreach ( $fields as $field ) {
            if ( isset( $params[ $field ] ) ) {
                update_option( 'zextapay_' . $field, sanitize_text_field( $params[ $field ] ) );
            }
        }

        return new WP_REST_Response( [ 'success' => true ], 200 );
    }
}