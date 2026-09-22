<?php
/**
 * デフォルトテンプレート(投稿一覧・その他フォールバック用)
 */
get_header();
?>

<main style="padding: 80px 60px;">
  <?php if ( have_posts() ) : ?>
    <?php while ( have_posts() ) : the_post(); ?>
      <article <?php post_class(); ?>>
        <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
        <div><?php the_excerpt(); ?></div>
      </article>
    <?php endwhile; ?>
  <?php else : ?>
    <p>コンテンツが見つかりませんでした。</p>
  <?php endif; ?>
</main>

<?php get_footer(); ?>
