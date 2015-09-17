<h1>OOYALA</h1>
<?php
require('wp-load.php');
global $wpdb;
$acc_info_table = $wpdb->prefix . "inp_acc_info_table";
$pw_settings_table = $wpdb->prefix . "inp_acc_pw_setting_table";
$acc_info_row = $wpdb->get_results("SELECT * FROM `$acc_info_table` WHERE 1", ARRAY_A);
$pw_settings_row = $wpdb->get_results("SELECT * FROM `$pw_settings_table` WHERE 1", ARRAY_A);
?>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
<script type="text/javascript" src="http://plugin.inplayer.com/html5/v3/latest/scripts/inplayer.js"></script> 
<link rel="stylesheet" type="text/css" href="http://plugin.inplayer.com/html5/v3/latest/style/style.css" />
<script src='//player.ooyala.com/v3/92ec3ecbb6fc4e39b42c310faf96abb4'></script>
<div id='ooyalaplayer' style='width:480px;height:360px'></div>
<script>
inplayer.publisher_id = <?php echo $acc_info_row[0]['publisherid']; ?>;
OO.ready(function() { 
OO.Player.create('ooyalaplayer', 'BvaWd2cTpQdb5pL7FFevTKATxzl7VuGu', {
onCreate: inplayer.ovps.ooyala.onCreate,
wmode: 'transparent',
autoplay: true
});
});
</script>
<noscript><div>Please enable Javascript to watch this video</div></noscript>
</body>
</html>
<script src='//player.ooyala.com/v3/92ec3ecbb6fc4e39b42c310faf96abb4'></script><div id='ooyalaplayer' style='width:480px;height:360px'></div><script>OO.ready(function() { OO.Player.create('ooyalaplayer', 'BvaWd2cTpQdb5pL7FFevTKATxzl7VuGu'); });</script><noscript><div>Please enable Javascript to watch this video</div></noscript>