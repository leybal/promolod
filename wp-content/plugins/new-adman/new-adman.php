<?php

/*
Plugin Name: New Adman
Plugin URI: http://www.ksenzov.ru/plugins/new-adman
Description: Plugin for inserting ads before, after and right in the middle of posts.
Version: 1.6.8
Author: gl_SPICE
Author URI: http://www.ksenzov.ru/
*/

 /*
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
 Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 */
 
class Adman {
	
	var $version = '1.6.8';
	
	var $adPattern = "<!-- adman -->";
	
	var $home_number_of_displays = 1;

	var $inap_excerpts_displayed = 0;
	
	function init() {
		if (function_exists('load_plugin_textdomain')) {
			load_plugin_textdomain('adman', 'wp-content/plugins/adman');
		}
	}

	function wp_head() {
		if (!is_feed()) {
			//echo("\n<!-- adman $this->version -->\n");
		}
	}
	
	function admin_menu() {
		add_submenu_page('options-general.php', __('New Adman'), __('New Adman'), 5, __FILE__, array($this, 'plugin_menu'));
	}
	
	function the_excerpt_inap($content = '') {
		if (class_exists('INAP_Post') && is_home() && !is_feed() && $this->inap_excerpts_displayed == 0 && get_option('adman_adcode_home')) {
			$content = stripslashes(get_option('adman_adcode_home')) . $content;
			$this->inap_excerpts_displayed++;
		}
		return $content;
	}
	
	function the_content($content = '') {
		if (is_single() || (class_exists('INAP_Post') && $_REQUEST['type'] == "content")) {
			global $wp_query;
			$post = $wp_query->get_queried_object();
			$adman_disable = get_post_meta($post->ID, '_adman_disable', false);
			if ($adman_disable) {
				return $content;
			}
			if ((get_option('adman_adcode')) AND (mb_strlen($content) >= get_option('adman_mid_length'))) {
				if (strpos($content, $this->adPattern) === false) {
					$middle = intval(mb_strlen($content) / 2);
					$positions = $this->get_occurrences($content, "</p>");
					$positions = array_merge($positions, $this->get_occurrences($content, "</div>"));
					$positions = array_merge($positions, $this->get_occurrences($content, "</ul>"));
					$positions = array_merge($positions, $this->get_occurrences($content, "</ol>"));
					$positions = array_merge($positions, $this->get_occurrences($content, "</pre>"));
					$deviations = array();
					foreach ($positions as $pos) {
						$diff = abs($pos - $middle);
						$deviations[$diff] = $pos;
					}
					ksort($deviations);
					$final = array_shift($deviations);
					if ($final > 0) {
						$content = substr($content, 0, $final - 1) . "<!-- adman_adcode (middle, 1) -->" . stripslashes(get_option('adman_adcode')) . "<!-- /adman_adcode (middle) -->" . substr($content, $final - 1);
					} else {
						$content = "<!-- adman_adcode (middle, 2) -->" . stripslashes(get_option('adman_adcode')) . $content . "<!-- /adman_adcode (middle) -->";
					}
				} else {
					$content = str_replace($this->adPattern, "<!-- adman_adcode (middle, 3) -->" . stripslashes(get_option('adman_adcode')) . "<!-- /adman_adcode (middle) -->", $content);
				}
			}
			if ((get_option('adman_adcode_beginning')) AND (mb_strlen($content) >= get_option('adman_top_length'))) {
				$content = "<!-- adman_adcode_beginning -->" . stripslashes(get_option('adman_adcode_beginning')) . "<!-- /adman_adcode_beginning -->" . $content;
			}
			if ((get_option('adman_adcode_after')) AND (mb_strlen($content) >= get_option('adman_bot_length'))) {
				$content = $content . "<!-- adman_adcode_after -->" . stripslashes(get_option('adman_adcode_after')) . "<!-- /adman_adcode_after -->";
			}
		} else if (is_home() && !is_feed() && $this->home_number_of_displays > 0 && get_option('adman_adcode_home')) {
			$this->home_number_of_displays--;
			$content = stripslashes(get_option('adman_adcode_home')) . $content;
		}
    	return $content;
	}
	
	function get_occurrences($content, $what) {
		$result = array();
		$pos = 0;
		while($pos !== false) {
			$pos = strpos($content, $what, $pos);
			if ($pos === false) {
				return $result;
			}
			$pos += mb_strlen($what) + 1;
			array_push($result, $pos);
			if ($pos >= mb_strlen($content)) {
				return $result;
			}
		}
		return $result;
	}
	
	function edit_action($id) {
	    $adman_edit = $_POST["adman_edit"];
	    if (isset($adman_edit) && !empty($adman_edit)) {
		    $adman_disable = $_POST["adman_disable"];

		    delete_post_meta($id, '_adman_disable');

		    if (isset($adman_disable) && !empty($adman_disable)) {
			    add_post_meta($id, '_adman_disable', $adman_disable);
		    }
	    }
	}

	function edit_form_action() {
	    global $post;
	    $post_id = $post;
	    if (is_object($post_id)) {
	    	$post_id = $post_id->ID;
	    }
	    $disable_adman = htmlspecialchars(stripcslashes(get_post_meta($post_id, '_adman_disable', true)));
		?>

		<script type="text/javascript">
		<!--
		    function toggleVisibility(id) {
		       var e = document.getElementById(id);
		       if(e.style.display == 'block')
		          e.style.display = 'none';
		       else
		          e.style.display = 'block';
		    }
		//-->
		</script>
		
		<input value="adman_edit" type="hidden" name="adman_edit" />
		<table style="margin-bottom:40px; margin-top:30px;">
		<tr>
		<th style="text-align:left;" colspan="2">
		<a target="blank" href="http://www.ksenzov.ru/plugins/new-adman"><?php _e('New Adman', 'adman') ?></a>
		</th>
		</tr>

		<tr>
		<th scope="row" style="text-align:right; vertical-align:top;">
		<a style="cursor:pointer;" title="<?php _e('Click for Help!', 'adman')?>" onclick="toggleVisibility('adman_disable_tip');">
		<?php _e('Disable ads on this page/post:', 'adman')?>
		</a>
		</th>
		<td>
		<input type="checkbox" name="adman_disable" <?php if ($disable_adman) echo "checked=\"1\""; ?>/>
		<div style="max-width:500px; text-align:left; display:none" id="adman_disable_tip">
		<?php
		_e('Check this for disabling any adman ads for this post/page.', 'adman');
		 ?>
		</div>
		</td>
		</tr>

		</table>
		<?php
	}

	function plugin_menu() {
		$message = null;
		$message_updated = __("Ad-Code updated.");
		
		// update options
		if ($_POST['action'] && $_POST['action'] == 'update_adman_adcode') {
			$message = $message_updated;
			update_option('adman_adcode', $_POST['adman_adcode']);
			update_option('adman_top_length', $_POST['adman_top_length']);
			update_option('adman_mid_length', $_POST['adman_mid_length']);
			update_option('adman_bot_length', $_POST['adman_bot_length']);
			update_option('adman_adcode_beginning', $_POST['adman_adcode_beginning']);
			update_option('adman_adcode_after', $_POST['adman_adcode_after']);
			update_option('adman_adcode_home', $_POST['adman_adcode_home']);
			wp_cache_flush();
		}

?>
<?php if ($message) : ?>
<div id="message" class="updated fade"><p><?php echo $message; ?></p></div>
<?php endif; ?>
<div id="dropmessage" class="updated" style="display:none;"></div>
<div class="wrap">
<h2><?php _e('New Adman Options'); ?></h2>
<p><?php _e('For feedback, help etc. please click <a title="New Adman Homepage" href="http://www.ksenzov.ru/plugins/new-adman#respond">here.</a>.') ?></p>
<p><?php _e('Specify ad-codes to appear in your posts, e.g., adsense code:') ?></p>
<form name="dofollow" action="" method="post">
<table>
<tr>
<th scope="row" style="text-align:right; vertical-align:top;"><?php _e('Ad-Code to appear on homepage only, before your first post:')?></th>
<td>
<textarea cols="80" rows="5" name="adman_adcode_home"><?php echo stripslashes(get_option('adman_adcode_home')); ?></textarea></td>
</tr>
<tr>
<th scope="row" style="text-align:right; vertical-align:top;"><?php _e('Ad-Code to appear before your post content:')?></th>
<td>
<textarea cols="80" rows="5" name="adman_adcode_beginning"><?php echo stripslashes(get_option('adman_adcode_beginning')); ?></textarea></td>
</tr>
<tr>
<th scope="row" style="text-align:right; vertical-align:top;"><?php _e('Ad-Code to appear in the middle (calculated) or where you specify &lt!-- adman -->:')?></th>
<td>
<textarea cols="80" rows="5" name="adman_adcode"><?php echo stripslashes(get_option('adman_adcode')); ?></textarea></td>
</tr>
<tr>
<th scope="row" style="text-align:right; vertical-align:top;"><?php _e('Ad-Code to appear after your post content')?></th>
<td>
<textarea cols="80" rows="5" name="adman_adcode_after"><?php echo stripslashes(get_option('adman_adcode_after')); ?></textarea></td>
</tr>
<tr>
<th scope="row" style="text-align:right; vertical-align:top;"><?php _e('Minimal content length for top block inserting')?></th>
<td>
<input size="10" name="adman_top_length" value="<?php echo stripslashes(get_option('adman_top_length')); ?>" /></td>
</tr>
<tr>
<th scope="row" style="text-align:right; vertical-align:top;"><?php _e('Minimal content length for middle block inserting')?></th>
<td>
<input size="10" name="adman_mid_length" value="<?php echo stripslashes(get_option('adman_mid_length')); ?>" /></td>
</tr>
<tr>
<th scope="row" style="text-align:right; vertical-align:top;"><?php _e('Minimal content length for bottom block inserting')?></th>
<td>
<input size="10" name="adman_bot_length" value="<?php echo stripslashes(get_option('adman_bot_length')); ?>" /></td>
</tr>
</table>
<p class="submit">
<input type="hidden" name="action" value="update_adman_adcode" /> 
<input type="hidden" name="page_options" value="home_keywords,home_description" /> 
<input type="submit" name="Submit" value="<?php _e('Update Options')?> &raquo;" /> 
</p>
</form>
</div>
<?php
	
	} // plugin_menu

} // New Adman

$_adman_plugin = new Adman();

add_option("adman_adcode", null, __('AdMan AdCode (middle part)'), 'yes');
add_option("adman_adcode_beginning", null, __('AdMan AdCode (beginning of posts)'), 'yes');

add_action('admin_menu', array($_adman_plugin, 'admin_menu'));
add_filter('the_content', array($_adman_plugin, 'the_content'));
add_filter('the_excerpt', array($_adman_plugin, 'the_excerpt_inap'));
add_action('wp_head', array($_adman_plugin, 'wp_head'));

add_action('simple_edit_form', array($_adman_plugin, 'edit_form_action'));
add_action('edit_form_advanced', array($_adman_plugin, 'edit_form_action'));
//add_action('edit_page_form', array($_adman_plugin, 'edit_form_action'));

add_action('edit_post', array($_adman_plugin, 'edit_action'));
add_action('publish_post', array($_adman_plugin, 'edit_action'));
add_action('save_post', array($_adman_plugin, 'edit_action'));
add_action('edit_page_form', array($_adman_plugin, 'edit_action'));

add_action('init', array($_adman_plugin, 'init'));

?>
