<?php get_header(); ?>

<main class="l-container-width" style="padding: 100px 20px;">
    <?php
    if ( have_posts() ) :
        while ( have_posts() ) : the_post();
            the_title('<h1>', '</h1>');
            the_content();
        endwhile;
    else :
        echo '<p>お探しのページは見つかりませんでした。</p>';
    endif;
    ?>
</main>

<?php get_footer(); ?>