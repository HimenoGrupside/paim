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
            'with_front' => false // 他の設定に干渉されないようにする
        ], 
    ]);
});

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