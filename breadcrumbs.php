<?php
/**
 * Plugin Name: Breadcrumbs
 * Description: Breadcrumbs based on custom menu's.
 * 
 * Plugin URI: https://github.com/trendwerk/breadcrumbs
 * 
 * Author: Trendwerk
 * Author URI: https://github.com/trendwerk
 * 
 * Version: 1.0.1
 *
 * @uses TP_Nav
 */

/**
 * Show the breadcrumbs
 *
 * @param string $separator Separator between breadcrumbs
 * @param string $menu The menu which will be used
 */
function tp_breadcrumbs( $separator = '>', $menu = 'mainnav' ) {
	global $post;
	
	$nav = new TP_Nav($menu);
	$breadcrumbs = apply_filters( 'tp-breadcrumbs', $nav->get_breadcrumb_items() );
	
	//Home
	echo '<a href="' . home_url() . '">'.__('Home','tp').'</a>';
	tp_separator($separator);
	
	$i=0;
	if($breadcrumbs) {
		foreach($breadcrumbs as $breadcrumb) {
			if( ! isset( $breadcrumb->is_current ) || !$breadcrumb->is_current) {
				echo '<a href="'.$breadcrumb->url.'">';
					echo $breadcrumb->title;
				echo '</a>';
			} else {
				echo '<span class="current">'.$breadcrumb->title.'</span>';
			}
			
			$i++;
			if($i < count($breadcrumbs)) {
				tp_separator($separator);
			}
		}
	}
	
	//Single post or CPT and author pages or taxonomy pages have some
	if(is_single() && isset( $breadcrumbs[0]->ID ) && !is_single($breadcrumbs[0]->ID)) {
		tp_separator($separator);
		echo '<span class="current">'.$post->post_title.'</span>';
	} else if(is_category()) {
		tp_separator($separator);
		$category = get_the_category();
		echo '<span class="current">'.$category[0]->name.'</span>';
	} else if(get_query_var('author')) {
		tp_separator($separator);
		$author = get_userdata(get_query_var('author'));
		echo '<span class="current">'.$author->first_name.' '.$author->last_name.'</span>';
	}
}

/**
 * Use a separator between breadcrumbs
 *
 * @param string $separator
 */
function tp_separator($separator) {
	echo ' <span class="separator">'.$separator.'</span> ';	
}
