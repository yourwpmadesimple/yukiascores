<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Humescores
 */

get_header(); ?>

<?php if ( have_posts() ) : ?>

<div id="primary" class="content-area">
        <main id="main" class="site-main" role="main">

        <?php

                if ( is_home() && ! is_front_page() ) : ?>
                        <header>
                                <h1 class="page-title screen-reader-text"><?php single_post_title(); ?></h1>
                        </header>

                <?php
                endif;

                /* Start the Loop */
                while ( have_posts() ) : the_post();

                        /*
                         * Include the Post-Format-specific template for the content.
                         * If you want to override this in a child theme, then include a file
                         * called content-___.php (where ___ is the Post Format name) and that will be used instead.
                         */
                        get_template_part( 'template-parts/content', get_post_format() );

                endwhile;

                the_posts_pagination( array(
                        'prev_text' => yukiascores_get_svg( array('icon' => 'arrow-long-left')) . __( '  Newer', 'humescores' ),
                        'next_text' => __( 'Older  ', 'humescores' ) . yukiascores_get_svg( array('icon' => 'arrow-long-right')),
                        'before_page_number' => '<span class="screen-reader-text">' . __( 'Page ', 'humescores' ) . '</span>',
                ));

        ?>
        </main><!-- #main -->
        <div class="svg-coffee">
        <a href="http://starbucks.com">
            <?php echo yukiascores_get_svg( array('icon' => 'coffee')); ?>
        </a>
        </div> 
</div><!-- #primary -->
<?php
get_sidebar();
get_footer();


else :

get_template_part( 'template-parts/content', 'none' );
return;

endif;