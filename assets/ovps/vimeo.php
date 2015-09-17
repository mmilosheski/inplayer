<h1>VIMEO</h1>
<?php
require('wp-load.php');
global $wpdb;
$acc_info_table = $wpdb->prefix . "inp_acc_info_table";
$pw_settings_table = $wpdb->prefix . "inp_acc_pw_setting_table";
$acc_info_row = $wpdb->get_results("SELECT * FROM `$acc_info_table` WHERE 1", ARRAY_A);
$pw_settings_row = $wpdb->get_results("SELECT * FROM `$pw_settings_table` WHERE 1", ARRAY_A);
?>
<div align="center">
<div id="swf_container">
<p><a href="http://www.adobe.com/go/getflashplayer"><img border="0" src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Get Adobe Flash player" /></a></p>
</div>
<script type="text/javascript" src="http://plugin.inplayer.com/common/swfobject.js">
</script>
<script type="text/javascript">
//var pid = <?php echo $acc_info_row[0]['publisherid']; ?>;
//var vid = <?php echo $pw_settings_row[5]['videoid']; ?>;
var flashvars = {
type: 'http://plugin.inplayer.com/vimeo/vimeo.swf',
file: 'https://vimeo.com/93190447',
plugins: "http://plugin.inplayer.com/v6/inplayer.swf",
width: 550,
height: 320,
screencolor: '0x000000',
skin: 'http://plugin.inplayer.com/vimeo/bekle.zip',
controlbar: 'over',
stretching: 'fill',
'inplayer.pid': <?php echo $acc_info_row[0]['publisherid']; ?>,
'inplayer.ovp_video_id': <?php echo $pw_settings_row[5]['videoid']; ?>, 
'inplayer.ovp_name': 'vimeo'
};
var parameters = {
allowfullscreen: "true",
allownetworking: "all",
allowscriptaccess: "always",
};

swfobject.embedSWF("http://plugin.inplayer.com/common/player_5.6_licensed.swf","swf_container","550","320","10.0.0","http://plugin.inplayer.com/common/expressInstall.swf", flashvars, parameters);
</script>
</div>