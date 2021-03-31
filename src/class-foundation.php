<?php

namespace CLA_WSOrder;

class Foundation {
	public function __construct(){
		// Navigation.
		add_filter( 'genesis_attr_nav-primary', function($atts){
			$atts['class'] .= ' top-bar';
			return $atts;
		});
		// Header.
		add_filter( 'genesis_seo_title', function ( $title, $inside, $wrap ) {
			$title = '<div class="cell auto">' . $title . '</div>';
			return $title;
		}, 10, 3 );
		add_filter( 'get_custom_logo', function ( $output ) {
			$output = '<div class="cell shrink">' . $output . '</div>';
			return $output;
		} );
		add_filter( 'genesis_markup_title-area_open', function( $open_html, $args ) {
			$open_html = str_replace( 'title-area', 'title-area grid-x row', $open_html );
			return $open_html;
		}, 10, 2 );
	}
}
