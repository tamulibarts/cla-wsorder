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

		// Foundation class names and other attributes.
		include CLA_THEME_DIRPATH . '/src/class-foundation.php';
		$foundation = new \CLA_WSOrder\Foundation();

		// Navigation menu.
		include CLA_THEME_DIRPATH . '/src/class-navigation.php';
		$nav = new \CLA_WSOrder\Navigation();

		// Header.
		include CLA_THEME_DIRPATH . '/src/class-header.php';
		$nav = new \CLA_WSOrder\Header();

		// Run functions after the theme is loaded.
		add_action( 'after_setup_theme', array( $this, 'after_setup_theme' ) );
		$this->remove_genesis_features();

		// Remove access to profile options.
		remove_action( 'admin_color_scheme_picker', 'admin_color_scheme_picker' );

		// Home page heading as current program name.
		add_filter( 'the_title', array ( $this, 'home_title_current_program' ), 10, 2 );

		// Add custom user switch back link.
		add_action('genesis_after_header', array( $this, 'add_user_switch_back_link' ) );

		// Add footer horizontal line.
		add_action( 'genesis_footer', array( $this, 'genesis_footer_content' ), 5 );
		add_filter( 'genesis_attr_site-footer', array( $this, 'genesis_footer_att' ) );

		// Disable the admin bar.
		add_action('after_setup_theme', array( $this, 'admin_bar_enable_or_disable' ) );

	}

	/**
	 * Disable the admin bar for users who cannot access the admin interface.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function admin_bar_enable_or_disable() {
		if (
			current_user_can( 'read' )
		) {
			show_admin_bar( true );
		} else {
			show_admin_bar( false );
		}
	}

	/**
	 * Remove Genesis features from the child theme.
	 *
	 * @return void
	 */
	private function remove_genesis_features() {

		add_action( 'after_setup_theme', array( $this, 'after_setup_genesis_remove' ), 11 );

		add_action( 'admin_init', array( $this, 'admin_genesis_remove' ), 11 );

	}

	/**
	 * Remove Genesis features on after_setup_theme
	 *
	 * @return void
	 */
	public function after_setup_genesis_remove() {

		// Remove Genesis sidebars.
		remove_action( 'genesis_sidebar', 'genesis_do_sidebar' );

		// Remove theme support.
		remove_theme_support( 'genesis-archive-layouts' );

	}

	/**
	 * Remove Genesis features on admin_init
	 *
	 * @return void
	 */
	public function admin_genesis_remove() {

		// Remove Genesis hooks.
		remove_action( 'edit_user_profile', 'genesis_user_options_fields' );
		remove_action( 'edit_user_profile', 'genesis_user_archive_fields' );
		remove_action( 'edit_user_profile', 'genesis_user_seo_fields' );
		remove_action( 'edit_user_profile', 'genesis_user_layout_fields' );
		remove_action( 'show_user_profile', 'genesis_user_options_fields' );
		remove_action( 'show_user_profile', 'genesis_user_archive_fields' );
		remove_action( 'show_user_profile', 'genesis_user_seo_fields' );
		remove_action( 'show_user_profile', 'genesis_user_layout_fields' );

	}

	/**
	 * Output Genesis site footer content.
	 *
	 * @return void
	 */
	public function genesis_footer_content() {

		echo '<hr />';

	}

	/**
	 * Add container class name to Genesis footer element.
	 *
	 * @param array $attr The array of attributes.
	 *
	 * @return array
	 */
	public function genesis_footer_att( $attr ) {

		$attr['class'] .= ' container';

		return $attr;

	}

	/**
	 * Add user switch back link.
	 *
	 * @return void
	 */
	public function add_user_switch_back_link() {

		if ( method_exists( 'user_switching', 'get_old_user' ) ) {
			$old_user = user_switching::get_old_user();
			if ( $old_user ) {
				$current_user = wp_get_current_user();
				$display_name = $current_user->display_name;
				$back_url     = esc_url( user_switching::switch_back_url( $old_user ) );
				$uri          = $_SERVER['REQUEST_URI'];
				$protocol     = !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' ? "https://" : "http://";
				$redirect     = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . '?user_switched=true';
				$redirect     = urlencode( $redirect );
				$back_name    = esc_html( $old_user->display_name );
				echo wp_kses_post( "<div class=\"alert alert-info\">Impersonating: $display_name. <a href=\"{$back_url}&redirect_to={$redirect}\">Back to $back_name</a></div>" );
			}
		}
	}

	/**
	 * Determine the home page title based on the currently active program.
	 *
	 * @param string $title   The current page title.
	 * @param int    $post_id The home page post ID.
	 *
	 * @return string.
	 */
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
	 * Modify theme features based on parent theme API.
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
