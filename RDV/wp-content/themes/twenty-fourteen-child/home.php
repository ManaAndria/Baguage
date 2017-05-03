<?php
/* Template Name: Home */

get_header(); ?>

<div id="main-content" class="main-content">

<?php
	if ( is_front_page() && twentyfourteen_has_featured_posts() ) {
		// Include the featured content template.
		get_template_part( 'featured-content' );
	}
?>
	<div id="primary" class="content-area">
		<div id="content" class="site-content" role="main">

			<?php
				$args = array(
					'echo'           => true,
					'remember'       => true,
					'redirect'       => ( is_ssl() ? 'https://' : 'http://' ) . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'],
					'form_id'        => 'loginform',
					'id_username'    => 'user_login',
					'id_password'    => 'user_pass',
					'id_remember'    => 'rememberme',
					'id_submit'      => 'wp-submit',
					'label_username' => __( 'Username' ),
					'label_password' => __( 'Password' ),
					'label_remember' => __( 'Remember Me' ),
					'label_log_in'   => __( 'Log In' ),
					'value_username' => '',
					'value_remember' => false
				);
				echo '<div style="margin:0 auto;width:320px;">';
				wp_login_form($args);
				
				echo '</div>';
			?>

		</div><!-- #content -->
	</div><!-- #primary -->
	<?php /*get_sidebar( 'content' );*/ ?>
</div><!-- #main-content -->

<?php
// get_sidebar();
get_footer();