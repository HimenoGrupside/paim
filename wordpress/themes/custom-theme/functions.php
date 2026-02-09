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