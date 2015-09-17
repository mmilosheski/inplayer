<?php
/**
 * Plugin Name: InPlayer WP Plugin
 * Plugin URI: http://inplayer.com/
 * Description: Sell your videos on your Wordpress site. <a href="http://panel.inplayer.com/">Sign up for publisher account</a> and create a paywall. Then just embed the paywall ID with your WordPress plugin and include the shortcode* eg. [inplayer paywallid="someid"] to your post/page. 
 * Version: 1.0.0
 * Author: InPlayer 
 * Author URI: http://inplayer.com/
 * Text Domain: WordPress Video Monetization Plugin
 * Domain Path: http://inplayer.com/handbook-paywall/?f=wordpress-monetisation
 * Network: 
 * License: InPlayer Ltd
 */

if (!defined('ABSPATH'))
    exit;
$plugins_url = plugins_url();
register_activation_hook(__FILE__, 'inplayer_plugin_install');
register_uninstall_hook(__FILE__, 'inplayer_plugin_uninstall');

global $inp_db_version;
$inp_db_version = "1.0";

function inplayer_plugin_install()
{
    global $wpdb;
    global $inp_db_version;
    require_once(ABSPATH . '/wp-admin/includes/upgrade.php');
    
    // create account information table
    $db_table_name = $wpdb->prefix . "inp_acc_info_table";
    if ($wpdb->get_var("SHOW TABLES LIKE '$db_table_name'") != $db_table_name) {
        if (!empty($wpdb->charset))
            $charset_collate = "DEFAULT CHARACTER SET $wpdb->charset";
        if (!empty($wpdb->collate))
            $charset_collate .= " COLLATE $wpdb->collate";

        $sql = "CREATE TABLE $db_table_name (
		  `id` bigint(15) NOT NULL AUTO_INCREMENT,
          `publisherid` bigint(15) NOT NULL,
		  `token` varchar(250) NOT NULL,
		  `publickey` varchar(250) NOT NULL,
		  `privatekey` varchar(250) NOT NULL,
		  `fullname` varchar(250) NOT NULL,
		  `email` varchar(250) NOT NULL,
		  `screenname` varchar(250) NOT NULL,
		  PRIMARY KEY (`id`)
		  	) $charset_collate;";
        dbDelta($sql);
    }

    $wpdb->insert($db_table_name, array('id' => 1, 'publisherid' => "0", 'token' => "", 'publickey' => "", 'privatekey' => "", 'fullname' => "", 'email' => "", 'screenname' => ""));

    // create account information table
    $db_table_name = $wpdb->prefix . "inp_acc_userinfo";
    if ($wpdb->get_var("SHOW TABLES LIKE '$db_table_name'") != $db_table_name) {
        if (!empty($wpdb->charset))
            $charset_collate = "DEFAULT CHARACTER SET $wpdb->charset";
        if (!empty($wpdb->collate))
            $charset_collate .= " COLLATE $wpdb->collate";

        $sql = "CREATE TABLE $db_table_name (
          `id` bigint(15) NOT NULL AUTO_INCREMENT,
          `email` varchar(250) NOT NULL,
          `password` varchar(250) NOT NULL,
          PRIMARY KEY (`id`)
            ) $charset_collate;";
        dbDelta($sql);
    }

    $wpdb->insert($db_table_name, array('id' => 1, 'email' => "", 'password' => ""));
    
    add_option("inp_db_version", $inp_db_version);

    global $isInstalled;
    $isInstalled = true;
    
}
// End install()

function inplayer_plugin_uninstall()
{
    global $wpdb;
    global $inp_db_version;
    $table_name = $wpdb->prefix . "inp_acc_info_table";
    $wpdb->query("DROP TABLE IF EXISTS $table_name");
    $table_name = $wpdb->prefix . "inp_acc_pw_setting_table";
    $wpdb->query("DROP TABLE IF EXISTS $table_name");
    $table_name = $wpdb->prefix . "inp_acc_ovp_table";
    $wpdb->query("DROP TABLE IF EXISTS $table_name");
    setcookie('pll_updateW', '0');
    unset($_COOKIE['pll_updateW']);
    unset($_COOKIE['pll_updateW']);
    setcookie('pll_updateW', null, -1, '/');
    setcookie('pll_updateW', null, -1, '/');

}
// End uninstall()
add_action('admin_print_scripts', 'add_script');

/**
 * Add script to admin page
 */
function add_script() {
    // Build in tag auto complete script
    wp_enqueue_script( 'suggest' );
    wp_enqueue_style('shortcode', plugins_url('assets/css/shortcode.css', __FILE__));
}

add_action('admin_menu', 'my_plugin_menu');

function my_plugin_menu() {

    $cformsSettings = get_option('cforms_settings');
    $p = basename(dirname(__FILE__));
    add_menu_page( 'Inplayer', 'Inplayer', 'manage_options', 'inplayer-login', 'myinplayer', plugins_url('inplayer/assets/img/icon.png'));
    add_submenu_page('inplayer', 'API Settings', 'API Settings', 'manage_options', 'manage-general-options', 'settings');
}

function myinplayer() {
    require_once 'inplayer-admin1.php';
    inplayer_register_scripts_styles();
}

function settings() {
    require_once 'inplayer-options.php';
    inplayer_register_scripts_styles();
}

function inplayer_register_scripts_styles() {
	  wp_register_script( 'bootstrap-min', plugins_url( 'assets/js/bootstrap.min.js', __FILE__ ) );
  	wp_register_script( 'admin-js', plugins_url( 'assets/js/admin-js.js', __FILE__ ) );
  	
    wp_enqueue_script( 'bootstrap-min' );
    wp_enqueue_script( 'admin-js' );

    
    wp_register_style( 'bootstrap-min', plugins_url('assets/css/bootstrap.min.css', __FILE__) );
    wp_register_style( 'admin-style', plugins_url('assets/css/admin-style.css', __FILE__) );

    
    wp_enqueue_style( 'bootstrap-min' );
    wp_enqueue_style( 'admin-style' );
}

function my_plugin_options() {

    echo "Silence is golden...";

}

add_action('fire_payment_script','payment_script');

function payment_script(/*$packageused, $amount, $packageid, */$content = null) {
    require(ABSPATH . 'wp-load.php');
    global $wpdb;
    $acc_info_table = $wpdb->prefix . "inp_acc_info_table";
    $acc_info_row = $wpdb->get_results("SELECT * FROM `$acc_info_table` WHERE 1", ARRAY_A);
    $content = strip_tags($content, '<br/>');
    $content = str_replace('<p>', '', $content);
    $content = str_replace('</p>', '', $content);
    $pid = 5070;
    $payment_scipt = '<link rel="stylesheet" type="text/css" href="http://invideous.s3.amazonaws.com/html5/3.1.3/style/style.css" />';
    $payment_scipt .= '<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>';
    $payment_scipt .= '<script type="text/javascript" src="http://invideous.s3.amazonaws.com/html5/jwplayer/v7.0.0/jwplayer.js"></script>';
    $payment_scipt .= '<script type="text/javascript" src="http://invideous.s3.amazonaws.com/html5/3.1.3/scripts/inplayer.js"></script>';
    $payment_scipt .= '<div id="myElement" class="invideous" style="width:640px;height:390px;">'.$content.'</div>';
    $payment_scipt .= '<script type="text/javascript"> inplayer.ovps.wordpress.createInstance({ publisher_id: 5070, ovp_video_id: \'5070wptest1111\', width: "550px",height: "320px" }); </script>';
    return $payment_scipt;
}

// add custom fields code
function inplayer_protectedcontent($atts, $content = null) {

    extract(shortcode_atts(
        array(
                'packagename' => '',
                'period' => '',
                'tarrif_option_id' => '',
                'price' => '',
                'is_recurrent' => ''
            ), $atts, 'inplayer_protectedcontent' 
        ));
    debug_to_console($atts);

    if (current_user_can('create_users'))
        return '<div id="myElement" class="invideous" style="width:640px;height:390px;">' . $content . '</div>';
    return payment_script($content = $content);
}

add_shortcode('inplayer_protectedcontent', 'inplayer_protectedcontent');


function debug_to_console( $data ) {

    if ( is_array( $data ) )
        $output = "<script>console.log( 'Debug Objects: " . implode( ',', $data) . "' );</script>";
    else
        $output = "<script>console.log( 'Debug Objects: " . $data . "' );</script>";

    echo $output;
}

// init process for registering our button
 add_action('init', 'wpse72394_shortcode_button_init');
 function wpse72394_shortcode_button_init() {

      //Abort early if the user will never see TinyMCE
      if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') && get_user_option('rich_editing') == 'true')
           return;

      //Add a callback to regiser our tinymce plugin   
      add_filter("mce_external_plugins", "wpse72394_register_tinymce_plugin"); 

      // Add a callback to add our button to the TinyMCE toolbar
      add_filter('mce_buttons', 'wpse72394_add_tinymce_button');

}


//This callback registers our plug-in mce buttons
function wpse72394_register_tinymce_plugin($plugin_array) {
    $plugin_array['wpse72394_button'] = plugins_url('inplayer/assets/js/shortcode.js');
    return $plugin_array;
}

//This callback adds our button to the toolbar
function wpse72394_add_tinymce_button($buttons) {
            //Add the button ID to the $button array
    //$buttons[] = "wpse72394_button";
    array_push( $buttons, "inplayer_protectedcontent", "inplayer_protectedcontent1", "custom_mce_button" );
    return $buttons;
}