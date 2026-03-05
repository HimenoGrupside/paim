    <footer>
        <ul>
            <li><a href="<?= esc_url(home_url('/#works')); ?>">WORKS</a></li>
            <li><a href="<?= esc_url(home_url('/#news')); ?>">NEWS</a></li>
            <li><a href="<?= esc_url(home_url('/#aboutus')); ?>">ABOUT US</a></li>
            <li><a href="<?= esc_url(home_url('/#contact')); ?>">CONTACT</a></li>
        </ul>
        <div>
            <img src="<?= get_template_directory_uri() ?>/images/logo.svg" alt="PAIM">
        </div>
    </footer>
    <small>© PAIM CO.,LTD ALL RIGHT RESERVED.</small>
<?php wp_footer(); ?>
</body>
</html>


