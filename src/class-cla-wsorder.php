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

		add_action( 'after_setup_theme', array( $this, 'after_setup_theme' ) );

		// Foundation class names and other attributes.
		@include CLA_THEME_DIRPATH . '/src/class-foundation.php';
		$foundation = new \CLA_WSOrder\Foundation();

		// Navigation menu.
		@include CLA_THEME_DIRPATH . '/src/class-navigation.php';
		$nav = new \CLA_WSOrder\Navigation();

		// Header.
		@include CLA_THEME_DIRPATH . '/src/class-header.php';
		$nav = new \CLA_WSOrder\Header();

		// Remove profile options.
		remove_action( 'admin_color_scheme_picker', 'admin_color_scheme_picker' );

		if ( ! function_exists( 'cla_remove_unneeded_account_options' ) ) {
		  /**
		   * Removes the leftover 'Visual Editor', 'Keyboard Shortcuts' and 'Toolbar' options.
		   */
		  function cla_remove_unneeded_account_options( $subject ) {
		    $subject = preg_replace( '#<h2>Personal Options</h2>.+?/table>#s', '', $subject, 1 );
		    $subject = preg_replace( '#<h2>About Yourself</h2>.+?/table>#s', '', $subject, 1 );
		    $subject = preg_replace( '#<h2>Author Archive Settings</h2>.+?/table>#s', '', $subject, 1 );
		    $subject = preg_replace( '#<h2>Author Archive SEO Settings</h2>.+?/table>#s', '', $subject, 1 );
		    $subject = preg_replace( '#<h2>Layout Settings</h2>.+?/table>#s', '', $subject, 1 );
		    $subject = preg_replace( '#<h2>User Permissions</h2>.+?/table>#s', '', $subject, 1 );
		    $subject = preg_replace( '#<h2>Account Management</h2>.+?/table>#s', '', $subject, 1 );
		    return $subject;
		  }

		  function cla_profile_subject_start() {
		    ob_start( 'cla_remove_unneeded_account_options' );
		  }

		  function cla_profile_subject_end() {
		    ob_end_flush();
		  }
		}
		add_action( 'admin_head-profile.php', 'cla_profile_subject_start' );
		add_action( 'admin_footer-profile.php', 'cla_profile_subject_end' );

		// Home page heading as current program name.
		add_filter( 'the_title', array ( $this, 'home_title_current_program' ), 10, 2 );

	}

	public function home_title_current_program( $title, $post_id ) {
		if ( ! is_admin() ) {
			$front_page_id = (int) get_option( 'page_on_front' );
			if ( ! empty( $front_page_id ) && $front_page_id === $post_id ) {
				$current_program_post  = get_field( 'current_program', 'option' );
				if ( $current_program_post ) {
					$current_program_title = $current_program_post->post_title;
					$title = $current_program_title;
				}
			}
		}
		return $title;
	}

	/**
	 * Add theme support for wide page alignment
	 *
	 * @since 0.1.0
	 * @return void
	 */
	public function after_setup_theme() {

		// Add theme support.
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
		add_theme_support( 'html5', array() );

		// Remove sidebars.
		unregister_sidebar( 'sidebar' );
		unregister_sidebar( 'sidebar-alt' );
		unregister_sidebar( 'header-right' );
		remove_action( 'genesis_sidebar', 'genesis_do_sidebar' );

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
