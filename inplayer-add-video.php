<?php

require(ABSPATH . 'wp-blog-header.php');
require(ABSPATH . 'wp-load.php');
global $wpdb;
$pw_settings_table = $wpdb->prefix . "inp_acc_pw_setting_table";
$ovps_table = $wpdb->prefix . "inp_acc_ovp_table";
$apps_table = $wpdb->prefix . "inp_acc_apps_table";

$pw_settings_row = $wpdb->get_results("SELECT * FROM `$pw_settings_table` WHERE 1", ARRAY_A);
$ovps_row = $wpdb->get_results("SELECT * FROM `$ovps_table` WHERE 1", ARRAY_A);
$apps_row = $wpdb->get_results("SELECT * FROM `$apps_table` WHERE 1", ARRAY_A);
//$pw_settings_row_join = $wpdb->get_results("SELECT `tabkey.id` AS `$pw_settings_row`, AS `$ovps_row` FROM (SELECT `$pw_settings_row`.id FROM `$pw_settings_row` UNION SELECT `$ovps_row`.ovpid FROM $ovps_row) AS `tabkey` LEFT JOIN `$pw_settings_row` ON `tabkey`.id = `$pw_settings_row`.id LEFT JOIN `$ovps_row` on `tabkey`.ovpid = `$ovps_row`.ovpid");
//$pw_settings_row_join = $wpdb->get_results("SELECT `ovp` FROM `$pw_settings_row` LEFT JOIN `$ovps_row` ON `$pw_settings_row`.`ovp`= `$ovps_row`.`ovpname` WHERE `$pw_settings_row`.`ovp` = `$ovps_row`.`ovpname`");
$pw_settings_row_join = $wpdb->get_results("SELECT `ovpname` FROM `$ovps_row` LEFT JOIN `$pw_settings_row` ON `$ovps_row`.`ovpid`= `$pw_settings_row`.`ovp` WHERE `$ovps_row`.`ovpid` = `$pw_settings_row`.`ovp`");
$query = $wpdb->get_results("SELECT family.Position, food.Meal ". "FROM family, food ". "WHERE family.Position = food.Position");
$query = $wpdb->get_results("SELECT `$ovps_row`.`ovpname` FROM `$pw_settings_row`, `$ovps_row` WHERE `$pw_settings_row`.`ovp` = `$ovps_row`.`ovpid`");
foreach ( $query as $joined) {
echo $joined['ovpname'];
}
extract($_POST);

if(isset($save_pw_settings)) {
$ovpss=$_POST['ovps'];
$appss=$_POST['apps'];
$pw_settings_sql = "INSERT INTO `$pw_settings_table` SET `videoid`='".$videoids."',`ovp`='".$ovpss."',`app`='".$appss."', `shortcode`='".$shortcodeinput."'";

$wpdb->query($pw_settings_sql);
}


$videoid = "<span id='videoid1'></span>"; 
$ovp = "<span id='ovp1'></span>";
$app = "<span id='app1'></span>";
//$shortcodeinput = '[inplayer video="'. $videoid .'" ovp="'. $ovp .'" app="'. $app .'"]';
$shortcodeinput = "[inplayer video=". $videoid ." ovp=". $ovp ." app=". $app ."]";
//$shortcodeinput1 = "$shortcodeinput";
//$shortcodeinput1 = settype($shortcodeinput, 'string');
$shortcodeinput1 = strval($shortcodeinput);
$shortcodespan = '[inplayer video="'. $videoid .'" ovp="'. $ovp .'" app="'. $app .'"]';
?>
        <div class="container">
            <div class="row">
            <h4 class="text-center">Your Inplayer - Add Protected Video</h4>
      <p class="text-center">Embed your video with ease into your posts or pages</p>
      <p class="text-center">1. Enter your Video ID =>
      2. Choose the OVP for that video =>
      3. Choose the active app on that video =>
      4. Save the shortcode and paste it into your posts or pages</p>
<div class="container">
<div class="stepwizard">
    <div class="stepwizard-row setup-panel">
        <div class="stepwizard-step">
            <a href="#step-1" type="button" class="btn btn-primary btn-circle">1</a>
            <p>1. Setup your Paywall and video</p>
        </div>
        <!--<div class="stepwizard-step">
            <a href="#step-2" type="button" class="btn btn-default btn-circle" disabled="disabled">2</a>
            <p>2. Secure your premium content</p>
        </div>-->
        <div class="stepwizard-step">
            <a href="#step-2" type="button" class="btn btn-default btn-circle" disabled="disabled">2</a>
            <p>2. Get the embed shortcode for post/page</p>
        </div>
    </div>
</div>
<form action="" method="post">
    <div class="row setup-content" id="step-1">
    <div class="clear"></div>
        <div class="col-xs-12">
            <div class="col-md-10">
                <!-- <h3>1. Setup your Paywall and video</h3>
                <h5>Sign in/up to your <a href="https://panel.inplayer.com/login/">Inplayer Publisher</a> account</h5>
                <h5>Upload your video from the list of the OVP's</h5>
                <h5>Choose application form the list for monetizing the video</h5>
                <h5>and get your Video ID</h5> -->
                <div class="form-group">
                    <label class="control-label">Video ID:</label>
                    <input  maxlength="100" type="text" required="required" name="videoids" id="videoids" class="form-control" value="" placeholder="Put your video ID here"  />
                </div>
                <div class="form-group">
                    <label class="control-label">OVP(OnlineVideoPlayer):</label>
                    <select required="required" class="form-control required" id="ovps" name="ovps" style="height: 34px;">
                    	<option value="">--- Select OVP ---</option>
                    	<?php foreach ( $ovps_row  as $ovps) {?>
                        <option value="<?php echo $ovps['ovpid']; ?>"><?php echo $ovps['ovpname']; ?></option>
                        <?php } ?>                         
                    </select>
                </div>
                <div class="form-group">
                    <label class="control-label">Application Active:</label>
                    <select required="required" class="form-control required" id="apps" name="apps" style="height: 34px;">
                    	<option value="">--- Select Application ---</option>
                    	<?php foreach ( $apps_row  as $apps) {?>
                        <option value="<?php echo $apps['appid']; ?>"><?php echo $apps['appname']; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <button class="btn btn-primary nextBtn btn-lg pull-right" type="button" >Next</button>
            </div>
        </div>
        <div class="clear"></div>
    </div>
    <!--<div class="row setup-content" id="step-2">
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
    </div>-->
    <div class="clear"></div>
    <div class="row setup-content" id="step-2">
        <div class="col-xs-12">
            <div class="col-md-10">
                <h3>2. Get the embed shortcode for post/page</h3>
                <h5>Copy this automatically generated shortcode and paste it in your post/page where you want to display the video content</h5>
                <h5>Shortcode</h5>
                <span id="shortcodetodb"><?php echo $shortcodespan; ?></span><br/>
                <input type="hidden" name="shortcodetodb1" id="shortcodetodb1" value="<?php echo $shortcodeinput1; ?>" />
                <a href="#copy" class="button-secondary" id="copyshortcode">Copy</a>
                <div class="clear"></div>
                <button class="btn btn-success btn-lg pull-right" type="submit" name="save_pw_settings" id="save_pw_settings">Save Video</button>
            </div>
        </div>
    </div>
</form>
</div>
</div>
<div class="tab-content faq-cat-content">
    <div class="tab-pane active in fade" id="faq-cat-1">
        <div class="panel-group" id="accordion-cat-1">
            <div class="panel panel-default panel-faq">
                <div class="panel-heading">
                    <a data-toggle="collapse" data-parent="#accordion-cat-1" href="#faq-cat-1-sub-1">
                        <h4 class="panel-title">
                            VIEW YOUR SAVED VIDEOS &amp; SHORTCODES
                            <span class="pull-right"><i class="glyphicon glyphicon-plus"></i></span>
                        </h4>
                    </a>
                </div>
                <div id="faq-cat-1-sub-1" class="panel-collapse collapse">
                    <div class="panel-body">
                        <table class="table" id="table">
                        <thead>
                            <tr>
                                <th>Video ID:</th>
                                <th>OVP(OnlineVideoPlayer):</th>
                                <th>Application Active:</th>
                                <th>Video embed shortcodee:</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ( $pw_settings_row  as $pws) {?>
                            <tr>
                                <td><?php echo $pws['videoid']; ?></td>
                                <td><?php if($pws['ovp']==1) echo "Brightcove";else if($pws['ovp']==2) echo "Dailymotion";else if($pws['ovp']==3) echo "Freecaster";else if($pws['ovp']==4) echo "Kaltura";else if($pws['ovp']==5) echo "Limelight";else if($pws['ovp']==6) echo "Livebeats";else if($pws['ovp']==7) echo "Piksel";else if($pws['ovp']==8) echo "MUZU.TV";else if($pws['ovp']==9) echo "Nexeven";else if($pws['ovp']==10) echo "Ooyala";else if($pws['ovp']==11) echo "OSMF";else if($pws['ovp']==12) echo "Other";else if($pws['ovp']==13) echo "Qbrick";else if($pws['ovp']==14) echo "StreamUK";else if($pws['ovp']==15) echo "Stupeflix";else if($pws['ovp']==16) echo "thePlatform";else if($pws['ovp']==17) echo "Twistage";else if($pws['ovp']==18) echo "TooCast";else if($pws['ovp']==19) echo "Unicorn Media";else if($pws['ovp']==20) echo "Vimeo";else if($pws['ovp']==21) echo "Vyoo";else if($pws['ovp']==22) echo "vzaar";else if($pws['ovp']==23) echo "YouTube"; ?></td>
                                <td><?php if($pws['app']==1) echo "Paywall"; else echo "Donations"; ?></td>
                                <td>[inplayer video="<?php echo $pws['videoid']; ?>" ovp="<?php if($pws['ovp']==1) echo "Brightcove";else if($pws['ovp']==2) echo "Dailymotion";else if($pws['ovp']==3) echo "Freecaster";else if($pws['ovp']==4) echo "Kaltura";else if($pws['ovp']==5) echo "Limelight";else if($pws['ovp']==6) echo "Livebeats";else if($pws['ovp']==7) echo "Piksel";else if($pws['ovp']==8) echo "MUZU.TV";else if($pws['ovp']==9) echo "Nexeven";else if($pws['ovp']==10) echo "Ooyala";else if($pws['ovp']==11) echo "OSMF";else if($pws['ovp']==12) echo "Other";else if($pws['ovp']==13) echo "Qbrick";else if($pws['ovp']==14) echo "StreamUK";else if($pws['ovp']==15) echo "Stupeflix";else if($pws['ovp']==16) echo "thePlatform";else if($pws['ovp']==17) echo "Twistage";else if($pws['ovp']==18) echo "TooCast";else if($pws['ovp']==19) echo "Unicorn Media";else if($pws['ovp']==20) echo "Vimeo";else if($pws['ovp']==21) echo "Vyoo";else if($pws['ovp']==22) echo "vzaar";else if($pws['ovp']==23) echo "YouTube"; ?>" app="<?php if($pws['app']==1) echo "Paywall"; else echo "Donations"; ?>"]</td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>                
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>