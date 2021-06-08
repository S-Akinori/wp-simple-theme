<?php
/**
 * ファイルのインポート
 */
require_once get_template_directory() . '/functions/widgets.php';
require_once get_template_directory() . '/functions/widgets-area.php';
require_once get_template_directory() . '/functions/shortcodes.php';

add_theme_support('post-thumbnails');

// カスタムヘッダー
function custom_header_setup() {
    $args = array(
        'width' => 1000,
        'height' => 600,
        'flex-width' => true,
        'flex-height' => true,
    );
    add_theme_support( 'custom-header', $args );
}
add_action( 'after_setup_theme', 'custom_header_setup' );

// メニュー
register_nav_menu('mainmenu', 'メインメニュー');

//patination
function the_pagination() {
    global $wp_query;
    $bignum = 999999999;
    if ( $wp_query->max_num_pages <= 1 )
      return;
    echo '<nav class="pagination">';
    echo paginate_links( array(
      'base'         => str_replace( $bignum, '%#%', esc_url( get_pagenum_link($bignum) ) ),
      'format'       => '',
      'current'      => max( 1, get_query_var('paged') ),
      'total'        => $wp_query->max_num_pages,
      'prev_text'    => '&larr;',
      'next_text'    => '&rarr;',
      'type'         => 'list',
      'end_size'     => 3,
      'mid_size'     => 3
    ) );
    echo '</nav>';
}


/** 
 * Removes empty paragraph tags from shortcodes in WordPress.
 */
add_filter('the_content', 'remove_empty_p', 11);
function remove_empty_p($content){
    $content = force_balance_tags($content);
    //return preg_replace('#<p>\s*+(<br\s*/*>)?\s*</p>#i', '', $content);
    return preg_replace('#<p></p>#i', '', $content);
}

/**
 * アーカイブリストにクラスをつける
 */
function my_archives_link ($link_html) {
    $link_html = preg_replace('@<li>@i', '<li class="list-group-item">', $link_html);
    return $link_html;
}
add_filter('get_archives_link', 'my_archives_link');

/**
 * 見出しの作成
 */

function add_heading_id($content) {
    if(is_single()) {
        // codeタグ内のh2,h3タグは無効する
        $pattern = '/<code[^>]*>[\s\S]*?<\/code>/i';
        preg_match_all($pattern, $content, $matches, PREG_SET_ORDER);

        $pattern = '/<h[2-3]>(.*?)<\/h[2-3]>/i';
        foreach($matches as $match) {
            preg_match_all($pattern, $match[0], $removes, PREG_SET_ORDER);
        }

        // 全てのh2, h3タグを取得
        preg_match_all($pattern, $content, $matches, PREG_SET_ORDER);
        
        $i = 0;
        $j = 0;
        $headings = [];
        // 各タグの書き換え&リストの作成
        foreach($matches as $element) {
            $isHeading = true;
            // codeタグ内のhタグは無効
            foreach($removes as $remove) {
                if($element[0] == $remove[0]) {
                    $isHeading = false;
                    break;
                }
            }
            if($isHeading) {
                if(strpos($element[0], '<h2') === 0) { // h2タグの場合
                    $i++;
                    $id = 'heading' . $i;
                    // $heading = preg_replace('/<h2>(.+?)<\/h2>/', '<h2 id="'.$id.'">$1<\h2>', $element[0]);
                    $heading = preg_replace('/<h2>/', '<h2 id="'.$id.'">', $element[0]);
                    $j = 0;
                } else { //h3タグの場合
                    $j++;
                    $id = 'heading' . $i . '_'  .$j;
                    $heading = preg_replace('/<h3>/', '<h3 id="'.$id.'">', $element[0]);
                }
                $content = str_replace($element[0], $heading, $content);
                $headings[] = $heading;
                
            }
            // $content = preg_replace($pattern, $heading, $content, 1);
        }
    }
    return $content;
}
add_action('the_content', 'add_heading_id');

function add_index_of_contents() {
    global $post;
    $content = $post->post_content;
    // codeタグ内のh2,h3タグは無効する
    $pattern = '/<code[^>]*>[\s\S]*?<\/code>/i';
    preg_match_all($pattern, $content, $matches, PREG_SET_ORDER);

    $pattern = '/<h[2-3]>(.*?)<\/h[2-3]>/i';
    foreach($matches as $match) {
        preg_match_all($pattern, $match[0], $removes, PREG_SET_ORDER);
    }

    // 全てのh2, h3タグを取得
    preg_match_all($pattern, $content, $matches, PREG_SET_ORDER);
    
    $list = '<ul class="table-of-contents">';
    $hierarchy = 0;
    $i = 0;
    $j = 0;
    // 各タグの書き換え&リストの作成
    foreach($matches as $element) {
        $isHeading = true;
        // codeタグ内のhタグは無効
        foreach($removes as $remove) {
            if($element[0] == $remove[0]) {
                $isHeading = false;
                break;
            }
        }
        if($isHeading) {
            if(strpos($element[0], '<h2') === 0) { // h2タグの場合
                if($hierarchy == 0) { //1つ前がh2タグの場合, liを閉じる
                    if($i > 1) {
                        $list .= '</li>';
                    }
                } else { // 1つ前がh3タグの場合, h3のul内のli, h3のul, h2のul内のliを閉じる
                    $list .= '</li></ul></li>';
                }
                $i++;
                $id = 'heading' . $i;
                $list .= '<li><a href="#'.$id.'">' . $element[1] . '</a>';
                $hierarchy = 0;
                $j = 0;
            } else { //h3タグの場合
                if($hierarchy == 0) {//1つ前がh2タグの場合, h3用のulを追加
                    $list .= '<ul>' ;
                } else { //1つ前がh2タグの場合, h3用のliを閉じる追加
                    $list .= '</li>' ;
                }
                $j++;
                $id = 'heading' . $i . '_'  .$j;
                $list .= '<li><a href="#'.$id.'">' . $element[1] . '</a>'; 
                $hierarchy = 1;
            }
        }
    }

    if($hierarchy == 0 ) {
        $list .= '</li></ul>';
    } else {
        $list .= '</li></ul></li></ul>';
    }
    return $list;
}
add_shortcode('mokuji', 'add_index_of_contents');

// function add_heading_id($content) {
//     if(is_single()) {
//         // h2, h3タグの部分を取り出す
//         $pattern = '/<h[2-3]>(.*?)<\/h[2-3]>/i';
//         preg_match_all($pattern, $content, $matches, PREG_SET_ORDER);
//         // 見出しを表示するタグの最小個数
//         $min = 3;
//         if(count($matches) > $min) {
//             $toc = '<ul class="table-of-contents">';
//             $hierarchy = 0;
//             $i = 0;
//             // 各タグの書き換え&リストの作成
//             foreach($matches as $element) {
//                 $i++;
//                 $id = 'heading' . $i;
//                 if(strpos($element[0], '<h2') === 0) { // h2タグの場合
//                     // $heading = preg_replace('/<h2>(.+?)<\/h2>/', '<h2 id="'.$id.'">$1<\h2>', $element[0]);
//                     $heading = preg_replace('/<h2>/', '<h2 id="'.$id.'">', $element[0]);
//                     $content = preg_replace($pattern, $heading, $content, 1);
//                     if($hierarchy == 0) { //1つ前がh2タグの場合, liを閉じる
//                         if($i > 1) {
//                             $toc .= '</li>';
//                         }
//                     } else { // 1つ前がh3タグの場合, h3のul内のli, h3のul, h2のul内のliを閉じる
//                         $toc .= '</li></ul></li>';
//                     }
//                     $toc .= '<li><a href="#'.$id.'">' . $element[1] . '</a>';
//                     $hierarchy = 0;
//                 } else { //h3タグの場合
//                     $heading = preg_replace('/<h3>/', '<h3 id="'.$id.'">', $element[0]);
//                     $content = preg_replace($pattern, $heading, $content, 1);
//                     if($hierarchy == 0) {//1つ前がh2タグの場合, h3用のulを追加
//                         $toc .= '<ul>' ;
//                     } else { //1つ前がh2タグの場合, h3用のliを閉じる追加
//                         $toc .= '</li>' ;
//                     }
//                     $toc .= '<li><a href="#'.$id.'">' . $element[1] . '</a>'; 
//                     $hierarchy = 1;
//                 }
//             }

//             if($hierarchy == 0 ) {
//                 $toc .= '</li></ul>';
//             } else {
//                 $toc .= '</li></ul></li></ul>';
//             }
//             $content = $toc . $content;
//         }
//         return $content;
//     }
// }
// add_action('the_content', 'add_heading_id');

/**
 * 管理画面
 */


 //投稿、固定ページにIDを表示
add_filter('manage_posts_columns', 'posts_columns_id', 5);
add_action('manage_posts_custom_column', 'posts_custom_id_columns', 5, 2);
add_filter('manage_pages_columns', 'posts_columns_id', 5);
add_action('manage_pages_custom_column', 'posts_custom_id_columns', 5, 2);
function posts_columns_id($defaults){
$defaults['wps_post_id'] = __('ID');
return $defaults;
}
function posts_custom_id_columns($column_name, $id){
if($column_name === 'wps_post_id'){
echo $id;
}
}