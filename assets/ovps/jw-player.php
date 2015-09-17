<h1>JW PLAYER</h1>
<?php
require('wp-load.php');
global $wpdb;
$acc_info_table = $wpdb->prefix . "inp_acc_info_table";
$pw_settings_table = $wpdb->prefix . "inp_acc_pw_setting_table";
$acc_info_row = $wpdb->get_results("SELECT * FROM `$acc_info_table` WHERE 1", ARRAY_A);
$pw_settings_row = $wpdb->get_results("SELECT * FROM `$pw_settings_table` WHERE 1", ARRAY_A);
?>
<script type="text/javascript" src="http://invideous.s3.amazonaws.com/html5/jwplayer/jwplayer.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
<script type="text/javascript" src="http://plugin.inplayer.com/html5/v3/latest/scripts/inplayer.js"></script>
<link rel="stylesheet" type="text/css" href="http://plugin.inplayer.com/html5/v3/latest/style/style.css" />
<div id='playerCVzPaBIh' class="invideous">Loading the player...</div>
<script type='text/javascript'>
    jwplayer('playerCVzPaBIh').setup({
        playlist: '//content.jwplatform.com/feed/CVzPaBIh.rss',
        width: '100%',
        aspectratio: '16:9',
        skin: 'vapor',
        invideous:{
		publisher_id: <?php echo $acc_info_row[0]['publisherid']; ?>
		}
    });
</script>
<!-- <div id="myElement" class="invideous">Loading the player...</div>

<script type="text/javascript">
jwplayer("myElement").setup({
file: "http://staging.invideous.com/demo/NewPlugin/The%20Roots%20-%20The%20Seed%20%282.0%29%20ft.%20Cody%20ChesnuTT.mp4",
image: "http://www.invideous.com/media/images/publisher/video-not-available.png",
width: "550px",
height: "320px",
aspectratio: "12:5",
invideous:{
publisher_id: 414301
}
});
</script> -->