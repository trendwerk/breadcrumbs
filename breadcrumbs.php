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

class TP_Breadcrumbs {

	var $crumbs = array();
	var $separator;
	var $menu;

	function __construct( $separator, $menu ) {
		$this->separator = $separator;
		$this->menu = $menu;

		$this->init();
	}

	/**
	 * Initialize crumbs
	 */
	function init() {
		if( ( $locations = get_nav_menu_locations() ) && isset( $locations[ $this->menu ] ) ) {
			$this->crumbs[] = '<a href="' . home_url() . '" title="' . __( 'Home', 'tp' ).  '">' . __( 'Home', 'tp' ) . '</a>';

			$this->menu = wp_get_nav_menu_object( $locations[ $this->menu ] );
			$items = wp_get_nav_menu_items( $this->menu->term_id );
			_wp_menu_item_classes_by_context( $items );

			$items = apply_filters( 'wp_nav_menu_objects', $items, (object) array() );

			if( 0 === count( $items ) )
				return;

			foreach( $items as $item ) {
				if( ! $item->current && ! $item->current_item_parent && ! $item->current_item_ancestor )
					continue;

				if( $item->url === trailingslashit( home_url() ) )
					continue;
				
				$this->crumbs[] = '<a href="' . $item->url . '" title="' . $item->title.  '">' . $item->title . '</a>';
			}

			/**
			 * Singular
			 */
			if( is_single() )
				$this->crumbs[] = '<span class="current-item">' . get_the_title() . '</span>';

			$this->crumbs = apply_filters( 'tp-breadcrumbs', $this->crumbs );
		}
	}

	/**
	 * Display
	 */
	function display() {
		if( 0 < count( $this->crumbs ) )
			echo implode( $this->separate( $this->separator ), $this->crumbs );
	}

	/**
	 * Separator
	 */
	function separate( $separator ) {
		return '<span class="separator">' . $separator . '</span>';
	}

}

/**
 * API
 *
 * @param string $separator Separator between crumbs
 * @param string $menu Menu location
 */
function tp_breadcrumbs( $separator = '>', $menu = 'mainnav' ) {
	$breadcrumbs = new TP_Breadcrumbs( $separator, $menu );
	$breadcrumbs->display();
}
