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
                <span itemprop="name"><?php the_title(); ?></span>
                <meta itemprop="position" content="2" />
            </li>
        </ul>
    </div>
</nav>

<main class="page-detail l-container-width">
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        <article class="works-post">
            <h1><?php the_title(); ?></h1>
            
            <?php 
            $company = get_post_meta(get_the_ID(), '_works_company', true); 
            if($company): 
            ?>
                <p class="works-company-name" style="padding:10px;">
                    <?php echo esc_html($company); ?>
                </p>
            <?php endif; ?>

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

    <div class="backbtn" style="margin-top: 80px; text-align: center;">
        <a class="btn-common" href="<?= esc_url(home_url('/#works')); ?>">戻る</a>
    </div>
</main>

<?php get_footer(); ?>