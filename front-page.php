<?php
/**
 * フロントページテンプレート
 * 「設定 > 表示設定」で固定ページを選び、そのページをこのテンプレートで表示します。
 */

get_header();

$hero_bg = get_field('hero_bg_image');
$hero_title = get_field('hero_title');
$hero_sub = get_field('hero_subtitle');
$hero_btn_txt = get_field('hero_button_text');
$hero_btn_url = get_field('hero_button_link');

$features = array(
  array('icon' => get_field('feature_1_icon'), 'title' => get_field('feature_1_title'), 'text' => get_field('feature_1_text')),
  array('icon' => get_field('feature_2_icon'), 'title' => get_field('feature_2_title'), 'text' => get_field('feature_2_text')),
  array('icon' => get_field('feature_3_icon'), 'title' => get_field('feature_3_title'), 'text' => get_field('feature_3_text')),
);

$menu_query = new WP_Query(array(
  'post_type' => 'menu_item',
  'posts_per_page' => -1,
  'orderby' => 'menu_order',
  'order' => 'ASC',
));

$about_heading = get_field('about_heading');
$about_text = get_field('about_text');
$about_image = get_field('about_image');

$testimonial_query = new WP_Query(array(
  'post_type' => 'testimonial',
  'posts_per_page' => 6,
  'orderby' => 'menu_order',
  'order' => 'ASC',
));

$access_address = get_field('access_address');
$access_hours = get_field('access_hours');
$access_phone = get_field('access_phone');
$access_map_url = get_field('access_map_url');

$faq_query = new WP_Query(array(
  'post_type' => 'faq',
  'posts_per_page' => -1,
  'orderby' => 'menu_order',
  'order' => 'ASC',
));

$contact_heading = get_field('contact_heading');
$contact_text = get_field('contact_text');
$contact_shortcode = get_field('contact_form_shortcode');
?>

<section class="hero" <?php echo $hero_bg ? ' style="background-image:url(\'' . esc_url($hero_bg['url']) . '\');"' : ''; ?>>
  <h1><?php echo esc_html($hero_title); ?></h1>
  <p><?php echo esc_html($hero_sub); ?></p>
  <?php if ($hero_btn_txt): ?>
    <a class="btn"
      href="<?php echo esc_url($hero_btn_url ? $hero_btn_url : '#contact'); ?>"><?php echo esc_html($hero_btn_txt); ?></a>
  <?php endif; ?>
</section>

<section class="features">
  <?php foreach ($features as $f): ?>
    <div class="feature-card">
      <div class="feature-icon" <?php echo $f['icon'] ? ' style="background-image:url(\'' . esc_url($f['icon']['url']) . '\');"' : ''; ?>></div>
      <h3><?php echo esc_html($f['title']); ?></h3>
      <p><?php echo esc_html($f['text']); ?></p>
    </div>
  <?php endforeach; ?>
</section>

<div class="page-layout">
  <main class="page-main">

    <section class="menu" id="menu">
      <h2 class="menu-heading">Menu</h2>
      <div class="menu-preview">
        <?php if ($menu_query->have_posts()): ?>
          <?php while ($menu_query->have_posts()):
            $menu_query->the_post(); ?>
            <div class="menu-card">
              <div class="menu-photo" <?php echo has_post_thumbnail() ? ' style="background-image:url(\'' . esc_url(get_the_post_thumbnail_url(get_the_ID(), 'medium')) . '\');"' : ''; ?>>
                <?php if (get_field('is_recommended')): ?>
                  <span class="menu-recommend-badge">おすすめ</span>
                <?php endif; ?>
              </div>
              <h3><?php the_title(); ?></h3>
              <p class="price"><?php echo esc_html(get_field('menu_item_price')); ?></p>
            </div>
          <?php endwhile;
          wp_reset_postdata(); ?>
        <?php else: ?>
          <p style="color:var(--color-text-sub);">メニュー項目がまだ登録されていません。</p>
        <?php endif; ?>
      </div>
    </section>

    <div class="menu-more">
      <a class="btn btn-outline"
        href="<?php echo esc_url(get_post_type_archive_link('menu_item')); ?>">メニューをすべて見る</a>
    </div>

    <section class="about" id="about">
      <div class="about-photo" <?php echo $about_image ? ' style="background-image:url(\'' . esc_url($about_image['url']) . '\');"' : ''; ?>></div>
      <div class="about-text">
        <h2><?php echo esc_html($about_heading); ?></h2>
        <p><?php echo nl2br(esc_html($about_text)); ?></p>
      </div>
    </section>

    <section class="access" id="access">
      <div class="access-text">
        <h2>Access</h2>
        <p>
          住所:<?php echo esc_html($access_address); ?><br />
          営業時間:<?php echo esc_html($access_hours); ?><br />
          電話番号:<?php echo esc_html($access_phone); ?>
        </p>
      </div>
      <div class="access-map">
        <?php if ($access_map_url): ?>
          <iframe src="<?php echo esc_url($access_map_url); ?>" width="100%" height="100%" style="border: 0"
            allowfullscreen="" loading="lazy" referrerpolicy="strict-origin-when-cross-origin"></iframe>
        <?php endif; ?>
      </div>
    </section>

    <?php if ($faq_query->have_posts()): ?>
      <section class="faq" id="faq">
        <h2 class="faq-heading">よくある質問</h2>
        <div class="faq-list">
          <?php while ($faq_query->have_posts()):
            $faq_query->the_post(); ?>
            <details class="faq-item">
              <summary class="faq-question"><?php the_title(); ?></summary>
              <div class="faq-answer"><?php echo nl2br(esc_html(get_field('faq_answer'))); ?></div>
            </details>
          <?php endwhile;
          wp_reset_postdata(); ?>
        </div>
      </section>
    <?php endif; ?>

    <section class="contact" id="contact">
      <h2><?php echo esc_html($contact_heading); ?></h2>
      <?php if ($contact_text): ?>
        <p class="contact-lead"><?php echo esc_html($contact_text); ?></p>
      <?php endif; ?>

      <div class="contact-form">
        <?php
        if ($contact_shortcode) {
          echo do_shortcode($contact_shortcode);
        } else {
          echo '<p style="color:var(--color-text-sub);">お問い合わせフォームのショートコードが設定されていません。</p>';
        }
        ?>
      </div>
    </section>

    <?php if ($testimonial_query->have_posts()): ?>
      <section class="testimonials" id="testimonials">
        <h2 class="testimonials-heading">お客様の声</h2>
        <div class="testimonials-grid">
          <?php while ($testimonial_query->have_posts()):
            $testimonial_query->the_post();
            $rating = (int) get_field('testimonial_rating');
            $rating = $rating ? $rating : 5;
            ?>
            <div class="testimonial-card">
              <p class="testimonial-stars">
                <?php echo esc_html(str_repeat('★', $rating) . str_repeat('☆', 5 - $rating)); ?></p>
              <p class="testimonial-text">「<?php echo esc_html(get_field('testimonial_text')); ?>」</p>
              <p class="testimonial-name">
                <?php the_title(); ?>
                <?php $attr = get_field('testimonial_attribute'); ?>
                <?php if ($attr): ?>
                  <span class="testimonial-attribute"><?php echo esc_html($attr); ?></span>
                <?php endif; ?>
              </p>
            </div>
          <?php endwhile;
          wp_reset_postdata(); ?>
        </div>
      </section>
    <?php endif; ?>

  </main>

  <?php get_sidebar(); ?>

</div>

<?php get_footer(); ?>