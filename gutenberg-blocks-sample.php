<?php
/** 
 * Plugin that add Gutenberg block samples
 * 
 * @link              https://github.com/eudesgit/gutenberg-sample-blocks
 * @since             1.0.0
 * @package           Gutenberg_Block_Samples
 * 
 * @wordpress-plugin
 * Plugin Name:       Gutenberg Block Samples
 * Plugin URI:        https://github.com/eudesgit/gutenberg-sample-blocks
 * Description:       Simple plugin that adds Gutenberg block samples for WP developers learning and boilerplate
 * Version:           0.8.0
 * Author:            Eudes
 * Author URI:        https://github.com/eudesgit/
 * License:           Apache-2.0
 * Text Domain:       gutenberg-blocks-sample
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

const GBC_VERSION = '0.8.0';

class Gutenberg_Blocks_Sample {

	/**
	 * The unique identifier of this plugin (slug).
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
    protected $plugin_name;
    
	/**
	 * The array of actions registered with WordPress.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      array    $actions    The actions registered with WordPress to fire when the plugin loads.
	 */
	protected $actions;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
        
        $this->plugin_name = 'gutenberg-blocks-sample';

        $this->actions = [];
		$this->filters = [];

        // Register hooks
		$this->hooks(); 

    }

    /**
     * Getters
     */
	public function get_plugin_name ( ) { return $this->plugin_name; }

	/**
	 * Register all hooks
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function hooks ( ) {

        $this->add_action('init', $this, 'register_simple_block_action');  
    }
    
    /**
     * Registers the simple block JS script and its styles
     *
     * @since    1.0.0
     * @return void
     */
    public function register_simple_block_action ( ) {

        $block_name = 'block-simple';

        $block_namespace = 'gutenberg-blocks-sample/' . $block_name;

        $script_slug = $this->plugin_name . '-' . $block_name;
        $style_slug = $this->plugin_name . '-' . $block_name . '-style';
        $editor_style_slug = $this->plugin_name . '-' . $block_name . '-editor-style';

        // The JS block script
        $script_file = $block_name . '/dist/block.js';
        wp_enqueue_script( 
            $script_slug, 
            plugin_dir_url(__FILE__) . $script_file, 
            [  // Dependencies that will have to be imported on the block JS file
                'wp-blocks', // Required: contains registerBlockType function that creates a block
                'wp-element', // Required: contains element function that handles HTML markup
                'wp-i18n', // contains registerBlockType function that creates a block
            ], 
            plugin_dir_path(__FILE__) . $script_file
        );

        // The block style
        // It will be loaded on the editor and on the site
        wp_register_style(
            $style_slug,
            plugin_dir_url( __FILE__ )  . $block_name . '/css/index.css', 
            ['wp-blocks'], // General style
            GBC_VERSION
        );            

        // The block style for the editor only
        wp_register_style(
            $editor_style_slug,
            plugin_dir_url( __FILE__ ) . $block_name . '/css/index.css', 
            ['wp-edit-blocks'], // Style for the editor
            GBC_VERSION
        );
        
        // Registering the block
        register_block_type(
            $block_namespace,  // Block name with namespace
            [
                'style' => $style_slug, // General block style slug
                'editor_style' => $editor_style_slug, // Editor block style slug
                'editor_script' => $script_slug,  // The block script slug
            ]
        );

    }


	/**
	 * Add a new action to the collection to be registered with WordPress.
	 *
	 * @since    1.0.0
	 * @param    string               $hook             The name of the WordPress action that is being registered.
	 * @param    object               $component        A reference to the instance of the object on which the action is defined.
	 * @param    string               $callback         The name of the function definition on the $component.
	 * @param    int                  $priority         Optional. The priority at which the function should be fired. Default is 10.
	 * @param    int                  $accepted_args    Optional. The number of arguments that should be passed to the $callback. Default is 1.
	 */
	protected function add_action( $hook, $component, $callback, $priority = 10, $accepted_args = 1 ) {
		$this->actions = $this->add( $this->actions, $hook, $component, $callback, $priority, $accepted_args );
	}
   
	/**
	 * A utility function that is used to register the actions and hooks into a single
	 * collection.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @param    array                $hooks            The collection of hooks that is being registered (that is, actions or filters).
	 * @param    string               $hook             The name of the WordPress filter that is being registered.
	 * @param    object               $component        A reference to the instance of the object on which the filter is defined.
	 * @param    string               $callback         The name of the function definition on the $component.
	 * @param    int                  $priority         The priority at which the function should be fired.
	 * @param    int                  $accepted_args    The number of arguments that should be passed to the $callback.
	 * @return   array                                  The collection of actions and filters registered with WordPress.
	 */
	private function add( $hooks, $hook, $component, $callback, $priority, $accepted_args ) {

		$hooks[] = [
			'hook'          => $hook,
			'component'     => $component,
			'callback'      => $callback,
			'priority'      => $priority,
			'accepted_args' => $accepted_args
        ];

		return $hooks;

	}    

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->run_adds();
    }
    
	/**
	 * Register the filters and actions with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run_adds() {

		foreach ( $this->actions as $hook ) {
			add_action( $hook['hook'], array( $hook['component'], $hook['callback'] ), $hook['priority'], $hook['accepted_args'] );
		}

	}    



}

/*
 * BEGIN
 */
$gsb = new Gutenberg_Blocks_Sample();
$gsb->run();