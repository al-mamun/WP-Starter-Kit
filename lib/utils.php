<?php
/**
 * Theme wrapper
 *
 * @link http://scribu.net/wordpress/theme-wrappers.html
 */
function allt_template_path() {
	return allt_Wrapping::$main_template;
}

function allt_sidebar_path() {
	return allt_Wrapping::sidebar();
}

class allt_Wrapping {
	// Stores the full path to the main template file
	static $main_template;

	// Stores the base name of the template file; e.g. 'page' for 'page.php' etc.
	static $base;

	static function wrap($template) {
		self::$main_template = $template;

		self::$base = substr(basename(self::$main_template), 0, -4);

		if (self::$base === 'index') {
			self::$base = false;
		}

		$templates = array('base.php');

		if (self::$base) {
			array_unshift($templates, sprintf('base-%s.php', self::$base));
		}

		return locate_template($templates);
	}

	static function sidebar() {
		$templates = array('templates/sidebar.php');

		if (self::$base) {
			array_unshift($templates, sprintf('templates/sidebar-%s.php', self::$base));
		}

		return locate_template($templates);
	}
}
add_filter('template_include', array('allt_Wrapping', 'wrap'), 99);

/**
 * Page titles
 */
function allt_title() {
	if (is_home()) {
		if (get_option('page_for_posts', true)) {
			echo get_the_title(get_option('page_for_posts', true));
		} else {
			_e('Latest Posts', ALLT_TEXT_DOMAIN);
		}
	} elseif (is_archive()) {
		$term = get_term_by('slug', get_query_var('term'), get_query_var('taxonomy'));
		if ($term) {
			echo $term->name;
		} elseif (is_post_type_archive()) {
			echo get_queried_object()->labels->name;
		} elseif (is_day()) {
			printf(__('Daily Archives: %s', ALLT_TEXT_DOMAIN), get_the_date());
		} elseif (is_month()) {
			printf(__('Monthly Archives: %s', ALLT_TEXT_DOMAIN), get_the_date('F Y'));
		} elseif (is_year()) {
			printf(__('Yearly Archives: %s', ALLT_TEXT_DOMAIN), get_the_date('Y'));
		} elseif (is_author()) {
			printf(__('Author Archives: %s', ALLT_TEXT_DOMAIN), get_the_author());
		} else {
			single_cat_title();
		}
	} elseif (is_search()) {
		printf(__('Search Results for %s', ALLT_TEXT_DOMAIN), get_search_query());
	} elseif (is_404()) {
		_e('Not Found', ALLT_TEXT_DOMAIN);
	} else {
		the_title();
	}
}

/**
 * Return WordPress subdirectory if applicable
 */
function wp_base_dir() {
	preg_match('!(https?://[^/|"]+)([^"]+)?!', site_url(), $matches);
	if (count($matches) === 3) {
		return end($matches);
	} else {
		return '';
	}
}

/**
 * Opposite of built in WP functions for trailing slashes
 */
function leadingslashit($string) {
	return '/' . unleadingslashit($string);
}

function unleadingslashit($string) {
	return ltrim($string, '/');
}

function add_filters($tags, $function) {
	foreach($tags as $tag) {
		add_filter($tag, $function);
	}
}

function is_element_empty($element) {
	$element = trim($element);
	return empty($element) ? false : true;
}

function allt_print($arr) {
	echo "<pre style='background:#b9e0f5;padding:1em;margin:1em 0;border-radius:4px;overflow-x:scroll;'>";
	print_r($arr);
	echo "</pre>";
}

/**
 * Return option value
 */

function allt_opt_get($opt_name, $default = null){
	global $Redux_Options;
	return $Redux_Options->get($opt_name, $default);
}

function allt_opt_print_all(){
	global $Redux_Options;

	$opts = array();

	foreach ($Redux_Options->sections as $section){
		foreach ($section['fields'] as $field){
			$opts[$field['id']] = $Redux_Options->get($field['id']);
		}
	}

	allt_print($opts);
}

/**
 * Return option type
 */

function allt_opt_type($opt_name){
	global $Redux_Options;
	return $Redux_Options->type($opt_name);
}

/**
 * Return opacity CSS, 0 < $val < 100
 */

function allt_generate_opacity($val){
	$css = '-webkit-opacity:' . $val/100 . '; ';
	$css .= '-moz-opacity:' . $val/100 . '; ';
	$css .= 'opacity:' . $val/100 . '; ';
	$css .= 'filter:alpha(opacity=' . $val . '); ';
	$css .= '-ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=' . $val . ')"';
	return $css;
}

/**
 * Return button HTML
 */

function allt_generate_button($link = '#', $title = 'How are you?', $text = 'Hi!', $icon = null, $extra_class = ''){
	$html = '<a href="' . $link . '" title="' . $title . '" class="button ' . $extra_class . '">';
	if (!is_null($icon)) {
		$html .= '<i class="icon icon-' . $icon . '"></i>';
	}
	$html .= $text;
	$html .= '</a>';
	return $html;
}

/**
 * Echo CSS from an option
 */

function allt_generate_css($opt_name, $selector = array('a'), $property = 'background-color', $child = ''){
	if (!is_array($selector)) $selector = array($selector);
	if (!is_array($property)) $property = array($property);

	// Background bundles, WITHOUT selector
	if (allt_opt_type($opt_name) == 'bg_bundle') {
		$css = 'background: ';
		$values = allt_opt_get($opt_name);

		if (isset($values['img']) && $values['img'] != '') {
			$img = 'url("' . $values['img'] . '") ';
			$repeat = ($values['repeat'] != 'cover') ? $values['repeat'] . ' ' : '';
			$pos = $values['pos'] . ' ';
			$css .= $img . $repeat . $pos;
		}

		if (isset($values['color']) && $values['color'] != '') {
			$css .= $values['color'];
		}
		$css .= '; ';

		if (isset($values['img']) && $values['img'] != '' && $values['repeat'] == 'cover')  {
			$css .= '-webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;background-size:cover; ';
			$css .= 'filter: "progid:DXImageTransform.Microsoft.AlphaImageLoader(src=\'' . $values['img'] . '\', sizingMethod=\'scale\')"; ';
			$css .=	'-ms-filter: "progid:DXImageTransform.Microsoft.AlphaImageLoader(src=\'' . $values['img'] . '\', sizingMethod=\'scale\')"; ';
		}

		return $css;
	}

	// Gradient, WITH selectors
	if (allt_opt_type($opt_name) == 'color_gradient') {
		$values = allt_opt_get($opt_name);
		$direction = ($values['dir'] == 'vertical') ? 'top' : 'left';
		$direction_webkit = ($values['dir'] == 'vertical') ? 'left top, left bottom' : 'left top, right top';
		$from = $values['from'];
		$to = $values['to'];

		$css = "background: $from;";
		$css .= "background: -moz-linear-gradient($direction, $from 0%, $to 100%);";
		$css .= "background: -webkit-gradient(linear, $direction_webkit, color-stop(0%, $from), color-stop(100%, $to));";
		$css .= "background: -webkit-linear-gradient($direction, $from 0%, $to 100%);";
		$css .= "background: -o-linear-gradient($direction, $from 0%, $to 100%);";
		$css .= "background: -ms-linear-gradient($direction, $from 0%, $to 100%);";
		$css .= "background: linear-gradient($direction, $from 0%, $to 100%);";
		$css .= "filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='$from', endColorstr='$to',GradientType=0);";

		return $css;
	}

	// Gradient States, WITH selectors
	if (allt_opt_type($opt_name) == 'color_gradient_states') {
		$values = allt_opt_get($opt_name);
		$direction = 'top';
		$direction_webkit ='left top, left bottom';
		$normalfrom = (isset($values['normalfrom']) && $values['normalfrom'] != '') ? $values['normalfrom'] : 'transparent';
		$normalto = (isset($values['normalto']) && $values['normalto'] != '') ? $values['normalto'] : 'transparent';
		$hoverfrom = (isset($values['hoverfrom']) && $values['hoverfrom'] != '') ? $values['hoverfrom'] : 'transparent';
		$hoverto = (isset($values['hoverto']) && $values['hoverto'] != '') ? $values['hoverto'] : 'transparent';
		$activefrom = (isset($values['activefrom']) && $values['activefrom'] != '') ? $values['activefrom'] : 'transparent';
		$activeto = (isset($values['activeto']) && $values['activeto'] != '') ? $values['activeto'] : 'transparent';


		if (isset($values['unactivefrom']) && isset($values['unactiveto'])) {
			$unactivefrom = (isset($values['unactivefrom']) && $values['unactivefrom'] != '') ? $values['unactivefrom'] : 'transparent';
			$unactiveto = (isset($values['unactiveto']) && $values['unactiveto'] != '') ? $values['unactiveto'] : 'transparent';
		}

		$css = join(', ', $selector) . ' { ';
		$css .= "background: $normalfrom;";
		$css .= "background: -moz-linear-gradient($direction, $normalfrom 0%, $normalto 100%);";
		$css .= "background: -webkit-gradient(linear, $direction_webkit, color-stop(0%, $normalfrom), color-stop(100%, $normalto));";
		$css .= "background: -webkit-linear-gradient($direction, $normalfrom 0%, $normalto 100%);";
		$css .= "background: -o-linear-gradient($direction, $normalfrom 0%, $normalto 100%);";
		$css .= "background: -ms-linear-gradient($direction, $normalfrom 0%, $normalto 100%);";
		$css .= "background: linear-gradient($direction, $normalfrom 0%, $normalto 100%);";
		$css .= "filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='$normalfrom', endColorstr='$normalto',GradientType=0);";
		$css .= ' } ';

		$css .= join(', ', array_map(function($val) { return $val . ':hover, ' . $val . '.hover'; } , $selector)) . ' { ';
		$css .= "background: $hoverfrom;";
		$css .= "background: -moz-linear-gradient($direction, $hoverfrom 0%, $hoverto 100%);";
		$css .= "background: -webkit-gradient(linear, $direction_webkit, color-stop(0%, $hoverfrom), color-stop(100%, $hoverto));";
		$css .= "background: -webkit-linear-gradient($direction, $hoverfrom 0%, $hoverto 100%);";
		$css .= "background: -o-linear-gradient($direction, $hoverfrom 0%, $hoverto 100%);";
		$css .= "background: -ms-linear-gradient($direction, $hoverfrom 0%, $hoverto 100%);";
		$css .= "background: linear-gradient($direction, $hoverfrom 0%, $hoverto 100%);";
		$css .= "filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='$hoverfrom', endColorstr='$hoverto',GradientType=0);";
		$css .= ' } ';

		$css .= join(', ', array_map(function($val) { return $val . ':active, ' . $val . '.active'; } , $selector)) . ' { ';
		$css .= "background: $activefrom;";
		$css .= "background: -moz-linear-gradient($direction, $activefrom 0%, $activeto 100%);";
		$css .= "background: -webkit-gradient(linear, $direction_webkit, color-stop(0%, $activefrom), color-stop(100%, $activeto));";
		$css .= "background: -webkit-linear-gradient($direction, $activefrom 0%, $activeto 100%);";
		$css .= "background: -o-linear-gradient($direction, $activefrom 0%, $activeto 100%);";
		$css .= "background: -ms-linear-gradient($direction, $activefrom 0%, $activeto 100%);";
		$css .= "background: linear-gradient($direction, $activefrom 0%, $activeto 100%);";
		$css .= "filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='$activefrom', endColorstr='$activeto',GradientType=0);";
		$css .= ' } ';

		if (isset($values['unactivefrom']) && isset($values['unactiveto'])) {
			$css .= join(', ', array_map(function($val) { return $val . ':disabled, ' . $val . '.unactive'; } , $selector)) . ' { ';
			$css .= "background: $unactivefrom;";
			$css .= "background: -moz-linear-gradient($direction, $unactivefrom 0%, $unactiveto 100%);";
			$css .= "background: -webkit-gradient(linear, $direction_webkit, color-stop(0%, $unactivefrom), color-stop(100%, $unactiveto));";
			$css .= "background: -webkit-linear-gradient($direction, $unactivefrom 0%, $unactiveto 100%);";
			$css .= "background: -o-linear-gradient($direction, $unactivefrom 0%, $unactiveto 100%);";
			$css .= "background: -ms-linear-gradient($direction, $unactivefrom 0%, $unactiveto 100%);";
			$css .= "background: linear-gradient($direction, $unactivefrom 0%, $unactiveto 100%);";
			$css .= "filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='$unactivefrom', endColorstr='$unactiveto',GradientType=0);";
			$css .= ' } ';
		}

		return $css;
	}

	// Color states, WITH selectors
	if (allt_opt_type($opt_name) == 'color_states') {
		$values = allt_opt_get($opt_name);

		// Normal
		$normal = (isset($values['normal']) && $values['normal'] != '') ? $values['normal'] : 'transparent';
		$css = (isset($child)) ? join(', ', array_map(function($val, $c) { return $val . ' ' . $c; } , $selector, array($child))) . ' { ' : join(', ', $selector) . ' { ';
		foreach ($property as $prop) {
			$css .= $prop . ': ' . $normal . '; ';
		}
		$css .= '} ';

		// Hover
		$hover = (isset($values['hover']) && $values['hover'] != '') ? $values['hover'] : 'transparent';
		$css .= (isset($child)) ? join(', ', array_map(function($val, $c) { return $val . ':hover ' . $c . ', ' . $val . '.hover ' . $c; } , $selector, array($child))) . ' { ' : join(', ', array_map(function($val) { return $val . ':hover'; } , $selector)) . ' { ';
		foreach ($property as $prop) {
			$css .= $prop . ': ' . $hover . '; ';
		}
		$css .= '} ';

		// Active
		$active = (isset($values['active']) && $values['active'] != '') ? $values['active'] : 'transparent';
		$css .= (isset($child)) ? join(', ', array_map(function($val, $c) { return $val . ':active ' . $c . ', ' . $val . '.active ' . $c; } , $selector, array($child))) . ' { ' : join(', ', array_map(function($val) { return $val . ':active, ' . $val . '.active'; } , $selector)) . ' { ';
		foreach ($property as $prop) {
			$css .= $prop . ': ' . $active . '; ';
		}
		$css .= '} ';

		if (isset($values['unactive'])) {
			// Unactive
			$unactive = (isset($values['unactive']) && $values['unactive'] != '') ? $values['unactive'] : 'transparent';
			$css .= (isset($child)) ? join(', ', array_map(function($val, $c) { return $val . ':disabled ' . $c . ', ' . $val . '.unactive ' . $c; } , $selector, array($child))) . ' { ' : join(', ', array_map(function($val) { return $val . ':disabled, ' . $val . '.unactive'; } , $selector)) . ' { ';
			foreach ($property as $prop) {
				$css .= $prop . ': ' . $unactive . '; ';
			}
			$css .= '} ';
		}

		return $css;
	}

	// Gfonts field
	if (allt_opt_type($opt_name) == 'gfonts') {
		$values = allt_opt_get($opt_name);

		if (strstr($values, '+') == true){
			return '"' . str_replace('+', ' ', $values) . '"';
		} else {
			return $values;
		}
	}
}

/**
 * Transform a time in "time ago"
 * http://webcodingeasy.com/PHP/Convert-twitter-createdat-time-format-to-ago-format
 */

function allt_time_ago($time) {
	$b = strtotime("now");
	$c = strtotime($time);
	$d = $b - $c;
	$minute = 60;
	$hour = $minute * 60;
	$day = $hour * 24;
	$week = $day * 7;

	if (is_numeric($d) && $d > 0) {
		if ($d < 3) return __('right now', ALLT_TXT_DOMAIN);
		if ($d < $minute) return floor($d) . __(' seconds ago', ALLT_TXT_DOMAIN);
		if ($d < $minute * 2) return __('about 1 minute ago', ALLT_TXT_DOMAIN);
		if ($d < $hour) return floor($d / $minute) . __(' minutes ago', ALLT_TXT_DOMAIN);
		if ($d < $hour * 2) return __('about 1 hour ago', ALLT_TXT_DOMAIN);
		if ($d < $day) return floor($d / $hour) . __(' hours ago', ALLT_TXT_DOMAIN);
		if ($d > $day && $d < $day * 2) return __('yesterday', ALLT_TXT_DOMAIN);
		if ($d < $day * 365) return floor($d / $day) . __(' days ago', ALLT_TXT_DOMAIN);
		return __('over a year ago', ALLT_TXT_DOMAIN);
	} else return $time;
}

/**
 * Generates sharing buttons (addthis.com)
 */

function allt_share_buttons(){

	echo '<nav id="share-buttons" class="clearfix">';
	do_action('allt_share_buttons_before'); ?>

<div class="addthis_toolbox addthis_default_style ">
	<a class="addthis_button_facebook_like" fb:like:layout="button_count"></a>
	<a class="addthis_button_tweet"></a>
	<a class="addthis_button_pinterest_pinit"></a>
	<a class="addthis_counter addthis_pill_style"></a>
</div>
<script type="text/javascript">var addthis_config = {"data_track_addressbar":true};</script><script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js"></script>

<?php do_action('allt_share_buttons_after');
	echo '</nav>';
}