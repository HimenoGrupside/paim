<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Title</title>
  <?php 
    if(WP_DEBUG){
      $root = "http://localhost:5173";
      $css_ext = "scss";
      $js_ext = "ts";
      echo '<script type="module" src="http://localhost:5173/@vite/client"></script>';
    }else{
      $root = get_template_directory_uri();
      $css_ext = "css";
      $js_ext = "js";
    } 
  ?>
  <link rel="stylesheet" href="<?php echo $root;?>/assets/style/style.<?php echo $css_ext?>">
  <script src="<?php echo $root;?>/assets/js/script.<?php echo $js_ext?>" type="module"></script>
  <?php wp_head(); ?>
</head>
  <body>
  <header>
    <a href="<?= esc_url(home_url('/')); ?>" class="header-logo"><img src="<?= get_template_directory_uri() ?>/images/logo.svg" alt="PAIM"></a>

    <button class="hamburger" id="js-hamburger" aria-label="メニュー開閉">
      <span></span>
      <span></span>
      <span></span>
    </button>

    <nav class="header-nav" id="js-nav">
      <ul>
        <li><a href="#works">WORKS</a></li>
        <li><a href="#news">NEWS</a></li>
        <li><a href="#aboutus">ABOUT US</a></li>
        <li><a href="#contact">CONTACT</a></li>
      </ul>
    </nav>
  </header>