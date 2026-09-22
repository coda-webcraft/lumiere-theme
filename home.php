<?php
/**
 * ブログ記事一覧テンプレート
 */
get_header();
?>

<div class="page-layout">
<main class="page-main">

  <?php if ( function_exists( 'yoast_breadcrumb' ) ) : ?>
    <?php yoast_breadcrumb( '<p class="breadcrumbs">', '</p>' ); ?>
  <?php endif; ?>

  <section class="blog-archive">
    <h1 class="blog-archive-title">Blog</h1>

    <?php if ( have_posts() ) : ?>
      <div class="blog-list">
        <?php while ( have_posts() ) : the_post(); ?>
          <article class="blog-card">
            <a href="<?php the_permalink(); ?>" class="blog-card-link">
              <?php if ( has_post_thumbnail() ) : ?>
                <div class="blog-card-thumb"><?php the_post_thumbnail( 'medium' ); ?></div>
              <?php endif; ?>
              <div class="blog-card-body">
                <span class="blog-card-date"><?php echo esc_html( get_the_date() ); ?></span>
                <?php $cats = get_the_category(); ?>
                <?php if ( ! empty( $cats ) ) : ?>
                  <span class="blog-card-category"><?php echo esc_html( $cats[0]->name ); ?></span>
                <?php endif; ?>
                <h2 class="blog-card-title"><?php the_title(); ?></h2>
                <p class="blog-card-excerpt"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 40 ) ); ?></p>
              </div>
            </a>
          </article>
        <?php endwhile; ?>
      </div>

      <div class="blog-pagination">
        <?php the_posts_pagination( array(
            'prev_text' => '← 前へ',
            'next_text' => '次へ →',
        ) ); ?>
      </div>
    <?php else : ?>
      <p>まだ記事がありません。</p>
    <?php endif; ?>
  </section>

</main>

<?php get_sidebar(); ?>

</div>

<?php get_footer(); ?>
