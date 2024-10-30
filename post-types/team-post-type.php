<?php
	$ttype_labels = array(
		'name'                  => _x( 'Teams', 'Post Type General Name', 'blaize-companion' ),
		'singular_name'         => _x( 'Team', 'Post Type Singular Name', 'blaize-companion' ),
		'menu_name'             => __( 'Teams', 'blaize-companion' ),
		'name_admin_bar'        => __( 'Post Type', 'blaize-companion' ),
		'archives'              => __( 'Item Archives', 'blaize-companion' ),
		'attributes'            => __( 'Item Attributes', 'blaize-companion' ),
		'parent_item_colon'     => __( 'Parent Team:', 'blaize-companion' ),
		'all_items'             => __( 'All Teams', 'blaize-companion' ),
		'add_new_item'          => __( 'Add New Team', 'blaize-companion' ),
		'add_new'               => __( 'Add New', 'blaize-companion' ),
		'new_item'              => __( 'New Team', 'blaize-companion' ),
		'edit_item'             => __( 'Edit Team', 'blaize-companion' ),
		'update_item'           => __( 'Update Team', 'blaize-companion' ),
		'view_item'             => __( 'View Team', 'blaize-companion' ),
		'view_items'            => __( 'View Teams', 'blaize-companion' ),
		'search_items'          => __( 'Search Team', 'blaize-companion' ),
		'not_found'             => __( 'Not found', 'blaize-companion' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'blaize-companion' ),
		'featured_image'        => __( 'Featured Image', 'blaize-companion' ),
		'set_featured_image'    => __( 'Set Team Member image', 'blaize-companion' ),
		'remove_featured_image' => __( 'Remove Team Member image', 'blaize-companion' ),
		'use_featured_image'    => __( 'Use as Team Member image', 'blaize-companion' ),
		'insert_into_item'      => __( 'Insert into item', 'blaize-companion' ),
		'uploaded_to_this_item' => __( 'Uploaded to this item', 'blaize-companion' ),
		'items_list'            => __( 'Items list', 'blaize-companion' ),
		'items_list_navigation' => __( 'Items list navigation', 'blaize-companion' ),
		'filter_items_list'     => __( 'Filter items list', 'blaize-companion' ),
	);
	$ttype_args = array(
		'label'                 => __( 'Team', 'blaize-companion' ),
		'description'           => __( 'A Post Type that contains Team Members', 'blaize-companion' ),
		'labels'                => $ttype_labels,
		'supports'              => array( 'title', 'editor', 'thumbnail' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'menu_icon'             => 'dashicons-groups',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => false,		
		'exclude_from_search'   => true,
		'publicly_queryable'    => true,
		'capability_type'       => 'page',
	);
	register_post_type( 'team', $ttype_args );