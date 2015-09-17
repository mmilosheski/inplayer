<h1>YOUTUBE</h1>
<?php
require('wp-load.php');
global $wpdb;
$acc_info_table = $wpdb->prefix . "inp_acc_info_table";
$pw_settings_table = $wpdb->prefix . "inp_acc_pw_setting_table";
$acc_info_row = $wpdb->get_results("SELECT * FROM `$acc_info_table` WHERE 1", ARRAY_A);
$pw_settings_row = $wpdb->get_results("SELECT * FROM `$pw_settings_table` WHERE 1", ARRAY_A);
?>
<div id="inv_mediaplayer"><p><a href="http://www.adobe.com/go/getflashplayer">
<img border = "0" src = "http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt = "Get Adobe Flash player" /></a ></p>
</div>
<script type="text/javascript" src="http://plugin.inplayer.com/player/licensed/5.9/jwplayer.js"></script>
<script type="text/javascript">
    jwplayer("inv_mediaplayer").setup({
        flashplayer: "http://plugin.inplayer.com/player/licensed/5.9/player.swf",
        width: 512,
        height: 288,
        volume: 100,
        mute: false,
        autostart: false,
        file: 'http://www.youtube.com/v/hMR7FgM2ksM',
        plugins: 'http://plugin.inplayer.com/v6/inplayer.swf',
        'inplayer.pid': '<?php echo $acc_info_row[0]['publisherid'] ?>',
        'inplayer.ovp_name' : 'youtube',
        'inplayer.ovp_video_id' : 'hMR7FgM2ksM'
    });
</script>