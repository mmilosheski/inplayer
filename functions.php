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
    
    //create paywall settings table
    $db_table_name = $wpdb->prefix . "inp_acc_pw_setting_table";
    if ($wpdb->get_var("SHOW TABLES LIKE '$db_table_name'") != $db_table_name) {
        if (!empty($wpdb->charset))
            $charset_collate = "DEFAULT CHARACTER SET $wpdb->charset";
        if (!empty($wpdb->collate))
            $charset_collate .= " COLLATE $wpdb->collate";

        $sql = "CREATE TABLE $db_table_name (
		  `id` bigint(15) NOT NULL AUTO_INCREMENT,
		  `videoid` bigint(15) NOT NULL,
		  `ovp` varchar(250) NOT NULL,
		  `app` varchar(250) NOT NULL,
		  PRIMARY KEY (`id`),
  		  FOREIGN KEY (`ovp`) REFERENCES inp_acc_ovp_table(ovpid)
			) $charset_collate;";
        dbDelta($sql);
    }
    
    //create ovps table
    $db_table_name = $wpdb->prefix . "inp_acc_ovp_table";
    if ($wpdb->get_var("SHOW TABLES LIKE '$db_table_name'") != $db_table_name) {
        if (!empty($wpdb->charset))
            $charset_collate = "DEFAULT CHARACTER SET $wpdb->charset";
        if (!empty($wpdb->collate))
            $charset_collate .= " COLLATE $wpdb->collate";

        $sql = "CREATE TABLE $db_table_name (
		  `ovpid` bigint(15) NOT NULL AUTO_INCREMENT,
		  `ovpname` varchar(250) NOT NULL,
		  `embedcode` varchar(9999) NOT NULL,
		  PRIMARY KEY (`ovpid`)
			) $charset_collate;";
        dbDelta($sql);
    }             

    //Insert ovps into table
    $wpdb->insert($db_table_name, array('ovpid' => 1, 'ovpname' => "BotR", 'embedcode' => ""));
    $wpdb->insert($db_table_name, array('ovpid' => 2, 'ovpname' => "Brightcove", 'embedcode' => ""));
    $wpdb->insert($db_table_name, array('ovpid' => 3, 'ovpname' => "Dailymotion", 'embedcode' => ""));
    $wpdb->insert($db_table_name, array('ovpid' => 4, 'ovpname' => "Freecaster", 'embedcode' => ""));
    $wpdb->insert($db_table_name, array('ovpid' => 5, 'ovpname' => "Kaltura", 'embedcode' => ""));
    $wpdb->insert($db_table_name, array('ovpid' => 6, 'ovpname' => "Limelight", 'embedcode' => ""));
    $wpdb->insert($db_table_name, array('ovpid' => 7, 'ovpname' => "Livebeats", 'embedcode' => ""));
    $wpdb->insert($db_table_name, array('ovpid' => 8, 'ovpname' => "Piksel", 'embedcode' => ""));
    $wpdb->insert($db_table_name, array('ovpid' => 9, 'ovpname' => "MUZU.TV", 'embedcode' => ""));
    $wpdb->insert($db_table_name, array('ovpid' => 10, 'ovpname' => "Nexeven", 'embedcode' => ""));
    $wpdb->insert($db_table_name, array('ovpid' => 11, 'ovpname' => "Ooyala", 'embedcode' => ""));
    $wpdb->insert($db_table_name, array('ovpid' => 12, 'ovpname' => "OSMF", 'embedcode' => ""));
    $wpdb->insert($db_table_name, array('ovpid' => 13, 'ovpname' => "Other", 'embedcode' => ""));
    $wpdb->insert($db_table_name, array('ovpid' => 14, 'ovpname' => "Qbrick", 'embedcode' => ""));
    $wpdb->insert($db_table_name, array('ovpid' => 15, 'ovpname' => "StreamUK", 'embedcode' => ""));
    $wpdb->insert($db_table_name, array('ovpid' => 16, 'ovpname' => "Stupeflix", 'embedcode' => ""));
    $wpdb->insert($db_table_name, array('ovpid' => 17, 'ovpname' => "thePlatform", 'embedcode' => ""));
    $wpdb->insert($db_table_name, array('ovpid' => 18, 'ovpname' => "Twistage", 'embedcode' => ""));
    $wpdb->insert($db_table_name, array('ovpid' => 19, 'ovpname' => "TooCast", 'embedcode' => ""));
    $wpdb->insert($db_table_name, array('ovpid' => 20, 'ovpname' => "Unicorn Media", 'embedcode' => ""));
    $wpdb->insert($db_table_name, array('ovpid' => 21, 'ovpname' => "Vimeo", 'embedcode' => ""));
    $wpdb->insert($db_table_name, array('ovpid' => 22, 'ovpname' => "Vyoo", 'embedcode' => ""));
    $wpdb->insert($db_table_name, array('ovpid' => 23, 'ovpname' => "vzaar", 'embedcode' => ""));
    $wpdb->insert($db_table_name, array('ovpid' => 24, 'ovpname' => "YouTube", 'embedcode' => ""));
    
    //create apps table
    $db_table_name = $wpdb->prefix . "inp_acc_apps_table";
    if ($wpdb->get_var("SHOW TABLES LIKE '$db_table_name'") != $db_table_name) {
        if (!empty($wpdb->charset))
            $charset_collate = "DEFAULT CHARACTER SET $wpdb->charset";
        if (!empty($wpdb->collate))
            $charset_collate .= " COLLATE $wpdb->collate";

        $sql = "CREATE TABLE $db_table_name (
		  `appid` bigint(15) NOT NULL AUTO_INCREMENT,
		  `appname` varchar(250) NOT NULL,
		  PRIMARY KEY (`appid`)
			) $charset_collate;";
        dbDelta($sql);
    }             

    //Insert ovps into table
    $wpdb->insert($db_table_name, array('appid' => 1, 'appname' => "Paywall"));
    $wpdb->insert($db_table_name, array('appid' => 2, 'appname' => "Donations"));
    $wpdb->insert($db_table_name, array('appid' => 3, 'appname' => "eComm"));
    add_option("inp_db_version", $inp_db_version);

    global $isInstalled;
    $isInstalled = true;
    //exit( wp_redirect("admin.php?page=inplayer") );
    //exit("<script>location.href = '".admin_url('admin.php?page=inplayer-login')."';</script>");
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
//add_action('admin_head', 'add_script_config');

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
    //add_menu_page('Inplayer', 'Inplayer', 'manage_options', 'inplayer', 'myinplayer', plugins_url('inplayer/assets/img/icon.png'));
    add_menu_page( 'Inplayer', 'Inplayer', 'manage_options', 'inplayer-login', 'myinplayer', plugins_url('inplayer/assets/img/icon.png'));
    //add_submenu_page('inplayer', 'Add & Protect Video', 'Add & Protect Video', 'manage_options', 'add-video', 'add_video');
    //add_submenu_page('inplayer', 'Add & Protect Any Content', 'Add & Protect Any Content', 'manage_options', 'add-content', 'add_content');
    add_submenu_page('inplayer', 'API Settings', 'API Settings', 'manage_options', 'manage-general-options', 'settings');
}

function myinplayer() {
    require_once 'inplayer-admin1.php';
    inplayer_register_scripts_styles();
}

function add_video () {
    require_once 'inplayer-add-video.php';
    inplayer_register_scripts_styles();
}

function add_content () {
	require_once 'inplayer-add-content.php';
    inplayer_register_scripts_styles();
}

function settings() {
    require_once 'inplayer-options.php';
    inplayer_register_scripts_styles();
}

function inplayer_register_scripts_styles() {
	wp_register_script( 'jquery', plugins_url( 'assets/js/jquery-1.11.2.min.js', __FILE__ ) );
    wp_register_script( 'bootstrap', plugins_url( 'assets/js/bootstrap.js', __FILE__ ) );
	wp_register_script( 'bootstrap-min', plugins_url( 'assets/js/bootstrap.min.js', __FILE__ ) );
	wp_register_script( 'jquery-ui', plugins_url( 'assets/js/jquery-ui.js', __FILE__ ) );
	wp_register_script( 'jquery-ui-min', plugins_url( 'assets/js/jquery-ui.min.js', __FILE__ ) );
	wp_register_script( 'jquery-searchable', plugins_url( 'assets/js/jquery.searchable.js', __FILE__ ) );
	wp_register_script( 'jquery-dataTables', plugins_url( 'assets/js/jquery.dataTables.min.js', __FILE__ ) );
	wp_register_script( 'jquery-zclip', plugins_url( 'assets/js/jquery.zclip.js', __FILE__ ) );
	wp_register_script( 'admin-js', plugins_url( 'assets/js/admin-js.js', __FILE__ ) );
	
    wp_enqueue_script( 'jquery' );
    wp_enqueue_script( 'bootstrap' );
    wp_enqueue_script( 'bootstrap-min' );
    wp_enqueue_script( 'jquery-ui' );
    wp_enqueue_script( 'jquery-ui-min' );
    wp_enqueue_script( 'jquery-searchable' );
    wp_enqueue_script( 'jquery-dataTables' );
    wp_enqueue_script( 'jquery-zclip');
    wp_enqueue_script( 'admin-js' );

    wp_register_style( 'jquery-ui-min', plugins_url('assets/css/jquery-ui.min.css', __FILE__) );
    wp_register_style( 'jquery-ui-structure', plugins_url('assets/css/jquery-ui.structure.css', __FILE__) );
    wp_register_style( 'jquery-ui-structure-min', plugins_url('assets/css/jquery-ui.structure.min.css', __FILE__) );
    wp_register_style( 'bootstrap', plugins_url('assets/css/bootstrap.css', __FILE__) );
    wp_register_style( 'bootstrap-min', plugins_url('assets/css/bootstrap.min.css', __FILE__) );
    wp_register_style( 'bootstrap-theme', plugins_url('assets/css/bootstrap-theme.css', __FILE__) );
    wp_register_style( 'bootstrap-theme-min', plugins_url('assets/css/bootstrap-theme.min.css', __FILE__) );
    wp_register_style( 'admin-style', plugins_url('assets/css/admin-style.css', __FILE__) );
    wp_register_style( 'jquery-dataTables', plugins_url('assets/css/jquery.dataTables.css', __FILE__) );

    wp_enqueue_style( 'jquery-ui-min' );
    wp_enqueue_style( 'jquery-ui-structure' );
    wp_enqueue_style( 'jquery-ui-structure-min' );
    wp_enqueue_style( 'bootstrap' );
    wp_enqueue_style( 'bootstrap-min' );
    wp_enqueue_style( 'bootstrap-theme' );
    wp_enqueue_style( 'bootstrap-theme-min' );
    wp_enqueue_style( 'admin-style' );
    wp_enqueue_style( 'jquery-dataTables' );
}

function my_plugin_options() {

    echo "Silence is golden...";

}

//REGISTER SHORTCODE FOR FRONT END BOOKING
add_shortcode("inplayer_brightcove", "inplayer_register_shortcode");


//CREATE SHORTCODE FOR FRONT END BOOKING
function inplayer_register_shortcode($atts) {

    include_once '/assets/ovps/brightcove.php';

}
add_shortcode("inplayer_youtube", "inplayer_youtube_register_shortcode");


//CREATE SHORTCODE FOR FRONT END BOOKING
function inplayer_youtube_register_shortcode($atts) {

    include_once '/assets/ovps/youtube.php';

}
add_shortcode("inplayer_vimeo", "inplayer_vimeo_register_shortcode");


//CREATE SHORTCODE FOR FRONT END BOOKING
function inplayer_vimeo_register_shortcode($atts) {

    include_once '/assets/ovps/vimeo.php';

}
add_shortcode("inplayer_jwplayer", "inplayer_jwplayer_register_shortcode");


//CREATE SHORTCODE FOR FRONT END BOOKING
function inplayer_jwplayer_register_shortcode($atts) {

    include_once '/assets/ovps/jw-player.php';

}

add_shortcode("inplayer_wistia", "inplayer_wistia_register_shortcode");


//CREATE SHORTCODE FOR FRONT END BOOKING
function inplayer_wistia_register_shortcode($atts) {

    include_once '/assets/ovps/wistia.php';

}

add_shortcode("inplayer_theplatform", "inplayer_theplatform_register_shortcode");


//CREATE SHORTCODE FOR FRONT END BOOKING
function inplayer_theplatform_register_shortcode($atts) {

    include_once '/assets/ovps/theplatform.php';

}

add_shortcode("inplayer_kaltura", "inplayer_kaltura_register_shortcode");


//CREATE SHORTCODE FOR FRONT END BOOKING
function inplayer_kaltura_register_shortcode($atts) {

    include_once '/assets/ovps/kaltura.php';

}
add_shortcode("inplayer_haivision", "inplayer_haivision_register_shortcode");


//CREATE SHORTCODE FOR FRONT END BOOKING
function inplayer_haivision_register_shortcode($atts) {

    include_once '/assets/ovps/haivision.php';

}

add_shortcode("inplayer_voyo", "inplayer_voyo_register_shortcode");


//CREATE SHORTCODE FOR FRONT END BOOKING
function inplayer_voyo_register_shortcode($atts) {

    include_once '/assets/ovps/voyo.php';

}
add_action('front_end_scripts_styles','front_end_scripts_styles');
function front_end_scripts_styles() {
    wp_register_style('inplayercss','http://plugin.inplayer.com/html5/v3/latest/style/style.css');
    wp_register_script('inplayerjs','http://plugin.inplayer.com/html5/v3/latest/scripts/inplayer.js');

    wp_enqueue_style('inplayercss');
    wp_enqueue_script('inplayerjs');
}
add_action('fire_payment_script','payment_script');

function payment_script(/*$packageused, $amount, $packageid, */$content = null) {
    require(ABSPATH . 'wp-load.php');
    global $wpdb;
    $acc_info_table = $wpdb->prefix . "inp_acc_info_table";
    $acc_info_row = $wpdb->get_results("SELECT * FROM `$acc_info_table` WHERE 1", ARRAY_A);
    $content = strip_tags($content, '<br/>');
    //$id = isset($_POST['id']) ? $_POST['id'] : ( isset($_GET['id']) ? $_GET['id'] : false );
    //$packageid['post_id'] = get_the_ID();
    /*$payment_scipt = '<link rel="stylesheet" type="text/css" href="http://plugin.inplayer.com/html5/v3/latest/style/style.css" />';
    $payment_scipt .= '<script type="text/javascript" src="http://invideous.s3.amazonaws.com/html5/jwplayer/jwplayer.js"></script>';
    $payment_scipt .= '<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>';
    $payment_scipt .= '<script type="text/javascript" src="http://plugin.inplayer.com/html5/v3/latest/scripts/inplayer.js"></script>';
    $payment_scipt .= '<div id="myElement" class="invideous">'.$content.'</div>';
    $payment_scipt .= '<script type="text/javascript">';
    $payment_scipt .= 'jwplayer("myElement").setup({';
    $payment_scipt .= 'file: "'. //$content .'",';
    $payment_scipt .= 'width: "550px",';
    $payment_scipt .= 'height: "320px",';
    $payment_scipt .= 'invideous:{ publisher_id:"'. $acc_info_row[0]['publisherid'] .'" }';
    $payment_scipt .= '});';
    $payment_scipt .= '</script>';
    $payment_scipt .= 'HERE THE PAYMENT SCRIPT WILL FIREUP!';*/
    $content = str_replace('<p>', '', $content);
    $content = str_replace('</p>', '', $content);
    $pid = 5070;
    $payment_scipt = '<link rel="stylesheet" type="text/css" href="http://invideous.s3.amazonaws.com/html5/3.1.3/style/style.css" />';
    $payment_scipt .= '<script type="text/javascript" src="http://invideous.s3.amazonaws.com/html5/3.1.3/jwplayer/jwplayer.js"></script>';
    $payment_scipt .= '<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>';
    $payment_scipt .= '<script type="text/javascript" src="http://invideous.s3.amazonaws.com/html5/3.1.3/scripts/inplayer.js"></script>';
    $payment_scipt .= '<div id="myElement" class="invideous">'.$content.'</div>';
    $payment_scipt .= '<script type="text/javascript">inplayer.ovps.wordpress.createInstance({publisher_id: 5070,ovp_video_id: \'5070wptest1111\'});</script>';

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
    //debug_to_console($atts);

    if (current_user_can('create_users'))
        return '<div id="myElement" class="invideous">' . $content . '</div>';
    return payment_script($content = $content);
}
function debug_to_console( $data ) {

    if ( is_array( $data ) )
        $output = "<script>console.log( 'Debug Objects: " . implode( ',', $data) . "' );</script>";
    else
        $output = "<script>console.log( 'Debug Objects: " . $data . "' );</script>";

    echo $output;
}
add_shortcode('inplayer_protectedcontent', 'inplayer_protectedcontent');

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

//This callback registers our plug-in
/*function wpse72394_register_tinymce_plugin1($plugin_array) {
    $plugin_array['wpse72394_button1'] = plugins_url('inplayer/assets/js/shortcode1.js');
    return $plugin_array;
}*/

//This callback adds our button to the toolbar
/*function wpse72394_add_tinymce_button1($buttons) {
            //Add the button ID to the $button array
    $buttons[] = "wpse72394_button1";
    return $buttons;
}*/
