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

    register_activation_hook(__FILE__, 'inplayer_plugin_install');
    register_uninstall_hook(__FILE__, 'inplayer_plugin_uninstall');

    global $inp_db_version, $wpdb, $is_paid_view, $ovp_video_id, $content;
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
        add_menu_page( 'Inplayer', 'Inplayer', 'manage_options', 'inplayer-login', 'myinplayer', plugins_url('assets/img/icon.png', __FILE__ ));
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
    	// wp_register_script( 'bootstrap-min', plugins_url( 'assets/js/bootstrap.min.js', __FILE__ ) );
      	// wp_register_script( 'admin-js', plugins_url( 'assets/js/admin-js.js', __FILE__ ) );
        
        // wp_enqueue_script( 'bootstrap-min' );
        // wp_enqueue_script( 'admin-js' );
        
        // wp_register_style( 'bootstrap-min', plugins_url('assets/css/bootstrap.min.css', __FILE__) );
        wp_register_style( 'admin-style', plugins_url('assets/css/admin-style.css', __FILE__) );
        
        // wp_enqueue_style( 'bootstrap-min' );
        wp_enqueue_style( 'admin-style' );
    }

    add_action('wp_enqueue_scripts','front_end_scripts');

    function front_end_scripts() {
        wp_register_script( 'front-end', plugins_url( 'assets/js/front-end.js', __FILE__ ) );
        wp_enqueue_script( 'front-end' );
        // wp_localize_script( 'front-end', 'ajax_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' ), 'is_paid_view' => true ) );
        // embed the javascript file that makes the AJAX request
        // wp_enqueue_script( 'front-end', plugin_dir_url( __FILE__ ) . 'assets/js/front-end.js', array( 'jquery' ) );

        // declare the URL to the file that handles the AJAX request (wp-admin/admin-ajax.php)
        // wp_localize_script( 'front-end', 'inplayerAjax', array( 'ajaxurl' => admin_url('admin-ajax.php'), 'is_paid_view' => "" ) );
    }

    // if both logged in and not logged in users can send this AJAX request,
    // add both of these actions, otherwise add only the appropriate one
    add_action( 'wp_ajax_nopriv_myajax-submit', 'myajax_submit' );
    add_action( 'wp_ajax_myajax-submit', 'myajax_submit' );

    function myajax_submit() {
        global $ovp_video_id, $is_paid_view;

        ob_start();

        // get the submitted parameters
        $is_paid_view = $_POST['paid_or_not'];

        //var_dump($is_paid_view);

        // if ( $is_paid_view == true ) {
        //     $response = payment_script($ovp_video_id,$content = $content);
        //     $response .= 'THIS IS PAID';
        // }
        // else {
        //     $response = payment_script($ovp_video_id,$content);
        //     $response = strip_tags($response, '<br/>');
        //     $response = str_replace('<p>', '', $response);
        //     $response = str_replace('</p>', '', $response);
        //     $response .= 'THIS IS NOT PAID';
        // }
        $response = payment_script($ovp_video_id,$content);
        // generate the response
        // $response = payment_scipt($ovp_video_id,$content);

        // response output
        header( "Content-Type: application/json" );

        //echo '<script>console.log("---->", "' . var_export($is_paid_view, true) . '");</script>';
        // echo $is_paid_view; 

        echo $response;
        
        // ob_flush();
        // IMPORTANT: don't forget to "exit"
        exit;
    }

    function my_plugin_options() {

        echo "Silence is golden...";

    }

    add_action('fire_payment_script','payment_script');
    // add_action('fire_payment_script','payment_script');

    function payment_script($ovp_video_id, $content = null) {

        // $is_paid_content = false;
        // $is_paid_content = is_paid(); 
        
        global $wpdb, $ovp_video_id, $is_paid_view;


        // $is_paid_view = true;

        $acc_info_table = $wpdb->prefix . "inp_acc_info_table";
        $acc_info_row = $wpdb->get_results("SELECT * FROM `$acc_info_table` WHERE 1", ARRAY_A);
        
        $pub_id = $acc_info_row['0']['publisherid'];

        // $content = $content;
        // $is_paid_content = false;
        // $is_paid_content = is_paid();

        if ( $is_paid_view == 'paid' ) {
            // var_dump($is_paid_view);
            $content = $content;
            $content .= '<br><br><b>THIS IS PAID vo ifot od payment_script + 1 ili true</b><br><br><br>';
        }
        else {
            // var_dump($is_paid_view);
            $content = $content;
            // $content = strip_tags($content, '<br/>');
            // $content = str_replace('<p>', '', $content);
            // $content = str_replace('</p>', '', $content);
            $content .= '<br><br><b>THIS IS NOT PAID vo elsot od payment_script + 0 ili false</b><br><br>';
        }
        
        // $protected_content = $content;
        // $content = strip_tags($content, '<br/>');
        // $content = str_replace('<p>', '', $content);
        // $content = str_replace('</p>', '', $content);
        // $exerpt_content = $content;

        $payment_scipt = '<div id="inv_wp_wrap_'.$ovp_video_id.'" class="invideous" style="width:100%;height:315px;">'.$content.'</div><input type="hidden" id="video_p" value="'.$ovp_video_id.'"><br>';
        $payment_scipt .= '<script type="text/javascript">inplayer.ready(function(){inplayer.ovps.wordpress.createInstance({ publisher_id: \''.$pub_id.'\', ovp_video_id: \''.$ovp_video_id.'\', container: '.'\'#inv_wp_wrap_'.$ovp_video_id.'\' });';
        $payment_scipt .= ' });</script>';
        $payment_scipt .= '<b>madafaka na kraj od payment_script + kontent nad </b><br><br><br>';
        return $payment_scipt;
    }

    // add_action('wp_ajax_nopriv_fire_is_paid','is_paid');
    // add_action('wp_ajax_fire_is_paid','is_paid');

    // function is_paid() {

    //     $is_paid_content = $_POST['is_paid_view'];
    //     debug_to_console($is_paid_content);
    //     $contentp = payment_scipt($is_paid_content,$ovp_video_id,$content);
    //     debug_to_console($contentp);
    //     return $contentp;

    // }

    // add_action( 'wp_ajax_nopriv_getContent', 'getContent' );
    // add_action( 'wp_ajax_getContent', 'getContent' );

    function inplayer_protectedcontent($atts, $content = null) {
        global $content, $ovp_video_id;
        // var_dump($atts);
        extract(shortcode_atts(
            array(
                    'ovp_video_id' => '',
                    'packagename' => '',
                    'period' => '',
                    'tarrif_option_id' => '',
                    'price' => '',
                    'is_recurrent' => ''
                ), $atts, 'inplayer_protectedcontent' 
            ));
        $ovp_video_id = (string)$atts['ovp_video_id'];
        // debug_to_console($atts);

        if (current_user_can('create_users'))
            return '<div id="inv_wp_wrap_'.$ovp_video_id.'" class="invideous" style="width:100%;height:auto;">' . $content . '</div><br>';
        // if ($get_user)
        return payment_script($ovp_video_id,$content);
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
        $plugin_array['wpse72394_button'] = plugins_url('inplayer/assets/js/shortcode.js', __FILE__ );
        return $plugin_array;
    }

    //This callback adds our button to the toolbar
    function wpse72394_add_tinymce_button($buttons) {
        //Add the button ID to the $button array
        array_push( $buttons, "inplayer_protectedcontent", "inplayer_protectedcontent1", "custom_mce_button" );
        return $buttons;
    }