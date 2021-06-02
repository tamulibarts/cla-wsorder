<?php

namespace CLA_WSOrder;

class Header {

	public function __construct(){

		add_filter( 'genesis_markup_title-area_open', array( $this, 'grid_title_area' ), 10, 2 );

		add_filter( 'get_custom_logo', array( $this, 'wrap_logo' ) );

		add_filter( 'genesis_seo_title', array( $this, 'modify_site_title' ), 10, 3 );

		add_filter( 'genesis_seo_title', array( $this, 'add_header_links' ), 10, 3 );

	}

	public function grid_title_area ( $open_html, $args ) {
		$open_html = str_replace( 'title-area', 'title-area grid-x align-middle row', $open_html );
		return $open_html;
	}

	public function wrap_logo ( $output ) {
		$output = '<div class="cell small-6 medium-shrink text-left">' . $output . '</div>';
		return $output;
	}

	public function modify_site_title ( $title, $inside, $wrap ) {
		$title = str_replace( $inside, '<a href="' . home_url() . '">' . $inside . '</a>', $title );
		$title = '<div class="cell auto">' . $title . '</div>';
		return $title;
	}

	public function add_header_links ( $title, $inside, $wrap ) {
		$logout_url = wp_logout_url();
		$user = wp_get_current_user();
		$user_name = $user->user_login;
		$admin_links = "<div class=\"account-links cell small-12 medium-shrink text-right\"><a href=\"/my-orders/\">My Orders</a><a href=\"/my-account/\">My Account</a><a href=\"$logout_url\">Logout ({$user_name})</a></div>";
		$title .= $admin_links;
		return $title;
	}
}
