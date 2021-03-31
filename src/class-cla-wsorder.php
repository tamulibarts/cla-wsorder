<?php
/**
 * The file that defines the core theme class
 *
 * @link       https://https://github.tamu.edu/liberalarts-web/cla-wsorder/blob/master/src/class-cla-wsorder.php
 * @since      0.1.0
 * @package    cla-wsorder
 * @subpackage cla-wsorder/src
 */

/**
 * The core plugin class
 *
 * @since 0.1.0
 * @return void
 */
class CLA_WSOrder {

	/**
	 * File name
	 *
	 * @var file
	 */
	private static $file = __FILE__;

	/**
	 * Instance
	 *
	 * @var instance
	 */
	private static $instance;

	/**
	 * Initialize the class
	 *
	 * @since 0.1.0
	 * @return void
	 */
	private function __construct() {

		add_theme_support( 'html5', array() );

		add_action( 'after_setup_theme', array( $this, 'after_setup_theme' ) );

		@include CLA_THEME_DIRPATH . '/src/class-foundation.php';
		$foundation = new \CLA_WSOrder\Foundation();

		// Navigation menu changes
		@include CLA_THEME_DIRPATH . '/src/class-navigation.php';
		$nav = new \CLA_WSOrder\Navigation();

		// Header changes
		@include CLA_THEME_DIRPATH . '/src/class-header.php';
		$nav = new \CLA_WSOrder\Header();

	}

	/**
	 * Add theme support for wide page alignment
	 *
	 * @since 0.1.0
	 * @return void
	 */
	public function after_setup_theme() {

		$defaults = array(
      'height'      => 279,
      'width'       => 50,
			'flex-height' => true,
			'flex-width'  => true,
			// 'header-text' => array( 'site-title', 'site-description' ),
		);

		add_theme_support( 'align-wide' );
		add_theme_support( 'responsive-embeds' );
		add_theme_support( 'custom-logo', $defaults );
		add_theme_support( 'genesis-custom-logo', $defaults );

	}

	/**
	 * Autoloads any classes called within the theme
	 *
	 * @since 0.1.0
	 * @param string $classname The name of the class.
	 * @return void
	 */
	public static function autoload( $classname ) {

		$filename = dirname( __FILE__ ) .
			DIRECTORY_SEPARATOR .
			str_replace( '_', DIRECTORY_SEPARATOR, $classname ) .
			'.php';
		if ( file_exists( $filename ) ) {
			require $filename;
		}

	}

	/**
	 * Return instance of class
	 *
	 * @since 0.1.0
	 * @return object.
	 */
	public static function get_instance() {

		return null === self::$instance ? new self() : self::$instance;

	}

}
