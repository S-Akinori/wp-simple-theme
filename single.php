<?php get_header(); ?>
<article>
    <div class="container">
        <div class="row">
            <div class="col-md-8 post-content">
                <?php if(have_posts()) : while(have_posts()) : the_post(); ?>
                <h1 class="post-title"><?php the_title(); ?></h1>
                <?php the_date(); ?>
                <?php if(has_post_thumbnail()) : ?>
                <div class="img-container thumbnail">
                    <img src="<?= get_the_post_thumbnail_url('', 'full') ?>" alt="<?php the_title(); ?>">
                </div>
                <?php endif; ?>
                <div>
                    <?php the_content(); ?>
                </div>
                <?php endwhile; endif ?>
            </div>
            <div class="col-md-4">
                <?php get_sidebar(); ?>
            </div>
        </div>
    </div>
</article>
<?php get_footer(); ?>