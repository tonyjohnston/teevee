<?php

namespace ohryan\TeeVee;

Class TeeVee_Core {

	public function init() {
		self::cpt();
		self::tax();
		self::rewrite_rules();

		add_action('cmb2_init', array($this, 'metaboxes'));

	}

	public function activation() { 

		self::rewrite_rules();
		flush_rewrite_rules();

	}

	public function deactivation() {
		flush_rewrite_rules();
	}


	public function rewrite_rules() {
		add_rewrite_tag( '%teeveeclient%', '([^/]+)');
		add_rewrite_tag( '%teevee-template%', '([^/]+)' );
		add_rewrite_tag( '%teevee-js%', '([^/]+)');

		add_rewrite_rule( '^teeveeclient/xml/([^/]+)?', 'index.php?teeveeclient=true&teevee-template=$matches[1]', 'top' );
	}

	public function cpt() {


			$labels = array(
			'name'                => _x( 'AppleTV Videos', 'Post Type General Name', 'teevee' ),
			'singular_name'       => _x( 'AppleTV Video', 'Post Type Singular Name', 'teevee' ),
			'menu_name'           => __( 'AppleTV Videos', 'teevee' ),
			'name_admin_bar'      => __( 'AppleTV Video', 'teevee' ),
			'parent_item_colon'   => __( 'Parent Video:', 'teevee' ),
			'all_items'           => __( 'All Videos', 'teevee' ),
			'add_new_item'        => __( 'Add New Video', 'teevee' ),
			'add_new'             => __( 'Add New', 'teevee' ),
			'new_item'            => __( 'New Video', 'teevee' ),
			'edit_item'           => __( 'Edit Video', 'teevee' ),
			'update_item'         => __( 'Update Video', 'teevee' ),
			'view_item'           => __( 'View Video', 'teevee' ),
			'search_items'        => __( 'Search Video', 'teevee' ),
			'not_found'           => __( 'Not found', 'teevee' ),
			'not_found_in_trash'  => __( 'Not found in Trash', 'teevee' ),
		);
		$args = array(
			'label'               => __( 'AppleTV Video', 'teevee' ),
			'description'         => __( 'TV Bridge Video', 'teevee' ),
			'labels'              => $labels,
			'supports'            => array( 'title', 'thumbnail' ),
			'taxonomies'          => array( 'teevee_category' ),
			'hierarchical'        => false,
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'menu_position'       => 20,
			'menu_icon'           => 'dashicons-video-alt',
			'show_in_admin_bar'   => true,
			'show_in_nav_menus'   => true,
			'can_export'          => true,
			'has_archive'         => false,		
			'exclude_from_search' => false,
			'publicly_queryable'  => false,
			'capability_type'     => 'page',
		);
		register_post_type( 'teevee_video', $args );

	}

	public function tax() {
		$labels = array(
			'name'                       => _x( 'Shows', 'Taxonomy General Name', 'teevee' ),
			'singular_name'              => _x( 'Show', 'Taxonomy Singular Name', 'teevee' ),
			'menu_name'                  => __( 'Series', 'teevee' ),
			'all_items'                  => __( 'All Series', 'teevee' ),
			'parent_item'                => __( 'Parent Series', 'teevee' ),
			'parent_item_colon'          => __( 'Parent Series:', 'teevee' ),
			'new_item_name'              => __( 'New Series Name', 'teevee' ),
			'add_new_item'               => __( 'Add New Series', 'teevee' ),
			'edit_item'                  => __( 'Edit Series', 'teevee' ),
			'update_item'                => __( 'Update Series', 'teevee' ),
			'view_item'                  => __( 'View Series', 'teevee' ),
			'separate_items_with_commas' => __( 'Separate series with commas', 'teevee' ),
			'add_or_remove_items'        => __( 'Add or remove series', 'teevee' ),
			'choose_from_most_used'      => __( 'Choose from the most used', 'teevee' ),
			'popular_items'              => __( 'Popular Series', 'teevee' ),
			'search_items'               => __( 'Search Series', 'teevee' ),
			'not_found'                  => __( 'Not Found', 'teevee' ),
		);
		$args = array(
			'labels'                     => $labels,
			'hierarchical'               => true,
			'public'                     => false,
			'show_ui'                    => true,
			'show_admin_column'          => true,
			'show_in_nav_menus'          => true,
			'show_tagcloud'              => false,
			'rewrite'						=> false
		);
		register_taxonomy( 'teevee_series', array( 'teevee_video' ), $args );
	}

	public function metaboxes() {
		$prefix = '_teevee_';

		$cpt_meta = \new_cmb2_box( array(
				'id'	=> 	$prefix.'video_metabox',
				'title'	=>	'Video Details',
				'object_types'	=>	array( 'teevee_video' ),
				'context'	=>	'advanced',
				'priority'	=>	'high',
				'show_name'	=>	true
				));

		$cpt_meta->add_field( array(
				'name'	=>	__('Sub-title', 'teevee'),
				'id'	=>	$prefix . 'subtitle',
				'type' 	=>	'text'));

		$cpt_meta->add_field( array(
				'name'	=>	__('Description', 'teevee'),
				'id'	=>	$prefix . 'desc',
				'type'	=>	'textarea'
				));

		$cpt_meta->add_field( array(
				'name'	=>	__('Video URI', 'teevee'),
				'id'	=>	$prefix . 'video_uri',
				'type'	=>	'text'));

		

	}
}