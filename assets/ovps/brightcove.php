<h1>BRIGHTCOVE</h1>
<?php
require('wp-load.php');
global $wpdb;
$acc_info_table = $wpdb->prefix . "inp_acc_info_table";
$pw_settings_table = $wpdb->prefix . "inp_acc_pw_setting_table";
$acc_info_row = $wpdb->get_results("SELECT * FROM `$acc_info_table` WHERE 1", ARRAY_A);
$pw_settings_row = $wpdb->get_results("SELECT * FROM `$pw_settings_table` WHERE 1", ARRAY_A);
?>
<link rel="stylesheet" type="text/css" href="http://plugin.inplayer.com/html5/v3/latest/style/style.css"/>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script type="text/javascript" src="http://plugin.inplayer.com/html5/v3/latest/scripts/inplayer.js"></script>
<script type="text/javascript" src="http://plugin.inplayer.com/html5/latest/scripts/flashdetect.js"></script>
<script type="text/javascript"> 
var inv_vid = <?php echo $pw_settings_row[9]['videoid']; ?>;
var inv_pid = <?php echo $acc_info_row[0]['publisherid']; ?>;
</script> 
<!-- Start of Brightcove Player -->
<div style="display:none">
</div>
<!--
By use of this code snippet, I agree to the Brightcove Publisher T and C 
found at https://accounts.brightcove.com/en/terms-and-conditions/. 
-->
<script language="JavaScript" type="text/javascript" src="http://admin.brightcove.com/js/BrightcoveExperiences.js"></script>
<object id="myExperience3916863792001" class="BrightcoveExperience">
<param name="bgcolor" value="#FFFFFF" />
<param name="width" value="550" />
<param name="height" value="320" />
<param name="playerID" value="" />
<param name="playerKey" value="AQ~~,AAAAEnqFE6k~,BzTqje2ipv-mwhoSOearQ15tvcUZgNbg" />
<param name="isVid" value="true" />
<param name="isUI" value="true" />
<param name="dynamicStreaming" value="true" />
<param name="@videoPlayer" value="3916863792001" />
<param name="includeAPI" value="true" />
<param name="templateLoadHandler" value="inplayer.ovps.brightcove.templateLoaded"/>
</object>
<!-- 
This script tag will cause the Brightcove Players defined above it to be created as soon
as the line is read by the browser. If you wish to have the player instantiated only after
the rest of the HTML is processed and the page load is complete, remove the line.
-->
<script type="text/javascript">brightcove.createExperiences();</script>
<!-- End of Brightcove Player -->