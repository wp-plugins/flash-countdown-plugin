<?php
/*
	Plugin Name: Flash CountDown Plugin
	Plugin URI: http://www.flex-blog.com/components/flash-countdown-plugin/
	Description: Flash CountDown Plugin is a Countdown Timer made in Flash for Wordpress.
	Author: Flex-Blog.com (Arjan Nieuwenhuizen, Roelof Albers)
	Author URI: http://www.flex-blog.com
	Version: 0.1
*/

/*  Copyright 2009  Roelof Albers  (email : roelof@flex-blog.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

$FlashCountDownPlugin = new FlashCountDownPlugin();
$FlashCountDownPlugin->initialize_fcdp();

class FlashCountDownPlugin
{		
	function initialize_fcdp() {
		//Wordpress Admin interface hook
		add_action('admin_menu', array($this,'fcdp_add_options_page'));
		//WordPress Hook for the widget
		add_action("widgets_init", array($this, 'widget_my_countdown_init'), 10);
		
		add_filter('the_content', array($this, 'fcdp_callback'), 99);
		add_action('wp_head', array(&$this, 'fcdp_add_script_to_header'), 10);
		
		//add this swfobject.js to the header (this is used for showing the swf correctly in all browsers)
		wp_enqueue_script( 'swfobject', plugins_url(plugin_basename( dirname( __FILE__ )).'/js/swfobject.js'), array(), '2.1' );
		
	}

	function fcdp_callback( $content ) {
		global $fcdp_strings;
		
		/* Run the input check. */		
		if(false === strpos($content, '[fcdp]')) {
			return $content;
		}
		
		$form = array();	
		$siteurl = plugins_url('/flash-countdown-plugin/FlashCountDownPlugin.swf');
		
		$form[] = ' <div id="flexcountdown" align="center">';
		$form[] = ' <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" id="FlashCountDownPlugin" class="flashmovie" width="280" height="170">';
		$form[] = '	<param name="movie" value="'.$siteurl.'" />';
		$form[] = '	<!--[if !IE]>-->';
		$form[] = '	<object	type="application/x-shockwave-flash" data="'.$siteurl.'" name="FlashCountDownPlugin" width="280" height="170">';
		$form[] = '	<!--<![endif]-->';			
		$form[] = '<p><a href="http://adobe.com/go/getflashplayer"><img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Get Adobe Flash player" /></a></p>';
		$form[] = '	<!--[if !IE]>-->';
		$form[] = '	</object>';
		$form[] = '	<!--<![endif]-->';
		$form[] = '</object>';
		//<!--Please show this link or make a donation to support our plugin. Thick the checkbox on the options page to show this url.-->
		$fcdp_sponsor_link = stripslashes(get_option('fcdp_sponsor_link'));
		if($fcdp_sponsor_link) {
			$form[] = '<p><font size="1"><a href="http://www.flex-blog.com/components/flash-countdown-plugin/" target="_blank">Flash CountDown Plugin</a></font></p>';
		}
		else {
		//<!-- This text will be shown if you do not check the checkbox to support our plugin. -->
//			$form[] = '<p><font size="1">Powered by Flex-Blog.com</font></p>';
		}
		$form[] = '</div>';
		
		$form1 = join("\n", $form); 
		return str_replace('[fcdp]', $form1, $content);
	}
	
	function fcdp_add_script_to_header() {
		//to make the swf object is only registered within the correct page
		$current_page = "http://" . $_SERVER['HTTP_HOST']  . $_SERVER['REQUEST_URI'];
		
		if( $current_page == get_option('fcdp_form_url')) {
	
			// Otherwise build out the script.
			$out = array();	
			
			$out[]		= '';
			$out[]		= '<script type="text/javascript" charset="utf-8">';
			$out[]		= '';
			$out[]		= '	(function(){';
			$out[]		= '		try {';		
			$out[]		= '			// Registering Statically Published SWFs';
			$out[]		= '			swfobject.registerObject("FlashCountDownPlugin","9.0.124");';
			$out[]		= '		} catch(e) {}';
			$out[]		= '	}())';
			$out[]		= '</script>';

			$script = join("\n", $out);
			echo $script;
		}
	}
	
	function fcdp_add_options_page() {
		add_options_page(__('', 'fcdp'), __('Flash CountDown Options', 'fcdp'), 'manage_options', 'flash-countdown-plugin/options-fcdp.php');
	}
	
	function widget_my_countdown_init(){
		register_widget('myCountDownWidget');
	}
	
}

class myCountDownWidget extends WP_Widget {
	
	function myCountDownWidget() {
		$widget_ops = array('classname' => 'flash_countdown_plugin', 'description' => "Flash CountDown Plugin" );
		$this->WP_Widget('flash_countdown_plugin', 'Flash CountDown Plugin', $widget_ops);	
	}	

	function widget($args) {
		extract( $args );		
		
		echo $before_widget;
		echo $before_title . 'CountDown' . $after_title;
		
		$form = array();	
		$siteurl = plugins_url('/flash-countdown-plugin/FlashCountDownPlugin.swf');
		
		$form[] = ' <div id="flexcountdown" align="center">';
		$form[] = ' <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" id="FlashCountDownPlugin" class="flashmovie" width="280" height="170">';
		$form[] = '	<param name="movie" value="'.$siteurl.'" />';
		$form[] = '	<!--[if !IE]>-->';
		$form[] = '	<object	type="application/x-shockwave-flash" data="'.$siteurl.'" name="FlashCountDownPlugin" width="280" height="170">';
		$form[] = '	<!--<![endif]-->';			
		$form[] = '<p><a href="http://adobe.com/go/getflashplayer"><img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Get Adobe Flash player" /></a></p>';
		$form[] = '	<!--[if !IE]>-->';
		$form[] = '	</object>';
		$form[] = '	<!--<![endif]-->';
		$form[] = '</object>';
		//<!--Please show this link or make a donation to support our plugin. Thick the checkbox on the options page to show this url.-->
		$fcdp_sponsor_link = stripslashes(get_option('fcdp_sponsor_link'));
		if($fcdp_sponsor_link) {
			$form[] = '<p><font size="1"><a href="http://www.flex-blog.com/components/flash-countdown-plugin/" target="_blank">Flash CountDown Plugin</a></font></p>';
		}
		$form[] = '</div>';
		
		$form1 = join("\n", $form); 	
		echo $form1;	
		
		echo $after_widget;
	}
	
	function form($instance) {
		$location = get_option('siteurl') . '/wp-admin/admin.php?page=flash-countdown-plugin/options-fcdp.php'; // Form Action URI
		echo "Sorry! It we're just too many options.";
		?> Go to the <a href='<?php echo $location; ?>'>options page</a>.<?php
	}
}
?>