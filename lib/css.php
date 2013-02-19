<?php

/**
 * Inject CSS based on styles defined in options
 * use allt_generate_css($opt_name, $selector = array('a'), $property = 'background-color');
*/
function allt_inject_css(){ ?>

<style type="text/css" media="screen">

</style>

<?php }
add_action('wp_head', 'allt_inject_css', 100);