<?php
/*
Plugin Name: Options Demo
Plugin URI:
Description: Demonstration of Option API
Version: 1.0.0
Author: LWHH
Author URI:
License: GPLv2 or later
Text Domain: option-demo
 */



add_action( 'admin_enqueue_scripts', function ( $hook ) {
    if ( 'toplevel_page_options-demo' == $hook ) {
        wp_enqueue_style( 'pure-grid-css', '//unpkg.com/purecss@1.0.1/build/grids-min.css' );
        wp_enqueue_style( 'options-demo-css', plugin_dir_url( __FILE__ ) . "assets/css/style.css", null, time() );
        wp_enqueue_script( 'options-demo-js', plugin_dir_url( __FILE__ ) . "assets/js/main.js", array( 'jquery' ), time(), true );
        $nonce = wp_create_nonce( 'options_display_result' );
        wp_localize_script(
            'options-demo-js',
            'plugindata',
            array( 'ajax_url' => admin_url( 'admin-ajax.php' ), 'nonce' => $nonce )
        );
    }
} );

add_action( 'wp_ajax_options_display_result', function () {
    global $options;
    $table_name = $options->prefix . 'persons';
    if ( wp_verify_nonce( $_POST['nonce'], 'options_display_result' ) ) {
        $task = $_POST['task'];
        if ( 'add-new-record' == $task ) {
            echo "Bring";
        } 
    }
    die( 0 );
} );

add_action( 'admin_menu', function () {
    add_menu_page( 'Options Demo', 'Options Demo', 'manage_options', 'options-demo', 'optionsdemo_admin_page' );
} );

function optionsdemo_admin_page() {
    ?>
        <div class="container" style="padding-top:20px;">
            <h1>Options Demo</h1>
            <div class="pure-g">
                <div class="pure-u-1-4" style='height:100vh;'>
                    <div class="plugin-side-options">
                        <button class="action-button" data-task='add-option'>Add New Option</button>
                        <button class="action-button" data-task='add-array-option'>Add Array Option</button>
                        <button class="action-button" data-task='get-option'>Display Saved Option</button>
                        <button class="action-button" data-task='get-array-option'>Display Option Array</button>
                        <button class="action-button" data-task='update-option'>Update Option</button>
                        <button class="action-button" data-task='update-array-option'>Update Array Option</button>
                        <button class="action-button" data-task='delete-option'>Delete Option</button>
                        <button class="action-button" data-task='export-option'>Export Options</button>
                        <button class="action-button" data-task='import-option'>Import Options</button>
                    </div>
                </div>
                <div class="pure-u-3-4">
                    <div class="plugin-demo-content">
                        <h3 class="plugin-result-title">Result</h3>
                        <div id="plugin-demo-result" class="plugin-result"></div>
                    </div>
                </div>
            </div>
        </div>
    <?php
}
