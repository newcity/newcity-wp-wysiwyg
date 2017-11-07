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
		add_filter( 'tiny_mce_before_init', array( $this, 'modify_tiny_mce' ) );
		add_action( 'init', array( $this, 'register_mce_toolbar' ) );
		add_filter( 'acf/fields/wysiwyg/toolbars', array( $this, 'my_toolbars' ) );
	}

	public function modify_tiny_mce( $settings ) {
		// Set dropdown formatting options in WYSIWYG Editor
		// {Display Name}={html tag}
		$settings['block_formats'] = 'Paragraph=p;Heading 2=h2;Heading 3=h3;Heading 4=h4;';

		return $settings;
	}

	private function blockquote_name() {
		if ( shortcode_exists( 'newcity_blockquote' ) ) {
			return 'newcity_blockquote';
		}
		
		return 'blockquote';
	}

	function my_toolbars( $toolbars ) {
		// Add new WYSIWYG toolbar sets


		$toolbars['Minimum'] = array();
		$toolbars['Minimum'][1] = array( 'bold', 'italic', '|', 'removeformat' );

		$toolbars['Minimum with Links'] = array();
		$toolbars['Minimum with Links'][1] = array( 'bold', 'italic', 'link', 'unlink', '|', 'removeformat' );

		$toolbars['Minimum with Lists'] = array();
		$toolbars['Minimum with Lists'][1] = array( 'bold', 'italic', 'link', 'unlink', '|', 'bullist', 'numlist', '|', 'removeformat' );

		$toolbars['Simple'] = array();
		$toolbars['Simple'][1] = array( 'bold', 'italic', 'link', 'unlink', 'bullist', 'numlist', $this->blockquote_name(), '|', 'removeformat' );

		$toolbars['Simple with Headers'] = array();
		$toolbars['Simple with Headers'][1] = array( 'bold', 'italic', 'link', 'unlink', 'bullist', 'numlist', $this->blockquote_name(), 'formatselect', '|', 'removeformat' );

		// Edit the "Full" toolbar and remove 'code'
		// if (($key = array_search('code', $toolbars['Full' ][2])) !== false) {
		//     unset($toolbars['Full' ][2][$key]);
		// }

		// remove the 'Basic' toolbar completely
		unset( $toolbars['Basic'] );

		// return $toolbars - IMPORTANT!
		return $toolbars;
	}

	public function default_mce_toolbar( $buttons ) {
		$buttons = array( 'bold', 'italic', 'link', 'unlink', 'bullist', 'numlist', $this->blockquote_name(), 'formatselect', '|', 'removeformat' );
		return $buttons;
	}
	public function extra_mce_toolbar( $buttons ) {
		$buttons = array( 'charmap', 'pastetext', 'undo', 'redo' );
		return $buttons;
	}

	function register_mce_toolbar() {
		add_filter( 'mce_buttons', array( $this, 'default_mce_toolbar' ) );
		add_filter( 'mce_buttons_2', array( $this, 'extra_mce_toolbar' ) );
	}
}
