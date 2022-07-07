<?php get_header(); ?>
<?php if (have_posts()) : ?>
    <?php while (have_posts()) : the_post() ?>
        <?php
            /**
             * Functions hooked into `theme/single/content` action.
             *
             * @hooked Glanz\Theme\App\Structure\render_post_content - 10
             */
            do_action('theme/single/content');
        ?>
    <?php endwhile; ?>
<?php endif; ?>
<?php get_footer(); ?>