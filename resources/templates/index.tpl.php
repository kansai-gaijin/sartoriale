<?php get_header(); ?>
<?= do_shortcode('[pagetitle title="BLOG" subtitle="ブログ"]') ?>
<div class="single-page-body">
    <div class="cont">
        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 md:grid-cols-3 md:gap-5 lg:grid-cols-4 lg:gap-10">
            <?php if (have_posts()) : ?>
            <?php while (have_posts()) : the_post() ?>
            <div>
                <article class="w-full">
                    <a class="bloc transition hover:opacity-60" href="<?= get_the_permalink() ?>">
                        <figure class="relative h-full w-full shadow">
                            <img class="h-full w-full object-cover object-center"
                                src="<?= get_the_post_thumbnail_url() ?>" alt="" />
                            <figcaption class="absolute left-0 bottom-0 w-full p-3 font-bold"
                                style="box-sizing:border-box">
                                <div class="bg-white/70 p-3 ">
                                    <p class="text-[9px] font-black">
                                        <?= do_shortcode('[wpv-post-date format="Y.m.j"]') ?>
                                    </p>
                                    <p class="text-[13.5px] font-black line-clamp-1">
                                        <?= get_the_title() ?>
                                    </p>
                                </div>
                            </figcaption>
                        </figure>
                    </a>
                </article>
            </div>
            <?php endwhile; ?>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php get_footer(); ?>