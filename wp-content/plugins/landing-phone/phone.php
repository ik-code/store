<?php
/*
Plugin Name: Landing phone numbers
Description: Plugin for save phone numbers from landing page.
Version: 0.0.1
Author: Halo-lab
Author URI: https://halo-lab.com/
*/

register_activation_hook(__FILE__,'jal_install');
add_action('wp_ajax_landing-phone', 'add_landing_phone');
add_action('wp_ajax_nopriv_landing-phone', 'add_landing_phone');

function add_landing_phone() {
    $phone = trim($_POST['phone']);

    if ($phone === '') {
        wp_send_json( [ 'result' => false], 201 );
    } else {
        $result = set_landing_phones($phone);
        if ($result) {
            wp_send_json( 'true', 200 );
        }
        wp_send_json( 'false', 201 );
    }
    wp_die();
}

function set_landing_phones($phone) {
    global $wpdb;
    $result = $wpdb->insert($wpdb->prefix . "landing_phones", ['phone' => $phone], '%s');
    if ($result) {
        return true;
    }
    return false;
}

global $jal_db_version;
$jal_db_version = "1.0";

function jal_install () {
    global $wpdb;
    global $jal_db_version;

    $table_name = $wpdb->prefix . "landing_phones";
    if($wpdb->get_var("show tables like '$table_name'") != $table_name) {
        $sql = "CREATE TABLE " . $table_name . " (
        id bigint(11) NOT NULL AUTO_INCREMENT,
        phone text(15) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        UNIQUE KEY id (id)
	);";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
        add_option("jal_db_version", $jal_db_version);
    }
}

add_action( 'admin_menu', 'landing_phone_numbers' );

function get_landing_phones() {
    global $wpdb;
    $phones = $wpdb->get_results( "SELECT * FROM wp_landing_phones", 'ARRAY_A' );

    return $phones;
}

function landing_phone_numbers() {
    add_menu_page(
        'Landing phones',
        'Landing phones',
        'edit_others_posts',
        'landing_phones',
        'landing_phones_function',
        'dashicons-phone' ,
        100
    );
}

function landing_phones_function() {
    $phones = get_landing_phones();
    $start = '<h1 class="wp-heading-inline">Landing phones</h1>
        <a class="button" href=' . admin_url("admin.php?page=landing_phones" ) . '&action=download_csv&_wpnonce=' . wp_create_nonce("download_csv") . '>Export to CSV</a>
        <br>
        <br>
        <table class="wp-list-table widefat fixed striped pages" id="landing_phones_table" style="width: 600px">
            <thead>
                <tr>
                    <td style="width: 50px">id</td>
                    <td>phone</td>
                    <td>date</td>
                </tr>
            </thead>
            <tbody>';
            foreach ($phones as $item) {
                $start = $start . '<tr>
                    <td>'. $item['id'] .'</td>
                    <td>'. $item['phone'] .'</td>
                    <td>'. $item['created_at'] .'</td>
                </tr>';
            };
    $finish = '</tbody></table>';
    echo $start . $finish;
}

// Add action hook only if action=download_csv
if ( isset($_GET['action'] ) && $_GET['action'] == 'download_csv' )  {
    // Handle CSV Export
    add_action( 'admin_init', 'csv_export');
}

function csv_export() {
    // Check for current user privileges
    if( !current_user_can( 'manage_options' ) ){ return false; }
    // Check if we are in WP-Admin
    if( !is_admin() ){ return false; }
    // Nonce Check
    $nonce = isset( $_GET['_wpnonce'] ) ? $_GET['_wpnonce'] : '';
    if ( ! wp_verify_nonce( $nonce, 'download_csv' ) ) {
        die( 'Security check error' );
    }

    ob_start();
    $domain = $_SERVER['SERVER_NAME'];
    $filename = 'phones-' . $domain . '-' . time() . '.csv';

    $header_row = array(
        'Phone number',
        'Created date',
    );
    $data_rows = array();

    $phones = get_landing_phones();

    foreach ( $phones as $phone ) {
        $row = array(
            $phone['phone'],
            $phone['created_at'],
        );
        $data_rows[] = $row;
    }
    $fh = @fopen( 'php://output', 'w' );
    fprintf( $fh, chr(0xEF) . chr(0xBB) . chr(0xBF) );
    header( 'Cache-Control: must-revalidate, post-check=0, pre-check=0' );
    header( 'Content-Description: File Transfer' );
    header( 'Content-type: text/csv' );
    header( "Content-Disposition: attachment; filename={$filename}" );
    header( 'Expires: 0' );
    header( 'Pragma: public' );
    fputcsv( $fh, $header_row );
    foreach ( $data_rows as $data_row ) {
        fputcsv( $fh, $data_row );
    }
    fclose( $fh );
    ob_end_flush();
    die();
};
?>