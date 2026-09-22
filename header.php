<!doctype html>
<html <?php language_attributes(); ?>>
  <head>
    <meta charset="<?php bloginfo( 'charset' ); ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <?php wp_head(); ?>
  </head>

  <body <?php body_class(); ?>>
  <?php wp_body_open(); ?>

    <header class="header">
      <div class="logo"><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a></div>

      <?php
      if ( has_nav_menu( 'primary' ) ) {
          wp_nav_menu( array(
              'theme_location' => 'primary',
              'container'      => false,
              'menu_class'     => 'nav',
              'items_wrap'     => '<nav class="nav" id="primary-nav">%3$s</nav>',
          ) );
      } else {
          echo '<nav class="nav" id="primary-nav">';
          lumiere_nav_fallback();
          echo '</nav>';
      }
      ?>

      <button class="hamburger" id="hamburger-btn" aria-label="メニューを開く" aria-expanded="false" aria-controls="primary-nav">
        <span></span>
        <span></span>
        <span></span>
      </button>
    </header>
