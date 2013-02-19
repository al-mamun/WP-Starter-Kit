<?php
/**
 * Theme includes
 */
require_once locate_template('/lib/utils.php');           // Utility functions
require_once locate_template('/lib/init.php');            // Initial theme setup and constants

require_once locate_template('/lib/cuztom/cuztom.php');   // Cuztom lib
require_once locate_template('/lib/post_types.php');      // Cuztom lib: post types and metaboxes
require_once locate_template('/lib/metaboxes.php');       // Cuztom lib: post types and metaboxes
require_once locate_template('/lib/theme_options.php');   // Redux lib: theme options

require_once locate_template('/lib/css.php');             // CSS styles from options

require_once locate_template('/lib/sidebar.php');         // Sidebar class
require_once locate_template('/lib/config.php');          // Configuration
require_once locate_template('/lib/cleanup.php');         // Cleanup
require_once locate_template('/lib/nav.php');             // Custom nav modifications
require_once locate_template('/lib/comments.php');        // Custom comments modifications
require_once locate_template('/lib/widgets.php');         // Sidebars and widgets
require_once locate_template('/lib/scripts.php');         // Scripts and stylesheets
