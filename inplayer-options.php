<?php
/*CONST API_LOGIN = "http://api.invideous.com/plugin/login";
CONST API_CREATE_PACKAGE = "http://api.inplayer.com/write/create_package";*/

require(ABSPATH . 'wp-blog-header.php');
require(ABSPATH . 'wp-load.php');
global $wpdb;

$acc_info_table = $wpdb->prefix . "inp_acc_info_table";
$acc_userinfo = $wpdb->prefix . "inp_acc_userinfo";


$acc_info_row = $wpdb->get_results("SELECT * FROM `$acc_info_table` WHERE 1", ARRAY_A);
$acc_userinfo_row = $wpdb->get_results("SELECT * FROM `$acc_userinfo` WHERE 1", ARRAY_A);
extract($_POST);

if(isset($save_settings_acc_info1)) {

  $insert_userinfo_sql1 = "UPDATE `$acc_info_table` SET `token`='$txt_token',`publickey`='$txt_pukey',`privatekey`='$txt_prkey' WHERE 1";

  $wpdb->query($insert_userinfo_sql1);

  echo "<script>location.href = '".admin_url('admin.php?page=manage-general-options')."';</script>";

}

?>
<div class="container">
            <div class="row">
            <h4 class="text-center">Your Inplayer - API Settings</h4>
      <p class="text-center">Settings for your Inplayer Publisher Account</p>
<div class="container">
      <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 col-xs-offset-0 col-sm-offset-0 col-md-offset-2 col-lg-offset-2 toppad" >
          <div class="panel panel-info">
            <div class="panel-heading">
              <h3 class="panel-title">Personal Information</h3>
            </div>
            <div class="panel-body">
              <div class="row">
                <div class=" col-md-6 col-lg-6 ">
                <form action="" method="post"> 
                  <table class="table table-user-information">
                    <tbody>
                      <tr>
                        <td>Publisher ID:</td>
                        <td><?php echo $acc_info_row[0]['publisherid']; ?></td>
                      </tr>
                      <tr>
                        <td>Full Name:</td>
                        <td><?php echo $acc_info_row[0]['fullname']; ?></td>
                      </tr>
                      <tr>
                        <td>Email Address:</td>
                        <td><?php echo $acc_info_row[0]['email']; ?></td>
                      </tr>
                      <tr>
                        <td>Screen Name:</td>
                        <td><?php echo $acc_info_row[0]['screenname']; ?></td>
                      </tr>
                      </tbody>
                      </table>
                      </div>
                      <div class=" col-md-6 col-lg-6 ">
                      <table class="table table-user-information">
                      <tbody>
                      <tr>
                        <td>Your Token:</td>
                        <td><input type="text" id="txt_token" name="txt_token" value="<?php echo $acc_info_row[0]['token']; ?>" /></td>
                      </tr>
                       <tr>
                        <td>Your Public Key:</td>
                        <td><input type="text" id="txt_pukey" name="txt_pukey" value="<?php echo $acc_info_row[0]['publickey']; ?>" /></td>
                      </tr>
                   
                         <tr>
                             <tr>
                        <td>Your Private Key:</td>
                        <td><input type="text" id="txt_prkey" name="txt_prkey" value="<?php echo $acc_info_row[0]['privatekey']; ?>" /></td>
                      </tr>
                    </tbody>
                  </table>
                  <p class="text-left">
                    <input type="submit" class="btn btn-outline-rounded green" name="save_settings_acc_info1" id="save_settings_acc_info1" value="Save Changes" style="margin:0px!important;padding:7px 18px!important;"/>
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
<?php
//}
//}
?>