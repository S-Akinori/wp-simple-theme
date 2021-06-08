<?php
/**
 * ウェジェットエリア登録
 */
//ヘッダー下
function below_header() {
    register_sidebar(array(
      'id' => 'below_header',
      'name' => 'ヘッダー下',
      'before_widget' => '<div class="recommended-posts">',
      'after_widget' => '</div>'
    ));
}
add_action( 'widgets_init', 'below_header' );

//ヘッダー画像上
function on_header_img() {
    register_sidebar(array(
        'id' => 'on_header_img',
        'name' => 'ヘッダー画像上',
        'before_widget' => '<div id="onHeaderImg">',
        'after_widget' => '</div>'
    ));
}
add_action( 'widgets_init', 'on_header_img' );