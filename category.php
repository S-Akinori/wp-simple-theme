<?php get_header(); ?>
<div class="container">
    <div class="row">
        <div class="col-sm-8 posts">
            <h2 class="title">カテゴリー： <?php single_cat_title(); ?></h2>
            <div class="row">
                <?php if(have_posts()) : while(have_posts()) : the_post(); ?>
                    <div class="col-sm-6">
                        <div class="post">
                            <div class="img-container">
                                <a href="<?php the_permalink() ?>"><img src="<?= has_post_thumbnail() ? get_the_post_thumbnail_url('', 'full') : get_template_directory_uri() . '/images/no-image.jpg' ?>" alt="<?php the_title(); ?>"></a>
                            </div>
                            <div class="mx-2">
                                <h2 class="title"><a href="<?php the_permalink() ?>"><?php the_title() ?></a></h2>
                                <p class="description">ここに抜粋文が入ります。だいたい100文字くらいかな？</p>
                            </div>
                        </div>
                    </div>
                <?php endwhile; endif; ?>
            </div>
        </div>
        <div class="col-12 col-sm-4">
            <?php get_sidebar(); ?>            
        </div>
    </div>
</div>
<?php get_footer() ?>