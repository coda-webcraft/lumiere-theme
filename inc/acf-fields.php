<?php
/**
 * ACF フィールドグループ定義
 *
 * すべて無料版ACFで使えるフィールドタイプのみで構成しています
 * (Repeater / Options Page は ACF PRO限定のため使用していません)。
 *
 * 対象ページ:「設定 > 表示設定」で固定フロントページに指定したページ。
 */

if (!function_exists('acf_add_local_field_group')) {
    return;
}

add_action('acf/init', function () {

    acf_add_local_field_group(array(
        'key' => 'group_lumiere_top',
        'title' => 'トップページ コンテンツ',
        'fields' => array(

            // --- ヒーロー ---
            array(
                'key' => 'field_lumiere_hero_tab',
                'label' => 'ヒーローセクション',
                'type' => 'tab',
            ),
            array(
                'key' => 'field_lumiere_hero_title',
                'label' => '見出し',
                'name' => 'hero_title',
                'type' => 'text',
                'default_value' => '一杯のコーヒーから、丁寧な時間を',
            ),
            array(
                'key' => 'field_lumiere_hero_subtitle',
                'label' => 'サブテキスト',
                'name' => 'hero_subtitle',
                'type' => 'text',
                'default_value' => '厳選した豆と、心地よい空間でお迎えします。',
            ),
            array(
                'key' => 'field_lumiere_hero_bg',
                'label' => '背景画像',
                'name' => 'hero_bg_image',
                'type' => 'image',
                'return_format' => 'array',
                'preview_size' => 'medium',
            ),
            array(
                'key' => 'field_lumiere_hero_btn_text',
                'label' => 'ボタン文言',
                'name' => 'hero_button_text',
                'type' => 'text',
                'default_value' => 'ご予約はこちら',
            ),
            array(
                'key' => 'field_lumiere_hero_btn_link',
                'label' => 'ボタンリンク先',
                'name' => 'hero_button_link',
                'type' => 'text',
                'default_value' => '#contact',
            ),

            // --- こだわり(features) ---
            array(
                'key' => 'field_lumiere_features_tab',
                'label' => 'こだわり(3項目)',
                'type' => 'tab',
            ),

            array('key' => 'field_lumiere_f1_icon', 'label' => '① アイコン画像(任意)', 'name' => 'feature_1_icon', 'type' => 'image', 'return_format' => 'array'),
            array('key' => 'field_lumiere_f1_title', 'label' => '① タイトル', 'name' => 'feature_1_title', 'type' => 'text', 'default_value' => '厳選された豆'),
            array('key' => 'field_lumiere_f1_text', 'label' => '① 説明文', 'name' => 'feature_1_text', 'type' => 'textarea', 'rows' => 2, 'default_value' => '世界各地から選りすぐった豆を、丁寧に焙煎しています。'),

            array('key' => 'field_lumiere_f2_icon', 'label' => '② アイコン画像(任意)', 'name' => 'feature_2_icon', 'type' => 'image', 'return_format' => 'array'),
            array('key' => 'field_lumiere_f2_title', 'label' => '② タイトル', 'name' => 'feature_2_title', 'type' => 'text', 'default_value' => '落ち着いた空間'),
            array('key' => 'field_lumiere_f2_text', 'label' => '② 説明文', 'name' => 'feature_2_text', 'type' => 'textarea', 'rows' => 2, 'default_value' => '木の温もりを感じる店内で、ゆったりとお寛ぎいただけます。'),

            array('key' => 'field_lumiere_f3_icon', 'label' => '③ アイコン画像(任意)', 'name' => 'feature_3_icon', 'type' => 'image', 'return_format' => 'array'),
            array('key' => 'field_lumiere_f3_title', 'label' => '③ タイトル', 'name' => 'feature_3_title', 'type' => 'text', 'default_value' => '焼きたてスイーツ'),
            array('key' => 'field_lumiere_f3_text', 'label' => '③ 説明文', 'name' => 'feature_3_text', 'type' => 'textarea', 'rows' => 2, 'default_value' => '毎朝手作りする、季節のスイーツをご堪能ください。'),

            // --- メニュー(4品) --- は「メニュー」投稿タイプに移行したため削除

            // --- About ---
            array(
                'key' => 'field_lumiere_about_tab',
                'label' => '私たちのこだわり(About)',
                'type' => 'tab',
            ),
            array('key' => 'field_lumiere_about_heading', 'label' => '見出し', 'name' => 'about_heading', 'type' => 'text', 'default_value' => '私たちのこだわり'),
            array('key' => 'field_lumiere_about_text', 'label' => '本文', 'name' => 'about_text', 'type' => 'textarea', 'rows' => 4, 'default_value' => 'LUMIÈREは"丁寧な時間"をコンセプトに、厳選した豆と落ち着いた空間をご用意しました。'),
            array('key' => 'field_lumiere_about_image', 'label' => '写真', 'name' => 'about_image', 'type' => 'image', 'return_format' => 'array'),

            // --- Access ---
            array(
                'key' => 'field_lumiere_access_tab',
                'label' => 'アクセス',
                'type' => 'tab',
            ),
            array('key' => 'field_lumiere_access_address', 'label' => '住所', 'name' => 'access_address', 'type' => 'text', 'default_value' => '〇〇県××町'),
            array('key' => 'field_lumiere_access_hours', 'label' => '営業時間', 'name' => 'access_hours', 'type' => 'text', 'default_value' => '9:00〜18:00'),
            array('key' => 'field_lumiere_access_phone', 'label' => '電話番号', 'name' => 'access_phone', 'type' => 'text', 'default_value' => '090-1234-5678'),
            array(
                'key' => 'field_lumiere_access_map_url',
                'label' => 'Googleマップ 埋め込みURL',
                'name' => 'access_map_url',
                'type' => 'url',
                'instructions' => 'Googleマップの「地図を埋め込む」で取得したiframeのsrc属性の値を貼り付けてください。',
            ),

            // --- Contact ---
            array(
                'key' => 'field_lumiere_contact_tab',
                'label' => 'お問い合わせ(Contact)',
                'type' => 'tab',
            ),
            array(
                'key' => 'field_lumiere_contact_heading',
                'label' => '見出し',
                'name' => 'contact_heading',
                'type' => 'text',
                'default_value' => 'Contact',
            ),
            array(
                'key' => 'field_lumiere_contact_text',
                'label' => '説明文',
                'name' => 'contact_text',
                'type' => 'textarea',
                'rows' => 2,
                'default_value' => 'ご予約・お問い合わせは、以下のフォームよりお気軽にご連絡ください。',
            ),
            array(
                'key' => 'field_lumiere_contact_shortcode',
                'label' => 'お問い合わせフォーム ショートコード',
                'name' => 'contact_form_shortcode',
                'type' => 'text',
                'instructions' => 'Contact Form 7の編集画面上部に表示されているショートコード(例: [contact-form-7 id="xxxx" title="コンタクトフォーム1"])を、そのまま貼り付けてください。',
            ),

            // --- Footer ---
            array(
                'key' => 'field_lumiere_footer_tab',
                'label' => 'フッター',
                'type' => 'tab',
            ),
            array('key' => 'field_lumiere_footer_copyright', 'label' => 'コピーライト表記', 'name' => 'footer_copyright', 'type' => 'text', 'default_value' => '© 2026 Cafe LUMIÈRE'),
            array('key' => 'field_lumiere_footer_instagram', 'label' => 'Instagram URL', 'name' => 'footer_instagram_url', 'type' => 'url'),
            array('key' => 'field_lumiere_footer_x', 'label' => 'X (Twitter) URL', 'name' => 'footer_x_url', 'type' => 'url'),

        ),
        'location' => array(
            array(
                array(
                    'param' => 'page_type',
                    'operator' => '==',
                    'value' => 'front_page',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'active' => true,
        'description' => '「設定 > 表示設定」で固定フロントページとして指定したページの編集画面にのみ表示されます。',
    ));

    // メニュー項目(menu_item)の編集画面に「価格」フィールドを追加
    acf_add_local_field_group(array(
        'key' => 'group_lumiere_menu_item',
        'title' => 'メニュー詳細',
        'fields' => array(
            array(
                'key' => 'field_lumiere_menu_item_price',
                'label' => '価格',
                'name' => 'menu_item_price',
                'type' => 'text',
                'instructions' => '例: ¥550',
            ),
            array(
                'key' => 'field_lumiere_menu_item_recommend',
                'label' => 'おすすめ表示',
                'name' => 'is_recommended',
                'type' => 'true_false',
                'ui' => 1,
                'instructions' => 'ONにすると、写真の左上に「おすすめ」のバッジが表示されます。',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'menu_item',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'active' => true,
    ));

    // お客様の声(testimonial)の編集画面に「レビュー本文」「評価」を追加
    acf_add_local_field_group(array(
        'key' => 'group_lumiere_testimonial',
        'title' => 'レビュー詳細',
        'fields' => array(
            array(
                'key' => 'field_lumiere_testimonial_text',
                'label' => 'レビュー本文',
                'name' => 'testimonial_text',
                'type' => 'textarea',
                'rows' => 3,
            ),
            array(
                'key' => 'field_lumiere_testimonial_rating',
                'label' => '評価',
                'name' => 'testimonial_rating',
                'type' => 'select',
                'choices' => array(
                    '5' => '★★★★★(5)',
                    '4' => '★★★★☆(4)',
                    '3' => '★★★☆☆(3)',
                ),
                'default_value' => '5',
            ),
            array(
                'key' => 'field_lumiere_testimonial_attr',
                'label' => '属性(任意)',
                'name' => 'testimonial_attribute',
                'type' => 'text',
                'instructions' => '例: 常連のお客様 / 30代女性 など。タイトルの「お名前」の下に小さく表示されます。',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'testimonial',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'active' => true,
    ));

    // 休業日(closure_day)の編集画面に「日付」を追加
    acf_add_local_field_group(array(
        'key' => 'group_lumiere_closure_day',
        'title' => '休業日の詳細',
        'fields' => array(
            array(
                'key' => 'field_lumiere_closure_date',
                'label' => '日付',
                'name' => 'closure_date',
                'type' => 'date_picker',
                'display_format' => 'Y年n月j日',
                'return_format' => 'Ymd',
                'instructions' => 'タイトルには「臨時休業」「年末年始休業」など、休業理由を入力してください。',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'closure_day',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'active' => true,
    ));

    // FAQ(faq)の編集画面に「回答」を追加
    acf_add_local_field_group(array(
        'key' => 'group_lumiere_faq',
        'title' => 'FAQ詳細',
        'fields' => array(
            array(
                'key' => 'field_lumiere_faq_answer',
                'label' => '回答',
                'name' => 'faq_answer',
                'type' => 'textarea',
                'rows' => 3,
                'instructions' => 'タイトルには「質問」をそのまま入力してください(例: 駐車場はありますか?)。',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'faq',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'active' => true,
    ));

});
