<?php
//CONST API_LOGIN = "http://api.invideous.com/";
CONST API_DOMAIN = "http://staging.invideous.com/masterapi/";
//CONST API_CREATE_PACKAGE = "http://api.inplayer.com/write/create_package";

//require(ABSPATH . 'wp-blog-header.php');
require(ABSPATH . 'wp-load.php');
global $wpdb;

$acc_info_table = $wpdb->prefix . "inp_acc_info_table";
$acc_userinfo = $wpdb->prefix . "inp_acc_userinfo";


$acc_info_row = $wpdb->get_results("SELECT * FROM `$acc_info_table` WHERE 1", ARRAY_A);
$acc_userinfo_row = $wpdb->get_results("SELECT * FROM `$acc_userinfo` WHERE 1", ARRAY_A);

extract($_POST);

$email = $_GET['txt_email'];

$password = $_GET['txt_password'];

if (isset($save_settings_acc_info)) {

$acc_userinfo_sql = "UPDATE `$acc_userinfo` SET `email`='$txt_email', `password`='$txt_password' WHERE 1";

$wpdb->query($acc_userinfo_sql);

}

$emailapi = $acc_userinfo_row[0]['email'];

$passwordapi = $acc_userinfo_row[0]['password'];

$platform = 'web';

$send_login = wp_remote_post(API_DOMAIN . 'plugin/login', array(
  'method'   => 'POST',
  'blocking' => true,
  'body'     => array(
    'username' => $emailapi,
    'password' => $passwordapi,
    'platform' => $platform
    /*'username' => get_option('emailacc'),
    'password' => get_option('passacc'),
    'platform' => get_option('platacc')*/
  ))
);

$userinfo = json_decode($send_login['body'], true);

if ($userinfo['response']['status'] == 'error') {

  //  handle wrong response from API
  if($acc_userinfo_row[0]['email'] == '') {
  $message_error = '<b style="color:red">Your are not logged in, please login!</b>';
  }/*echo '<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xs-offset-0 col-sm-offset-0 col-md-offset-3 col-lg-offset-3 toppad"><div class="alert alert-warning">
    <a href="#" class="close" data-dismiss="alert">&times;</a>
    '.$message_error.'
</div></div><div class="clearfix"></div>';*/

} else {

  // OK
  $userinfo_roles = $userinfo['response']['roles'];
  $userinfo_roles['id'] == 4;
  $is_publisher = $userinfo_roles['id'];
  
  if ($is_publisher != $userinfo_roles['id'])
  {
    echo "Your are not a publisher!";
  }
  else
  {
  $userinfo = $userinfo['response']['result']['user_info'];


    //$insert_userinfo_sql = sprintf("INSERT INTO `$acc_info_table` (`publisherid`, `fullname`, `screenname`, `email`) VALUES('%s', '%s', '%s', '%s')",
    $insert_userinfo_sql = sprintf("UPDATE `$acc_info_table` SET `publisherid` = '%s', `fullname` = '%s', `screenname` = '%s', `email` = '%s' WHERE 1",
      $userinfo['id'],
      $userinfo['fullname'],
      $userinfo['username'],
      $userinfo['email']
    );

    $wpdb->query($insert_userinfo_sql);
echo("<script>location.href = '".admin_url('admin.php?page=manage-general-options')."';</script>"); exit;
  }
  }
//extract($_POST);

$username_register = $_POST['txt_username_register'];

$email_register = $_POST['txt_email_register'];

$password_register = $_POST['txt_password_register'];

$password_register_repeat = $_POST['txt_password_register_repeat'];

$fullname_register = $_POST['txt_fullname_register'];

$role = $_POST['role'];

if (isset($save_settings_acc_info2)) {
/*
$username_register1 = $username_register;

$email_register1 = $email_register;

$password_register1 = $password_register;

$password_register_repeat1 = $password_register_repeat;

$fullname_register1 = $fullname_register;

$role1 = $role;*/

$send_register = wp_remote_post(API_DOMAIN . 'plugin/register', array(
  'method'   => 'POST',
  'blocking' => true,
  'body'     => array(
    'username' => $username_register,
    'password' => $password_register,
    'repeat_password' => $password_register_repeat,
    'fullname' => $fullname_register,
    'email' => $email_register,
    'role' => $role

  ))
);

}

$userregister = json_decode($send_register['body'], true);
//var_dump($userregister);
$message_register = $userregister['response']['message'];

if ($userregister['response']['status'] == 'error') {
  //$message_register_error = '<b style="color:red">Something went wrong, please try again!</b>';
   
} else {
  //$message_register_success = '<b style="color:green">Register succesfull, please login!</b>';
  $userregister = $userregister['response']['result']['user_info'];
}
?>
        <div class="container">
            <div class="row">
            <h4 class="text-center">Your Inplayer - Connect with Inplayer</h4>
      <p class="text-center">Connecting with your Inplayer Publisher Account</p>
<div class="container">
      <div class="row">
      <?php if ($acc_info_row[0]['publisherid'] > 0) { 
        echo("<script>location.href = '".admin_url('admin.php?page=manage-general-options')."';</script>");
        exit;
      } ?>
          
        <!-- <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xs-offset-0 col-sm-offset-0 col-md-offset-3 col-lg-offset-3 toppad"> -->
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
          <div class="panel panel-info">
            <div class="panel-heading">
              <h3 class="panel-title">Login <?php echo $message_error; ?></h3>
            </div>
            <div class="panel-body">
              <div class="row">
                <div class=" col-md-9 col-lg-9 " style="width: 99%;">
                <form action="" method="post"> 
                  <table class="table table-user-information">
                    <tbody>
                      <tr>
                        <td>Your Email:</td>
                        <td><input type="email" id="txt_email" name="txt_email" value="<?php echo $acc_userinfo_row[0]['email']; ?>" /></td>
                      </tr>
                       <tr>
                        <td>Your Password:</td>
                        <td><input type="password" id="txt_password" name="txt_password" value="<?php echo $acc_userinfo_row[0]['password']; ?>" /></td>
                      </tr>
                    </tbody>
                  </table>
                  <p class="text-left">
                    <input type="submit" class="btn btn-outline-rounded green" name="save_settings_acc_info" id="save_settings_acc_info" value="Login" style="margin:0px!important;padding:7px 18px!important;"/>
                    <!-- Don't have account yet? <a href="https://panel.inplayer.com/" target="_blank" class="btn btn-outline-rounded green" style="margin:0px!important;padding:7px 18px!important;" >Register</a> -->
                 </p>

                 </form>
                </div>
              </div>
            </div>
                 <div class="panel-footer">
                 </div>
          </div>
        </div>
                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
          <div class="panel panel-info">
            <div class="panel-heading">
              <h3 class="panel-title">Don't have account yet? Register <?php echo $message_register; ?></h3>
            </div>
            <div class="panel-body">
              <div class="row">
                <div class=" col-md-9 col-lg-9 " style="width: 99%;">
                <form action="" method="post"> 
                  <table class="table table-user-information">
                    <tbody>
                      <tr>
                        <td>Your Username:</td>
                        <td><input type="text" id="txt_username_register" name="txt_username_register" value="" /></td>
                      </tr>
                      <tr>
                        <td>Your Email:</td>
                        <td><input type="text" id="txt_email_register" name="txt_email_register" value="" /></td>
                      </tr>
                       <tr>
                        <td>Your Password:</td>
                        <td><input type="password" id="txt_password_register" name="txt_password_register" value="" /></td>
                      </tr>
                      <tr>
                        <td>Repeat Password:</td>
                        <td><input type="password" id="txt_password_register_repeat" name="txt_password_register_repeat" value="" /></td>
                      </tr>
                      <tr>
                        <td>Your Full Name:</td>
                        <td><input type="text" id="txt_fullname_register" name="txt_fullname_register" value="" /></td>
                      </tr>
                      <tr>
                        <td>Choose account type:</td>
                        <td><select name="role" id="role">
                              <option>---Choose account type---</option>
                              <option value="consumer">Consumer</option>
                              <option value="publisher">Publisher</option>
                            </select></td>
                      </tr>
                    </tbody>
                  </table>
                  <p class="text-left">
                    <input type="submit" class="btn btn-outline-rounded green" name="save_settings_acc_info2" id="save_settings_acc_info2" value="Register" style="margin:0px!important;padding:7px 18px!important;"/>
                    <!-- Don't have account yet? <a href="https://panel.inplayer.com/" target="_blank" class="btn btn-outline-rounded green" style="margin:0px!important;padding:7px 18px!important;" >Register</a> -->
                 </p>

                 </form>
                </div>
              </div>
            </div>
                 <div class="panel-footer">
                 </div>
          </div>
        </div>
      </div>
        </div>
      </div>
        </div>