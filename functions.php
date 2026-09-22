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
 * 指定した年月の休業日一覧を取得
 * 戻り値: array( 日にち(int) => 休業理由(タイトル) )
 */
function lumiere_get_closure_days( $year, $month ) {
    $first_day = sprintf( '%04d%02d%02d', $year, $month, 1 );
    $last_day  = sprintf( '%04d%02d%02d', $year, $month, cal_days_in_month( CAL_GREGORIAN, $month, $year ) );

    $query = new WP_Query( array(
        'post_type'      => 'closure_day',
        'posts_per_page' => -1,
        'meta_query'      => array(
            array(
                'key'     => 'closure_date',
                'value'   => array( $first_day, $last_day ),
                'compare' => 'BETWEEN',
                'type'    => 'DATE',
            ),
        ),
    ) );

    $closures = array();
    if ( $query->have_posts() ) {
        foreach ( $query->posts as $post ) {
            $date = get_field( 'closure_date', $post->ID );
            if ( $date ) {
                $day = (int) substr( $date, 6, 2 );
                $closures[ $day ] = get_the_title( $post );
            }
        }
    }
    wp_reset_postdata();

    return $closures;
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
 */
function lumiere_nav_fallback() {
    echo '<a href="#about">About</a><a href="#menu">Menu</a><a href="#access">Access</a><a href="#contact">Contact</a>';
}
