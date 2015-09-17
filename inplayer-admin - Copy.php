<?php

require(ABSPATH . 'wp-blog-header.php');
require(ABSPATH . 'wp-load.php');
global $wpdb;

$acc_info_table = $wpdb->prefix . "inp_acc_info_table";
$pw_settings_table = $wpdb->prefix . "inp_acc_pw_setting_table";
$ovps_table = $wpdb->prefix . "inp_acc_ovp_table";
$apps_table = $wpdb->prefix . "inp_acc_apps_table";

$acc_info_row = $wpdb->get_results("SELECT * FROM `$acc_info_table` WHERE 1", ARRAY_A);
$pw_settings_row = $wpdb->get_results("SELECT * FROM `$pw_settings_table` WHERE 1", ARRAY_A);
$ovps_row = $wpdb->get_results("SELECT * FROM `$ovps_table` WHERE 1", ARRAY_A);
$apps_row = $wpdb->get_results("SELECT * FROM `$apps_table` WHERE 1", ARRAY_A);

extract($_POST);

if(isset($save_settings_acc_info)) {
$acc_info_sql = "UPDATE `$acc_info_table` SET `id`='$txt_acc_id',`token`='$txt_token',`pukey`='$txt_pukey',`prkey`='$txt_prkey' WHERE 1";
$wpdb->query($acc_info_sql);
}
if(isset($save_pw_settings)) {
$pw_settings_sql = "UPDATE `$pw_settings_table` SET `id`='$txt_acc_id',`token`='$txt_token',`pukey`='$txt_pukey',`prkey`='$txt_prkey', `fullname`='fullname', `email`='email', `screenname`='screenname', `phone`='phone', `uid`='uid' WHERE 1";
  $wpdb->query($pw_settings_sql);
}
$dir = plugin_dir_path( __FILE__ );
?>
    <!--<link rel="stylesheet" href="<?php echo $dir?>assets/css/bootstrap.css" type="text/css" media="all" />
    <link rel="stylesheet" href="<?php echo $dir?>assets/css/bootstrap.min.css" type="text/css" media="all" />
    <link rel="stylesheet" href="<?php echo $dir;?>assets/css/bootstrap-theme.css" type="text/css" media="all" />
    <link rel="stylesheet" href="<?php echo $dir;?>assets/css/bootstrap-theme.min.css" type="text/css" media="all" />
<section style="background:#efefe9;">-->
        <div class="container inplayer-holder">
            <div class="row">
            <h4 class="text-center">Your Inplayer Paywall Manager</h4>
			<p class="text-center">Settings for your Inplayer WordPress plugin</p>
                <div class="board">
                    <div class="board-inner">
                    <ul class="nav nav-tabs" id="myTab">
                    <div class="liner"></div>
                     <li><h4>Paywall Settings</h4>
                     <a href="#home" data-toggle="tab" title="">
                      
                      <span class="round-tabs one">
                         <i class="glyphicon glyphicon-cog"></i>
                      </span> 
                  </a></li>
                  <li class="active" style="display:none"><h4>Paywall Settings</h4>
                     <a href="#landing" data-toggle="tab" title="">
                      
                      <span class="round-tabs one">
                         <i class="glyphicon glyphicon-cog"></i>
                      </span> 
                  </a></li>
                 <li><h4>General Settings</h4>
                 	 <a href="#messages" data-toggle="tab" title="">
                 	 
                     <span class="round-tabs three">
                          <i class="glyphicon glyphicon-wrench"></i>
                     </span> </a>
                     </li>

                  	 <li><h4>Your Videos</h4>
                  	 <a href="#profile" data-toggle="tab" title="">
                     
                     <span class="round-tabs two">
                         <i class="glyphicon glyphicon-facetime-video"></i>
                     </span> 
           </a>
                 </li>
                     </ul></div>

                     <div class="tab-content">
                     <div class="tab-pane fade in active" id="landing">
                     <h4 class="text-center">Landing Page Here 1st time openning</h4>
                     </div>
                      <div class="tab-pane fade" id="home">
                      	<div class="container">
<div class="stepwizard">
    <div class="stepwizard-row setup-panel">
        <div class="stepwizard-step">
            <a href="#step-1" type="button" class="btn btn-primary btn-circle">1</a>
            <p>1. Setup your Paywall and video</p>
        </div>
        <div class="stepwizard-step">
            <a href="#step-2" type="button" class="btn btn-default btn-circle" disabled="disabled">2</a>
            <p>2. Secure your premium content</p>
        </div>
        <div class="stepwizard-step">
            <a href="#step-3" type="button" class="btn btn-default btn-circle" disabled="disabled">3</a>
            <p>3. Get the embed shortcode for post/page</p>
        </div>
    </div>
</div>
<form role="form">
    <div class="row setup-content" id="step-1">
        <div class="col-xs-12">
            <div class="col-md-10">
                <h3>1. Setup your Paywall and video</h3>
                <h5>Sign in/up to your <a href="https://panel.inplayer.com/login/">Inplayer Publisher</a> account</h5>
                <h5>Upload your video from the list of the OVP's</h5>
                <h5>Choose application form the list for monetizing the video</h5>
                <h5>and get your Video ID</h5>
                <div class="form-group">
                    <label class="control-label">Video ID:</label>
                    <input  maxlength="100" type="text" required="required" name="vidid" id="vidid" class="form-control" value="" placeholder="Put your video ID here"  />
                </div>
                <div class="form-group">
                    <label class="control-label">OVP(OnlineVideoPlayer):</label>
                    <!--<input maxlength="100" type="text" required="required" class="form-control" value="Paywall" />-->
                    <select required="required" class="form-control required" style="height: 34px;">
                    	<option value="">--- Select OVP ---</option>
                    	<?php foreach ( $ovps_row  as $ovps) {?>
                        <option value="<?php echo $ovps['ovpid']; ?><?php //echo mb_strtolower($ovps['ovpname']); ?>"><?php echo $ovps['ovpname']; ?></option>
                        <?php } ?>                         
                        <!--<option value="brightcove">Brightcove</option>                          
                        <option value="dailymotion">Dailymotion</option>                          
                        <option value="freecaster">Freecaster</option>                          
                        <option value="kaltura">Kaltura</option>                          
                        <option value="limelight">Limelight</option>                          
                        <option value="livebeats">Livebeats</option>                          
                        <option value="multicastmedia">Piksel</option>                          
                        <option value="muzu">MUZU.TV</option>                          
                        <option value="nexeven">Nexeven</option>                          
                        <option value="ooyala">Ooyala</option>                          
                        <option value="osmf">OSMF</option>                          
                        <option value="other">Other</option>                          
                        <option value="qbrick">Qbrick</option>                          
                        <option value="streamuk">StreamUK</option>                          
                        <option value="stupeflix">Stupeflix</option>                          
                        <option value="the_platform">thePlatform</option>                          
                        <option value="twistage">Twistage</option>                          
                        <option value="toocast">TooCast</option>                          
                        <option value="unicorn">Unicorn Media</option>
                        <option value="vimeo">Vimeo</option>                          
                        <option value="vyoo">Vyoo</option>
                        <option value="vzaar">vzaar</option>
                        <option value="youtube">YouTube</option>-->
                    </select>
                </div>
                <div class="form-group">
                    <label class="control-label">Application Active:</label>
                    <!--<input maxlength="100" type="text" required="required" class="form-control" value="Paywall" />-->
                    <select required="required" class="form-control required" style="height: 34px;">
                    	<option value="">--- Select Application ---</option>
                    	<?php foreach ( $apps_row  as $apps) {?>
                        <option value="<?php echo $apps['appid']; ?><?php //echo mb_strtolower($apps['appname']); ?>"><?php echo $apps['appname']; ?></option>
                        <?php } ?>
                    	<!--<option value="paywall">Paywall</option>
                    	<option value="donations">Donations</option>-->
                    </select>
                </div>
                <button class="btn btn-primary nextBtn btn-lg pull-right" type="button" >Next</button>
            </div>
        </div>
    </div>
    <div class="row setup-content" id="step-2">
        <div class="col-xs-12">
            <div class="col-md-10">
            <div class="col-md-11">
                <h3>2. Secure your premium content</h3>
                <h5>Choose the tags and restrict all the posts/pages that are tagged with that tag</h5>
                <div class="postbox"> 
				<h3 style="margin-bottom:0px">Select the tags of the content you want restricted</h3>
				<div class=""> 
					<div class="inp-tag-holder">
					</div>
					<div class="clear"></div>
					<div class="inp-tag-entry tp-bg">
						<input type="text" class="premium_tags" autocomplete="on">
						<a class="add_tag button-secondary">Add</a>
					</div>
				</div>
				
			</div>
            </div>
<button class="btn btn-primary nextBtn btn-lg pull-right" type="button" >Next</button>
            </div>
        </div>
    </div>
    <div class="row setup-content" id="step-3">
        <div class="col-xs-12">
            <div class="col-md-10">
                <h3>3. Get the embed shortcode for post/page</h3>
                <h5>Copy this automatically generated shortcode and paste it in your post/page where you want to display the video content</h5>
                <h5>Shortcode</h5>
                <input type="text" id="shortcodebox" value='[inplayer ovp="vimeo" vidid="1244123" activeapp="paywall"]'/><a href="#copy" class="button-secondary" id="copyshortcode">Copy</a>
                <div class="clear"></div>
                <button class="btn btn-success btn-lg pull-right" type="submit" name="save_pw_settings" id="save_pw_settings">Save Video</button>
            </div>
        </div>
    </div>
</form>
</div>
                      </div>
                      <div class="tab-pane fade" id="messages" style="padding-top:0!important">
                          <div class="container">
      <div class="row">
          <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xs-offset-0 col-sm-offset-0 col-md-offset-3 col-lg-offset-3 toppad" style="margin-left:0!important;width:45%!important;">
          <div class="panel panel-info">
            <div class="panel-heading">
              <h3 class="panel-title">Account Information</h3>
            </div>
            <div class="panel-body">
              <div class="row">
                <div class=" col-md-9 col-lg-9 " style="width: 99%;">
                <form action="" method="post"> 
                  <table class="table table-user-information">
                    <tbody>
                      <tr>
                        <td>Your Publisher ID:</td>
                        <td><input type="text" id="txt_acc_id" name="txt_acc_id" value="<?php echo $acc_info_row[0]['id']; ?>" /></td>
                      </tr>
                      <tr>
                        <td>Your Read Token:</td>
                        <td><input type="text" id="txt_token" name="txt_token" value="<?php echo $acc_info_row[0]['token']; ?>" /></td>
                      </tr>
                      <tr>
                        <td>Your Public Key:</td>
                        <td><input type="text" id="txt_pukey" name="txt_pukey" value="<?php echo $acc_info_row[0]['pukey']; ?>" /></td>
                      </tr>
                   
                         <tr>
                             <tr>
                        <td>Your Private Key:</td>
                        <td><input type="text" id="txt_prkey" name="txt_prkey" value="<?php echo $acc_info_row[0]['prkey']; ?>" /></td>
                      </tr>   
                      </tr>
                    </tbody>
                  </table>
                  <p class="text-left">
                    <input type="submit" class="btn btn-outline-rounded green" name="save_settings_acc_info" id="save_settings_acc_info" value="Save Settings" style="margin:0px!important;padding:7px 18px!important;"/>
                 </p>
                 </form>
                </div>
              </div>
            </div>
                 <div class="panel-footer">
                 </div>
          </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xs-offset-0 col-sm-offset-0 col-md-offset-3 col-lg-offset-3 toppad" style="margin-left:0!important;width:45%!important;">
          <div class="panel panel-info">
            <div class="panel-heading">
              <h3 class="panel-title">Personal Information</h3>
            </div>
            <div class="panel-body">
              <div class="row">
                <div class="col-md-3 col-lg-3 " align="center"> <img alt="User Pic" src="https://lh5.googleusercontent.com/-b0-k99FZlyE/AAAAAAAAAAI/AAAAAAAAAAA/eu7opA4byxI/photo.jpg?sz=100" class="img-circle"> </div>
                <div class=" col-md-9 col-lg-9 "> 
                  <table class="table table-user-information">
                    <tbody>
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
                   
                         <tr>
                             <tr>
                        <td>Phone Number:</td>
                        <td><?php echo $acc_info_row[0]['phone']; ?></td>
                      </tr>   
                      </tr>
                      <tr style="border-top:none!important">
                        <td></td>
                        <td></td>
                      </tr>
                      <tr style="border-top:none!important">
                        <td></td>
                        <td></td>
                      </tr>
                      <tr style="border-top:none!important">
                        <td></td>
                        <td></td>
                      </tr>
                      <tr style="border-top:none!important">
                        <td></td>
                        <td></td>
                      </tr>
                      <tr style="border-top:none!important">
                        <td></td>
                        <td></td>
                      </tr>
                    </tbody>
                  </table>
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
                       <div class="tab-pane fade" id="profile">
                       <div class="container">
<div class="row">
    <!--<div class="col-lg-12">
        <h3>Search your videos</h3>
    </div>
</div>
<div class="row">
   <div class="col-lg-4">
      <input type="search" id="search" value="" class="form-control" placeholder="Search using Fuzzy searching">
   </div>
</div>-->
<div class="row">
        <div class="col-lg-11 tablewidth">
            <table class="table" id="table">
                <thead>
                    <tr>
                        <th>Video ID:</th>
                        <th>OVP(OnlineVideoPlayer):</th>
                        <th>Application Active:</th>
                        <th>Tags:</th>
                        <th>Video embed shortcodee:</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ( $pw_settings_row  as $pws) {?>
                    <tr>
                        <td><?php echo $pws['vidid']; ?></td>
                        <td><?php if($pws['ovptype']==1) echo "Brightcove";else if($pws['ovptype']==2) echo "Dailymotion";else if($pws['ovptype']==3) echo "Freecaster";else if($pws['ovptype']==4) echo "Kaltura";else if($pws['ovptype']==5) echo "Limelight";else if($pws['ovptype']==6) echo "Livebeats";else if($pws['ovptype']==7) echo "Piksel";else if($pws['ovptype']==8) echo "MUZU.TV";else if($pws['ovptype']==9) echo "Nexeven";else if($pws['ovptype']==10) echo "Ooyala";else if($pws['ovptype']==11) echo "OSMF";else if($pws['ovptype']==12) echo "Other";else if($pws['ovptype']==13) echo "Qbrick";else if($pws['ovptype']==14) echo "StreamUK";else if($pws['ovptype']==15) echo "Stupeflix";else if($pws['ovptype']==16) echo "thePlatform";else if($pws['ovptype']==17) echo "Twistage";else if($pws['ovptype']==18) echo "TooCast";else if($pws['ovptype']==19) echo "Unicorn Media";else if($pws['ovptype']==20) echo "Vimeo";else if($pws['ovptype']==21) echo "Vyoo";else if($pws['ovptype']==22) echo "vzaar";else if($pws['ovptype']==23) echo "YouTube"; ?></td>
                        <td><?php if($pws['activeapp']==1) echo "Paywall"; else echo "Donations"; ?></td>
                        <td><?php echo $pws['tags']; ?></td>
                        <td><?php echo "shortcode";//$pws['appname']; ?></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
            <hr>
        </div>
    </div>
    </div>
                      </div>
</div>
</div>
</div>
</div>
<!--</section>-->