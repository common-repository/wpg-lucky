<?php
/*
Plugin Name: WPG-Lucky
Plugin URI: http://bwskyer.com/wpg-lucky-plugin-wordpress.html
Description: WPG.im论坛的I Feel Lucky活动, 随机跳转组织博客的Widget.
Version: 1.0
Author: Sam Zuo
Author URI: http://bwskyer.com
*/
function feelucky(){
	$defaultimg = feelucky_get_plugin_dir('url') . "/images/1.gif";
	$img = get_option("feelucky_img");
    if($img == ""){
	update_option("feelucky_img",$defaultimg);
	}
	echo '<a href="http://wpg.im/lucky/" target="_blank"><img src="'. get_option("feelucky_img") . '" alt="I Feel Lucky" title="I Feel Lucky"></a>';
    }

function widget_sidebar_feelucky() {
	function widget_feelucky($args) {
	    extract($args);
		echo $before_widget;
		
		$feelucky_options = get_option('widget_feelucky');
		$title = $feelucky_options['title'];

		if ( empty($title) )	$title = 'WPG-Lucky';
		
		echo $before_title . $title . $after_title;

		echo feelucky();
		echo $after_widget;
	}
	register_sidebar_widget('WPG-Lucky', 'widget_feelucky');
	
	function widget_feelucky_options() {			
		$feelucky_options = $new_feelucky_options = get_option('widget_feelucky'); 
		if ( $_POST["feelucky_submit"] ) { 
			$new_feelucky_options['title'] = strip_tags(stripslashes($_POST["feelucky_title"]));
			if ( $feelucky_options != $new_feelucky_options ) {
				$feelucky_options = $new_feelucky_options;
				update_option('widget_feelucky', $feelucky_options);
			}
		}
		$title = attribute_escape($feelucky_options['title']);
?>
		<p><label for="feelucky_title"><?php _e('Title:'); ?> <input style="width: 220px;" id="feelucky_title" name="feelucky_title" type="text" value="<?php echo $title; ?>" /></label></p>
		<input type="hidden" id="feelucky_submit" name="feelucky_submit" value="1" />
<?php
	}
	
	register_widget_control('WPG-Lucky', 'widget_feelucky_options', 235, 90);
}

//Return path to plugin directory (url/path)
function feelucky_get_plugin_dir($type) {
	if ( !defined('WP_CONTENT_URL') )
		define( 'WP_CONTENT_URL', get_option('siteurl') . '/wp-content');
	if ( !defined('WP_CONTENT_DIR') )
		define( 'WP_CONTENT_DIR', ABSPATH . 'wp-content' );
	if ($type=='path') { return WP_CONTENT_DIR.'/plugins/'.plugin_basename(dirname(__FILE__)); }
	else { return WP_CONTENT_URL.'/plugins/'.plugin_basename(dirname(__FILE__)); }
}

function feelucky_options(){
	$message='更新成功';
	if($_POST['update_feelucky_option']){
		$feelucky_img_saved = get_option("feelucky_img");
		$feelucky_img = $_POST['feelucky_img_option'];
		if ($feelucky_img_saved != $feelucky_img)
			if(!update_option("feelucky_img",$feelucky_img))
				$message='更新失败';
		
		echo '<div class="updated"><strong><p>'. $message . '</p></strong></div>';
	}
?>
<div class=wrap>
	<form method="post" action="">
		<h2>Choose image</h2>
		<fieldset name="wp_basic_options"  class="options">
		<table>
			<tr>
			<td><label for="post_date_1"><input type="radio" name="feelucky_img_option" value="<?php echo feelucky_get_plugin_dir('url') ?>/images/1.gif" /><img src="<?php echo feelucky_get_plugin_dir('url') ?>/images/1.gif"></label></td>
			<td><label for="post_date_2"><input type="radio" name="feelucky_img_option" value="<?php echo feelucky_get_plugin_dir('url') ?>/images/2.gif" /><img src="<?php echo feelucky_get_plugin_dir('url') ?>/images/2.gif"></label></td>
			<td><label for="post_date_3"><input type="radio" name="feelucky_img_option" value="<?php echo feelucky_get_plugin_dir('url') ?>/images/3.gif" /><img src="<?php echo feelucky_get_plugin_dir('url') ?>/images/3.gif"></label></td>
			</tr>
		</table>			
		</fieldset>
		<p class="submit"><input type="submit" name="update_feelucky_option" value="更新设置 &raquo;" /></p>
		<p>如果你想跳转到您的博客，你必须加入<a target="_blank" href="http://wpg.im/">wpg.im</a>论坛并通过 <a target="_blank" href="http://wpg.im/lucky/IFeelLucky">http://wpg.im/lucky/IFeelLucky</a> 这个链接提交您的博客.</p>
		<p>访问<a target="_blank" href="http://bwskyer.com/wpg-lucky-plugin-wordpress.html">插件主页</a>获取更多信息. 如果你发现什么问题或者有什么好的意见, 请<a target="_blank" href="http://t.sina.com.cn/bwskyer">联系我</a>!</p>
		<br/>
		<p>If you want jump to your blog, you must join <a target="_blank" href="http://wpg.im/">wpg.im</a> bbs and submit your blog here: <a target="_blank" href="http://wpg.im/lucky/IFeelLucky">http://wpg.im/lucky/IFeelLucky</a></p>
		<p>Visit the <a target="_blank" href="http://bwskyer.com/wpg-lucky-plugin-wordpress.html">plugin's homepage</a> for further details. If you find a bug, or have a fantastic idea for this plugin, <a target="_blank" href="http://twitter.com/bwskyer">twitter me</a>!</p>

	</form>
</div>
<?php
}

function feelucky_options_admin(){
	add_options_page('WPG-Lucky', 'WPG-Lucky', 5,  __FILE__, 'feelucky_options');
}

add_action('admin_menu', 'feelucky_options_admin');	
add_action('plugins_loaded', 'widget_sidebar_feelucky');
?>
