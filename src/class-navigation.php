<?php

namespace CLA_WSOrder;

class Navigation {
	public function __construct(){

		if (
			current_user_can( 'wso_it_rep' )
			|| current_user_can( 'wso_business_admin' )
			|| current_user_can( 'wso_logistics' )
			|| current_user_can( 'wso_admin' )
		) {
			add_filter( 'genesis_nav_items', array( $this, 'genesis_add_nav_menu_items' ), 10, 2 );
			add_filter( 'wp_nav_menu_items', array( $this, 'wp_add_nav_menu_items' ), 10, 2 );
		} else {
			remove_action( 'genesis_after_header', 'genesis_do_nav' );
		}

		add_filter( 'genesis_attr_nav-primary', array( $this, 'add_top_bar_class' ) );

	}

	/**
	 * Add administrative navigation menu items via Genesis filter.
	 *
	 * @param string $menu The menu HTML.
	 * @param array  $args The arguments for the menu.
	 *
	 * @return string
	 */
	public function genesis_add_nav_menu_items ( $menu, $args ) {

		if ( 'primary' === $args['theme_location'] ) {
			$current_program_id = get_site_option( 'options_current_program' );
			$orders_url         = admin_url( "edit.php?post_type=wsorder&program=$current_program_id" );
			$output             = "<li class=\"brand\">Administrative Functions</li><li><a href=\"/orders/\">Orders</a></li>";
			if ( current_user_can( 'wso_admin' ) || current_user_can( 'wso_logistics' ) ) {
				$bundles_url     = admin_url( 'edit.php?post_type=bundle' );
				$categories_url  = admin_url( 'edit-tags.php?taxonomy=product-category' );
				$products_url    = admin_url( 'edit.php?post_type=product' );
				$departments_url = admin_url( 'edit.php?post_type=department' );
				$users_url       = admin_url( 'users.php' );
				$programs_url    = admin_url( 'edit.php?post_type=program' );
				$settings_url    = admin_url( 'admin.php?page=wsorder-settings' );
				$output          .= "<li><a href=\"$bundles_url\">Bundles</a></li><li><a href=\"$categories_url\">Categories</a></li><li><a href=\"$products_url\">Products</a></li><li><a href=\"$departments_url\">Departments</a></li><li><a href=\"$users_url\">Users</a></li><li><a href=\"$programs_url\">Programs</a></li><li><a href=\"$settings_url\">Settings</a></li>";
			}
			$menu = $output . $menu;
		}

		return $menu;

	}

	/**
	 * Add administrative navigation menu items via WordPress filter.
	 *
	 * @param string $menu The menu HTML.
	 * @param array  $args The arguments for the menu.
	 *
	 * @return string
	 */
	public function wp_add_nav_menu_items( $menu, $args ) {

		if ( 'primary' === $args->theme_location ) {
			$current_program_id = get_site_option( 'options_current_program' );
			$orders_url         = admin_url( "edit.php?post_type=wsorder&program=$current_program_id" );
			$output             = "<li class=\"brand\">Administrative Functions</li><li><a href=\"/orders/\">Orders</a></li>";
			if ( current_user_can( 'wso_admin' ) || current_user_can( 'wso_logistics' ) ) {
				$bundles_url     = admin_url( 'edit.php?post_type=bundle' );
				$categories_url  = admin_url( 'edit-tags.php?taxonomy=product-category' );
				$products_url    = admin_url( 'edit.php?post_type=product' );
				$departments_url = admin_url( 'edit.php?post_type=department' );
				$users_url       = admin_url( 'users.php' );
				$programs_url    = admin_url( 'edit.php?post_type=program' );
				$settings_url    = admin_url( 'admin.php?page=wsorder-settings' );
				$output          .= "<li><a href=\"$bundles_url\">Bundles</a></li><li><a href=\"$categories_url\">Categories</a></li><li><a href=\"$products_url\">Products</a></li><li><a href=\"$departments_url\">Departments</a></li><li><a href=\"$users_url\">Users</a></li><li><a href=\"$programs_url\">Programs</a></li><li><a href=\"$settings_url\">Settings</a></li>";
			}
			$menu = $output . $menu;
		}

		return $menu;

	}

	/**
	 * Add classes to the primary navigation menu.
	 *
	 * @param array $atts The navigation menu's attributes.
	 *
	 * @return array
	 */
	public function add_top_bar_class( $atts ) {

		$atts['class'] .= ' top-bar';
		return $atts;

	}
}
