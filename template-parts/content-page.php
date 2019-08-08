<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Yukiascores
 */

?>
    <header class="entry-header">
            <?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
    </header><!-- .entry-header -->
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>


        <div class="entry-content post-content">
            <?php  the_content(); ?>
        </div><!-- .entry-content -->

        <footer class="entry-footer">
            <?php yukiascores_entry_footer(); ?>
        </footer><!-- .entry-footer -->    
<?php get_sidebar('page'); ?>
<?php
// If comments are open or we have at least one comment, load up the comment template.
if ( comments_open() || get_comments_number() ) :
        comments_template();
endif;
?>
</article><!-- #post-<?php the_ID(); ?> --
