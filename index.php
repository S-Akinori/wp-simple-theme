<?php get_header(); ?>
    <?php if(is_active_sidebar('below_header')) : ?>
        <?php dynamic_sidebar('below_header'); ?>
    <?php endif; ?>
    <div class="container">
        <div class="row">
            <div class="col-lg-8 posts">
                <h2 class="title">記事一覧</h2>
                <div>
                    <?php if(have_posts()) : while(have_posts()) : the_post(); ?>
                        <div class="post position-relative mb-3 p-2">
                            <div class="row">
                                <div class="col-md-5 img-container thumbnail-container">
                                    <img src="<?= has_post_thumbnail() ? get_the_post_thumbnail_url('', 'full') : get_template_directory_uri() . '/images/no-image.jpg' ?>" alt="<?php the_title(); ?>">
                                </div>
                                <div class="col-md-7">
                                    <h2 class="title"><?php the_title() ?></h2>
                                    <p class="description"><?php the_excerpt() ?></p>
                                </div>
                            </div>
                            <a href="<?php the_permalink() ?>" class="stretched-link"></a>
                        </div>
                    <?php endwhile; endif; ?>
                </div>
                <?php if( function_exists("the_pagination") ) the_pagination(); ?>
            </div>
            <div class="col-lg-4">
                <?php get_sidebar(); ?>            
            </div>
        </div>
    </div>
<?php get_footer(); ?>