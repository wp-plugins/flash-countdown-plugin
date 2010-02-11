<?php
/*
Author: Roelof Albers
Author URI: http://www.flex-blog.com
Description: Options Page for Flash CountDown Plugin
Version: 0.1
*/

// yes this function will fail if attempting to open this options page from outside the admin panel..

//Only an admin can change these settings..
if (is_admin())
{
	load_plugin_textdomain('fcdp', $path = plugins_url('/flash-countdown-plugin/'));
	$location = get_option('siteurl') . '/wp-admin/admin.php?page=flash-countdown-plugin/options-fcdp.php'; // Form Action URI
	$fcdp_plugin_url = plugins_url('/flash-countdown-plugin/jscolor/jscolor.js');
	$fcdp_datetimepicker_url = plugins_url('/flash-countdown-plugin/js/datetimepicker_css.js');
	$fcdp_timepicker_url = plugins_url('/flash-countdown-plugin/js/jquery.timePicker.js');
	$default_image_url = plugins_url('/flash-countdown-plugin/images/') . 'the_end.png'. 
	
	/*Lets add some default options if they don't exist*/
	add_option('fcdp_title', 'Counting down....till Christmas', '');
	add_option('fcdp_target_date', '2010/12/25', '');
	add_option('fcdp_target_time', '00:00:00', '');
	add_option('fcdp_target_timezone', '+0100', '');
	add_option('fcdp_background_color', 'FFFFFF','');
	add_option('fcdp_header_color', 'FEDA79','');
	add_option('fcdp_header_txt_color', 'DA5839','');
	add_option('fcdp_panel_color', 'FEDA79','');
	add_option('fcdp_countdown_txt_color', 'DA5839','');
	add_option('fcdp_panel_txt_color', 'DA5839','');
	add_option('fcdp_form_url', 'http://www.yourwebsite.com','');
	add_option('fcdp_sponsor_link', '', '');	
	add_option('fcdp_image_url', $default_image_url, '');	
	add_option('fcdp_xml_options', '<fcdp></fcdp>', '');
	
	/*check form submission and update options*/
	if (isset ($_POST['stage']) && ( 'process' == $_POST['stage']) ) {
		update_option('fcdp_target_date', $_POST['fcdp_target_date']);
		update_option('fcdp_sponsor_link', $_POST['fcdp_sponsor_link']);
		update_option('fcdp_title', $_POST['fcdp_title']);
		update_option('fcdp_target_time', $_POST['fcdp_target_time']);
		update_option('fcdp_target_timezone', $_POST['fcdp_target_timezone']);
		update_option('fcdp_background_color', $_POST['fcdp_background_color']);
		update_option('fcdp_header_color', $_POST['fcdp_header_color']);
		update_option('fcdp_header_txt_color', $_POST['fcdp_header_txt_color']);
		update_option('fcdp_panel_color', $_POST['fcdp_panel_color']);
		update_option('fcdp_countdown_txt_color', $_POST['fcdp_countdown_txt_color']);
		update_option('fcdp_panel_txt_color', $_POST['fcdp_panel_txt_color']);
		update_option('fcdp_form_url', $_POST['fcdp_form_url']);
		update_option('fcdp_image_url', $_POST['fcdp_image_url']);
		
		$xml = "<fcdp>";
		$xml .= "<fcdp_title>" . $_POST['fcdp_title'] . "</fcdp_title>";
		$xml .= "<fcdp_target_date>" . $_POST['fcdp_target_date'] . "</fcdp_target_date>";
		$xml .= "<fcdp_target_time>" . $_POST['fcdp_target_time'] . "</fcdp_target_time>";
		$xml .= "<fcdp_target_timezone>" . $_POST['fcdp_target_timezone'] . "</fcdp_target_timezone>";		
		$xml .= "<fcdp_image_url>" . $_POST['fcdp_image_url'] . "</fcdp_image_url>";	
		$xml .= "<fcdp_background_color>" . "0x" . $_POST['fcdp_background_color'] . "</fcdp_background_color>";
		$xml .= "<fcdp_header_color>" . "0x" . $_POST['fcdp_header_color'] . "</fcdp_header_color>";
		$xml .= "<fcdp_header_txt_color>" . "0x" . $_POST['fcdp_header_txt_color'] . "</fcdp_header_txt_color>";
		$xml .= "<fcdp_panel_color>" . "0x" . $_POST['fcdp_panel_color'] . "</fcdp_panel_color>";
		$xml .= "<fcdp_countdown_txt_color>" . "0x" . $_POST['fcdp_countdown_txt_color'] . "</fcdp_countdown_txt_color>";
		$xml .= "<fcdp_panel_txt_color>" . "0x" . $_POST['fcdp_panel_txt_color'] . "</fcdp_panel_txt_color>";
		$xml .= "</fcdp>";

		update_option('fcdp_xml_options', $xml);
	}

	/*Get options for form fields*/
	$fcdp_title = stripslashes(get_option('fcdp_title'));
	$fcdp_target_date = stripslashes(get_option('fcdp_target_date'));
	$fcdp_target_time = stripslashes(get_option('fcdp_target_time'));
	$fcdp_target_timezone = stripslashes(get_option('fcdp_target_timezone'));
	$fcdp_image_url = stripslashes(get_option('fcdp_image_url'));
	$fcdp_background_color = stripslashes(get_option('fcdp_background_color'));
	$fcdp_header_color = stripslashes(get_option('fcdp_header_color'));
	$fcdp_header_txt_color = stripslashes(get_option('fcdp_header_txt_color'));
	$fcdp_panel_color = stripslashes(get_option('fcdp_panel_color'));
	$fcdp_countdown_txt_color = stripslashes(get_option('fcdp_countdown_txt_color'));
	$fcdp_panel_txt_color = stripslashes(get_option('fcdp_panel_txt_color'));	
	$fcdp_form_url = stripslashes(get_option('fcdp_form_url'));
	$fcdp_sponsor_link = stripslashes(get_option('fcdp_sponsor_link'));
	
	if($fcdp_sponsor_link) {
		$fcdp_sponsor_link = ' checked="checked"';
	}
	else {
		$fcdp_sponsor_link = '';
	}
	
	?>

	<script type="text/javascript" src="<?php echo $fcdp_plugin_url; ?>"></script>
	<script type="text/javascript" src="<?php echo $fcdp_datetimepicker_url; ?>"></script>

	<div class="wrap">
	  <h2><?php _e('Flash CountDown Options', 'fcdp') ?></h2>
	  <hr>
	  <h3><?php _e('CountDown Options', 'fcdp') ?></h3>
	  <form name="form1" method="post" action="<?php echo $location ?>&amp;updated=true">
		<input type="hidden" name="stage" value="process" />

		<table width="100%" cellpadding="5" class="form-table">
			<tr valign="top">
				<th scope="row"><label for="fcdp_title"><?php _e('Title', 'fcdp') ?>:</label></th>
				<td><input name="fcdp_title" id="fcdp_title" type="text" size="50" value="<?php echo $fcdp_title; ?>"/>
				<span class="description"><?php _e('This will be the title of the CountDown Plugin.', 'fcdp') ?></span>
				<br />
			</tr>
			<tr valign="top">
				<th scope="row"><label for="fcdp_target_date"><?php _e('Target Date', 'fcdp') ?>:</label></th>
				<td><input name="fcdp_target_date" type="text" id="fcdp_target_date" value="<?php echo $fcdp_target_date; ?>" size="50" /><a href="javascript:NewCssCal('fcdp_target_date','yyyymmdd')">
<img src="<?php echo plugins_url('/flash-countdown-plugin/') . 'images/cal.gif' ?>" width="16" height="16" alt="Pick a date"></a>
				<span class="description"><?php _e('This will be the target date (used to calculate the difference). Use format YYYY/MM/DD', 'fcdp') ?></span>
				<br />
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><label for="fcdp_target_time"><?php _e('Target Date', 'fcdp') ?>:</label></th>
				<td><input name="fcdp_target_time" type="text" id="fcdp_target_time" value="<?php echo $fcdp_target_time; ?>" size="50" />
				<span class="description"><?php _e('Use the 24 hours format HH:MM:SS (e.g. 13:14:15). This will be the target time (used to calculate the difference)', 'fcdp') ?></span>
				<br />
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><label for="fcdp_target_timezone"><?php _e('Target Time Zone (GMT)', 'fcdp') ?>:</label></th>
				<td><input name="fcdp_target_timezone" type="text" id="fcdp_target_timezone" value="<?php echo $fcdp_target_timezone; ?>" size="50" />
				<span class="description"><?php _e('In which GMT timezone are you? Check http://www.flex-blog.com/components/flash-countdown-plugin/timezones/ for your GMT timezone.', 'fcdp') ?></span>
				<br />
				</td>
			</tr>				
			<tr valign="top">
				<th scope="row"><label for="fcdp_form_url"><?php _e('CountDown Plugin URL', 'fcdp') ?>:</label></th>
				<td><input name="fcdp_form_url" type="text" id="fcdp_form_url" value="<?php echo $fcdp_form_url; ?>" size="50" />
				<span class="description"><?php _e('This should be the url where the countdown plugin will be shown. Not required, but for cleaner coding.', 'fcdp') ?></span>
				<br />
				</td>
			</tr>	
			<tr valign="top">
				<th scope="row"><label for="fcdp_image_url"><?php _e('Image URL', 'fcdp') ?>:</label></th>
				<td><input name="fcdp_image_url" type="text" id="fcdp_image_url" value="<?php echo $fcdp_image_url; ?>" size="50" />
				<span class="description"><?php _e('This image will be shown when the countdown is finished!', 'fcdp') ?></span>
				<br />
				</td>
			</tr>				
		  </table>
          <hr>
		  <h3><?php _e('Colors', 'fcdp') ?></h3>	
			<table width="100%" cellpadding="5" class="form-table">
			<tr valign="top">
				<th scope="row"><label for="fcdp_background_color"><?php _e('Backgroundcolor', 'fcdp') ?>:</label></th>
				<td><input class="color" name="fcdp_background_color" type="text" id="fcdp_background_color" value="<?php echo $fcdp_background_color; ?>" size="6" />
				<span class="description"><?php _e('This will be the background color. Do NOT use a #.', 'fcdp') ?></span>
				<br />
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><label for="fcdp_header_color"><?php _e('Header Color', 'fcdp') ?>:</label></th>
				<td><input class="color" name="fcdp_header_color" type="text" id="fcdp_header_color" value="<?php echo $fcdp_header_color; ?>" size="6" />
				<span class="description"><?php _e('This will be the header color of the countdown component.  Do NOT use a #.', 'fcdp') ?></span>
				<br />
				</td>
			</tr>	
			<tr valign="top">
				<th scope="row"><label for="fcdp_header_txt_color"><?php _e('Title Text Color', 'fcdp') ?>:</label></th>
				<td><input class="color" name="fcdp_header_txt_color" type="text" id="fcdp_header_txt_color" value="<?php echo $fcdp_header_txt_color; ?>" size="6" />
				<span class="description"><?php _e('This will be the color of title text. Do NOT use a #.', 'fcdp') ?></span>
				<br />
				</td>
			</tr>	
			<tr valign="top">
				<th scope="row"><label for="fcdp_panel_color"><?php _e('Component background color', 'fcdp') ?>:</label></th>
				<td><input class="color" name="fcdp_panel_color" type="text" id="fcdp_panel_color" value="<?php echo $fcdp_panel_color; ?>" size="6" />
				<span class="description"><?php _e('This will be the background color of the panel. Do NOT use a #.', 'fcdp') ?></span>
				<br />
				</td>
			</tr>	
			<tr valign="top">
				<th scope="row"><label for="fcdp_countdown_txt_color"><?php _e('Counter Text Color', 'fcdp') ?>:</label></th>
				<td><input class="color" name="fcdp_countdown_txt_color" type="text" id="fcdp_countdown_txt_color" value="<?php echo $fcdp_countdown_txt_color; ?>" size="6" />
				<span class="description"><?php _e('This will be the color of the text that counts down. Do NOT use a #.', 'fcdp') ?></span>
				<br />
				</td>
			</tr>	
			<tr valign="top">
				<th scope="row"><label for="fcdp_panel_txt_color"><?php _e('Component Text Color', 'fcdp') ?>:</label></th>
				<td><input class="color" name="fcdp_panel_txt_color" type="text" id="fcdp_panel_txt_color" value="<?php echo $fcdp_panel_txt_color; ?>" size="6" />
				<span class="description"><?php _e('This will be the color of the text on the component (days, hours etc). Do NOT use a #.', 'fcdp') ?></span>
				<br />
				</td>
			</tr>				
			</table>
			<hr>			
		  <h3><?php _e('Support this plugin', 'fcdp') ?></h3>	  
		  <table width="100%" cellpadding="5" class="form-table">			  
			<tr valign="top">
				<th scope="row" vertical-align="center"><label for="fcdp_sponsor_link"><?php _e('Support this plugin?', 'fcdp') ?>:</label></th>
				<td><input type="checkbox" id="fcdp_sponsor_link" name="fcdp_sponsor_link" value="1" <?php echo $fcdp_sponsor_link; ?>" />
				<?php echo " or <a href='http://www.flex-blog.com'>Donate</a>"; ?>
				<span class="description"><?php _e('A sponsorlink will appear below the CountDown Plugin when you tick this checkbox. We really appreciate any kind of support for our plugins.', 'fcdp') ?></span>
				<br />
				</td>
			</tr>		  
		  </table>

		<p class="submit">
		  <input type="submit" name="Submit" value="<?php _e('Update Options', 'fcdp') ?> &raquo;" />
		</p>
	  </form>
	  
	</div>
<?php
}
?>