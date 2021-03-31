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
			add_filter( 'genesis_nav_items', function($menu, $args){
				if ( 'primary' === $args['theme_location'] ) {
					$menu = '<li class="brand">Administrative Functions</li>' . $menu;
				}

				return $menu;
			}, 10, 2 );

			add_filter( 'wp_nav_menu_items', function($menu, $args){
				if ( 'primary' === $args->theme_location ) {
					$menu = '<li class="brand">Administrative Functions</li>' . $menu;
				}

				return $menu;
			}, 10, 2 );
		}

	}
}
