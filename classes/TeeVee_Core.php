<?php

namespace ohryan\TeeVee;

Class TeeVee_Core {

	public function init() {
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

	public function tax() {
		$labels = array(
			'name'                       => _x( 'TeeVee Series', 'Taxonomy General Name', 'teevee' ),
			'singular_name'              => _x( 'TeeVee Series', 'Taxonomy Singular Name', 'teevee' ),
			'menu_name'                  => __( 'TeeVee Series', 'teevee' ),
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
		register_taxonomy( 'teevee_series', array( 'post' ), $args );
	}

	public function metaboxes() {
		$prefix = '_teevee_';

		$cpt_meta = \new_cmb2_box( array(
				'id'	=> 	$prefix.'video_metabox',
				'title'	=>	'TeeVee Video Meta Data',
				'object_types'	=>	array( 'post' ),
				'context'	=>	'advanced',
				'priority'	=>	'high',
				'show_name'	=>	true
				));

		$cpt_meta->add_field( array(
				'name'	=>	__('Title', 'teevee'),
				'id'	=>	$prefix . 'title_override',
				'type'	=>	'text',
				'description'	=>	__('note: leave blank to use post title', 'teevee')));

		$cpt_meta->add_field( array(
				'name'	=>	__('Sub-title', 'teevee'),
				'id'	=>	$prefix . 'subtitle',
				'type' 	=>	'text'));

		$cpt_meta->add_field( array(
				'name'	=>	__('Description', 'teevee'),
				'id'	=>	$prefix . 'desc',
				'type'	=>	'textarea',
				));

		$cpt_meta->add_field( array(
				'name'	=>	__('Video URI', 'teevee'),
				'id'	=>	$prefix . 'video_uri',
				'type'	=>	'text',
				'description'	=>	__('Path to video file for AppleTV.', 'teevee')));
	}
}