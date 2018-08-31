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

	public function __construct() {
		add_editor_style( plugins_url( 'wysiwyg-styles.css', __FILE__ ) );
		add_filter( 'tiny_mce_before_init', array( $this, 'modify_tiny_mce' ) );
		add_action( 'init', array( $this, 'register_mce_toolbar' ) );
		add_filter( 'acf/fields/wysiwyg/toolbars', array( $this, 'my_toolbars' ) );
	}

	public function modify_tiny_mce( $settings ) {
		$settings['block_formats'] = 'Paragraph=p;Heading 2=h2;Heading 3=h3;Heading 4=h4;';

		if (get_option('newcity_wysiwyg_toolbar_format_dropdown')) {

			$style_formats = array(
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
			
			$settings['style_formats'] = json_encode( $style_formats );
		}

		return $settings;
	}

	private function blockquote_name() {
		if ( shortcode_exists( 'newcity_blockquote' ) ) {
			return 'newcity_blockquote';
		}
		
		return 'blockquote';
	}

	private function custom_styles( $init_array ) {
		if (get_option('newcity_wysiwyg_toolbar_format_dropdown')) {
			$style_formats = array(
				array(
					'title' => 'Intro Paragraph',
					'block' => 'p',
					'classes' => 'intro',
					'wrapper' => false,
				),
				array(
					'title' => 'Featured Link',
					'selector' => 'a',
					'block' => 'a',
					'classes' => 'large-arrow',
					'wrapper' => false,
				),
			);

			$init_array['style_formats'] = json_encode( $style_formats );
		}
		return $init_array;
	}

	function add_style_select_buttons( $buttons ) {
		array_unshift( $buttons, 'styleselect' );
		return $buttons;
	}

	function my_toolbars( $toolbars ) {

		$toolbars['Minimum'] = array();
		$toolbars['Minimum'][1] = array( 'bold', 'italic', '|', 'removeformat' );

		$toolbars['Minimum with Links'] = array();
		$toolbars['Minimum with Links'][1] = array( 'bold', 'italic', 'link', 'unlink', '|', 'removeformat' );

		$toolbars['Minimum with Lists'] = array();
		$toolbars['Minimum with Lists'][1] = array( 'bold', 'italic', 'link', 'unlink', '|', 'bullist', 'numlist', '|', 'removeformat' );

		$toolbars['Simple'] = array();
		$toolbars['Simple'][1] = array( 'bold', 'italic', 'link', 'unlink', 'bullist', 'numlist', $this->blockquote_name(), '|', 'removeformat' );

		$toolbars['Simple with Headers'] = array();
		$toolbars['Simple with Headers'][1] = array( 'bold', 'italic', 'link', 'unlink', 'bullist', 'numlist', 'formatselect', '|', 'removeformat' );
		if (get_option('newcity_wysiwyg_toolbar_format_dropdown')) {
			array_splice($toolbars['Simple with Headers'][1], 6, 0, 'styleselect');
		}

		unset( $toolbars['Basic'] );

		return $toolbars;
	}

	public function default_mce_toolbar( $buttons ) {
		$buttons = array( 'bold', 'italic', 'link', 'unlink', 'bullist', 'numlist', 'formatselect', '|', 'removeformat' );
		return $buttons;
	}
	public function extra_mce_toolbar( $buttons ) {
		$buttons = array( 'charmap', 'pastetext', 'undo', 'redo' );
		return $buttons;
	}

	function register_mce_toolbar() {
		add_filter( 'mce_buttons', array( $this, 'default_mce_toolbar' ) );
		add_filter( 'mce_buttons', array( $this, 'add_style_select_buttons' ) );
		add_filter( 'mce_buttons_2', array( $this, 'extra_mce_toolbar' ) );
	}
}
