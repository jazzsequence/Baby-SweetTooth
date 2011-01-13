<?php
add_action('admin_head','theme_check_ver'); //Theme Update Function
/****************************
Update Noticication Script
By Jeremy Clark
http://clark-technet.com
License: GPL
*****************************/
/*********************VALUES BELOW NEED TO BE CHANGED*************************/
$theme_sn= "babysweettooth";
//Theme's short name for adding options to database
$remote_file = "http://www.museumthemes.com/wp-content/themes/babysweettooth/version.txt";
//Address of remote file with version number
$update_check_int = 24; 
// Time in hours to check file for new version
$theme_update_notice ="<p>There's a new version of this theme available.  <a href='https://github.com/ArcanePalette/Baby-SweetTooth/zipball/master' target='_blank'>Please download the latest version here</a>.</p>";
//Text for notice displayed to user about new version

/*********************END EDITING*********************************************/


//These variables don't need editing
$theme_data = get_theme_data(TEMPLATEPATH . '/style.css');
$local_version = $theme_data['Version'];
$update_last_check = get_option($theme_sn.'_last_ver_check');
$new_ver_notice = get_option($theme_sn.'_new_ver');

function theme_check_ver() {
	global $update_check_int, $update_last_check,$new_ver_notice,$theme_sn;
		if ($new_ver_notice = true) {
			add_action('admin_notices','theme_new_ver');
		}
		$update_check_int_seconds = $update_check_int * 3600;
		$now = time();
		if ( empty( $update_last_check ) ) {
				//first run
				theme_compare_ver();
				add_option($theme_sn.'_last_ver_check', $now);
			} else {
				$time_ago = $now - $update_last_check;
				if ( $time_ago > $update_check_int_seconds ) {
					theme_compare_ver();
					update_option($theme_sn.'_last_ver_check', $now);
				}
			}
}
function theme_compare_ver() {
	global $remote_file, $local_version,$theme_sn;
		$remote_text = file_get_contents($remote_file);
		if ($remote_text !== false) {
			$remote_version = $remote_text;
		if ($local_version == $remote_version) {
				delete_option($theme_sn.'_new_ver');
			} else {
				if ( is_numeric(str_replace(".", "", $local_version)) && is_numeric(str_replace(".", "", $remote_version)) ) {
					if ( substr_count($local_version, '.') == 0 ) {
						// x -> x.x.x.x
						$local_version = $local_version . '.0.0.0';
					} else if ( substr_count($local_version, '.') == 1 ) {
						// x.x -> x.x.x.x
						$local_version = $local_version . '.0.0';
					} else if ( substr_count($local_version, '.') == 2 ) {
						// x.x.x -> x.x.x.x
						$local_version = $local_version . '.0';
					}
					$local_version = str_replace(".", "", $local_version);
					//$local_version = substr($local_version,0,1) . '.' . substr($local_version,1,5);
					$local_version = '0.' . $local_version;
					//---------------//
					if ( substr_count($remote_version, '.') == 0 ) {
						// x -> x.x.x.x
						$remote_version = $remote_version . '.0.0.0';
					} else if ( substr_count($remote_version, '.') == 1 ) {
						// x.x -> x.x.x.x
						$remote_version = $remote_version . '.0.0';
					} else if ( substr_count($remote_version, '.') == 2 ) {
						// x.x.x -> x.x.x.x
						$remote_version = $remote_version . '.0';
					}
					$remote_version = str_replace(".", "", $remote_version);
					//$remote_version = substr($remote_version,0,1) . '.' . substr($remote_version,1,5);
					$remote_version = '0.' . $remote_version;
					//---------------//
					//echo $remote_version . ' - ' . $local_version . '<br />';
					if ( $remote_version > $local_version ) {
						add_action('admin_notices','theme_new_ver');
						add_option($theme_sn.'_new_ver',true);
					} else {
						del_option($theme_sn.'_new_ver');
					}
				} else {
					add_action('admin_notices','theme_new_ver');
					add_option($theme_sn.'_new_ver',true);
				}
			}
		} else {
			echo "Can't Connect to update server";
		}
}	
function theme_new_ver() { 
	global $theme_update_notice, $pagenow;
	if ( $pagenow == ( "themes.php" || "index.php")) {
?>
		<div id="message" class="updated fade">
		<?php echo $theme_update_notice; ?>
		</div>
<?php
	}
}
?>