<aside id="sideBar" class="my-3">
    <div class="profile">
        <div class="img-container">
            <img src="<?php echo get_template_directory_uri(); ?>/images/profile.jpg" alt="">
        </div>
        <div>
            <p class="title">一般人です。</p>
            <p>ここに自己紹介文が入ります。ここに自己紹介文が入ります。ここに自己紹介文が入ります。ここに自己紹介文が入ります。ここに自己紹介文が入ります。</p>
        </div>
    </div>

    <div class="category my-3">
        <h2 class="title">カテゴリー</h2>
        <?php $categories = get_categories(); if($categories) : ?>
        <ul class="list-group">
            <?php foreach($categories as $category) :?>
            <li class="list-group-item"><a href="<?= get_category_link($category->term_id) ?>"><?= $category->name ?></a></li>
            <?php endforeach; ?>
        </ul>
        <?php else: ?>
            <p>カテゴリーがありません</p>
        <?php endif ; ?>
    </div>

    <!-- <div class="portfolio my-3">
        <h2 class="title">ポートフォリオ</h2>
        <ul class="list-group">
            <li class="list-group-item"><a href="">1月 0記事</a></li>
            <li class="list-group-item"><a href="">1月 0記事</a></li>
            <li class="list-group-item"><a href="">1月 0記事</a></li>
        </ul>
    </div> -->
    <div class="archive my-3">
        <h2 class="title">アーカイブ</h2>
        <ul class="list-group">
            <?php
                $args = array(
                    'show_post_count' => true
                );
                wp_get_archives($args); 
            ?>
        </ul>
    </div>
</aside>