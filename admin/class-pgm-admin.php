<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class ZextaPay_Admin {

    public static function init() {
        add_action( 'admin_menu', [ __CLASS__, 'add_menu' ] );
        add_action( 'admin_enqueue_scripts', [ __CLASS__, 'enqueue_scripts' ] );
    }

    public static function add_menu() {
        add_menu_page(
            'ZextaPay',
            'ZextaPay',
            'manage_woocommerce',
            'zextapay-payment-monitor',
            [ __CLASS__, 'render_dashboard' ],
            'dashicons-shield',
            56
        );
    }

    public static function enqueue_scripts( $hook ) {
        if ( 'toplevel_page_zextapay-payment-monitor' !== $hook ) {
            return;
        }

        $asset_file_path = ZEXTAPAY_PLUGIN_DIR . 'build/index.asset.php';
        $dependencies    = [ 'wp-element', 'wp-components' ];
        $version         = ZEXTAPAY_VERSION;

        if ( file_exists( $asset_file_path ) ) {
            $asset_file   = include $asset_file_path;
            $dependencies = $asset_file['dependencies'];
            $version      = $asset_file['version'];
        }

        wp_enqueue_script(
            'zextapay-dashboard',
            ZEXTAPAY_PLUGIN_URL . 'build/index.js',
            $dependencies,
            $version,
            true
        );

        wp_enqueue_style(
            'zextapay-dashboard-style',
            ZEXTAPAY_PLUGIN_URL . 'build/index.css',
            [ 'wp-components' ],
            $version
        );

        wp_localize_script( 'zextapay-dashboard', 'zextapayData', [
            'apiUrl'          => esc_url_raw( rest_url( 'zextapay/v1' ) ),
            'nonce'           => wp_create_nonce( 'wp_rest' ),
            'currency_code'   => get_woocommerce_currency(),
            'currency_symbol' => get_woocommerce_currency_symbol(),
            'plan'            => 'free',
            'gates'           => [
                'can_use_failover'   => false,
                'can_use_multisite'  => false,
                'can_use_alerts'     => false,
                'log_retention_days' => 7,
            ],
        ] );
    }

    public static function render_dashboard() {
        require_once ZEXTAPAY_PLUGIN_DIR . 'admin/views/dashboard.php';
    }
}