<?php
/**
 * ショートコード
 */

//コード表示時のエスケープ処理
function code_escape($atts, $content = null) {
    return esc_html($content);
}
add_shortcode('code_escape', 'code_escape');

function code_block($atts, $content = null) {
    $atts = shortcode_atts([
        'lang' => 'html',
    ], $atts);
    //htmlspecialchars($content, ENT_QUOTES, 'UTF-8', false)
    // return '<script type="text/plain" class="language-'. esc_attr($atts['lang']) .'">'. $content .'</script>';
    return '<pre class="language-'.$atts['lang'].'"><code>'. htmlspecialchars($content, ENT_QUOTES, 'UTF-8', false) .'</code></pre>';
}
add_shortcode('code_block', 'code_block');