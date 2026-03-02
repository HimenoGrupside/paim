<?php get_header(); ?>

<nav class="p-breadcrumbs">
    <div class="l-container">
        <ul class="p-breadcrumbs__list" itemscope itemtype="https://schema.org/BreadcrumbList">
            <li class="p-breadcrumbs__item" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                <a href="<?= esc_url(home_url('/')); ?>" itemprop="item">
                    <span itemprop="name">HOME</span>
                </a>
                <meta itemprop="position" content="1" />
            </li>

            <li class="p-breadcrumbs__item" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                <a href="<?= esc_url(get_post_type_archive_link('post')); ?>" itemprop="item">
                    <span itemprop="name">NEWS</span>
                </a>
                <meta itemprop="position" content="2" />
            </li>

            <li class="p-breadcrumbs__item" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                <span itemprop="name"><?php the_title(); ?></span>
                <meta itemprop="position" content="3" />
            </li>
        </ul>
    </div>
</nav>

    <main class="page-detail l-container-width">
        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
            <article>
                <h1><?php the_title(); ?></h1>
                <p class="date"><?php echo get_the_date('Y.m.d'); ?></p>

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

        <div class="backbtn">
            <a class="btn-common" href="<?php echo home_url(); ?>/news/">一覧に戻る</a>
        </div>
    </main>

<?php get_footer(); ?>