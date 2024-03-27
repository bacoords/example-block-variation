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
function wpdev_example_register_post_meta() {
	register_post_meta(
		'book',
		'isbn',
		array(
			'show_in_rest' => true,
			'single'       => true,
			'type'         => 'string',
		)
	);
	register_post_meta(
		'book',
		'amazon',
		array(
			'show_in_rest' => true,
			'single'       => true,
			'type'         => 'string',
		)
	);
	register_post_meta(
		'book',
		'goodreads',
		array(
			'show_in_rest' => true,
			'single'       => true,
			'type'         => 'string',
		)
	);
}
add_action( 'init', 'wpdev_example_register_post_meta' );
add_action( 'rest_api_init', 'wpdev_example_register_post_meta' );


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
						'metadata' => array(
							'bindings' => array(
								'url' => array(
									'source' => 'core/post-meta',
									'args'   => array(
										'key' => 'amazon',
									),
								),
							),
						),
						'text'     => 'Amazon',
					),
				),
				array(
					'core/button',
					array(
						'metadata' => array(
							'bindings' => array(
								'url' => array(
									'source' => 'core/post-meta',
									'args'   => array(
										'key' => 'goodreads',
									),
								),
							),
						),
						'text'     => 'Goodreads',
					),
				),
			),
		);
	}

	return $variations;
}
add_filter( 'get_block_type_variations', 'wpdev_block_type_variations', 10, 2 );
