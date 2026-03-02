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
                <span itemprop="name">NEWS</span>
                <meta itemprop="position" content="2" />
            </li>
        </ul>
    </div>
</nav>

<main class="page-news">
    <h1>NEWS<span>新着情報</span></h1>

    <?php if (have_posts()) : ?>
        <ul>
            <?php while (have_posts()) : the_post(); ?>
                <li>
                    <a href="<?php the_permalink(); ?>">
                        <p class="date"><?php echo get_the_date(); ?></p>
                        <p class="title"><?php the_title(); ?></p>
                    </a>
                </li>
            <?php endwhile; ?>
        </ul>
        <div class="p-pagination">
            <?php
            echo paginate_links(array(
                'total'     => $wp_query->max_num_pages,
                'current'   => max(1, get_query_var('paged')),
                'format'    => '?paged=%#%',
                'prev_text' => '前へ',
                'next_text' => '次へ',
                'type'      => 'list', 
            ));
            ?>
        </div>        
    <?php else : ?>
        <p>記事が見つかりません。</p>
    <?php endif; ?>
</main>

<?php get_footer(); ?>