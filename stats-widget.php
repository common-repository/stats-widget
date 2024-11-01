<?php
/*
Plugin Name: Stats widget
Description: Widget to display stats on your site to guests such as the # total of pages, posts ,comments , tags and categories created on the site.
Version: 1.0
Author: Bledar Ramo
Author URI: http://coveredwpservices.com/
License: GPL2

    Copyright 2012  Bledar Ramo  (email: serviceramo@gmail.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/



	class Widget_SiteStats extends WP_Widget {
	
		function Widget_SiteStats() {		
			$widget_ops = array('classname' => 'widget-site-stats', 'description' => __('Widget for Site Stats', 'ramo_lang'));	
			$this -> WP_Widget('SiteStats', __('Site Stats Widget', 'ramo_lang'), $widget_ops);		
		}
	
		function widget($args, $instance) {		
			extract($args);		
			$title = apply_filters('widget_title', $instance['title']);		
			if (empty($title)) $title = false;
					
				echo $before_widget;	
				if ($title) {						
					echo $before_title;
					echo $title;
					echo $after_title;						
				}				

				?>	
				
				<!--STATS-->
<h2><span><?php
$count_pages = wp_count_posts('page');
echo $count_pages->publish;
?></span> <?php _e( 'Pages', 'ramo_lang' ); ?></h2>
				<h2><span><?php $published_posts = wp_count_posts()->publish; echo $published_posts; ?></span> <?php _e( ' Posts', 'ramo_lang' ); ?></h2>
				<h2><span><?php $comments_count = wp_count_comments(); echo $comments_count->total_comments; ?></span> <?php _e( ' Comments', 'ramo_lang' ); ?></h2>
                               <h2><span><?php
        $numtags = wp_count_terms('post_tag');
        echo $numtags;
?></span> <?php _e( 'Tags', 'ramo_lang' ); ?></h2>
<h2><span><?php
$thecats = wp_list_categories('title_li=&style=none&echo=0'); // Get a list of categories, minus title and HTML list..
$splitcats = explode('<br />',$thecats); // Explode into array where  tags are found (end of each category)..
$summ = count($splitcats)-1; // Count the total, minus 1.. Explode seems to add +1..
?><?php print $summ; // Print the numeric amount ie. 1, 2 etc... ?></span> <?php _e( 'Categories', 'ramo_lang' ); ?></h2>

			<?php
					echo $after_widget.'';				
				}
			
				function update($new_instance, $old_instance) {				
					$instance = $old_instance;				
					$instance['title'] = strip_tags($new_instance['title']);			
					return $instance;				
				}
			
				function form($instance) {				
					$title = isset($instance['title']) ? esc_attr($instance['title']) : '';
					
				?>
					<p><label for="<?php echo $this -> get_field_id('title'); ?>"><?php _e('Title:', 'ramo_lang'); ?></label>
					<input class="widefat" id="<?php echo $this -> get_field_id('title'); ?>" name="<?php echo $this -> get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></p>					
					<div>			
						<small><i><?php _e( 'Site Stats will automatically display..', 'ramo_lang' ); ?></i></small>		
					</div>
		<?php
				}			
		}

		function widgets_sitestats() {			
			register_widget('Widget_SiteStats');			
		}
		add_action('widgets_init', 'widgets_sitestats');




add_action('init', 'register_script');
function register_script() {
    wp_register_style( 'new_style', plugins_url('style.css', __FILE__), false, '1.0.0', 'all');
}

// use the registered jquery and style above
add_action('wp_enqueue_scripts', 'enqueue_style');
function enqueue_style(){
   wp_enqueue_style( 'new_style' );
}



?>