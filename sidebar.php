<?php
/**
 * サイドバー(最新ブログ記事)
 */
$recent_posts = new WP_Query(array(
  'posts_per_page' => 5,
  'post_status' => 'publish',
));
?>
<aside class="page-sidebar">
  <div class="sidebar-widget">
    <h3 class="sidebar-title">Blog</h3>

    <?php if ($recent_posts->have_posts()): ?>
      <ul class="sidebar-post-list">
        <?php while ($recent_posts->have_posts()):
          $recent_posts->the_post(); ?>
          <li class="sidebar-post-item">
            <a href="<?php the_permalink(); ?>">
              <?php if (has_post_thumbnail()): ?>
                <span class="sidebar-post-thumb">
                  <?php the_post_thumbnail('thumbnail'); ?>
                </span>
              <?php endif; ?>
              <span class="sidebar-post-info">
                <span class="sidebar-post-date">
                  <?php echo esc_html(get_the_date()); ?>
                </span>
                <span class="sidebar-post-title">
                  <?php the_title(); ?>
                </span>
              </span>
            </a>
          </li>
        <?php endwhile;
        wp_reset_postdata(); ?>
      </ul>
      <a class="sidebar-more-link"
        href="<?php echo esc_url(get_permalink(get_option('page_for_posts'))); ?>">ブログ記事一覧を見る</a>
    <?php else: ?>
      <p class="sidebar-empty">まだ記事がありません。</p>
    <?php endif; ?>
  </div>

  <div class="sidebar-widget sidebar-calendar-widget">
    <?php lumiere_render_calendar('sidebar-calendar', 'h3', 'sidebar-title'); ?>
  </div>
</aside>