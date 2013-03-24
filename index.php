<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme and one of the
 * two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * For example, it puts together the home page when no home.php file exists.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Thirteen
 * @since Riverside.io 1.0
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<div id="content" class="site-content" role="main">
			
			<div class="container-fluid">

			<div class="row-fluid" style="background:#222;padding:20px 0;">
				
				<div class="span5 offset1">
					<div class="video-container" style="max-width:640px;">
						<iframe width="100%" height="400" src="http://www.youtube.com/embed/le0dfcG_jVw?feature=player_embedded&amp;theme=light&amp;rel=0&amp;wmode=transparent" frameborder="0" allowfullscreen></iframe>
					</div>
				</div>

				<div class="span5">
					
				</div>

			</div>

			<div class="row-fluid">
				<div class="span10 offset1">
					<div class="row-fluid">
						<div class="span12">
							<h2 class="center">Who We Are</h2>
						</div>
					</div>

						<?php
						$count = 0;
						$blogusers = get_users('orderby=nicename&exclude=1');
						$blogusers_count = count($blogusers);
						foreach ($blogusers as $user) {

							if ($count % 4 == 0) echo '<div class="row-fluid">';
						?>
						<div class="span3">
							<div class="center">
								<a class="shadow">
									<?php echo get_wp_user_avatar( $user->user_email, apply_filters( 'riversideio_author_bio_avatar_size', 120 ) ); ?>
								</a>
							</div>
							<h4><?php _e($user->display_name); ?></h4>
							<p><?php _e($user->user_description); ?></p>
						</div>
						<?php
							if (($count % 4) == 3 || $count == $blogusers_count) echo '</div>';
							$count++;
							}
						?>
				</div>
				</div>		
			</div>

			<div class="row-fluid videos">
				<div class="span10 offset1">
					<div class="row-fluid">
						<div class="span12">
							<h2 class="center">Things We Like</h2>
						</div>
					</div>
					<div class="row-fluid">
						<div class="span6">
							<div class="video-container" style="max-width:640px;">
								<iframe src="http://player.vimeo.com/video/32424882?title=0&amp;byline=0&amp;portrait=0" webkitallowfullscreen="" mozallowfullscreen="" allowfullscreen="" frameborder="0" height="300" width="100%"></iframe>
							</div>
							<h4><a href="http://startupweekend.org">Startup Weekend</a></h4>
							<p>We've competed in <a href="http://startupweekend.org">Startup Weekends</a> in Southern California. They are excellent events.</p>
						</div>

						<div class="span6">
							<div class="video-container" style="max-width:640px;">
								<iframe src="http://player.vimeo.com/video/38101676?color=00c4ff" webkitallowfullscreen="" mozallowfullscreen="" allowfullscreen="" frameborder="0" height="300" width="100%"></iframe>
							</div>
							<h4>The Most Astounding Fact</h4>
							<p>Astrophysicist <a href="http://en.wikipedia.org/wiki/Neil_deGrasse_Tyson">Dr. Neil DeGrasse Tyson</a> speaks to Connectivity as the most astounding fact.</p>
						</div>
					</div>
					<div class="row-fluid">
						<div class="span6 offset3">
							<div class="video-container" style="max-width:640px;">
								<iframe src="http://player.vimeo.com/video/21837974?badge=0&amp;color=ffffff" webkitallowfullscreen="" mozallowfullscreen="" allowfullscreen="" frameborder="0" height="300" width="100%"></iframe>
							</div>
							<h4><a href="http://betahaus.de/">betahaus</a></h4>
							<p><a href="http://betahaus.de/">betahaus</a> is Berlin's coworking space. They have a large space, a coffee shop inside the coworking space, and events every week.</p>
						</div>
					</div>
				</div>
			</div>
			
			</div>

		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>