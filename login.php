<?php
CONST API_LOGIN = "http://api.invideous.com/plugin/login";
CONST API_CREATE_PACKAGE = "http://api.inplayer.com/write/create_package";

require(ABSPATH . 'wp-blog-header.php');
require(ABSPATH . 'wp-load.php');
global $wpdb;

$acc_info_table = $wpdb->prefix . "inp_acc_info_table";
$acc_userinfo = $wpdb->prefix . "inp_acc_userinfo";


$acc_info_row = $wpdb->get_results("SELECT * FROM `$acc_info_table` WHERE 1", ARRAY_A);
$acc_userinfo_row = $wpdb->get_results("SELECT * FROM `$acc_userinfo` WHERE 1", ARRAY_A);
extract($_POST);

if(isset($save_settings_acc_info)) {
  //$acc_info_sql = "UPDATE `$acc_info_table` SET `publisherid`='$txt_acc_id',`token`='$txt_token',`publickey`='$txt_pukey',`privatekey`='$txt_prkey' WHERE 1";
  //$wpdb->query($acc_info_sql);
  $acc_userinfo_sql = "UPDATE `$acc_userinfo` SET `email`='$txt_email',`password`='$txt_password' WHERE 1";
  $wpdb->query($acc_userinfo_sql);
}

$email = $acc_userinfo_row[0]['email'];
//add_option('emailacc',$email);
$password = $acc_userinfo_row[0]['password'];
//add_option('passacc',$passoword);
$platform = 'web';
//add_option('platacc',$platform);

$send_login = wp_remote_post(API_LOGIN, array(
  'method'   => 'POST',
  'blocking' => true,
  'body'     => array(
    'username' => $email,
    'password' => $password,
    'platform' => $platform
    /*'username' => get_option('emailacc'),
    'password' => get_option('passacc'),
    'platform' => get_option('platacc')*/
  ))
);

$userinfo = json_decode($send_login['body'], true);

if ($userinfo['status'] == 'error') {

  //  handle wrong response from API
  echo 'Something went wrong please login again!';
  wp_redirect( get_permalink( $post->post_parent )); exit;

} else {

  // OK

  $userinfo = $userinfo['response']['result']['user_info'];
  $insert_userinfo_sql = "UPDATE `$inp_acc_info_table` SET `publisherid`=".$userinfo['id'].", `fullname`=".$userinfo['fullname'].", `screenname`=".$userinfo['username']." WHERE 1";
  $wpdb->query($insert_userinfo_sql);
  if(isset($save_settings_acc_info1)) {
  $insert_userinfo_sql1 = "UPDATE `$inp_acc_info_table` SET `token`='$txt_token',`publickey`='$txt_pukey',`privatekey`='$txt_prkey' WHERE 1";
  $wpdb->query($insert_userinfo_sql1);
}
}
//wp_redirect(get_permalink($post->post_parent).'manage-general-options'); exit;


//echo '<pre>'. print_r($userinfo, true) . '</pre>';

//$body = wp_remote_retrieve_body( wp_remote_get( 'http://api.invideous.com/plugin/get_user_info' ) );
//var_dump($body);
//if (is_array($userinfo)) {

//foreach ($userinfo as $user) {
  //foreach ($ui as $user) {
?>