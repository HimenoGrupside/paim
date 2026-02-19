<?php get_header(); ?>

    <main class="l-container-width">
        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
            <article>
                <p class="date"><?php echo get_the_date('Y.m.d'); ?></p>
                <h1><?php the_title(); ?></h1>
                
                <?php if (has_post_thumbnail()) : ?>
                    <div class="post-img">
                        <?php the_post_thumbnail('large'); ?>
                    </div>
                <?php endif; ?>

                <div class="post-content">
                    <?php the_content(); ?>
                </div>
            </article>
        <?php endwhile; endif; ?>

        <div style="margin-top: 50px;">
            <a href="<?php echo home_url(); ?>">TOPに戻る</a>
        </div>
    </main>

<?php get_footer(); ?>