<h1>WISTIA</h1>
<?php
require('wp-load.php');
global $wpdb;
$acc_info_table = $wpdb->prefix . "inp_acc_info_table";
$pw_settings_table = $wpdb->prefix . "inp_acc_pw_setting_table";
$acc_info_row = $wpdb->get_results("SELECT * FROM `$acc_info_table` WHERE 1", ARRAY_A);
$pw_settings_row = $wpdb->get_results("SELECT * FROM `$pw_settings_table` WHERE 1", ARRAY_A);
?>
<div id="wistia_gcb1xzcrhf" style="height:387px;width:640px" data-video-width="640" data-video-height="360">
this is displayed if javascript is disabled
</div>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
<script src="http://fast.wistia.net/static/E-v1.js"></script>
<script type="text/javascript" src="http://plugin.inplayer.com/html5/testing/v3/3.0.6/scripts/inplayer.js"></script>
<script>
inplayer.publisher_id = <?php echo $acc_info_row[0]['publisherid']; ?>;
wistiaEmbed = Wistia.embed("gcb1xzcrhf", {
playerColor: "ff0000",
fullscreenButton: true,
container: "wistia_gcb1xzcrhf"
});
inplayer.ovps.wistia.players = [wistiaEmbed];
</script>
<link rel="stylesheet" type="text/css" href="http://plugin.inplayer.com/html5/testing/v3/3.0.6/style/style.css" />