<?php
/*
Author: Roelof Albers
Author URI: http://www.flex-blog.com
Description: Options Page for Flash CountDown Plugin
Version: 0.1
*/

	/* Short and sweet */
	define('WP_USE_THEMES', false);
	require('../../../wp-blog-header.php');

	$xml = get_option('fcdp_xml_options');
	echo $xml;
	
?>