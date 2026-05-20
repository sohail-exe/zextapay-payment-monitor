<?php
/**
 * Plugin Name: ZextaPay Payment Monitor for WooCommerce
 * Plugin URI: https://github.com/sohail-exe/zextapay-payment-monitor
 * Description: Real-time payment gateway monitor for WooCommerce.
 * Version: 1.0.1
 * Author: sultan1515
 * License: GPLv2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: zextapay-payment-monitor
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

define( 'ZEXTAPAY_PLUGIN_FILE', __FILE__ );
define( 'ZEXTAPAY_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'ZEXTAPAY_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'ZEXTAPAY_VERSION', '1.0.1' );
define( 'ZEXTAPAY_DB_VERSION', '1.0.0' );

if ( ! function_exists( 'zextapay_fs' ) ) {
    function zextapay_fs() {
        global $zextapay_fs;

        if ( ! isset( $zextapay_fs ) ) {
            if ( file_exists( dirname( __FILE__ ) . '/includes/freemius/start.php' ) ) {
                require_once dirname( __FILE__ ) . '/includes/freemius/start.php';
                $zextapay_fs = fs_dynamic_init( [
                    'id'               => 'YOUR_REAL_ID',
                    'slug'             => 'zextapay-payment-monitor',
                    'type'             => 'plugin',
                    'public_key'       => 'pk_YOUR_REAL_KEY',
                    'is_premium'       => false,
                    'is_org_compliant' => true,
                    'menu'             => [
                        'slug'    => 'zextapay-payment-monitor',
                        'contact' => false,
                        'support' => false,
                    ],
                ] );
            }
        }
        return $zextapay_fs;
    }
    zextapay_fs();
    do_action( 'zextapay_fs_loaded' );
}

require_once ZEXTAPAY_PLUGIN_DIR . 'includes/class-pgm-core.php';

function zextapay_init() {
    $instance = ZextaPay_Core::get_instance();
    $instance->init();
}
add_action( 'plugins_loaded', 'zextapay_init' );

register_activation_hook( __FILE__, 'zextapay_activate' );
function zextapay_activate() {
    require_once ZEXTAPAY_PLUGIN_DIR . 'includes/class-pgm-database.php';
    ZextaPay_Database::create_tables();
}
