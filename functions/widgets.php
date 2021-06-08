<?php

//ウィジェットの登録
function theme_register_widget() {
    register_widget('PostWidget');
}
add_action('widgets_init', 'theme_register_widget');

//クラスの作成
class PostWidget extends WP_Widget {
    //初期設定
    public function __construct() {
        $widget_options = array(
            'classname' => 'widget-post',
            'description' => '特定の表示を表示する',
            'customize_selective_refresh' => true
        );

        $control_options = array();

        parent::__construct(
            'widget-post',
            '投稿表示',
            $widget_options,
            $control_options,
        );
    }

    //ウィジェットの管理画面上での設定表示
    public function form($instance) {
        $post_id = !empty($instance['post_ids']) ? esc_attr(implode(',', $instance['post_ids'])) : '1';
        ?>
        <!-- 管理画面での表示 -->
        <p>
            <label for="<?php echo $this->get_field_id('post_ids'); ?>"><?php _e('投稿ID（カンマ区切りで入力）:'); ?></label>
            <input 
                type="text" 
                class="widefat" 
                id="<?php echo $this->get_field_id( 'post_ids' ); ?>"
                name="<?php echo $this->get_field_name( 'post_ids' ); ?>"
                value ="<?php echo $post_id; ?>" 
                required
            />
        </p>
        <!-- ここまで -->
        <?php
    }

    //入力フォームの更新
    public function update($new_instance, $old_instance) {
        $instance = $old_instance;

        $instance['post_ids'] = sanitize_text_field($new_instance['post_ids']);
        //数字、カンマのみを受け付ける
        $regex = "/[0-9\, ]+/";
        preg_match($regex, $instance['post_ids'], $matches);
        $matches[0] = str_replace(' ', '', $matches[0]);

        //文字列を配列化
        $post_ids = explode(',', $matches[0]);

        foreach($post_ids as $key => $value) {
            //空白は消す
            if($value == '') {
                unset($post_ids[$key]);
            } else {
                $value = (int)$value;
                //0は許可しない
                if($value == 0) {
                    unset($post_ids[$key]);
                } else {
                    $post_ids[$key] = $value;
                }
            }
        }

        $post_ids = array_values($post_ids);
        $instance['post_ids'] = $post_ids;

        return $instance;
    }

    // ウィジェットのページ上での出力処理
    public function widget($args, $instance) {
        $post_ids = (!empty($instance['post_ids'])) ? $instance['post_ids'] : array(1);
        $query_args = array(
            'post_type' => 'post',
            'post__in' => $post_ids,
            'ignore_sticky_posts' => true,
        );

        echo $args['before_widget'];
        //投稿データを取得
        $my_query = new WP_Query($query_args);
        if($my_query->have_posts());
        ?>

        <!-- オススメ記事一覧 -->
        <div class="swiper-container">
            <div class="swiper-wrapper">
                <?php while($my_query->have_posts()): $my_query->the_post(); ?>
                <div class="swiper-slide post position-relative">
                    <div class="img-container thumbnail-container">
                        <img src="<?= has_post_thumbnail() ? get_the_post_thumbnail_url('', 'full') : get_template_directory_uri() . '/images/no-image.jpg' ?>" alt="<?php the_title(); ?>">
                    </div>
                    <div class="p-2">
                        <h2 class="title"><?php the_title() ?></h2>
                    </div>
                    <a href="<?php the_permalink() ?>" class="stretched-link"></a>
                </div>
                <?php endwhile; ?>
            </div>
            <!-- If we need pagination -->
            <div class="swiper-pagination"></div>

            <!-- If we need navigation buttons -->
            <div class="swiper-button-prev text-success"></div>
            <div class="swiper-button-next text-success"></div>
        </div>
        <!-- ここまで -->

        <?php
        wp_reset_postdata();
        echo $args['after_widget'];
    }
}