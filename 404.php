<?php get_template_part('templates/page', 'header'); ?>

<div class="alert">
  <?php _e('Sorry, but the page you were trying to view does not exist.', ALLT_TEXT_DOMAIN); ?>
</div>

<p><?php _e('It looks like this was the result of either:', ALLT_TEXT_DOMAIN); ?></p>
<ul>
  <li><?php _e('a mistyped address', ALLT_TEXT_DOMAIN); ?></li>
  <li><?php _e('an out-of-date link', ALLT_TEXT_DOMAIN); ?></li>
</ul>

<?php get_search_form(); ?>
