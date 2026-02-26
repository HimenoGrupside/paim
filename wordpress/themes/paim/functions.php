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
 * 実績投稿に「企業名」入力欄を追加
 */
function add_works_meta_box() {
    add_meta_box(
        'works_company_meta',   // ID
        '企業名入力',            // タイトル
        'render_works_company_field', // 表示用関数
        'works',                // カスタム投稿名
        'side',                 // 表示場所（右サイド）
        'default'
    );
}
add_action('add_meta_boxes', 'add_works_meta_box');

// 入力欄のHTML
function render_works_company_field($post) {
    $value = get_post_meta($post->ID, '_works_company', true);
    echo '<input type="text" name="works_company" value="' . esc_attr($value) . '" style="width:100%;">';
}

// データの保存処理
function save_works_company_meta($post_id) {
    if (array_key_exists('works_company', $_POST)) {
        update_post_meta($post_id, '_works_company', $_POST['works_company']);
    }
}
add_action('save_post', 'save_works_company_meta');

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
 * Ajaxで実績（works）を読み込む
 */
function load_more_works() {
    $result="";
    $current_page = isset($_POST['page']) ? intval($_POST['page']) : 1;
    $args = array(
        'post_type'      => 'works',
        'posts_per_page' => 7,      // 追加する数
        'paged'          => $current_page + 1, // 次のページ（2枚目）を指定
        'post_status'    => 'publish',
        'orderby'        => 'date',
        'order'          => 'DESC',
    );

    $next_flag = $query->max_num_pages > $current_page + 1?1:0;

    $query = new WP_Query($args);

    if ($query->have_posts()) :
        while ($query->have_posts()) : $query->the_post(); 
            $count ++;
            $company = get_post_meta(get_the_ID(), '_works_company', true);
            $permalink = get_the_permalink();
            $thumbnail = has_post_thumbnail() 
                ? get_the_post_thumbnail(get_the_ID(), 'large') 
                : '<img src="' . get_template_directory_uri() . '/assets/images/dammy-g.png" alt="ダミー画像">';
            $company_name = esc_html($company);
            $post_title = get_the_title();
            $result.=<<<HTML
                <li>
                    <a href="{$permalink}">
                        {$thumbnail}
                        <div>
                            <p class="company-name">{$company_name}</p>
                            <p class="title-name">{$post_title}</p>
                        </div>
                    </a>
                </li>
                HTML;
        endwhile;
    endif;    

    wp_reset_postdata();
    wp_send_json([
        'next' => $next_flag,
        'result' => $result,
    ]);    
    wp_die();
}
add_action('wp_ajax_load_more_works', 'load_more_works');
add_action('wp_ajax_nopriv_load_more_works', 'load_more_works');

