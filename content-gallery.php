<?php
/**
 * The template for displaying posts in the Gallery post format.
 *
 * @package WordPress
 * @subpackage Twenty_Thirteen
 * @since Riverside.io 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php if ( is_single() ) : ?>
		<h1 class="entry-title"><?php the_title(); ?></h1>
		<?php else : ?>
		<h1 class="entry-title">
			<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'riversideio' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_title(); ?></a>
		</h1>
		<?php endif; // is_single() ?>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php if ( is_single() ) : ?>
			<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'riversideio' ) ); ?>
			<?php wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'riversideio' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) ); ?>
		<?php else : ?>
			<?php riversideio_featured_gallery(); ?>
		<?php endif; // is_single() ?>
	</div><!-- .entry-content -->

	<footer class="entry-meta">
		<?php riversideio_entry_meta(); ?>

		<?php if ( comments_open() && ! is_single() ) : ?>
		<span class="comments-link">
			<?php comments_popup_link( '<span class="leave-reply">' . __( 'Leave a comment', 'riversideio' ) . '</span>', __( 'One comment so far', 'riversideio' ), __( 'View all % comments', 'riversideio' ) ); ?>
		</span><!-- .comments-link -->
		<?php endif; // comments_open() ?>
		<?php edit_post_link( __( 'Edit', 'riversideio' ), '<span class="edit-link">', '</span>' ); ?>

		<?php if ( is_single() && get_the_author_meta( 'description' ) && is_multi_author() ) : ?>
			<?php get_template_part( 'author-bio' ); ?>
		<?php endif; ?>
	</footer><!-- .entry-meta -->
</article><!-- #post -->
