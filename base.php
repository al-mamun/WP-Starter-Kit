<?php get_template_part('templates/head'); ?>
<body <?php body_class(); ?>>

	<!--[if lt IE 7]><div class="alert"><?php sprintf( __('Your browser is <em>ancient!</em> <a href="%s">Upgrade to a different browser</a> to experience this site.', ALLT_TEXT_DOMAIN), 'http://browsehappy.com/' ); ?></div><![endif]-->

	<?php
		do_action('get_header');
		get_template_part('templates/header');
	?>

	<div class="wrap container" role="document">
		<div class="content row">
			<div class="main <?php echo allt_main_class(); ?>" role="main">
				<?php include allt_template_path(); ?>
			</div><!-- /.main -->
			<?php if (allt_display_sidebar()) : ?>
			<aside class="sidebar <?php echo allt_sidebar_class(); ?>" role="complementary">
				<?php include allt_sidebar_path(); ?>
			</aside><!-- /.sidebar -->
			<?php endif; ?>
		</div><!-- /.content -->
	</div><!-- /.wrap -->

	<?php get_template_part('templates/footer'); ?>

</body>
</html>
