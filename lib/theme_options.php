<?php
/**
 * Set the text domain for the theme or plugin.
 *
 */
define('Redux_TEXT_DOMAIN', ALLT_TEXT_DOMAIN);

if(!class_exists('Redux_Options')) {
    require_once(dirname(__FILE__) . '/redux/options/defaults.php');
}

function setup_framework_options() {
    $args = array();

	$args['dev_mode'] = true;
	$args['dev_mode_icon'] = 'iconfont';
	$args['dev_mode_icon_class'] = 'icon-large';
	$args['google_api_key'] = 'AIzaSyAqoGQfATOwgXxLPsR_qlw1YVFPdTWm2vs';
	$args['admin_stylesheet'] = 'custom';

	//$args['intro_text'] = __('<p>This text is displayed above the options panel. It isn\'t required, but more info is always better! The intro_text field accepts all HTML.</p>', ALLT_TEXT_DOMAIN);
    //$args['footer_text'] = __('<p>This text is displayed below the options panel. It isn\'t required, but more info is always better! The footer_text field accepts all HTML.</p>', ALLT_TEXT_DOMAIN);

    // Set footer/credit line.
    $args['footer_credit'] = __('<p id="footer-left" class="alignleft"><span id="footer-thankyou">Design and development by <a href="http://saika.li/" target="_blank">Pierre Sa&iuml;kali</a>.</span></p>', ALLT_TEXT_DOMAIN);

    // Setup custom links in the footer for share icons
    $args['share_icons']['twitter'] = array(
        'link' => 'http://twitter.com/psaikali',
        'title' => __('Follow me on Twitter', ALLT_TEXT_DOMAIN),
        'img' => Redux_OPTIONS_URL . 'img/social/Twitter.png'
    );
    $args['share_icons']['linked_in'] = array(
        'link' => 'http://www.linkedin.com/in/psaikali',
        'title' => __('Find me on LinkedIn', ALLT_TEXT_DOMAIN),
        'img' => Redux_OPTIONS_URL . 'img/social/LinkedIn.png'
    );

    // Enable the import/export feature.
    // Default: true
    //$args['show_import_export'] = false;

	// Set the icon for the import/export tab.
	// If $args['icon_type'] = 'image', this should be the path to the icon.
	// If $args['icon_type'] = 'iconfont', this should be the icon name.
	// Default: refresh
	//$args['import_icon'] = 'refresh';

	// Set the class for the import/export tab icon.
	// This is ignored unless $args['icon_type'] = 'iconfont'
	// Default: null
	$args['import_icon_class'] = 'icon-large';

    // Set a custom option name. Don't forget to replace spaces with underscores!
    $args['opt_name'] = 'twenty_eleven2';

    // Set a custom menu icon.
    //$args['menu_icon'] = '';

    // Set a custom title for the options page.
    // Default: Options
    $args['menu_title'] = __('Options', ALLT_TEXT_DOMAIN);

    // Set a custom page title for the options page.
    // Default: Options
    $args['page_title'] = __('Options', ALLT_TEXT_DOMAIN);

    // Set a custom page slug for options page (wp-admin/themes.php?page=***).
    // Default: redux_options
    $args['page_slug'] = 'redux_options';

    // Set a custom page capability.
    // Default: manage_options
    //$args['page_cap'] = 'manage_options';

    // Set the menu type. Set to "menu" for a top level menu, or "submenu" to add below an existing item.
    // Default: menu
    //$args['page_type'] = 'submenu';

    // Set the parent menu.
    // Default: themes.php
    // A list of available parent menus is available at http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
    //$args['page_parent'] = 'options-general.php';

    // Set a custom page location. This allows you to place your menu where you want in the menu order.
    // Must be unique or it will override other items!
    // Default: null
    //$args['page_position'] = null;

    // Set a custom page icon class (used to override the page icon next to heading)
    //$args['page_icon'] = 'icon-themes';

	// Set the icon type. Set to "iconfont" for Font Awesome, or "image" for traditional.
	// Redux no longer ships with standard icons!
	// Default: iconfont
	//$args['icon_type'] = 'image';
	//$args['dev_mode_icon_type'] = 'image';
	//$args['import_icon_type'] == 'image';

    // Disable the panel sections showing as submenu items.
    // Default: true
    //$args['allow_sub_menu'] = false;
        
    // Set ANY custom page help tabs, displayed using the new help tab API. Tabs are shown in order of definition.
    $args['help_tabs'][] = array(
        'id' => 'redux-opts-1',
        'title' => __('Theme Information 1', ALLT_TEXT_DOMAIN),
        'content' => __('<p>This is the tab content, HTML is allowed.</p>', ALLT_TEXT_DOMAIN)
    );
    $args['help_tabs'][] = array(
        'id' => 'redux-opts-2',
        'title' => __('Theme Information 2', ALLT_TEXT_DOMAIN),
        'content' => __('<p>This is the tab content, HTML is allowed.</p>', ALLT_TEXT_DOMAIN)
    );

    // Set the help sidebar for the options page.                                        
    $args['help_sidebar'] = __('<p>This is the sidebar content, HTML is allowed.</p>', ALLT_TEXT_DOMAIN);

    $sections = array();

    $sections[] = array(
		// Redux uses the Font Awesome iconfont to supply its default icons.
		// If $args['icon_type'] = 'iconfont', this should be the icon name minus 'icon-'.
		// If $args['icon_type'] = 'image', this should be the path to the icon.
		// Icons can also be overridden on a section-by-section basis by defining 'icon_type' => 'image'
		'icon_type' => 'image',
		'icon' => Redux_OPTIONS_URL . 'img/home.png',
		// Set the class for this icon.
		// This field is ignored unless $args['icon_type'] = 'iconfont'
		'icon_class' => 'icon-large',
        'title' => __('Getting Started', ALLT_TEXT_DOMAIN),
		'desc' => __('<p class="description">This is the description field for this section. HTML is allowed</p>', ALLT_TEXT_DOMAIN),
		'fields' => array(
			array(
				'id' => 'font_awesome_info',
				'type' => 'raw_html',
				'html' => '<h3 style="text-align: center; border-bottom: none;">Redux Framework is now powered by <a href="http://fortawesome.github.com/Font-Awesome/" target="_blank">Font Awesome</a>!</h3><h4 style="text-align: center; font-size: 1.3em;">What does this mean to you?</h4>
				<p>Well for one thing it means that Redux as a whole is a much leaner package than it used to be. Those annoying icons took up a <strong>lot</strong> of unnecessary space. Additionally, it means you have a lot more flexibility with your icons.
				Each icon field has an option for you to define custom classes. These are defined on an icon-by-icon basis and can be Font Awesome specific classes or your own custom ones. Want to see why this is so cool? Keep reading!</p>
				<br/><span style="font-weight: bold; text-decoration: underline;">The Icons</span><p>There&apos;s just too many to list! <a href="http://fortawesome.github.com/Font-Awesome/#icons-new" target="_blank">Click here</a> for the official list.</p>
				<br/><span style="font-weight: bold; text-decoration: underline;">The Classes</span><p>There are just as many built-in classes as icons! <a href="http://fortawesome.github.com/Font-Awesome/#examples" target="_blank">Click here</a> for a few examples.</p>
				<br/><span style="font-weight: bold; text-decoration: underline;">Anything Else?</span><p>Yep! Because it&apos;s iconfont and not image based, you can apply pretty much any CSS to an icon!</p>'
			)
		)
    );

    $sections[] = array(
		'icon' => 'edit',
		'icon_class' => 'icon-large',
        'title' => __('Text Fields', ALLT_TEXT_DOMAIN),
        'desc' => __('<p class="description">This is the description field for this section. Again HTML is allowed2</p>', ALLT_TEXT_DOMAIN),
        'fields' => array(
            array(
                'id' => 'text_demo', // The item ID must be unique
                'type' => 'text', // Built-in field types include:
                // text, textarea, editor, checkbox, multi_checkbox, radio, radio_img, button_set,
                // select, multi_select, color, date, divide, info, upload
                'title' => __('Text Option', ALLT_TEXT_DOMAIN),
                'sub_desc' => __('This is a little space under the field title which can be used for additonal info.', ALLT_TEXT_DOMAIN),
                'desc' => __('This is the description field, again good for additional info.', ALLT_TEXT_DOMAIN),
                //'validate' => '', // Built-in validation includes: 
                //  email, html, html_custom, no_html, js, numeric, comma_numeric, url, str_replace, preg_replace
                //'msg' => 'custom error message', // Override the default validation error message for specific fields
                //'std' => '', // This is the default value and is used to set an option on theme activation.
                //'class' => '' // Set custom classes for elements if you want to do something a little different
                //'rows' => '6' // Set the number of rows shown for the textarea. Default: 6
			),
            array(
                'id' => 'text_demo_email',
                'type' => 'text',
                'title' => __('Text Option - Email Validated', ALLT_TEXT_DOMAIN),
                'sub_desc' => __('This is a little space under the field title which can be used for additonal info.', ALLT_TEXT_DOMAIN),
                'desc' => __('This is the description field, again good for additional info.', ALLT_TEXT_DOMAIN),
                'validate' => 'email',
                'msg' => 'custom error message',
                'std' => 'test@test.com'
            ),
            array(
                'id' => 'password_demo',
                'type' => 'password',
                'title' => __('Password Option', ALLT_TEXT_DOMAIN),
                'sub_desc' => __('This is a little space under the field title which can be used for additonal info.', ALLT_TEXT_DOMAIN),
                'desc' => __('This is the description field, again good for additional info.', ALLT_TEXT_DOMAIN)
            ),
            array(
                'id' => 'multi_text_demo',
                'type' => 'multi_text',
                'title' => __('Multi Text Option', ALLT_TEXT_DOMAIN),
                'sub_desc' => __('This is a little space under the field title which can be used for additonal info.', ALLT_TEXT_DOMAIN),
                'desc' => __('This is the description field, again good for additional info.', ALLT_TEXT_DOMAIN),
            ),
            array(
                'id' => 'text_demo_url',
                'type' => 'text',
                'title' => __('Text Option - URL Validated', ALLT_TEXT_DOMAIN),
                'sub_desc' => __('This must be a URL.', ALLT_TEXT_DOMAIN),
                'desc' => __('This is the description field, again good for additional info.', ALLT_TEXT_DOMAIN),
                'validate' => 'url',
                'std' => 'http://reduxframework.com'
            ),
            array(
                'id' => 'text_demo_numeric',
                'type' => 'text',
                'title' => __('Text Option - Numeric Validated', ALLT_TEXT_DOMAIN),
                'sub_desc' => __('This must be numeric.', ALLT_TEXT_DOMAIN),
                'desc' => __('This is the description field, again good for additional info.', ALLT_TEXT_DOMAIN),
                'validate' => 'numeric',
                'std' => '0',
                'class' => 'small-text'
            ),
            array(
                'id' => 'text_demo_comma_numeric',
                'type' => 'text',
                'title' => __('Text Option - Comma Numeric Validated', ALLT_TEXT_DOMAIN),
                'sub_desc' => __('This must be a comma seperated string of numerical values.', ALLT_TEXT_DOMAIN),
                'desc' => __('This is the description field, again good for additional info.', ALLT_TEXT_DOMAIN),
                'validate' => 'comma_numeric',
                'std' => '0',
                'class' => 'small-text'
            ),
            array(
                'id' => 'text_demo_no_special_chars',
                'type' => 'text',
                'title' => __('Text Option - No Special Chars Validated', ALLT_TEXT_DOMAIN),
                'sub_desc' => __('This must be a alpha numeric only.', ALLT_TEXT_DOMAIN),
                'desc' => __('This is the description field, again good for additional info.', ALLT_TEXT_DOMAIN),
                'validate' => 'no_special_chars',
                'std' => '0'
            ),
            array(
                'id' => 'text_demo_str_replace',
                'type' => 'text',
                'title' => __('Text Option - Str Replace Validated', ALLT_TEXT_DOMAIN),
                'sub_desc' => __('You decide.', ALLT_TEXT_DOMAIN),
                'desc' => __('This is the description field, again good for additional info.', ALLT_TEXT_DOMAIN),
                'validate' => 'str_replace',
                'str' => array('search' => ' ', 'replacement' => 'thisisaspace'),
                'std' => '0'
            ),
            array(
                'id' => 'text_demo_preg_replace',
                'type' => 'text',
                'title' => __('Text Option - Preg Replace Validated', ALLT_TEXT_DOMAIN),
                'sub_desc' => __('You decide.', ALLT_TEXT_DOMAIN),
                'desc' => __('This is the description field, again good for additional info.', ALLT_TEXT_DOMAIN),
                'validate' => 'preg_replace',
                'preg' => array('pattern' => '/[^a-zA-Z_ -]/s', 'replacement' => 'no numbers'),
                'std' => '0'
            ),
            array(
                'id' => 'text_demo_custom_validate',
                'type' => 'text',
                'title' => __('Text Option - Custom Callback Validated', ALLT_TEXT_DOMAIN),
                'sub_desc' => __('You decide.', ALLT_TEXT_DOMAIN),
                'desc' => __('This is the description field, again good for additional info.', ALLT_TEXT_DOMAIN),
                'validate_callback' => 'validate_callback_function',
                'std' => '0'
			),
			array(
	            'id' => 'text_demo_sortable',
    	        'type' => 'text_sortable',
        	    'title' => __('Sortable Text Option', ALLT_TEXT_DOMAIN),
            	'sub_desc' => __('Define and reorder these however you want.', ALLT_TEXT_DOMAIN),
				'desc' => __('This is the description field, again good for additional info.', ALLT_TEXT_DOMAIN),
	            'options' => array(
    	            'si1' => 'Item 1',
        	        'si2' => 'Item 2',
            	    'si3' => 'Item 3',
        	    )
	        ),
            array(
                'id' => 'textarea_demo_no_html',
                'type' => 'textarea',
                'title' => __('Textarea Option - No HTML Validated', ALLT_TEXT_DOMAIN), 
                'sub_desc' => __('All HTML will be stripped', ALLT_TEXT_DOMAIN),
                'desc' => __('This is the description field, again good for additional info.', ALLT_TEXT_DOMAIN),
                'validate' => 'no_html',
                'std' => 'No HTML is allowed in here.'
            ),
            array(
                'id' => 'textarea_demo_html',
                'type' => 'textarea',
                'title' => __('Textarea Option - HTML Validated', ALLT_TEXT_DOMAIN), 
                'sub_desc' => __('HTML Allowed', ALLT_TEXT_DOMAIN),
                'desc' => __('This is the description field, again good for additional info.', ALLT_TEXT_DOMAIN),
                'validate' => 'html', // See http://codex.wordpress.org/Function_Reference/wp_kses_post
                'std' => 'HTML is allowed in here.'
            ),
            array(
                'id' => 'textarea_demo_html_custom',
                'type' => 'textarea',
                'title' => __('Textarea Option - HTML Validated Custom', ALLT_TEXT_DOMAIN), 
                'sub_desc' => __('Custom HTML Allowed', ALLT_TEXT_DOMAIN),
                'desc' => __('This is the description field, again good for additional info.', ALLT_TEXT_DOMAIN),
                'validate' => 'html_custom',
                'std' => 'Some HTML is allowed in here.',
                'allowed_html' => array('') // See http://codex.wordpress.org/Function_Reference/wp_kses
            ),
            array(
                'id' => 'textarea_demo_js',
                'type' => 'textarea',
                'title' => __('Textarea Option - JS Validated', ALLT_TEXT_DOMAIN), 
                'sub_desc' => __('JS will be escaped', ALLT_TEXT_DOMAIN),
                'desc' => __('This is the description field, again good for additional info.', ALLT_TEXT_DOMAIN),
                'validate' => 'js'
            ),
            array(
                'id' => 'editor_demo',
                'type' => 'editor',
                'title' => __('Editor Option', ALLT_TEXT_DOMAIN),
                'sub_desc' => __('Can also use the validation methods if required', ALLT_TEXT_DOMAIN),
                'desc' => __('This is the description field, again good for additional info.', ALLT_TEXT_DOMAIN),
                'std' => 'OOOOOOhhhh, rich editing.',
            ),
            array(
                'id' => 'editor_demo2',
                'type' => 'editor',
                'title' => __('Editor Option 2', ALLT_TEXT_DOMAIN), 
                'sub_desc' => __('Can also use the validation methods if required', ALLT_TEXT_DOMAIN),
                'desc' => __('This is the description field, again good for additional info.', ALLT_TEXT_DOMAIN),
                'std' => 'OOOOOOhhhh, rich editing with auto paragraphs disabled.',
                'autop' => false
            )
        )
    );
    
    $sections[] = array(
		'icon' => 'check',
		'icon_class' => 'icon-large',
        'title' => __('Radio/Checkbox Fields', ALLT_TEXT_DOMAIN),
        'desc' => __('<p class="description">This is the Description. Again HTML is allowed</p>', ALLT_TEXT_DOMAIN),
        'fields' => array(
            array(
                'id' => 'checkbox_demo_switch',
                'type' => 'checkbox',
                'title' => __('Switch Option', ALLT_TEXT_DOMAIN), 
                'sub_desc' => __('No validation can be done on this field type', ALLT_TEXT_DOMAIN),
                'desc' => __('This is the description field, again good for additional info.', ALLT_TEXT_DOMAIN),
                'switch' => true,
                'std' => '1' // 1 = checked | 0 = unchecked
            ),
            array(
                'id' => 'checkbox_demo',
                'type' => 'checkbox',
                'title' => __('Checkbox Option', ALLT_TEXT_DOMAIN), 
                'sub_desc' => __('No validation can be done on this field type', ALLT_TEXT_DOMAIN),
                'desc' => __('This is the description field, again good for additional info.', ALLT_TEXT_DOMAIN),
                'switch' => false,
                'std' => '1' // 1 = checked | 0 = unchecked
            ),
            array(
                'id' => 'multi_checkbox_demo',
                'type' => 'multi_checkbox',
                'title' => __('Multi Checkbox Option', ALLT_TEXT_DOMAIN), 
                'sub_desc' => __('No validation can be done on this field type', ALLT_TEXT_DOMAIN),
                'desc' => __('This is the description field, again good for additional info.', ALLT_TEXT_DOMAIN),
                'options' => array('1' => 'Opt 1', '2' => 'Opt 2', '3' => 'Opt 3'), // Must provide key => value pairs for multi checkbox options
                'std' => array('1' => '1', '2' => '0', '3' => '0') // See how std has changed? You also dont need to specify opts that are 0.
            ),
            array(
                'id' => 'radio_demo',
                'type' => 'radio',
                'title' => __('Radio Option', ALLT_TEXT_DOMAIN), 
                'sub_desc' => __('No validation can be done on this field type', ALLT_TEXT_DOMAIN),
                'desc' => __('This is the description field, again good for additional info.', ALLT_TEXT_DOMAIN),
                'options' => array('1' => 'Opt 1', '2' => 'Opt 2', '3' => 'Opt 3'), // Must provide key => value pairs for radio options
                'std' => '2'
            ),
            array(
                'id' => 'radio_img_demo',
                'type' => 'radio_img',
                'title' => __('Radio Image Option', ALLT_TEXT_DOMAIN), 
                'sub_desc' => __('No validation can be done on this field type', ALLT_TEXT_DOMAIN),
                'desc' => __('This is the description field, again good for additional info.', ALLT_TEXT_DOMAIN),
                'options' => array(
                    '1' => array('title' => 'Opt 1', 'img' => 'images/align-none.png'),
                    '2' => array('title' => 'Opt 2', 'img' => 'images/align-left.png'),
                    '3' => array('title' => 'Opt 3', 'img' => 'images/align-center.png'),
                    '4' => array('title' => 'Opt 4', 'img' => 'images/align-right.png')
                ), // Must provide key => value(array:title|img) pairs for radio options
                'std' => '2'
            ),
            array(
                'id' => 'radio_img_demo_layout',
                'type' => 'radio_img',
                'title' => __('Radio Image Option For Layout', ALLT_TEXT_DOMAIN), 
                'sub_desc' => __('No validation can be done on this field type', ALLT_TEXT_DOMAIN),
                'desc' => __('This uses some of the built in images, you can use them for layout options.', ALLT_TEXT_DOMAIN),
                'options' => array(
                    '1' => array('title' => '1 Column', 'img' => Redux_OPTIONS_URL . 'img/1col.png'),
                    '2' => array('title' => '2 Column Left', 'img' => Redux_OPTIONS_URL . 'img/2cl.png'),
                    '3' => array('title' => '2 Column Right', 'img' => Redux_OPTIONS_URL . 'img/2cr.png')
                ), // Must provide key => value(array:title|img) pairs for radio options
                'std' => '2'
            )                                                                        
        )
    );
    
    $sections[] = array(
		'icon' => 'list-alt',
		'icon_class' => 'icon-large',
        'title' => __('Select Fields', ALLT_TEXT_DOMAIN),
        'desc' => __('<p class="description">This is the Description. Again HTML is allowed</p>', ALLT_TEXT_DOMAIN),
        'fields' => array(
            array(
                'id' => 'select_demo',
                'type' => 'select',
                'title' => __('Select Option', ALLT_TEXT_DOMAIN), 
                'sub_desc' => __('No validation can be done on this field type', ALLT_TEXT_DOMAIN),
                'desc' => __('This is the description field, again good for additional info.', ALLT_TEXT_DOMAIN),
                'options' => array('1' => 'Opt 1', '2' => 'Opt 2', '3' => 'Opt 3'), // Must provide key => value pairs for select options
                'std' => '2'
            ),
            array(
                'id' => 'multi_select_demo',
                'type' => 'multi_select',
                'title' => __('Multi Select Option', ALLT_TEXT_DOMAIN), 
                'sub_desc' => __('No validation can be done on this field type', ALLT_TEXT_DOMAIN),
                'desc' => __('This is the description field, again good for additional info.', ALLT_TEXT_DOMAIN),
                'options' => array('1' => 'Opt 1', '2' => 'Opt 2', '3' => 'Opt 3'), // Must provide key => value pairs for radio options
                'std' => array('2', '3')
            )                                    
        )
    );
    
    $sections[] = array(
		'icon' => 'cogs',
		'icon_class' => 'icon-large',
        'title' => __('Custom Fields', ALLT_TEXT_DOMAIN),
        'desc' => __('<p class="description">This is the Description. Again HTML is allowed</p>', ALLT_TEXT_DOMAIN),
        'fields' => array(
            array(
                'id' => 'color_demo',
                'type' => 'color',
                'title' => __('Color Option', ALLT_TEXT_DOMAIN), 
                'sub_desc' => __('Only color validation can be done on this field type', ALLT_TEXT_DOMAIN),
                'desc' => __('This is the description field, again good for additional info.', ALLT_TEXT_DOMAIN),
                'std' => '#FFFFFF'
            ),
            array(
                'id' => 'color_gradient_demo',
                'type' => 'color_gradient',
                'title' => __('Color Gradient Option', ALLT_TEXT_DOMAIN),
                'sub_desc' => __('Only color validation can be done on this field type', ALLT_TEXT_DOMAIN),
                'desc' => __('This is the description field, again good for additional info.', ALLT_TEXT_DOMAIN),
                'std' => array('from' => '#000000', 'to' => '#FFFFFF')
            ),
            array(
                'id' => 'date_demo',
                'type' => 'date',
                'title' => __('Date Option', ALLT_TEXT_DOMAIN), 
                'sub_desc' => __('No validation can be done on this field type', ALLT_TEXT_DOMAIN),
                'desc' => __('This is the description field, again good for additional info.', ALLT_TEXT_DOMAIN)
            ),
            array(
                'id' => 'button_set_demo',
                'type' => 'button_set',
                'title' => __('Button Set Option', ALLT_TEXT_DOMAIN), 
                'sub_desc' => __('No validation can be done on this field type', ALLT_TEXT_DOMAIN),
                'desc' => __('This is the description field, again good for additional info.', ALLT_TEXT_DOMAIN),
                'options' => array('1' => 'Opt 1', '2' => 'Opt 2', '3' => 'Opt 3'), // Must provide key => value pairs for radio options
                'std' => '2'
			),
            array(
                'id' => 'upload_demo',
                'type' => 'upload',
                'title' => __('Upload Option', ALLT_TEXT_DOMAIN), 
                'sub_desc' => __('No validation can be done on this field type', ALLT_TEXT_DOMAIN),
                'desc' => __('This is the description field, again good for additional info.', ALLT_TEXT_DOMAIN)
            ),
            array(
                'id' => 'pages_select_demo',
                'type' => 'pages_select',
                'title' => __('Pages Select Option', ALLT_TEXT_DOMAIN), 
                'sub_desc' => __('No validation can be done on this field type', ALLT_TEXT_DOMAIN),
                'desc' => __('This field creates a drop down menu of all the sites pages.', ALLT_TEXT_DOMAIN),
                'args' => array() // Uses get_pages()
            ),
            array(
                'id' => 'pages_multi_select_demo',
                'type' => 'pages_multi_select',
                'title' => __('Pages Multiple Select Option', ALLT_TEXT_DOMAIN), 
                'sub_desc' => __('No validation can be done on this field type', ALLT_TEXT_DOMAIN),
                'desc' => __('This field creates a multi select menu of all the sites pages.', ALLT_TEXT_DOMAIN),
                'args' => array('number' => '5') // Uses get_pages()
            ),
            array(
                'id' => 'posts_select_demo',
                'type' => 'posts_select',
                'title' => __('Posts Select Option', ALLT_TEXT_DOMAIN), 
                'sub_desc' => __('No validation can be done on this field type', ALLT_TEXT_DOMAIN),
                'desc' => __('This field creates a drop down menu of all the sites posts.', ALLT_TEXT_DOMAIN),
                'args' => array('numberposts' => '10') // Uses get_posts()
            ),
            array(
                'id' => 'posts_multi_select_demo',
                'type' => 'posts_multi_select',
                'title' => __('Posts Multiple Select Option', ALLT_TEXT_DOMAIN), 
                'sub_desc' => __('No validation can be done on this field type', ALLT_TEXT_DOMAIN),
                'desc' => __('This field creates a multi select menu of all the sites posts.', ALLT_TEXT_DOMAIN),
                'args' => array('numberposts' => '10') // Uses get_posts()
            ),
            array(
                'id' => 'tags_select_demo',
                'type' => 'tags_select',
                'title' => __('Tags Select Option', ALLT_TEXT_DOMAIN), 
                'sub_desc' => __('No validation can be done on this field type', ALLT_TEXT_DOMAIN),
                'desc' => __('This field creates a drop down menu of all the sites tags.', ALLT_TEXT_DOMAIN),
                'args' => array('number' => '10') // Uses get_tags()
            ),
            array(
                'id' => 'tags_multi_select_demo',
                'type' => 'tags_multi_select',
                'title' => __('Tags Multiple Select Option', ALLT_TEXT_DOMAIN), 
                'sub_desc' => __('No validation can be done on this field type', ALLT_TEXT_DOMAIN),
                'desc' => __('This field creates a multi select menu of all the sites tags.', ALLT_TEXT_DOMAIN),
                'args' => array('number' => '10') // Uses get_tags()
            ),
            array(
                'id' => 'cats_select_demo',
                'type' => 'cats_select',
                'title' => __('Cats Select Option', ALLT_TEXT_DOMAIN), 
                'sub_desc' => __('No validation can be done on this field type', ALLT_TEXT_DOMAIN),
                'desc' => __('This field creates a drop down menu of all the sites cats.', ALLT_TEXT_DOMAIN),
                'args' => array('number' => '10') // Uses get_categories()
            ),
            array(
                'id' => 'cats_multi_select_demo',
                'type' => 'cats_multi_select',
                'title' => __('Cats Multiple Select Option', ALLT_TEXT_DOMAIN), 
                'sub_desc' => __('No validation can be done on this field type', ALLT_TEXT_DOMAIN),
                'desc' => __('This field creates a multi select menu of all the sites cats.', ALLT_TEXT_DOMAIN),
                'args' => array('number' => '10') // Uses get_categories()
            ),
            array(
                'id' => 'menu_select_demo',
                'type' => 'menu_select',
                'title' => __('Menu Select Option', ALLT_TEXT_DOMAIN),
                'sub_desc' => __('No validation can be done on this field type', ALLT_TEXT_DOMAIN),
                'desc' => __('This field creates a drop down menu of all the sites menus.', ALLT_TEXT_DOMAIN),
                //'args' => array() // Uses wp_get_nav_menus()
            ),
            array(
                'id' => 'menu_location_select_demo',
                'type' => 'menu_location_select',
                'title' => __('Menu Location Select Option', ALLT_TEXT_DOMAIN), 
                'sub_desc' => __('No validation can be done on this field type', ALLT_TEXT_DOMAIN),
                'desc' => __('This field creates a drop down menu of all the themes menu locations.', ALLT_TEXT_DOMAIN)
            ),
            array(
                'id' => 'post_type_select_demo',
                'type' => 'post_type_select',
                'title' => __('Post Type Select Option', ALLT_TEXT_DOMAIN), 
                'sub_desc' => __('No validation can be done on this field type', ALLT_TEXT_DOMAIN),
                'desc' => __('This field creates a drop down menu of all registered post types.', ALLT_TEXT_DOMAIN),
                //'args' => array() // Uses get_post_types()
            ),
            array(
                'id' => 'select_hide_below_demo',
                'type' => 'select_hide_below',
                'title' => __('Select Hide Below Option', ALLT_TEXT_DOMAIN), 
                'sub_desc' => __('No validation can be done on this field type', ALLT_TEXT_DOMAIN),
                'desc' => __('This field requires certain options to be checked before the below field will be shown.', ALLT_TEXT_DOMAIN),
                'options' => array(
                    '1' => array('name' => 'Opt 1 field below allowed', 'allow' => 'true'),
                    '2' => array('name' => 'Opt 2 field below hidden', 'allow' => 'false'),
                    '3' => array('name' => 'Opt 3 field below allowed', 'allow' => 'true')
                ), // Must provide key => value(array) pairs for select options
                'std' => '2'
            ),
            array(
                'id' => 'checkbox_hide_below_demo',
                'type' => 'checkbox_hide_below',
                'title' => __('Checkbox to hide below', ALLT_TEXT_DOMAIN), 
                'sub_desc' => __('No validation can be done on this field type', ALLT_TEXT_DOMAIN),
                'desc' => __('This field creates a checkbox which will allow the user to use the next setting.', ALLT_TEXT_DOMAIN),
            ),
            array(
                'id' => 'custom_callback_demo',
                //'type' => 'nothing', // Doesn't need to be called for callback fields
                'title' => __('Custom Field Callback', ALLT_TEXT_DOMAIN), 
                'sub_desc' => __('This is a completely unique field type', ALLT_TEXT_DOMAIN),
                'desc' => __('This is created with a callback function, so anything goes in this field. Make sure to define the function though.', ALLT_TEXT_DOMAIN),
                'callback' => 'my_custom_field'
            ),
            array(
                'id' => 'google_webfonts_demo',
                'type' => 'google_webfonts',
                'title' => __('Google Webfonts', ALLT_TEXT_DOMAIN), 
                'sub_desc' => __('This is a completely unique field type', ALLT_TEXT_DOMAIN),
                'desc' => __('This is a simple implementation of the developer API for Google Webfonts. Don\'t forget to set your API key!', ALLT_TEXT_DOMAIN)
            )                            
        )
    );

    $sections[] = array(
		'icon' => 'eye-open',
		'icon_class' => 'icon-large',
        'title' => __('Non Value Fields', ALLT_TEXT_DOMAIN),
        'desc' => __('<p class="description">This is the Description. Again HTML is allowed</p>', ALLT_TEXT_DOMAIN),
        'fields' => array(
            array(
                'id' => 'text_spacer1',
                'type' => 'text',
                'title' => __('Text Field', ALLT_TEXT_DOMAIN), 
                'sub_desc' => __('Additional Info', ALLT_TEXT_DOMAIN),
                'desc' => __('This is the description field, again good for additional info.', ALLT_TEXT_DOMAIN)
            ),
            array(
                'id' => 'divide_demo',
                'type' => 'divide'
            ),
            array(
                'id' => 'text_spacer2',
                'type' => 'text',
                'title' => __('Text Field', ALLT_TEXT_DOMAIN), 
                'sub_desc' => __('Additional Info', ALLT_TEXT_DOMAIN),
                'desc' => __('This is the description field, again good for additional info.', ALLT_TEXT_DOMAIN)
            ),
            array(
                'id' => 'info_demo',
                'type' => 'info',
                'desc' => __('<p class="description">This is the info field, if you want to break sections up.</p>', ALLT_TEXT_DOMAIN)
            ),
            array(
                'id' => 'text_spacer3',
                'type' => 'text',
                'title' => __('Text Field', ALLT_TEXT_DOMAIN), 
                'sub_desc' => __('Additional Info', ALLT_TEXT_DOMAIN),
                'desc' => __('This is the description field, again good for additional info.', ALLT_TEXT_DOMAIN)
			),
			array(
				'id' => 'raw_html_demo',
				'type' => 'raw_html',
				'html' => '<h4>This is the raw HTML field. It accepts all HTML.</h4><p style="text-align: center;">Some centered text...</p><p style="text-align: right;">...and some right aligned text...</p><p>..and a linked image!</p><a href="http://www.wordpress.org" target="_blank"><img src="http://s.wordpress.org/about/images/logos/wordpress-logo-stacked-rgb.png" style="width: 100px;" /></a>'
			)
        )
    );
                
    $tabs = array();

    if (function_exists('wp_get_theme')){
        $theme_data = wp_get_theme();
        $item_uri = $theme_data->get('ThemeURI');
        $description = $theme_data->get('Description');
        $author = $theme_data->get('Author');
        $author_uri = $theme_data->get('AuthorURI');
        $version = $theme_data->get('Version');
        $tags = $theme_data->get('Tags');
    }else{
        $theme_data = get_theme_data(trailingslashit(get_stylesheet_directory()) . 'style.css');
        $item_uri = $theme_data['URI'];
        $description = $theme_data['Description'];
        $author = $theme_data['Author'];
        $author_uri = $theme_data['AuthorURI'];
        $version = $theme_data['Version'];
        $tags = $theme_data['Tags'];
     }
    
    $item_info = '<div class="redux-opts-section-desc">';
    $item_info .= '<p class="redux-opts-item-data description item-uri">' . __('<strong>Theme URL:</strong> ', ALLT_TEXT_DOMAIN) . '<a href="' . $item_uri . '" target="_blank">' . $item_uri . '</a></p>';
    $item_info .= '<p class="redux-opts-item-data description item-author">' . __('<strong>Author:</strong> ', ALLT_TEXT_DOMAIN) . ($author_uri ? '<a href="' . $author_uri . '" target="_blank">' . $author . '</a>' : $author) . '</p>';
    $item_info .= '<p class="redux-opts-item-data description item-version">' . __('<strong>Version:</strong> ', ALLT_TEXT_DOMAIN) . $version . '</p>';
    $item_info .= '<p class="redux-opts-item-data description item-description">' . $description . '</p>';
    $item_info .= '<p class="redux-opts-item-data description item-tags">' . __('<strong>Tags:</strong> ', ALLT_TEXT_DOMAIN) . implode(', ', $tags) . '</p>';
    $item_info .= '</div>';

    $tabs['item_info'] = array(
		'icon' => 'info-sign',
		'icon_class' => 'icon-large',
        'title' => __('Theme Information', ALLT_TEXT_DOMAIN),
        'content' => $item_info
    );
    
    if(file_exists(trailingslashit(dirname(__FILE__)) . 'README.html')) {
        $tabs['docs'] = array(
			'icon' => 'book',
			'icon_class' => 'icon-large',
            'title' => __('Documentation', ALLT_TEXT_DOMAIN),
            'content' => nl2br(file_get_contents(trailingslashit(dirname(__FILE__)) . 'README.html'))
        );
    }

    global $Redux_Options;
    $Redux_Options = new Redux_Options($sections, $args, $tabs);

}
add_action('init', 'setup_framework_options', 0);

/*
 * 
 * Custom function for the callback referenced above
 *
 */
function my_custom_field($field, $value) {
    print_r($field);
    print_r($value);
}

/*
 * 
 * Custom function for the callback validation referenced above
 *
 */
function validate_callback_function($field, $value, $existing_value) {
    $error = false;
    $value =  'just testing';
    /*
    do your validation
    
    if(something) {
        $value = $value;
    } elseif(somthing else) {
        $error = true;
        $value = $existing_value;
        $field['msg'] = 'your custom error message';
    }
    */
    
    $return['value'] = $value;
    if($error == true) {
        $return['error'] = $field;
    }
    return $return;
}
