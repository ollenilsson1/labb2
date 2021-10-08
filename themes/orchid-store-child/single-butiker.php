<?php
/**
 * Template override för att ta bort alla sidebars och divar på våra butiker sidan
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Orchid_Store
 */

get_header();
?>
<div class="inner-page-wrap default-page-wrap default-page-s1">
    <?php
    /**
	* Hook - orchid_store_title_breadcrumb.
	*
	* @hooked orchid_store_title_breadcrumb_action - 10
	*/
	do_action( 'orchid_store_title_breadcrumb' );
	?>
    <div class="__os-container__">
        <div class="os-row">
            <div class="<?php orchid_store_content_container_class(); ?>">
                <div id="primary" class="content-area">
                    <main id="main" class="site-main">
                    	<?php
                    	while( have_posts() ) :

                    		the_post();

                    		get_template_part( 'template-parts/content', 'single' );

                    		/**
	                        * Hook - orchid_store_post_navigation.
	                        *
	                        * @hooked orchid_store_post_navigation_action - 10
	                        */
	                        do_action( 'orchid_store_post_navigation' );

                    	endwhile;
                    	?>
                    </main>
                </div>
            </div>
           
        </div>
    </div>
</div>
<?php
get_footer();