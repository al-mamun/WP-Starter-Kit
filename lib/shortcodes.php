<?php

class allt_shortcodes_bootstrap {

	function __construct() {
		add_action('init', array($this, 'add_shortcodes'));
	}

	function add_shortcodes() {
		add_shortcode('clear', array($this, 'allt_clearfix'));
		add_shortcode('button', array($this, 'allt_button'));
		add_shortcode('buttongroup', array($this, 'allt_buttongroup'));
		add_shortcode('progress', array($this, 'allt_progress'));
		add_shortcode('alert', array($this, 'allt_alert'));
		add_shortcode('code', array($this, 'allt_code'));
		add_shortcode('row', array($this, 'allt_row'));
		add_shortcode('span', array($this, 'allt_span'));
		add_shortcode('label', array($this, 'allt_label'));
		add_shortcode('badge', array($this, 'allt_badge'));
		add_shortcode('icon', array($this, 'allt_icon'));
		add_shortcode('table', array($this, 'allt_table'));
		add_shortcode('collapsibles', array($this, 'allt_collapsibles'));
		add_shortcode('collapse', array($this, 'allt_collapse'));
		add_shortcode('well', array($this, 'allt_well'));
		add_shortcode('tabs', array($this, 'allt_tabs'));
		add_shortcode('tab', array($this, 'allt_tab'));
	}

	function allt_clearfix() {
		return '<div class="clearfix"></div>';
	}

	function allt_button($atts, $content = null) {
		extract(shortcode_atts(array(
			'type' => '',
			'size' => '',
			'link' => '',
			'xclass' => ''
		), $atts));
		return '<a href="' . $link . '" class="button btn-' . $size . ' ' . $xclass . '">' . do_shortcode($content) . '</a>';
	}

	function allt_buttongroup($atts, $content = null) {
		return '<div class="btn-group">' . do_shortcode($content) . '</div>';
	}

	function allt_progress($atts, $content = null) {
		extract(shortcode_atts(array(
			'val'	  => '50',
			'type'    => '',
			'striped' => '',
			'active'  => ''
		), $atts));

		if ($type != '') $type = "progress-$type";
		if ($striped == '1') $striped = "progress-striped";
		if ($active == '1') $active = "active";

		return '<div class="progress ' . $striped . ' ' . $active . ' ' . $type . '"><div class="bar" style="width:' . $val . '%;"></div></div>';
	}

	function allt_alert($atts, $content = null) {
		extract(shortcode_atts(array(
			'type' => '',
			'close' => '0'
		), $atts));
		$alert = '<div class="alert alert-' . $type . '">' . do_shortcode($content);
		if ($close == '1') $alert .= '<button type="button" class="close" data-dismiss="alert">&times;</button>';
		$alert .= '</div>';
		return $alert;
	}

	function allt_code($atts, $content = null) {
		extract(shortcode_atts(array(
			'type' => '',
			'size' => '',
			'link' => ''
		), $atts));
		return '<pre><code>' . do_shortcode($content) . '</code></pre>';
	}

	function allt_row($atts, $content = null) {
		return '<div class="row-fluid">' . do_shortcode($content) . '</div>';
	}

	function allt_span($atts, $content = null) {
		extract(shortcode_atts(array(
			'size' => 'size',
			'offset' => ''
		), $atts));

		$class = ($offset != '') ? $size . ' offset' . $offset : $size;
		return '<div class="span' . $class . '">' . do_shortcode($content) . '</div>';
	}

	function allt_label($atts, $content = null) {
		extract(shortcode_atts(array(
			'type' => 'type'
		), $atts));

		return '<span class="label label-' . $type . '">' . do_shortcode($content) . '</span>';

	}

	function allt_badge($atts, $content = null) {
		extract(shortcode_atts(array(
			'type' => 'type'
		), $atts));

		return '<span class="badge badge-' . $type . '">' . do_shortcode($content) . '</span>';

	}

	function allt_icon($atts, $content = null) {
		extract(shortcode_atts(array(
			'icon' => 'home',
			'size' => '',
			'color' => ''
		), $atts));

		$icon = '<i class="icon icon-' . $icon . ' ' . $size .'"';
		if ($color != '') $icon .= ' style="color:' . $color . '"';
		$icon .= '></i>';
		return $icon;
	}

	function allt_table($atts) {
		extract(shortcode_atts(array(
			'cols' => 'none',
			'data' => 'none',
			'type' => 'type'
		), $atts));
		$cols = explode(',',$cols);
		$data = explode(',',$data);
		$type = explode(' ', $type);
		$total = count($cols);
		$output = '';
		$output .= '<table class="table ' . join(' ', array_map(function($val) { return 'table-' . $val; } , $type)) . '"><tr>';
		foreach($cols as $col):
			$output .= '<th>'.$col.'</th>';
		endforeach;
		$output .= '</tr><tr>';
		$counter = 1;
		foreach($data as $datum):
			$output .= '<td>'.$datum.'</td>';
			if($counter%$total==0):
				$output .= '</tr>';
			endif;
			$counter++;
		endforeach;
		$output .= '</table>';
		return $output;
	}

	function allt_well($atts, $content = null) {
		extract(shortcode_atts(array(
			'size' => 'size'
		), $atts));

		return '<div class="well well-' . $size . '">' . do_shortcode($content) . '</div>';
	}

	function allt_tabs($atts, $content = null) {
		if( isset($GLOBALS['tabs_count']) )
			$GLOBALS['tabs_count']++;
		else
			$GLOBALS['tabs_count'] = 0;
		extract( shortcode_atts( array(
			'type' => 'nav-tabs',
			'direction' => '',
		), $atts ) );
		preg_match_all( '/tab title="([^\"]+)"/i', $content, $matches, PREG_OFFSET_CAPTURE );

		$tab_titles = array();
		if( isset($matches[1]) ){ $tab_titles = $matches[1]; }

		$output = '';

		if( count($tab_titles) ){
			$output .= '<div class="tabbable tabs-' . $direction . '"><ul class="nav '. $type .'" id="custom-tabs-'. rand(1, 100) .'">';

			$i = 0;
			foreach( $tab_titles as $tab ){
				if($i == 0)
					$output .= '<li class="active">';
				else
					$output .= '<li>';

				$output .= '<a href="#custom-tab-' . $GLOBALS['tabs_count'] . '-' . sanitize_title( $tab[0] ) . '"  data-toggle="tab">' . $tab[0] . '</a></li>';
				$i++;
			}

			$output .= '</ul>';
			$output .= '<div class="tab-content">';
			$output .= do_shortcode( $content );
			$output .= '</div></div>';
		} else {
			$output .= do_shortcode( $content );
		}

		return $output;
	}

	function allt_tab($atts, $content = null) {
		if( !isset($GLOBALS['current_tabs']) ) {
			$GLOBALS['current_tabs'] = $GLOBALS['tabs_count'];
			$state = 'active';
		} else {

			if( $GLOBALS['current_tabs'] == $GLOBALS['tabs_count'] ) {
				$state = '';
			} else {
				$GLOBALS['current_tabs'] = $GLOBALS['tabs_count'];
				$state = 'active';
			}
		}

		$defaults = array( 'title' => 'Tab');
		extract( shortcode_atts( $defaults, $atts ) );

		return '<div id="custom-tab-' . $GLOBALS['tabs_count'] . '-'. sanitize_title( $title ) .'" class="tab-pane ' . $state . '">'. do_shortcode( $content ) .'</div>';
	}

	function allt_collapsibles($atts, $content = null) {
		if(isset($GLOBALS['collapsibles_count']))
			$GLOBALS['collapsibles_count']++;
		else
			$GLOBALS['collapsibles_count'] = 0;

		$defaults = array();
		extract(shortcode_atts($defaults, $atts));

		preg_match_all('/collapse title="([^\"]+)"/i', $content, $matches, PREG_OFFSET_CAPTURE);

		$tab_titles = array();
		if(isset($matches[1])){ $tab_titles = $matches[1]; }

		$output = '';

		if(count($tab_titles)){
			$output .= '<div class="accordion" id="accordion-' . $GLOBALS['collapsibles_count'] . '">';
			$output .= do_shortcode($content);
			$output .= '</div>';
		} else {
			$output .= do_shortcode($content);
		}

		return $output;
	}

	function allt_collapse($atts, $content = null) {
		if(!isset($GLOBALS['current_collapse']))
			$GLOBALS['current_collapse'] = 0;
		else
			$GLOBALS['current_collapse']++;


		$defaults = array('title' => 'Tab', 'state' => '');
		extract(shortcode_atts($defaults, $atts));

		if (!empty($state))
			$state = 'in';

		return '
    <div class="accordion-group">
      <div class="accordion-heading">
        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion-' . $GLOBALS['collapsibles_count'] . '" href="#collapse_' . $GLOBALS['current_collapse'] . '_'. sanitize_title($title) .'">' . $title . '</a>
      </div>
      <div id="collapse_' . $GLOBALS['current_collapse'] . '_'. sanitize_title($title) .'" class="accordion-body collapse ' . $state . '"><div class="accordion-inner">' . do_shortcode($content) . ' </div></div></div>
    ';
	}
}

new allt_shortcodes_bootstrap(); ?>