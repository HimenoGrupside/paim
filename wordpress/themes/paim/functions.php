<?php

/**
* ローカルjquery削除
*/
add_action('wp_enqueue_scripts', 'load_my_script');
function load_my_script() {
    if(!is_user_logged_in() || !current_user_can('administrator')) {//管理者としてログインしていない場合
        wp_deregister_script( 'jquery' );
        wp_deregister_script( 'jquery-migrate' );
    }
}

/**
* title タグ
*/
add_theme_support( 'title-tag' );
add_filter( 'document_title_separator', 'change_title_separator' );
function change_title_separator( $sep ){
    $sep = ' | ';
    return $sep;
}

/**
* アイキャッチ画像を利用できるようにする
*/
add_action( 'init', function(){
    add_theme_support('post-thumbnails');
});

/*
* カスタム投稿「実績」を追加
*/
add_action( 'init', function() {
    register_post_type( 'works', [
        'labels' => [ 'name' => '実績' ],
        'public'        => true,
        'has_archive'   => true, 
        'menu_position' => 5,
        'show_in_rest'  => true, 
        'menu_icon'     => 'dashicons-portfolio',
        'rewrite'       => [ 
            'slug' => 'works',
            'with_front' => false
        ],
        // 👇 ここを追加！
        'supports' => [ 'title', 'editor', 'thumbnail', 'excerpt' ] 
    ]);
});

/**
 * 実績投稿に「企業名」および「リンク設定」入力欄を追加
 */
function add_works_meta_box() {
    add_meta_box(
        'works_custom_meta',        // ID
        '実績の詳細情報',             // タイトル（少し分かりやすく変更）
        'render_works_custom_fields', // 表示用関数
        'works',                    // カスタム投稿名
        'side',                     // 表示場所
        'default'
    );
}
add_action('add_meta_boxes', 'add_works_meta_box');

// 入力欄のHTML
function render_works_custom_fields($post) {
    // 既存の企業名
    $company = get_post_meta($post->ID, '_works_company', true);
    // リンクなしフラグ
    $no_link = get_post_meta($post->ID, '_no_link_flag', true);
    
    echo '<p><strong>企業名</strong></p>';
    echo '<input type="text" name="works_company" value="' . esc_attr($company) . '" style="width:100%; margin-bottom:15px;">';
    
    echo '<hr>';
    
    echo '<p><strong>リンク設定</strong></p>';
    echo '<label><input type="checkbox" name="no_link_flag" value="1" ' . checked($no_link, '1', false) . '> 詳細ページへのリンクを無効にする</label>';
}

// データの保存処理
function save_works_custom_meta($post_id) {
    // 企業名の保存
    if (isset($_POST['works_company'])) {
        update_post_meta($post_id, '_works_company', $_POST['works_company']);
    }
    // リンクなしフラグの保存
    if (isset($_POST['no_link_flag'])) {
        update_post_meta($post_id, '_no_link_flag', '1');
    } else {
        delete_post_meta($post_id, '_no_link_flag');
    }
}
add_action('save_post', 'save_works_custom_meta');
/*
* 投稿（Post）のパーマリンクに /news/ を付与する
*/
add_filter('register_post_type_args', function($args, $post_type) {
    if ($post_type === 'post') {
        $args['rewrite'] = [
            'slug' => 'news',
            'with_front' => false,
        ];
    }
    return $args;
}, 10, 2);

/**
 * Ajaxで実績（works）を読み込む（詳細リンク制御付き）
 */
function load_more_works() {
    $result = "";
    $current_page = isset($_POST['page']) ? intval($_POST['page']) : 1;
    
    $args = array(
        'post_type'      => 'works',
        'posts_per_page' => 7,                // 追加する数
        'paged'          => $current_page + 1, // 次のページ（2枚目以降）を指定
        'post_status'    => 'publish',
        'orderby'        => 'date',
        'order'          => 'DESC',
    );

    $query = new WP_Query($args);

    // 次のページがあるかどうかのフラグ判定
    $next_flag = $query->max_num_pages > $current_page + 1 ? 1 : 0;

    if ($query->have_posts()) :
        while ($query->have_posts()) : $query->the_post(); 
            // カスタムフィールドの取得
            $company = get_post_meta(get_the_ID(), '_works_company', true);
            $no_link = get_post_meta(get_the_ID(), '_no_link_flag', true); // リンクなしフラグ
            
            $permalink = get_the_permalink();
            $thumbnail = has_post_thumbnail() 
                ? get_the_post_thumbnail(get_the_ID(), 'large') 
                : '<img src="' . get_template_directory_uri() . '/assets/images/dammy-g.png" alt="ダミー画像">';
            
            $company_name = esc_html($company);
            $post_title = get_the_title();

            // リンクの有無によってタグを分岐
            if ($no_link === '1') {
                // リンクなし：divタグで囲む
                $tag_start = '<div class="works-item -no-link">';
                $tag_end   = '</div>';
            } else {
                // リンクあり：aタグで囲む
                $tag_start = '<a href="' . esc_url($permalink) . '" class="works-item">';
                $tag_end   = '</a>';
            }

            // HTMLの組み立て
            $result .= <<<HTML
                <li>
                    {$tag_start}
                        {$thumbnail}
                        <div class="works-item-name">
                            <p class="company-name">{$company_name}</p>
                            <p class="title-name">{$post_title}</p>
                        </div>
                    {$tag_end}
                </li>
HTML;
        endwhile;
    endif;    

    wp_reset_postdata();

    // JSON形式でレスポンスを返す
    wp_send_json([
        'next'   => $next_flag,
        'result' => $result,
    ]);    
    wp_die();
}
add_action('wp_ajax_load_more_works', 'load_more_works');
add_action('wp_ajax_nopriv_load_more_works', 'load_more_works');


// 送信元メールアドレスを固定
add_filter( 'wp_mail_from', function( $email ) {
    return 'info@paim.jp';
});

// 送信者名を固定
add_filter( 'wp_mail_from_name', function( $name ) {
    return '株式会社パイン（PAIM）';
});