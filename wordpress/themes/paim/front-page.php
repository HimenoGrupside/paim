<?php get_header(); ?>
    <div class="fv">
        <h1><img src="<?= get_template_directory_uri() ?>/images/logo.svg" alt="PAIM"></h1>
        <img class="arrow" src="<?= get_template_directory_uri() ?>/images/arrow.svg" alt="arrow">
    </div>

    <div class="top-content-area">
        <p class="top-content-message">PAIM は、広告制作・<br class="sp">イベント企画・映像・PR を横断し、<br>企業のコミュニケーションを支援するプロモーションカンパニーです。</p>
        <div class="box">
            <ul>
                <li><span>CREATIVE<br>DIRECTION</span>クリエイティブ<br>制作</li>
                <li><span>EVENT<br>PROMOTION</span>イベント企画<br>プロモーション</li>
                <li><span>MOVIE<br>PROMOTION</span>CM・PR 制作</li>
                <li><span>PROJECT<br>BRANDING</span>企業・事業<br>ブランディング</li>
            </ul>
            <p>企画立案からビジュアル開発、<br class="sp">現場運営までをワンストップで提供し、<br>ブランドの持つ価値を正しく伝えるための<br class="sp">クリエイティブを設計します。</p>
        </div>
    </div>

    <div class="wrapper">
        <div class="works-area l-container-width" id="works">
            <h2>WORKS<span>実績紹介</span></h2>
            <ul id="works-list">
                <?php
                $args = array(
                    'post_type'      => 'works',
                    'posts_per_page' => 7, // 最初に出す数
                    'paged'          => 1,
                );
                $works_query = new WP_Query($args);
                ?>

                <?php if ($works_query->have_posts()) : ?>
                    <?php while ($works_query->have_posts()) : $works_query->the_post(); ?>
                        <li>
                            <a href="<?php the_permalink(); ?>">
                                <?php if (has_post_thumbnail()) : ?>
                                    <?php the_post_thumbnail('large'); ?>
                                <?php else : ?>
                                    <img src="<?php echo get_template_directory_uri(); ?>/images/dammy-g.png" alt="ダミー画像">
                                <?php endif; ?>
                                
                                <div>
                                    <p class="company-name"><?php echo get_post_meta(get_the_ID(), '_works_company', true); ?></p>
                                    <p class="title-name"><?php the_title(); ?></p>
                                </div>
                            </a>
                        </li>                   
                     <?php endwhile; ?>
                    <?php wp_reset_postdata(); ?>
                <?php endif; ?>
            </ul>
            
            <div class="btn-center">
                <button id="load-more-works" class="btn-common" data-page="1">and more</button>
            </div>
        </div>       

        <div class="news-area l-container-100" id="news">
            <div class="l-container-width">
                <h2>NEWS<span>新着情報</span></h2>
                <ul>
                    <?php
                    // 最新の3件を取得x
                    $args = array(
                        'post_type'      => 'post',      
                        'posts_per_page' => 3,           
                    );
                    $news_query = new WP_Query($args);
                    ?>

                    <?php if ($news_query->have_posts()) : ?>
                        <?php while ($news_query->have_posts()) : $news_query->the_post(); ?>
                        <li>
                            <a href="<?php the_permalink(); ?>">
                                <?php if (has_post_thumbnail()) : ?>
                                    <?php the_post_thumbnail('medium'); ?>
                                <?php else : ?>
                                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/dammy.png" alt="ダミー画像">
                                <?php endif; ?>
                                
                                <div class="news-text-content">
                                    <p class="date"><?php echo get_the_date('Y.m.d'); ?></p>
                                    <p class="title"><?php the_title(); ?></p>
                                </div>
                            </a>
                        </li>                       
                         <?php endwhile; ?>
                        <?php wp_reset_postdata(); ?>
                    <?php else : ?>
                        <li>お知らせはまだありません。</li>
                    <?php endif; ?>
                </ul>
                <a href="<?php echo esc_url(home_url('/news/')); ?>" class="btn-common">past more</a>
            </div>
        </div>


        <div class="about-area l-container-width" id="aboutus">
            <h2>ABOUT US<span>会社概要</span></h2>
            <dl>
                <dt>名称</dt>
                <dd>株式会社 パイン　PAIM-inc</dd>
            </dl>
            <dl>
                <dt>設立</dt>
                <dd>2020年 3月</dd>
            </dl>
            <dl>
                <dt>資本金</dt>
                <dd>3,000,000 円</dd>
            </dl>
            <dl>
                <dt>事業内容</dt>
                <dd>テレビ、web、ラジオ コマーシャルの企画・制作、<br>エンターテインメントコンテンツの企画・制作（映画、TV 番組、PV、MV）</dd>
            </dl>
            <dl>
                <dt>本社</dt>
                <dd>東京都港区六本木3-16-35 イースト六本木ビル603</dd>
            </dl>
            <dl>
                <dt>取引銀行</dt>
                <dd>三井住友銀行、　りそな銀行、　みずほ銀行、　東日本銀行　他</dd>
            </dl>
            <dl>
                <dt>関連会社</dt>
                <dd>
                    <table>
                        <tr>
                            <td>［三田オフィス］</td>
                            <td>東京都港区芝四丁目7 番6 号 芝ビルディング704</td>
                        </tr>
                        <tr>
                            <td>［戸田オフィス／ウエアハウス］</td>
                            <td>埼玉県戸田市上戸田2-30-16 white cube steel</td>
                        </tr>
                    </table>
                 </dd>
            </dl>
            <dl>
                <dt>従業員</dt>
                <dd>5 名（契約社員含む）</dd>
            </dl>
            <dl>
                <dt>PAIM i nc.代表</dt>
                <dd>木村 章秀　Akihide Kimura</dd>
            </dl>
            <dl class="only-dd">
                <dd>2004 年より広告代理店 株式会社CIRCUS にて広告業務全般＋アスリートのマネージメントに携わる。<br>2012 年より株式会社コラージュへ入社。広告業務全般に加えて、テレビ局事業部のイベント企画制作やTVCF・TV 番組・<br>WEB 動画・映画制作など、プロデューサー／ディレクターとして活動。</dd>
            </dl>

        </div>

        <div class="contact-area l-container-100" id="contact">
            <div class="l-container-width">
                <h2>CONTACT<span>お問い合わせ</span></h2>
                <p>当社へのお問い合わせやご相談につきましては、下記メールフォームにて承っております。お気軽にどうぞ。</p>
                <?php echo apply_filters('the_content', '<!-- wp:snow-monkey-forms/snow-monkey-form {"formId":28} /-->'); ?>
            </div>
        </div>

    </div><!-- .wrapper -->

    <div class="map-area">
        <iframe src="https://www.google.com/maps/embed?pb=!1m16!1m12!1m3!1d3242.1336113094935!2d139.74981217578625!3d35.64907962259769!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!2m1!1z5p2x5Lqs6YO95riv5Yy66Iqd5Zub5LiB55uuNyDnlao2IOWPtyDoip3jg5Pjg6vjg4fjgqPjg7PjgrA3MDQ!5e0!3m2!1sja!2sjp!4v1771307134940!5m2!1sja!2sjp" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    </div>



<?php get_footer(); ?>