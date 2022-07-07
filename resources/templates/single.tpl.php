<?php get_header(); ?>
<?= do_shortcode('[pagetitle title="BLOG" subtitle="ブログ"]') ?>
<div class="single-page-body bg-gray-200">
    <div class="cont">
        <div class="m-auto max-w-[700px] bg-white p-5 shadow md:p-10">
            <?php if (have_posts()) : ?>
            <?php while (have_posts()) : the_post() ?>
            <div class="mb-5 md:mb-8">
                <h1 class="md:text-[2xl] mb-2 text-xl font-bold">
                    <?= get_the_title() ?>
                </h1>
                <p class="text-right text-sm"><?= do_shortcode('[wpv-post-date format="Y.m.j"]') ?></p>
            </div>
            <div>
                <figure class="mb-5">
                    <img class="h-full w-full object-cover object-center" src="<?= get_the_post_thumbnail_url() ?>"
                        alt="" />
                </figure>
                <div class="blog-body md:p-5">
                    <?php the_content(); ?>
                </div>
            </div>
            <?php endwhile; ?>
            <?php endif; ?>
        </div>
    </div>
</div>



<?php get_footer(); ?>