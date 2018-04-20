<?php

/**
 *
 * Defines custom toolbars for TinyMCE
 *
 * @since      0.1.0
 *
 * @package    NewCity_WYSIWYG
 * @author     Jesse Janowiak <jesse@insidenewcity.com>
 */

class NewCityToolbars {

	/**
	 * name of the theme config override
	 * if this file exists at the root of the current theme and is valid json, it will be parsed for keys:
	 *   - css : path of the wysiwyg css, relative to the theme root
	 *   - styles_format : styles format array for TinyMCE config, see e.g., https://www.tinymce.com/docs-3x/reference/configuration/Configuration3x@style_formats/
	 *
	 * @var string
	 */
	private $theme_config_file = "wysiwyg-config.json";

	/**
	 * Path to custom stylesheet
	 *
	 * @var string
	 */
	private $stylesheet;

	/**
	 * TinyMCE styles array
	 *
	 * @var array
	 */
	private $styles_formats;


	public function __construct() {

		// set defaults, override by theme config if it exists
		$this->get_custom_styles();

		add_action( 'admin_init', array( $this, 'add_editor_styles') );
		add_filter( 'tiny_mce_before_init', array( $this, 'modify_tiny_mce' ) );


		add_filter( 'acf/fields/wysiwyg/toolbars', array( $this, 'my_toolbars' ) );

		add_filter( 'mce_buttons', array( $this, 'default_mce_toolbar' ) );
		add_filter( 'mce_buttons', array( $this, 'add_style_select_buttons' ) );
		add_filter( 'mce_buttons_2', array( $this, 'extra_mce_toolbar' ) );
	}

	private function get_custom_styles() {
		$this->stylesheet = plugins_url( 'wysiwyg-styles.css', __FILE__ );
		$this->styles_formats = array(
			array(
				'title' => 'Intro Paragraph',
				'block' => 'p',
				'classes' => 'intro',
				'wrapper' => false
			),
			array(
				'title' => 'Featured Link',
				'inline' => 'a',
				'classes' => 'large-arrow',
				'wrapper' => true,
				'attributes' => array( 'href' => '#' ),
			),
		);

		// check for overrides in the theme
		$config_fn = get_template_directory() . '/' . $this->theme_config_file;
		if (file_exists($config_fn)) {
			$contents = file_get_contents($config_fn);
			$config = json_decode($contents, TRUE);
			if ($config) {
				if (isset($config['css'])) {
					$this->stylesheet = get_template_directory() . '/' . $config['css'];
				}
				if (isset($config['style_formats'])) {
					$this->style_formats = $config['style_formats'];
				}
			}
		}
	}

	public function add_editor_styles() {

		add_editor_style(  );
	}

	public function modify_tiny_mce( $settings ) {
		// Set dropdown formatting options in WYSIWYG Editor
		// {Display Name}={html tag}
		$settings['block_formats'] = 'Paragraph=p;Heading 2=h2;Heading 3=h3;Heading 4=h4;';

		$settings['style_formats'] = json_encode( $this->style_formats );

		return $settings;
	}

	public function add_style_select_buttons( $buttons ) {
		array_unshift( $buttons, 'styleselect' );
		return $buttons;
	}

	public function default_mce_toolbar( $buttons ) {
		$buttons = array( 'bold', 'italic', 'link', 'unlink', 'bullist', 'numlist', $this->blockquote_name(), 'formatselect', '|', 'removeformat' );
		return $buttons;
	}
	public function extra_mce_toolbar( $buttons ) {
		$buttons = array( 'charmap', 'pastetext', 'undo', 'redo' );
		return $buttons;
	}

	private function blockquote_name() {
		if ( shortcode_exists( 'newcity_blockquote' ) ) {
			return 'newcity_blockquote';
		}
		
		return 'blockquote';
	}
}
