<?php
/**
 * 固定ページ用テンプレート(フロントページ以外)
 */
get_header();
?>

<main style="padding: 80px 60px; max-width: 800px; margin: 0 auto;">
  <?php if ( function_exists( 'yoast_breadcrumb' ) ) : ?>
    <?php yoast_breadcrumb( '<p class="breadcrumbs">', '</p>' ); ?>
  <?php endif; ?>

  <?php while ( have_posts() ) : the_post(); ?>
    <article <?php post_class(); ?>>
      <h1><?php the_title(); ?></h1>
      <div><?php the_content(); ?></div>
    </article>
  <?php endwhile; ?>
</main>

<?php get_footer(); ?>
