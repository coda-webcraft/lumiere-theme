<?php
/**
 * メニューカテゴリー別一覧テンプレート(例: /menu-category/drink/)
 */
get_header();

$current_term = get_queried_object();

$menu_categories = get_terms(array(
  'taxonomy' => 'menu_category',
  'hide_empty' => true,
));
?>

<main style="max-width: 1100px; margin: 0 auto;">
  <?php if (function_exists('yoast_breadcrumb')): ?>
    <?php yoast_breadcrumb('<p class="breadcrumbs">', '</p>'); ?>
  <?php endif; ?>

  <section class="menu-archive">
    <h1 class="menu-archive-title"><?php echo esc_html($current_term->name); ?></h1>

    <?php if (!empty($menu_categories) && !is_wp_error($menu_categories)): ?>
      <div class="menu-category-tabs">
        <a href="<?php echo esc_url(get_post_type_archive_link('menu_item')); ?>" class="menu-category-tab">すべて</a>
        <?php foreach ($menu_categories as $cat): ?>
          <a href="<?php echo esc_url(get_term_link($cat)); ?>"
            class="menu-category-tab<?php echo ($cat->term_id === $current_term->term_id) ? ' is-active' : ''; ?>"><?php echo esc_html($cat->name); ?></a>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>

    <div class="menu menu-archive-grid">
      <?php if (have_posts()): ?>
        <?php while (have_posts()):
          the_post(); ?>
          <div class="menu-card">
            <div class="menu-photo" <?php echo has_post_thumbnail() ? ' style="background-image:url(\'' . esc_url(get_the_post_thumbnail_url(get_the_ID(), 'medium')) . '\');"' : ''; ?>>
              <?php if (get_field('is_recommended')): ?>
                <span class="menu-recommend-badge">おすすめ</span>
              <?php endif; ?>
            </div>
            <h3><?php the_title(); ?></h3>
            <p class="price"><?php echo esc_html(get_field('menu_item_price')); ?></p>
          </div>
        <?php endwhile; ?>
      <?php else: ?>
        <p style="color:var(--color-text-sub);">このカテゴリーにはまだメニューがありません。</p>
      <?php endif; ?>
    </div>

    <p class="menu-archive-back">
      <a href="<?php echo esc_url(home_url('/')); ?>">← トップページへ戻る</a>
    </p>
  </section>
</main>

<?php get_footer(); ?>