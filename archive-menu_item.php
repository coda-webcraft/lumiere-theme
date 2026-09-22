<?php
/**
 * メニュー(menu_item)一覧テンプレート
 */
get_header();

$menu_query = new WP_Query(array(
  'post_type' => 'menu_item',
  'posts_per_page' => -1,
  'orderby' => 'menu_order',
  'order' => 'ASC',
));

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
    <h1 class="menu-archive-title">Menu</h1>

    <?php if (!empty($menu_categories) && !is_wp_error($menu_categories)): ?>
      <div class="menu-category-tabs">
        <a href="<?php echo esc_url(get_post_type_archive_link('menu_item')); ?>"
          class="menu-category-tab is-active">すべて</a>
        <?php foreach ($menu_categories as $cat): ?>
          <a href="<?php echo esc_url(get_term_link($cat)); ?>"
            class="menu-category-tab"><?php echo esc_html($cat->name); ?></a>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>

    <div class="menu menu-archive-grid">
      <?php if ($menu_query->have_posts()): ?>
        <?php while ($menu_query->have_posts()):
          $menu_query->the_post(); ?>
          <div class="menu-card">
            <div class="menu-photo" <?php echo has_post_thumbnail() ? ' style="background-image:url(\'' . esc_url(get_the_post_thumbnail_url(get_the_ID(), 'medium')) . '\');"' : ''; ?>>
              <?php if (get_field('is_recommended')): ?>
                <span class="menu-recommend-badge">おすすめ</span>
              <?php endif; ?>
            </div>
            <?php $cats = get_the_terms(get_the_ID(), 'menu_category'); ?>
            <?php if ($cats && !is_wp_error($cats)): ?>
              <p class="menu-item-badge"><?php echo esc_html($cats[0]->name); ?></p>
            <?php endif; ?>
            <h3><?php the_title(); ?></h3>
            <p class="price"><?php echo esc_html(get_field('menu_item_price')); ?></p>
          </div>
        <?php endwhile;
        wp_reset_postdata(); ?>
      <?php else: ?>
        <p style="color:var(--color-text-sub);">メニュー項目がまだ登録されていません。</p>
      <?php endif; ?>
    </div>

    <p class="menu-archive-back">
      <a href="<?php echo esc_url(home_url('/')); ?>">← トップページへ戻る</a>
    </p>
  </section>
</main>

<?php get_footer(); ?>