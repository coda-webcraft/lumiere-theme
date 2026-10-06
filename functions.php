<?php
/**
 * Cafe LUMIERE テーマ functions.php
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

define( 'LUMIERE_VERSION', '1.0.0' );

/**
 * テーマの基本設定
 */
function lumiere_setup() {
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'html5', array( 'search-form', 'gallery', 'caption' ) );

    register_nav_menus( array(
        'primary' => __( 'メインナビゲーション', 'lumiere' ),
    ) );
}
add_action( 'after_setup_theme', 'lumiere_setup' );

/**
 * 「メニュー」専用の投稿タイプ登録
 * 通常の投稿と同じ感覚で、写真(アイキャッチ)・商品名(タイトル)・価格(ACF)を
 * 好きなだけ追加できます。並び順は編集画面の「並び替え」欄で指定できます。
 */
function lumiere_register_menu_item_post_type() {
    register_post_type( 'menu_item', array(
        'labels' => array(
            'name'               => 'メニュー',
            'singular_name'      => 'メニュー項目',
            'add_new_item'       => '新規メニュー項目を追加',
            'edit_item'          => 'メニュー項目を編集',
            'all_items'          => 'すべてのメニュー項目',
            'menu_name'          => 'メニュー',
        ),
        'public'        => true,
        'has_archive'   => true,
        'rewrite'       => array( 'slug' => 'menu' ),
        'menu_icon'     => 'dashicons-coffee',
        'supports'      => array( 'title', 'thumbnail', 'page-attributes' ),
        'menu_position' => 5,
    ) );
}
add_action( 'init', 'lumiere_register_menu_item_post_type' );

/**
 * メニューのカテゴリー(ドリンク/フードなど)
 */
function lumiere_register_menu_category_taxonomy() {
    register_taxonomy( 'menu_category', 'menu_item', array(
        'labels' => array(
            'name'          => 'メニューカテゴリー',
            'singular_name' => 'メニューカテゴリー',
            'add_new_item'  => 'カテゴリーを追加',
            'edit_item'     => 'カテゴリーを編集',
            'all_items'     => 'すべてのカテゴリー',
        ),
        'hierarchical'      => true,
        'public'            => true,
        'show_ui'           => true,
        'show_admin_column' => true,
        'rewrite'           => array( 'slug' => 'menu-category' ),
    ) );
}
add_action( 'init', 'lumiere_register_menu_category_taxonomy' );

/**
 * 「お客様の声」投稿タイプ
 */
function lumiere_register_testimonial_post_type() {
    register_post_type( 'testimonial', array(
        'labels' => array(
            'name'          => 'お客様の声',
            'singular_name' => 'お客様の声',
            'add_new_item'  => '新規レビューを追加',
            'edit_item'     => 'レビューを編集',
            'all_items'     => 'すべてのレビュー',
            'menu_name'     => 'お客様の声',
        ),
        'public'        => true,
        'has_archive'   => false,
        'supports'      => array( 'title', 'page-attributes' ),
        'menu_icon'     => 'dashicons-format-quote',
        'menu_position' => 6,
    ) );
}
add_action( 'init', 'lumiere_register_testimonial_post_type' );

/**
 * FAQ(よくある質問)投稿タイプ
 */
function lumiere_register_faq_post_type() {
    register_post_type( 'faq', array(
        'labels' => array(
            'name'          => 'FAQ',
            'singular_name' => 'FAQ',
            'add_new_item'  => '新規質問を追加',
            'edit_item'     => '質問を編集',
            'all_items'     => 'すべての質問',
            'menu_name'     => 'FAQ',
        ),
        'public'        => false,
        'show_ui'       => true,
        'show_in_menu'  => true,
        'supports'      => array( 'title', 'page-attributes' ),
        'menu_icon'     => 'dashicons-editor-help',
        'menu_position' => 8,
    ) );
}
add_action( 'init', 'lumiere_register_faq_post_type' );

/**
 * 「休業日」投稿タイプ(管理画面のみで使用、フロント側に個別ページは作らない)
 */
function lumiere_register_closure_day_post_type() {
    register_post_type( 'closure_day', array(
        'labels' => array(
            'name'          => '休業日',
            'singular_name' => '休業日',
            'add_new_item'  => '休業日を追加',
            'edit_item'     => '休業日を編集',
            'all_items'     => 'すべての休業日',
            'menu_name'     => '休業日カレンダー',
        ),
        'public'      => false,
        'show_ui'     => true,
        'show_in_menu' => true,
        'supports'    => array( 'title' ),
        'menu_icon'   => 'dashicons-calendar-alt',
        'menu_position' => 7,
    ) );
}
add_action( 'init', 'lumiere_register_closure_day_post_type' );

/**
 * 休業日を全件取得(年月を絞り込まない)
 *
 * 静的サイト(Simply Static)として書き出した場合、PHPで「今月」を計算すると
 * サイト生成時点の月のまま固定表示されてしまうため、休業日データは全件を
 * JSONとしてHTMLに埋め込み、実際の年月の絞り込みと表組みの描画はすべて
 * 閲覧者のブラウザ上でJavaScriptが行う(lumiere_render_calendar() / js/main.js)。
 *
 * 戻り値: array( array( 'date' => 'Ymd', 'title' => 休業理由 ), ... )
 */
function lumiere_get_all_closure_dates() {
    $query = new WP_Query( array(
        'post_type'      => 'closure_day',
        'posts_per_page' => -1,
        'orderby'        => 'meta_value',
        'meta_key'       => 'closure_date',
        'order'          => 'ASC',
    ) );

    $closures = array();
    if ( $query->have_posts() ) {
        foreach ( $query->posts as $post ) {
            $date = get_field( 'closure_date', $post->ID );
            if ( $date ) {
                $closures[] = array(
                    'date'  => $date,
                    'title' => get_the_title( $post ),
                );
            }
        }
    }
    wp_reset_postdata();

    return $closures;
}

/**
 * 営業カレンダーの共通マークアップを出力
 *
 * 曜日の見出し行以外は空の状態で出力し、休業日データ(JSON)を
 * data-closures属性に埋め込む。実際の年月・日付のマス目はすべて
 * js/main.js側で、閲覧者のブラウザの「現在日時」をもとに描画する。
 *
 * @param string $id            カレンダーを囲むdivのid(1ページに複数置く場合の区別用)
 * @param string $heading_tag   見出しのタグ名(h2/h3など)
 * @param string $heading_class 見出しに付与する追加クラス(デザイン用)
 */
function lumiere_render_calendar( $id = 'lumiere-calendar', $heading_tag = 'h3', $heading_class = 'sidebar-title' ) {
    $closures    = lumiere_get_all_closure_dates();
    $heading_tag = tag_escape( $heading_tag );
    ?>
    <div class="lumiere-calendar" id="<?php echo esc_attr( $id ); ?>" data-closures="<?php echo esc_attr( wp_json_encode( $closures ) ); ?>">
        <<?php echo $heading_tag; ?> class="<?php echo esc_attr( $heading_class ); ?> lumiere-calendar-heading">営業カレンダー</<?php echo $heading_tag; ?>>

        <table class="sidebar-calendar">
            <thead>
                <tr></tr>
            </thead>
            <tbody></tbody>
        </table>

        <p class="sidebar-calendar-legend">
            <span class="legend-dot is-closed"></span>休業日
            <span class="legend-dot is-today"></span>本日
        </p>

        <noscript><p class="lumiere-calendar-noscript">カレンダーの表示にはJavaScriptを有効にしてください。</p></noscript>
    </div>
    <?php
}

/**
 * お問い合わせページ(page-contact.phpテンプレートを指定した固定ページ)のURLを取得
 * 見つからない場合は /contact/ を仮のURLとして返す
 */
function lumiere_get_contact_page_url() {
    static $url = null;

    if ( null !== $url ) {
        return $url;
    }

    $pages = get_posts( array(
        'post_type'      => 'page',
        'post_status'    => 'publish',
        'posts_per_page' => 1,
        'meta_key'       => '_wp_page_template',
        'meta_value'     => 'page-contact.php',
    ) );

    $url = $pages ? get_permalink( $pages[0] ) : home_url( '/contact/' );

    return $url;
}

/**
 * CSS / JS の読み込み(直接<link><script>を書かず、必ずwp_enqueueを使う)
 */
function lumiere_enqueue_assets() {
    wp_enqueue_style( 'lumiere-style', get_stylesheet_uri(), array(), LUMIERE_VERSION );
    wp_enqueue_script( 'lumiere-main', get_template_directory_uri() . '/js/main.js', array(), LUMIERE_VERSION, true );
}
add_action( 'wp_enqueue_scripts', 'lumiere_enqueue_assets' );

/**
 * ACF未インストール時に管理画面へ通知を出す
 */
function lumiere_acf_admin_notice() {
    if ( ! class_exists( 'ACF' ) ) {
        echo '<div class="notice notice-error"><p><strong>Cafe LUMIEREテーマ:</strong> このテーマはAdvanced Custom Fields(ACF)プラグインが必要です。プラグインをインストール・有効化してください。</p></div>';
    }
}
add_action( 'admin_notices', 'lumiere_acf_admin_notice' );

/**
 * ACFフィールド定義の読み込み
 */
require_once get_template_directory() . '/inc/acf-fields.php';

/**
 * ナビの初期表示(メニュー未設定時のフォールバック)
 * Contactのみ、独立したお問い合わせページへのリンクにする
 */
function lumiere_nav_fallback() {
    // 「About」「Menu」「Access」はトップページ内のセクションへのアンカーリンクのため、
    // どのページから見てもトップページに戻ってからスクロールするよう、
    // トップページURL + アンカーの形にしておく(例: https://example.com/#about)。
    $home = home_url( '/' );
    echo '<a href="' . esc_url( $home . '#about' ) . '">About</a>';
    echo '<a href="' . esc_url( $home . '#menu' ) . '">Menu</a>';
    echo '<a href="' . esc_url( $home . '#access' ) . '">Access</a>';
    echo '<a href="' . esc_url( lumiere_get_contact_page_url() ) . '">Contact</a>';
}
