<?php
/**
 * 404エラーページ
 */
get_header();
?>

<main class="error-404-page">
  <p class="error-404-code">404</p>
  <h1 class="error-404-title">ページが見つかりませんでした</h1>
  <p class="error-404-text">
    お探しのページは、削除されたか、URLが変更された可能性があります。<br />
    お手数ですが、トップページからもう一度お探しください。
  </p>
  <a class="btn" href="<?php echo esc_url( home_url( '/' ) ); ?>">トップページへ戻る</a>
</main>

<?php get_footer(); ?>