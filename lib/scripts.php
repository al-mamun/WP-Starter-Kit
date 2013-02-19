<?php
/**
 * Enqueue scripts and stylesheets
 */
function allt_scripts() {
	wp_register_style('base', get_template_directory_uri() . '/style.css', array(), '1.0', 'all');
	wp_enqueue_style('base');

	if (is_child_theme()) {
		wp_enqueue_style('base_child', get_stylesheet_uri(), false, null);
	}

	if (!is_admin()) {
		wp_deregister_script('jquery');
		wp_register_script('jquery', '//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js', false, null, true);
	}

	if (is_single() && comments_open() && get_option('thread_comments')) {
		wp_enqueue_script('comment-reply');
	}

	wp_register_script('logic', get_template_directory_uri() . '/assets/js/logic.js', false, null, true);
	wp_enqueue_script('jquery');
	wp_enqueue_script('logic');
}
add_action('wp_enqueue_scripts', 'allt_scripts', 100);

// http://wordpress.stackexchange.com/a/12450
function allt_jquery_local_fallback($src, $handle = null) {
	static $add_jquery_fallback = false;

	if ($add_jquery_fallback) {
		echo '<script>window.jQuery || document.write(\'<script src="' . get_template_directory_uri() . '/assets/js/vendor/jquery-1.9.1.min.js"><\/script>\')</script>' . "\n";
		$add_jquery_fallback = false;
	}

	if ($handle === 'jquery') {
		$add_jquery_fallback = true;
	}

	return $src;
}
if (!is_admin()) {
	add_filter('script_loader_src', 'allt_jquery_local_fallback', 10, 2);
}