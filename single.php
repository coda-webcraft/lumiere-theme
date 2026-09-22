<?php
/**
 * ブログ記事 詳細ページテンプレート
 */
get_header();
?>

<div class="page-layout">
<main class="page-main">

  <?php if ( function_exists( 'yoast_breadcrumb' ) ) : ?>
    <?php yoast_breadcrumb( '<p class="breadcrumbs">', '</p>' ); ?>
  <?php endif; ?>

  <?php while ( have_posts() ) : the_post(); ?>
    <article class="blog-single">
      <p class="blog-single-date"><?php echo esc_html( get_the_date() ); ?></p>
      <?php $cats = get_the_category(); ?>
      <?php if ( ! empty( $cats ) ) : ?>
        <p class="blog-single-categories">
          <?php foreach ( $cats as $cat ) : ?>
            <a href="<?php echo esc_url( get_category_link( $cat ) ); ?>" class="blog-card-category"><?php echo esc_html( $cat->name ); ?></a>
          <?php endforeach; ?>
        </p>
      <?php endif; ?>
      <h1 class="blog-single-title"><?php the_title(); ?></h1>

      <?php if ( has_post_thumbnail() ) : ?>
        <div class="blog-single-thumb"><?php the_post_thumbnail( 'large' ); ?></div>
      <?php endif; ?>

      <div class="blog-single-content">
        <?php the_content(); ?>
      </div>

      <p class="blog-single-back">
        <a href="<?php echo esc_url( get_permalink( get_option( 'page_for_posts' ) ) ); ?>">← ブログ一覧へ戻る</a>
      </p>
    </article>
  <?php endwhile; ?>

</main>

<?php get_sidebar(); ?>

</div>

<?php get_footer(); ?>
