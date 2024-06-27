<?php
/**
 * Plugin Name:       Example Block Variation
 * Description:       Example block scaffolded with Create Block tool.
 * Requires at least: 6.1
 * Requires PHP:      7.0
 * Version:           0.1.0
 * Author:            The WordPress Contributors
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       example-block-variation
 *
 * @package           wpdev
 */


/**
 * Register post meta for books.
 *
 * @return void
 */
function wpdev_example_register_post() {

	register_post_type(
		'book',
		array(
			'labels'                => array(
				'name'          => __( 'Books', 'peoplesbancorp' ),
				'singular_name' => __( 'Book', 'peoplesbancorp' ),
			),
			'public'                => true,
			'publicly_queryable'    => true,
			'show_ui'               => true,
			'show_in_menu'          => true,
			'show_in_nav_menus'     => true,
			'show_in_admin_bar'     => true,
			'query_var'             => true,
			'capability_type'       => 'post',
			'has_archive'           => false,
			'hierarchical'          => false,
			'menu_position'         => null,
			'supports'              => array( 'editor', 'title', 'thumbnail', 'custom-fields' ),
			'menu_icon'             => 'dashicons-book',
			'show_in_rest'          => true,
			'rest_base'             => 'book',
			'rest_controller_class' => 'WP_REST_Posts_Controller',
			'rewrite'               => array(
				'slug' => 'book',
			),
			'template'              => array(
				array(
					'core/group',
					array(
						'templateLock'    => 'all',
						'lock'            => array(
							'move'   => true,
							'remove' => true,
						),
						'style'           => array(
							'spacing' => array(
								'padding' => array(
									'right'  => 'var:preset|spacing|10',
									'left'   => 'var:preset|spacing|10',
									'top'    => 'var:preset|spacing|10',
									'bottom' => 'var:preset|spacing|10',
								),
							),
						),
						'backgroundColor' => 'accent-5',
						'layout'          => array(
							'type' => 'constrained',
						),
					),
					array(
						array(
							'core/post-title',
							array(
								'level' => 1,
							),
							array(),
						),
						array(
							'core/group',
							array(
								'layout' => array(
									'type'     => 'flex',
									'flexWrap' => 'nowrap',
								),
							),
							array(
								array(
									'core/paragraph',
									array(
										'content' => 'ISBN: ',
									),
									array(),
								),
								array(
									'core/paragraph',
									array(
										'metadata' => array(
											'bindings' => array(
												'content' => array(
													'source' => 'core/post-meta',
													'args' => array(
														'key' => 'isbn',
													),
												),
											),
										),
									),
									array(),
								),
								array(
									'core/buttons',
									array(),
									array(
										array(
											'core/button',
											array(
												'metadata' => array(
													'bindings' => array(
														'url' => array(
															'source' => 'core/post-meta',
															'args' => array(
																'key' => 'amazon',
															),
														),
													),
												),
												'text'     => 'Amazon',
											),
											array(),
										),
										array(
											'core/button',
											array(
												'metadata' => array(
													'bindings' => array(
														'url' => array(
															'source' => 'core/post-meta',
															'args' => array(
																'key' => 'goodreads',
															),
														),
													),
												),
												'text'     => 'Goodreads',
											),
											array(),
										),

									),
								),

							),
						),

					),
				),
				array(
					'core/paragraph',
					array(),
					array(),
				),

			),
		)
	);

	register_post_meta(
		'book',
		'isbn',
		array(
			'show_in_rest' => true,
			'single'       => true,
			'type'         => 'string',
			'default'      => '000000001',
		)
	);
	register_post_meta(
		'book',
		'amazon',
		array(
			'show_in_rest' => true,
			'single'       => true,
			'type'         => 'string',
			'default'      => 'https://www.amazon.com/',
		)
	);
	register_post_meta(
		'book',
		'goodreads',
		array(
			'show_in_rest' => true,
			'single'       => true,
			'type'         => 'string',
			'default'      => 'https://www.goodreads.com/',
		)
	);
}
add_action( 'init', 'wpdev_example_register_post' );



/**
 * Registers our custom editor script.
 * (Disable if using PHP method.)
 */
function wpdev_example_block_variation_block_init() {
	$asset_file = include plugin_dir_path( __FILE__ ) . 'build/index.asset.php';

	wp_enqueue_script(
		'wpdev-example-block-variation-block-editor',
		plugins_url( 'build/index.js', __FILE__ ),
		$asset_file['dependencies'],
		$asset_file['version'],
		true
	);
}
add_action( 'enqueue_block_editor_assets', 'wpdev_example_block_variation_block_init' );





/**
 * Register our custom block type variations.
 *
 * @param array    $variations Array of block type variations.
 * @param WP_Block $block_type  The block type.
 * @return array
 */
function wpdev_block_type_variations( $variations, $block_type ) {

	if ( 'core/paragraph' === $block_type->name ) {
		$variations[] = array(
			'name'       => 'book-isbn',
			'title'      => 'ISBN',
			'icon'       => 'book-alt',
			'attributes' => array(
				'metadata' => array(
					'bindings' => array(
						'content' => array(
							'source' => 'core/post-meta',
							'args'   => array(
								'key' => 'isbn',
							),
						),
					),
				),
			),
		);
	} elseif ( 'core/buttons' === $block_type->name ) {
		$variations[] = array(
			'name'        => 'book-buttons',
			'title'       => 'Book Buttons',
			'icon'        => 'book-alt',
			'innerBlocks' => array(
				array(
					'core/button',
					array(
						'metadata'   => array(
							'bindings' => array(
								'url' => array(
									'source' => 'core/post-meta',
									'args'   => array(
										'key' => 'amazon',
									),
								),
							),
						),
						'text'       => 'Amazon',
						'linkTarget' => '_blank',
					),
				),
				array(
					'core/button',
					array(
						'metadata'   => array(
							'bindings' => array(
								'url' => array(
									'source' => 'core/post-meta',
									'args'   => array(
										'key' => 'goodreads',
									),
								),
							),
						),
						'text'       => 'Goodreads',
						'linkTarget' => '_blank',
					),
				),
			),
		);
	}

	return $variations;
}
add_filter( 'get_block_type_variations', 'wpdev_block_type_variations', 10, 2 );
