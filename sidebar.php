<?php
/**
 * サイドバー(最新ブログ記事)
 */
$recent_posts = new WP_Query( array(
    'posts_per_page' => 5,
    'post_status'     => 'publish',
) );
?>
<aside class="page-sidebar">
  <div class="sidebar-widget">
    <h3 class="sidebar-title">Blog</h3>

    <?php if ( $recent_posts->have_posts() ) : ?>
      <ul class="sidebar-post-list">
        <?php while ( $recent_posts->have_posts() ) : $recent_posts->the_post(); ?>
          <li class="sidebar-post-item">
            <a href="<?php the_permalink(); ?>">
              <?php if ( has_post_thumbnail() ) : ?>
                <span class="sidebar-post-thumb"><?php the_post_thumbnail( 'thumbnail' ); ?></span>
              <?php endif; ?>
              <span class="sidebar-post-info">
                <span class="sidebar-post-date"><?php echo esc_html( get_the_date() ); ?></span>
                <span class="sidebar-post-title"><?php the_title(); ?></span>
              </span>
            </a>
          </li>
        <?php endwhile; wp_reset_postdata(); ?>
      </ul>
      <a class="sidebar-more-link" href="<?php echo esc_url( get_permalink( get_option( 'page_for_posts' ) ) ); ?>">ブログ記事一覧を見る</a>
    <?php else : ?>
      <p class="sidebar-empty">まだ記事がありません。</p>
    <?php endif; ?>
  </div>

  <?php
  $cal_year  = (int) date( 'Y' );
  $cal_month = (int) date( 'n' );
  $cal_today = (int) date( 'j' );
  $closures  = function_exists( 'lumiere_get_closure_days' ) ? lumiere_get_closure_days( $cal_year, $cal_month ) : array();

  $days_in_month  = cal_days_in_month( CAL_GREGORIAN, $cal_month, $cal_year );
  $start_weekday  = (int) date( 'w', mktime( 0, 0, 0, $cal_month, 1, $cal_year ) );
  $weekday_labels = array( '日', '月', '火', '水', '木', '金', '土' );
  ?>
  <div class="sidebar-widget sidebar-calendar-widget">
    <h3 class="sidebar-title"><?php echo esc_html( $cal_year . '年' . $cal_month . '月' ); ?>の営業カレンダー</h3>

    <table class="sidebar-calendar">
      <thead>
        <tr>
          <?php foreach ( $weekday_labels as $w ) : ?>
            <th><?php echo esc_html( $w ); ?></th>
          <?php endforeach; ?>
        </tr>
      </thead>
      <tbody>
        <tr>
          <?php
          for ( $i = 0; $i < $start_weekday; $i++ ) {
              echo '<td class="is-empty"></td>';
          }

          $col = $start_weekday;
          for ( $day = 1; $day <= $days_in_month; $day++ ) {
              $is_closed = isset( $closures[ $day ] );
              $is_today  = ( $day === $cal_today );
              $classes   = array();
              if ( $is_closed ) {
                  $classes[] = 'is-closed';
              }
              if ( $is_today ) {
                  $classes[] = 'is-today';
              }
              $title_attr = $is_closed ? ' title="' . esc_attr( $closures[ $day ] ) . '"' : '';

              echo '<td class="' . esc_attr( implode( ' ', $classes ) ) . '"' . $title_attr . '>' . (int) $day . '</td>';

              $col++;
              if ( $col % 7 === 0 && $day !== $days_in_month ) {
                  echo '</tr><tr>';
              }
          }

          $remaining = ( 7 - ( $col % 7 ) ) % 7;
          for ( $i = 0; $i < $remaining; $i++ ) {
              echo '<td class="is-empty"></td>';
          }
          ?>
        </tr>
      </tbody>
    </table>

    <p class="sidebar-calendar-legend">
      <span class="legend-dot is-closed"></span>休業日
      <span class="legend-dot is-today"></span>本日
    </p>
  </div>
</aside>
