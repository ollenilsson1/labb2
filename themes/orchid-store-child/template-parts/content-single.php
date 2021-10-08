<?php
/**
 * Används i single-butiker.php tagit bort edit funktionen och sidebar och meta diven
 * Template part for displaying post content in single.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Orchid_Store
 */
$orchid_store_show_tags 		= orchid_store_get_option( 'display_post_tags' );
$orchid_store_show_categories	= orchid_store_get_option( 'display_post_cats' );
$orchid_store_show_author		= orchid_store_get_option( 'display_post_author' );
$orchid_store_show_date			= orchid_store_get_option( 'display_post_date' );
$orchid_store_show_featured_img	= orchid_store_get_option( 'display_page_featured_image' );
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php 
	if( orchid_store_get_option( 'display_page_header' ) == false ) {
		?>
		<h1 class="entry-title page-title"><?php the_title(); ?></h1>
		<?php
	} 

	if( $orchid_store_show_featured_img == true && has_post_thumbnail() && ! post_password_required() ) {
		?>
		<div class="thumb featured-thumb">
	       	<?php
	       	the_post_thumbnail( 'full', array(
				'alt' => the_title_attribute( array(
					'echo' => false,
				) ),
			) );
	       	?>
	    </div><!-- .thumb.featured-thumb -->
	    <?php
	}

	?>

	
	<div class="<?php orchid_store_content_entry_class(); ?>">
		<?php
		the_content();

		wp_link_pages( array(
			'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'orchid-store' ),
			'after'  => '</div>',
		) );
		?>
	</div><!-- .editor-entry -->
	<?php
	if( $orchid_store_show_tags == true ) {
		/**
	    * Hook - orchid_store_post_tags.
	    *
	    * @hooked orchid_store_post_tags_action - 10
	    */
	    do_action( 'orchid_store_post_tags' );
	}

    
	?>
</article><!-- #post-<?php the_ID(); ?> -->