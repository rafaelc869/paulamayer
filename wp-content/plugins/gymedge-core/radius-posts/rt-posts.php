<?php

if( !class_exists( 'RT_Posts' ) ){

	class RT_Posts {
		protected static $instance = null;
		private $post_types = array();
		private $taxonomies = array();

		private function __construct() {
			add_action( 'init', array( $this, 'initialize' ) );
		}

		public static function getInstance() {
			if ( null == self::$instance ) {
				self::$instance = new self;
			}
			return self::$instance;
		}

		public function initialize() {
			$this->register_taxonomies();
			$this->register_custom_post_types();
		}

		public function add_post_types( $post_types ) {

			foreach ( $post_types as $post_type => $args ) {

				$title = $args['title'];
				$plural_title = empty( $args['plural_title'] ) ? $title . 's' : $args['plural_title'];
				
				if ( ! empty( $args['rewrite'] ) ) {
					$args['rewrite'] = array( 'slug' => $args['rewrite'] );
				}

				$labels      = array(
					'name'               => $plural_title,
					'singular_name'      => $title,
					'add_new'            => __( 'Add New', 'gymedge-core' ),
					'add_new_item'       => __( 'Add New', 'gymedge-core' ) .' '. $title,
					'edit_item'          => __( 'Edit', 'gymedge-core' ) .' '. $title,
					'new_item'           => __( 'New', 'gymedge-core' ) .' '. $title,
					'all_items'          => __( 'All', 'gymedge-core' ) .' '. $plural_title,
					'view_item'          => __( 'View', 'gymedge-core' ) .' '. $title,
					'search_items'       => __( 'Search', 'gymedge-core' ) .' '. $plural_title,
					'not_found'          => $plural_title . __( ' not found', 'gymedge-core' ),
					'not_found_in_trash' => $plural_title . __( ' not found in Trash', 'gymedge-core' ),
					'parent_item_colon'  => '',
					'menu_name'          => $plural_title
					);

				if ( !empty( $args['labels_override'] ) ) {
					$labels = wp_parse_args( $args['labels_override'], $labels );
				}

				$defaults = array(
					'labels'             => $labels,
					'public'             => true,
					'publicly_queryable' => true,
					'show_ui'            => true,
					'show_in_menu'       => true,
					'show_in_nav_menus'  => true,
					'query_var'          => true,
					'has_archive'        => true,
					'hierarchical'       => false,
					'menu_position'      => null,
					'menu_icon'          => null,
					'supports'           => array( 'title', 'thumbnail', 'editor' )
					);

				$args = wp_parse_args( $args, $defaults );
				$this->post_types[ $post_type ] = $args;
			}
		}

		public function add_taxonomies( $taxonomies ) {

			foreach ($taxonomies as $taxonomy => $args ) {

				$title = $args['title'];
				$plural_title = empty( $args['plural_title'] ) ? $title . 's' : $args['plural_title'];

				$labels     = array(
					'name'              => $title,
					'singular_name'     => $title,
					'search_items'      => __( 'Search', 'gymedge-core' ) .' '. $plural_title,
					'all_items'         => __( 'All', 'gymedge-core' ) .' '. $plural_title,
					'parent_item'       => __( 'Parent', 'gymedge-core' ) .' '. $title,
					'parent_item_colon' => __( 'Parent', 'gymedge-core' ) .' '. $title.':',
					'edit_item'         => __( 'Edit', 'gymedge-core' ) .' '. $title,
					'update_item'       => __( 'Update', 'gymedge-core' ) .' '. $title,
					'add_new_item'      => __( 'Add New', 'gymedge-core' ) .' '. $title,
					'new_item_name'     => __( 'New name of', 'gymedge-core' ) .' '. $title,
					'menu_name'         => $plural_title,
					);

				if ( !empty( $args['labels_override'] ) ) {
					$labels = wp_parse_args( $args['labels_override'], $labels );
				}

				$defaults = array(
					'hierarchical'      => true,
					'labels'            => $labels,
					'show_in_nav_menus' => true,
					'show_ui'           => null,
					'show_admin_column' => true,
					'query_var'         => true,
					'rewrite'           => array( 'slug' => $taxonomy )
					);

				$args = wp_parse_args( $args, $defaults );
				$this->taxonomies[ $taxonomy ] = $args;
			}
		}

		private function register_custom_post_types() {
			foreach ( $this->post_types as $post_type => $args ) {
				register_post_type( $post_type, $args );
			}
		}

		private function register_taxonomies() {
			foreach ( $this->taxonomies as $taxonomy => $args ) {
				register_taxonomy( $taxonomy, $args['post_types'], $args );
			}
		}
	}
}

RT_Posts::getInstance();