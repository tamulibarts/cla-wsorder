<?php

namespace CLA_WSOrder;

class Foundation {
	public function __construct(){
		add_filter( 'genesis_attr_nav-primary', function($atts){
			$atts['class'] .= ' top-bar';
			return $atts;
		});
	}
}
