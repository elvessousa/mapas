<?php
/*-----------------------------------------------------------------------

	Type name: Storymaps
	Make sure you know what you're doing before altering this code.

------------------------------------------------------------------------*/
if ( !function_exists('ess_create_storymaps') ) {

	add_action('init', 'ess_create_storymaps');

	function ess_create_storymaps() {
		$storymaps_labels = array(
			'name' 					=> __('Storymaps', 'ess-storymap'),
			'singular_name' 		=> __('Storymap', 'ess-storymap'),
			'add_new' 				=> __('Add storymap', 'ess-storymap'),
			'add_new_item' 			=> __('Add new storymap', 'ess-storymap'),
			'edit' 					=> __('Edit', 'ess-storymap'),
			'edit_item' 			=> __('Edit storymap', 'ess-storymap'),
			'menu_name' 			=> __('Storymaps', 'ess-storymap'),
			'new_item' 				=> __('New storymap', 'ess-storymap'),
			'not_found' 			=> __('No storymaps Found', 'ess-storymap'),
			'not_found_in_trash' 	=> __('No storymaps Found in Trash', 'ess-storymap'),
			'parent' 				=> __('Parent storymaps', 'ess-storymap'),
			'search_items' 			=> __('Search storymaps', 'ess-storymap'),
			'view' 					=> __('View storymap', 'ess-storymap'),
			'view_item' 			=> __('View storymap', 'ess-storymap'),
		);

		$storymaps_args = array(
			'hierarchical' 			=> false,
			'labels' 				=> $storymaps_labels,
			'public' 				=> true,
			'show_in_nav_menus' 	=> false,
			'show_ui' 				=> true,
			'singular_label' 		=> __('storymap', 'ess-storymap'),
			'supports' 				=> array('title', 'thumbnail', 'excerpt', 'custom-fields', 'page-attributes'),
			'can_export' 			=> true,
			'capability_type'		=> 'post',
			'exclude_from_search' 	=> true,
			'publicly_queryable' 	=> true,
			'query_var' 			=> true,
			'has_archive' 			=> true,
			'rewrite' 				=> array(
					'slug'			=> 'storymaps',
					'with_front'	=> false,
					'feed'			=> true,
					'pages'			=> false
				),
			//'taxonomies'   => array('category', 'post_tag'),

		);
		register_post_type('storymaps',$storymaps_args);
	}

	// ----------------------------------------------------
	// Categories
	// ----------------------------------------------------
	function ess_storymaps_taxonomies() {

		// Types for organization
		$labels = array(
			'name'                       => __( 'Stories', 'ess-storymap' ),
			'singular_name'              => __( 'Stories', 'ess-storymap' ),
			'menu_name'                  => __( 'Stories', 'ess-storymap' ),
			'all_items'                  => __( 'All Items', 'ess-storymap' ),
			'new_item_name'              => __( 'New story', 'ess-storymap' ),
			'add_new_item'               => __( 'Add new story', 'ess-storymap' ),
			'edit_item'                  => __( 'Edit story', 'ess-storymap' ),
			'update_item'                => __( 'Update story', 'ess-storymap' ),
			'separate_items_with_commas' => __( 'Separate stories with commas', 'ess-storymap' ),
			'search_items'               => __( 'Search stories', 'ess-storymap' ),
			'add_or_remove_items'        => __( 'Add or remove stories', 'ess-storymap' ),
			'choose_from_most_used'      => __( 'Choose from the most used stories', 'ess-storymap' ),
			'not_found'                  => __( 'Not Found', 'ess-storymap' ),
		);

		$args = array(
			'labels'            => $labels,
			'public'            => true,
			'show_in_nav_menus' => true,
			'show_ui'           => true,
			'show_tagcloud'     => true,
			'hierarchical'      => true,
			'rewrite'           => array(
				'slug'			=> 'maps',
				'with_front'	=> false,
				'feed'			=> true,
				'pages'			=> false
			),
			'show_admin_column' => true,
		);

		register_taxonomy('stories', array('storymaps'), $args);

	}
	add_action( 'init', 'ess_storymaps_taxonomies', 0 );


	// ----------------------------------------------------
	// Storymaps [admin]
	// ----------------------------------------------------
	add_filter('manage_edit-storymaps_columns', 'ess_storymaps_edit_columns');
	add_action('manage_storymaps_posts_custom_column',  'ess_storymaps_columns_display');

	function ess_storymaps_edit_columns($storymaps_columns){
		$storymaps_columns = array(
			'cb'      => '<input type="checkbox" />',
			'icon'    => '',
			'title'   => __('Title', 'ess-storymap'),
			'author'  => __('Author', 'ess-storymap'),
			'stories' => __('Stories', 'ess-storymap'),
			'date'    => __('Date', 'ess-storymap'),
		);
		return $storymaps_columns;
	}

	// ----------------------------------------------------
	// Columns [admin]
	// ----------------------------------------------------
	function ess_storymaps_columns_display($storymaps_columns){
		global $post;
		switch ($storymaps_columns)
		{
			case 'icon':
				echo '<span class="big"><i class="icon-location tb-icon"></i></span>';
				break;
			case 'stories':
				echo get_the_term_list($post->ID, 'stories', '<li style="list-style: none; margin: 0">', '</li><li style="list-style: none; margin: 0">','</li>');
				break;
		}
	}

	// ----------------------------------------------------
	// Filter storymaps list
	// ----------------------------------------------------
	add_action('restrict_manage_posts', 'ess_restrict_storymaps_by_story');
	function ess_restrict_storymaps_by_story() {
		global $typenow;
		$post_type = 'storymaps';
		$taxonomy = 'stories';
		if ($typenow == $post_type) {
			$selected = isset($_GET[$taxonomy]) ? $_GET[$taxonomy] : '';
			$info_taxonomy = get_taxonomy($taxonomy);
			wp_dropdown_categories(array(
				'show_option_all' => __("Stories", "ess-storymap"),
				'taxonomy'        => $taxonomy,
				'name'            => $taxonomy,
				'orderby'         => 'name',
				'selected'        => $selected,
				'show_count'      => true,
				'hide_empty'      => true,
			));
		};
	}

	add_filter('parse_query', 'ess_convert_storymapid_to_term_in_query');
	function ess_convert_storymapid_to_term_in_query($query) {
		global $pagenow;
		$post_type   = 'storymaps';
		$taxonomy    = 'stories';
		$q_vars      = &$query->query_vars;
		if ($pagenow == 'edit.php' && isset($q_vars['post_type']) && $q_vars['post_type'] == $post_type && isset($q_vars[$taxonomy]) && is_numeric($q_vars[$taxonomy]) && $q_vars[$taxonomy] != 0) {
			$term = get_term_by('id', $q_vars[$taxonomy], $taxonomy);
			$q_vars[$taxonomy] = $term->slug;
		}
	}

	// ----------------------------------------------------
	// Post class
	// ----------------------------------------------------
	add_filter( 'post_class', 'ess_add_storymaps_class' );
	function ess_add_storymaps_class( $class ) {
		if ( ! is_tax() )
			return $class;
		$tax   = get_query_var( 'taxonomy' );
		$term  = $tax . '-' . get_query_var( 'term' );
		$class = array_merge( $class, array( 'taxonomy-archive', $tax, $term ) );
		return $class;
	}


	// ----------------------------------------------------
	// Storymap fields
	// ----------------------------------------------------
	function ess_get_storymap_fields($id) {
		if (empty($id)) { $id = get_the_ID(); }

		$prefix_storymaps = '_ess-storymap_';

		// Storymap data
		$storymap['type']        = get_post_meta($id, $prefix_storymaps . 'maptype', true);
		$storymap['address']     = get_post_meta($id, $prefix_storymaps . 'address', true);
		$storymap['description'] = get_post_meta($id, $prefix_storymaps . 'description', true);
		$storymap['media']       = get_post_meta($id, $prefix_storymaps . 'media', true);
		$storymap['caption']     = get_post_meta($id, $prefix_storymaps . 'caption', true);
		$storymap['credit']      = get_post_meta($id, $prefix_storymaps . 'credit', true);
		$storymap['backcolor']   = get_post_meta($id, $prefix_storymaps . 'backcolor', true);
		$storymap['image']   	 = get_post_meta($id, $prefix_storymaps . 'image', true);
		$storymap['backimage']   = get_post_meta($id, $prefix_storymaps . 'backimage', true);
		$storymap['zoom']        = get_post_meta($id, $prefix_storymaps . 'zoom', true);
		$storymap['line']        = get_post_meta($id, $prefix_storymaps . 'line', true);

		return $storymap;
	}
}
