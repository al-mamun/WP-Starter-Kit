<?php
/**
 * Theme activation
 */
if (is_admin() && isset($_GET['activated']) && 'themes.php' == $GLOBALS['pagenow']) {
	wp_redirect(admin_url('themes.php?page=theme_activation_options'));
	exit;
}

function allt_theme_activation_options_init() {
	if (allt_get_theme_activation_options() === false) {
		add_option('allt_theme_activation_options', allt_get_default_theme_activation_options());
	}

	register_setting(
		'allt_activation_options',
		'allt_theme_activation_options',
		'allt_theme_activation_options_validate'
	);
}
add_action('admin_init', 'allt_theme_activation_options_init');

function allt_activation_options_page_capability($capability) {
	return 'edit_theme_options';
}
add_filter('option_page_capability_allt_activation_options', 'allt_activation_options_page_capability');

function allt_theme_activation_options_add_page() {
	$allt_activation_options = allt_get_theme_activation_options();

	if ($allt_activation_options['first_run']) {
		$theme_page = add_theme_page(
			__('Theme Activation', ALLT_TEXT_DOMAIN),
			__('Theme Activation', ALLT_TEXT_DOMAIN),
			'edit_theme_options',
			'theme_activation_options',
			'allt_theme_activation_options_render_page'
		);
	} else {
		if (is_admin() && isset($_GET['page']) && $_GET['page'] === 'theme_activation_options') {
			global $wp_rewrite;
			$wp_rewrite->flush_rules();
			wp_redirect(admin_url('themes.php'));
			exit;
		}
	}
}
add_action('admin_menu', 'allt_theme_activation_options_add_page', 50);

function allt_get_default_theme_activation_options() {
	$default_theme_activation_options = array(
		'first_run'											 => true,
		'create_front_page'							 => false,
		'change_permalink_structure'			=> false,
		'change_uploads_folder'					 => false,
		'create_navigation_menus'				 => false,
		'add_pages_to_primary_navigation' => false,
	);

	return apply_filters('allt_default_theme_activation_options', $default_theme_activation_options);
}

function allt_get_theme_activation_options() {
	return get_option('allt_theme_activation_options', allt_get_default_theme_activation_options());
}

function allt_theme_activation_options_render_page() { ?>
	<div class="wrap">
		<?php screen_icon(); ?>
		<h2><?php printf(__('%s Theme Activation', ALLT_TEXT_DOMAIN), wp_get_theme()); ?></h2>
		<?php settings_errors(); ?>

		<form method="post" action="options.php">

			<?php
				settings_fields('allt_activation_options');
				$allt_activation_options = allt_get_theme_activation_options();
				$allt_default_activation_options = allt_get_default_theme_activation_options();
			?>

			<input type="hidden" value="false" name="allt_theme_activation_options[first_run]">

			<table class="form-table">

				<tr valign="top"><th scope="row"><?php _e('Create static front page?', ALLT_TEXT_DOMAIN); ?></th>
					<td>
						<fieldset><legend class="screen-reader-text"><span><?php _e('Create static front page?', ALLT_TEXT_DOMAIN); ?></span></legend>
							<select name="allt_theme_activation_options[create_front_page]" id="create_front_page">
								<option selected="selected" value="true"><?php echo _e('Yes', ALLT_TEXT_DOMAIN); ?></option>
								<option value="false"><?php echo _e('No', ALLT_TEXT_DOMAIN); ?></option>
							</select>
							<br>
							<small class="description"><?php printf(__('Create a page called Home and set it to be the static front page', ALLT_TEXT_DOMAIN)); ?></small>
						</fieldset>
					</td>
				</tr>

				<tr valign="top"><th scope="row"><?php _e('Change permalink structure?', ALLT_TEXT_DOMAIN); ?></th>
					<td>
						<fieldset><legend class="screen-reader-text"><span><?php _e('Update permalink structure?', ALLT_TEXT_DOMAIN); ?></span></legend>
							<select name="allt_theme_activation_options[change_permalink_structure]" id="change_permalink_structure">
								<option selected="selected" value="true"><?php echo _e('Yes', ALLT_TEXT_DOMAIN); ?></option>
								<option value="false"><?php echo _e('No', ALLT_TEXT_DOMAIN); ?></option>
							</select>
							<br>
							<small class="description"><?php printf(__('Change permalink structure to /&#37;postname&#37;/', ALLT_TEXT_DOMAIN)); ?></small>
						</fieldset>
					</td>
				</tr>

				<tr valign="top"><th scope="row"><?php _e('Change uploads folder?', ALLT_TEXT_DOMAIN); ?></th>
					<td>
						<fieldset><legend class="screen-reader-text"><span><?php _e('Update uploads folder?', ALLT_TEXT_DOMAIN); ?></span></legend>
							<select name="allt_theme_activation_options[change_uploads_folder]" id="change_uploads_folder">
								<option selected="selected" value="true"><?php echo _e('Yes', ALLT_TEXT_DOMAIN); ?></option>
								<option value="false"><?php echo _e('No', ALLT_TEXT_DOMAIN); ?></option>
							</select>
							<br>
							<small class="description"><?php printf(__('Change uploads folder to /assets/ instead of /wp-content/uploads/', ALLT_TEXT_DOMAIN)); ?></small>
						</fieldset>
					</td>
				</tr>

				<tr valign="top"><th scope="row"><?php _e('Create navigation menu?', ALLT_TEXT_DOMAIN); ?></th>
					<td>
						<fieldset><legend class="screen-reader-text"><span><?php _e('Create navigation menu?', ALLT_TEXT_DOMAIN); ?></span></legend>
							<select name="allt_theme_activation_options[create_navigation_menus]" id="create_navigation_menus">
								<option selected="selected" value="true"><?php echo _e('Yes', ALLT_TEXT_DOMAIN); ?></option>
								<option value="false"><?php echo _e('No', ALLT_TEXT_DOMAIN); ?></option>
							</select>
							<br>
							<small class="description"><?php printf(__('Create the Primary Navigation menu and set the location', ALLT_TEXT_DOMAIN)); ?></small>
						</fieldset>
					</td>
				</tr>

				<tr valign="top"><th scope="row"><?php _e('Add pages to menu?', ALLT_TEXT_DOMAIN); ?></th>
					<td>
						<fieldset><legend class="screen-reader-text"><span><?php _e('Add pages to menu?', ALLT_TEXT_DOMAIN); ?></span></legend>
							<select name="allt_theme_activation_options[add_pages_to_primary_navigation]" id="add_pages_to_primary_navigation">
								<option selected="selected" value="true"><?php echo _e('Yes', ALLT_TEXT_DOMAIN); ?></option>
								<option value="false"><?php echo _e('No', ALLT_TEXT_DOMAIN); ?></option>
							</select>
							<br>
							<small class="description"><?php printf(__('Add all current published pages to the Primary Navigation', ALLT_TEXT_DOMAIN)); ?></small>
						</fieldset>
					</td>
				</tr>

			</table>

			<?php submit_button(); ?>
		</form>
	</div>

<?php }

function allt_theme_activation_options_validate($input) {
	$output = $defaults = allt_get_default_theme_activation_options();

	$options = array(
		'first_run',
		'create_front_page',
		'change_permalink_structure',
		'change_uploads_folder',
		'create_navigation_menus',
		'add_pages_to_primary_navigation'
	);

	foreach($options as $option_name) {
		if (isset($input[$option_name])) {
			$input[$option_name] = ($input[$option_name] === 'true') ? true : false;
			$output[$option_name] = $input[$option_name];
		}
	}

	return apply_filters('allt_theme_activation_options_validate', $output, $input, $defaults);
}

function allt_theme_activation_action() {
	$allt_theme_activation_options = allt_get_theme_activation_options();

	if ($allt_theme_activation_options['create_front_page']) {
		$allt_theme_activation_options['create_front_page'] = false;

		$default_pages = array('Home');
		$existing_pages = get_pages();
		$temp = array();

		foreach ($existing_pages as $page) {
			$temp[] = $page->post_title;
		}

		$pages_to_create = array_diff($default_pages, $temp);

		foreach ($pages_to_create as $new_page_title) {
			$add_default_pages = array(
				'post_title' => $new_page_title,
				'post_content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum consequat, orci ac laoreet cursus, dolor sem luctus lorem, eget consequat magna felis a magna. Aliquam scelerisque condimentum ante, eget facilisis tortor lobortis in. In interdum venenatis justo eget consequat. Morbi commodo rhoncus mi nec pharetra. Aliquam erat volutpat. Mauris non lorem eu dolor hendrerit dapibus. Mauris mollis nisl quis sapien posuere consectetur. Nullam in sapien at nisi ornare bibendum at ut lectus. Pellentesque ut magna mauris. Nam viverra suscipit ligula, sed accumsan enim placerat nec. Cras vitae metus vel dolor ultrices sagittis. Duis venenatis augue sed risus laoreet congue ac ac leo. Donec fermentum accumsan libero sit amet iaculis. Duis tristique dictum enim, ac fringilla risus bibendum in. Nunc ornare, quam sit amet ultricies gravida, tortor mi malesuada urna, quis commodo dui nibh in lacus. Nunc vel tortor mi. Pellentesque vel urna a arcu adipiscing imperdiet vitae sit amet neque. Integer eu lectus et nunc dictum sagittis. Curabitur commodo vulputate fringilla. Sed eleifend, arcu convallis adipiscing congue, dui turpis commodo magna, et vehicula sapien turpis sit amet nisi.',
				'post_status' => 'publish',
				'post_type' => 'page'
			);

			$result = wp_insert_post($add_default_pages);
		}

		$home = get_page_by_title('Home');
		update_option('show_on_front', 'page');
		update_option('page_on_front', $home->ID);

		$home_menu_order = array(
			'ID' => $home->ID,
			'menu_order' => -1
		);
		wp_update_post($home_menu_order);
	}

	if ($allt_theme_activation_options['change_permalink_structure']) {
		$allt_theme_activation_options['change_permalink_structure'] = false;
		global $wp_rewrite;

		if (get_option('permalink_structure') !== '/%postname%/') {
			$wp_rewrite->set_permalink_structure('/%postname%/');
		}

		$wp_rewrite->init();
		$wp_rewrite->flush_rules();
	}

	if ($allt_theme_activation_options['change_uploads_folder']) {
		$allt_theme_activation_options['change_uploads_folder'] = false;

		update_option('uploads_use_yearmonth_folders', 0);
		update_option('upload_path', 'assets');
	}

	if ($allt_theme_activation_options['create_navigation_menus']) {
		$allt_theme_activation_options['create_navigation_menus'] = false;

		$allt_nav_theme_mod = false;

		$primary_nav = wp_get_nav_menu_object('Primary Navigation');

		if (!$primary_nav) {
			$primary_nav_id = wp_create_nav_menu('Primary Navigation', array('slug' => 'primary_navigation'));
			$allt_nav_theme_mod['primary_navigation'] = $primary_nav_id;
		} else {
			$allt_nav_theme_mod['primary_navigation'] = $primary_nav->term_id;
		}

		if ($allt_nav_theme_mod) {
			set_theme_mod('nav_menu_locations', $allt_nav_theme_mod);
		}
	}

	if ($allt_theme_activation_options['add_pages_to_primary_navigation']) {
		$allt_theme_activation_options['add_pages_to_primary_navigation'] = false;

		$primary_nav = wp_get_nav_menu_object('Primary Navigation');
		$primary_nav_term_id = (int) $primary_nav->term_id;
		$menu_items= wp_get_nav_menu_items($primary_nav_term_id);

		if (!$menu_items || empty($menu_items)) {
			$pages = get_pages();
			foreach($pages as $page) {
				$item = array(
					'menu-item-object-id' => $page->ID,
					'menu-item-object' => 'page',
					'menu-item-type' => 'post_type',
					'menu-item-status' => 'publish'
				);
				wp_update_nav_menu_item($primary_nav_term_id, 0, $item);
			}
		}
	}

	update_option('allt_theme_activation_options', $allt_theme_activation_options);
}
add_action('admin_init','allt_theme_activation_action');

function allt_deactivation() {
	delete_option('allt_theme_activation_options');
}
add_action('switch_theme', 'allt_deactivation');
