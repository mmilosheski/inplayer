<h1>THE PLATFORM</h1>
<?php
require('wp-load.php');
global $wpdb;
$acc_info_table = $wpdb->prefix . "inp_acc_info_table";
$pw_settings_table = $wpdb->prefix . "inp_acc_pw_setting_table";
$acc_info_row = $wpdb->get_results("SELECT * FROM `$acc_info_table` WHERE 1", ARRAY_A);
$pw_settings_row = $wpdb->get_results("SELECT * FROM `$pw_settings_table` WHERE 1", ARRAY_A);
?>
<meta name="tp:EnableExternalController" content="true" />
<meta name="tp:PreferredRuntimes" content="Flash,HTML5" />
<script type="text/javascript"
src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
<script src="http://plugin.inplayer.com/html5/v3/latest/scripts/inplayer.js"
type="text/javascript"></script>
<script type="text/javascript">
inplayer.publisher_id = <?php echo $acc_info_row[0]['publisherid']; ?>;
</script>
<link rel="stylesheet" type="text/css"
href="http://plugin.inplayer.com/html5/v3/latest/style/style.css" />
</head>
<body>
<div style="width: 640px; height: 360px" id="p1"><script src="http://player.theplatform.com/p/IfSiAC/243857475564?form=javascript" type="text/javascript"></script></div>