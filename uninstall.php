<?php
/**
 * ZextaPay Uninstall
 *
 * This file is called when the plugin is deleted from the WordPress admin.
 */

if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
    exit;
}

// Clean up options
delete_option( 'zextapay_primary_gateway' );
delete_option( 'zextapay_backup_gateway' );
delete_option( 'zextapay_db_version' );

// Delete database tables
global $wpdb;
$wpdb->query( "DROP TABLE IF EXISTS {$wpdb->prefix}zextapay_transaction_logs" ); // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching, WordPress.DB.DirectDatabaseQuery.SchemaChange

// Clear transients
$zextapay_transients = [
    'zextapay_dashboard_stats',
    'zextapay_recent_logs',
    'zextapay_last_hour_stats',
];

foreach ( $zextapay_transients as $zextapay_transient ) {
    delete_transient( $zextapay_transient );
    wp_cache_delete( $zextapay_transient, 'transient' );
}

if ( function_exists( 'wp_cache_flush' ) ) {
    wp_cache_flush();
}