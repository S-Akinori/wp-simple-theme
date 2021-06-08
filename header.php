<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <?php if(is_category()): ?>
        <?php elseif(is_archive()):?>
        <meta name="robots" content="noindex, follow">
        <?php elseif(is_search()): ?>
        <meta name="robots" content="noindex, follow">
        <?php elseif(is_tag()):?>
        <meta name="robots" content="noindex, follow">
        <?php elseif(is_paged()): ?>
        <meta name="robots" content="noindex, follow">
        <?php endif; ?>

        <title>
        <?php
        global $page, $paged;
        bloginfo('name');
        if(is_front_page()):
        elseif(is_single()):
        wp_title('|',true,'right');
        elseif(is_page()):
        wp_title('|',true,'right');
        elseif(is_archive()):
        wp_title('|',true,'right');
        elseif(is_search()):
        wp_title('|',true,'right');
        elseif(is_404()):
        echo'404 |';
        endif;
        if($paged >= 2 || $page >= 2):
        echo'-'.sprintf('%sページ',
        max($paged,$page));
        endif;
        ?>
        </title>

        <?php if(is_single() || is_page()) { 
            $type = 'article';

            if(has_post_thumbnail()) {
                $img = get_the_post_thumbnail_url('', 'full');
            } else {
                $img = get_template_directory_uri() . '/images/no-image.jpg';
            }

            if($post->post_excerpt) { 
                $description = $post->post_excerpt;
            } else {
                $description = strip_tags($post->post_content);
                $description = str_replace("\n", "", $description);
                $description = mb_substr($description, 0, 120). "...";
            }
        } else {
            $type = 'website';
            $img = get_template_directory_uri() . '/images/no-image.jpg';
            $description = get_the_title();
        }?>

        <meta property="og:description" content="<?php echo $description ?>">

        <!-- OGP -->
        <meta property="fb:app_id" content="Facebook ID">
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:site" content="@username">
        <meta name="twitter:creator" content="@username">
        <meta name="twitter:title" content="<?php the_title() ?>">
        <meta name="twitter:description" content="<?php echo $description ?>">

        <meta property="og:type" content="<?php echo $type ?>">
        <meta property="og:url" content="<?php the_permalink(); ?>">
        <meta property="og:image" content="<?php echo $img ?>">
        <meta property="og:title" content="<?php the_title(); ?>">
        <meta property="og:description" content="<?php echo $description ?>">
        <meta property="og:site_name" content="<?php bloginfo('name'); ?>">


        <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/style.css">

        <?php wp_head(); ?>
    </head>
    <body class="line-numbers">
        <header>
            <nav class="navbar navbar-expand-lg">
                <h1 class="logo"><a href="<?= home_url(); ?>">Worpdressテーマ</a></h1>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navContent" aria-controls="navContent" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fas fa-bars"></i>
                </button>
                <div class="collapse navbar-collapse" id="navContent">
                    <div class="navbar-nav">
                        <div class="dropdown">
                            <button class="btn dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                サンプル
                            </button>
                            <div class="dropdown-menu" id="dropdownMenuButton">
                                <a class="nav-link" href="category/sample">Sample</a>
                                <a class="nav-link" href="category/sample1">Sample1</a>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>
            <?php if(!empty(get_header_image()) && (is_home() || is_front_page())) :?>
            <div id="headerImgContainer" class="position-relative">
                <img src="<?= header_image() ?>" alt="<?php bloginfo('name') ?>">
                <?php if(is_active_sidebar('on_header_img')) : ?>
                    <?php dynamic_sidebar('on_header_img'); ?>
                <?php endif; ?>
            </div>
            <?php endif; ?>
        </header>
    <main class="my-5">