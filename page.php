<?php get_header(); ?>
<article>
    <div class="container">
        <div class="post-content">
            <?php if(have_posts()) : while(have_posts()) : the_post(); ?>
            <h1 class="post-title"><?php the_title(); ?></h1>
            <?php if(has_post_thumbnail()) : ?>
            <div class="img-container thumbnail">
                <a href="<?php the_permalink() ?>"><img src="<?= get_the_post_thumbnail_url('', 'full') ?>" alt="<?php the_title(); ?>"></a>
            </div>
            <?php endif; ?>
            <div>
                <?php the_content(); ?>
            </div>
            <?php endwhile; endif ?>
        </div>
    </div>
</article>
<?php get_footer(); ?>