<?php
/**
 * Template Name: お問い合わせページ
 *
 * 固定ページ用テンプレート: お問い合わせ
 * 管理画面の「固定ページ」で新規ページを作成し、
 * ページ属性の「テンプレート」で本テンプレートを選択してください。
 */
get_header();

$contact_heading = get_field('contact_heading');
$contact_text = get_field('contact_text');
$contact_shortcode = get_field('contact_form_shortcode');
?>

<section class="contact" id="contact">
    <?php if (function_exists('yoast_breadcrumb')): ?>
        <?php yoast_breadcrumb('<p class="breadcrumbs">', '</p>'); ?>
    <?php endif; ?>

    <h1>
        <?php echo esc_html($contact_heading ? $contact_heading : get_the_title()); ?>
    </h1>

    <?php if ($contact_text): ?>
        <p class="contact-lead">
            <?php echo esc_html($contact_text); ?>
        </p>
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

<?php get_footer(); ?>