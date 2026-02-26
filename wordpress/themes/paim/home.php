<?php get_header(); ?>

<main style="padding: 100px 20px;">
    <h1>NEWS 一覧</h1>

    <?php if (have_posts()) : ?>
        <ul>
            <?php while (have_posts()) : the_post(); ?>
                <li style="margin-bottom: 20px;">
                    <a href="<?php the_permalink(); ?>">
                        <time><?php echo get_the_date(); ?></time>
                        <h2><?php the_title(); ?></h2>
                    </a>
                </li>
            <?php endwhile; ?>
        </ul>
    <?php else : ?>
        <p>記事が1件も見つかりません。管理画面で「投稿」を作成していますか？</p>
    <?php endif; ?>
</main>

<?php get_footer(); ?>