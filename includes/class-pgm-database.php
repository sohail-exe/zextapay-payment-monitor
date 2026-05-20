<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class ZextaPay_Database {

    public static function create_tables() {
        global $wpdb;

        if ( get_option( 'zextapay_db_version' ) === ZEXTAPAY_DB_VERSION ) {
            return;
        }

        $charset_collate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE {$wpdb->prefix}zextapay_transaction_logs (
            id bigint(20) NOT NULL AUTO_INCREMENT,
            order_id bigint(20) NOT NULL,
            gateway_id varchar(50) NOT NULL,
            status varchar(20) NOT NULL,
            error_code varchar(100) DEFAULT NULL,
            error_message text DEFAULT NULL,
            error_type varchar(20) DEFAULT NULL,
            order_total decimal(10,2) DEFAULT NULL,
            customer_country varchar(5) DEFAULT NULL,
            response_time_ms int(11) DEFAULT NULL,
            retry_count tinyint(4) DEFAULT 0,
            created_at datetime DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY  (id),
            KEY gateway_id (gateway_id),
            KEY status (status),
            KEY created_at (created_at)
        ) $charset_collate;";

        require_once ABSPATH . 'wp-admin/includes/upgrade.php';
        dbDelta( $sql );

        update_option( 'zextapay_db_version', ZEXTAPAY_DB_VERSION );
    }

    public static function log_transaction( $args ) {
        global $wpdb;
        $table_name = $wpdb->prefix . 'zextapay_transaction_logs';

        $defaults = [
            'order_id'         => 0,
            'gateway_id'       => '',
            'status'           => '',
            'error_code'       => null,
            'error_message'    => null,
            'error_type'       => null,
            'order_total'      => null,
            'customer_country' => null,
            'response_time_ms' => null,
            'retry_count'      => 0,
            'created_at'       => current_time( 'mysql' ),
        ];

        $data   = wp_parse_args( $args, $defaults );
        $result = $wpdb->insert( $table_name, $data ); // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery

        if ( $result ) {
            delete_transient( 'zextapay_dashboard_stats' );
            delete_transient( 'zextapay_recent_logs' );
            do_action( 'zextapay_transaction_logged', $data );
        }

        return $result;
    }

    public static function get_last_hour_stats() {
        global $wpdb;

        $stats = wp_cache_get( 'zextapay_last_hour_stats' );
        if ( false !== $stats ) return $stats;

        // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
        $row = $wpdb->get_row( "
            SELECT gateway_id,
                   SUM(CASE WHEN status='success' THEN 1 ELSE 0 END) * 100 / NULLIF(COUNT(*), 0) as success_rate
            FROM {$wpdb->prefix}zextapay_transaction_logs
            WHERE created_at >= DATE_SUB(NOW(), INTERVAL 1 HOUR)
            GROUP BY gateway_id
            ORDER BY COUNT(*) DESC
            LIMIT 1
        " );

        if ( ! $row ) {
            $stats = [ 'gateway_id' => 'none', 'status' => 'up', 'success_rate' => 100 ];
        } else {
            $status = $row->success_rate < 80 ? 'down' : 'up';
            $stats  = [
                'gateway_id'   => $row->gateway_id,
                'status'       => $status,
                'success_rate' => round( $row->success_rate, 1 ),
            ];
        }

        wp_cache_set( 'zextapay_last_hour_stats', $stats, '', 300 );
        return $stats;
    }

    public static function prune_logs() {
        // All logs are kept in the free version.
    }
}
