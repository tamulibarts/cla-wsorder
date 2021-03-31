<?php

namespace CLA_WSOrder;

class Header {
	public function __construct(){

		if (
			current_user_can( 'wso_it_rep' )
			|| current_user_can( 'wso_business_admin' )
			|| current_user_can( 'wso_logistics' )
			|| current_user_can( 'wso_admin' )
		) {
			add_filter( 'genesis_seo_title', function ( $title, $inside, $wrap ) {
				$profile_url = get_edit_profile_url();
				$logout_url = wp_logout_url();
				$admin_links = "<div class=\"cell shrink\">My Orders | <a href=\"$profile_url\">My Account</a> | <a href=\"$logout_url\">Logout</a></div>";
				$title .= $admin_links;
				return $title;
			}, 10, 3 );
		}

	}
}
