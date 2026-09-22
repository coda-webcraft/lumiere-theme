<?php
    $copyright  = get_field( 'footer_copyright' );
    $instagram  = get_field( 'footer_instagram_url' );
    $x_url      = get_field( 'footer_x_url' );
    $privacy_url = get_privacy_policy_url();
    ?>
    <footer class="footer">
      <p>
        <?php echo esc_html( $copyright ? $copyright : '© ' . date( 'Y' ) . ' ' . get_bloginfo( 'name' ) ); ?>
        <?php if ( $privacy_url ) : ?>
          <a class="footer-privacy-link" href="<?php echo esc_url( $privacy_url ); ?>">プライバシーポリシー</a>
        <?php endif; ?>
      </p>
      <div class="sns">
        <?php if ( $instagram ) : ?>
          <a href="<?php echo esc_url( $instagram ); ?>" target="_blank" rel="noopener noreferrer">Instagram</a>
        <?php endif; ?>
        <?php if ( $x_url ) : ?>
          <a href="<?php echo esc_url( $x_url ); ?>" target="_blank" rel="noopener noreferrer">X</a>
        <?php endif; ?>
      </div>
    </footer>

    <?php wp_footer(); ?>
  </body>
</html>
