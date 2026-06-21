<?php
/**
 * ztheme core.php
 * Core functions inherited from msimple
 */

// Check user login status
function ztheme_check_status() {
    if (is_user_logged_in()) {
        show_admin_bar(true);
    }
}
add_action('ztheme_status', 'ztheme_check_status');

// Markdown parsing
function ztheme_parsedown() {
    if (defined('REST_REQUEST') && REST_REQUEST) {
        return get_the_content();
    }
    
    include_once(get_stylesheet_directory() . "/extend/Parsedown.php");
    $Parsedown = new Parsedown();
    
    $content = get_the_content();
    
    // Replace newlines in blockquotes
    $content = str_replace("a>\r\n", "a><br />", $content);
    $content = str_replace("a>\n", "a><br />", $content);
    
    // CDN image replacement
    if (!empty(of_get_option('cdn'))) {
        $siteurl = get_bloginfo('siteurl');
        $siteurl = str_replace('http://', '', $siteurl);
        $siteurl = str_replace('https://', '', $siteurl);
        $siteurl = rtrim($siteurl, '/');
        $content = str_replace("{$siteurl}/wp-content/uploads/", of_get_option('cdn') . "/wp-content/uploads/", $content);
    }
    
    $content = $Parsedown->text($content);
    $content = str_replace(">\n", ">", $content);
    
    // Replace table with styled class
    $content = str_replace('<table>', '<table class="w-full text-sm text-left text-slate-500 dark:text-slate-400">', $content);
    
    if (is_single() || is_page()) {
        preg_match_all('/href="(.*?)"/', $content, $matches);
        if ($matches) {
            foreach ($matches[1] as $val) {
                if (strpos($val, home_url()) === false) {
                    $content = str_replace("href=\"$val\"", "href=\"$val\" rel=\"external nofollow\" target=\"_blank\"", $content);
                }
            }
        }
        $content = str_replace('<img ', '<img loading="lazy" ', $content);
        echo $content;
    } else {
        $content = strip_tags($content);
        $content = mb_substr($content, 0, 150, 'UTF-8');
        echo $content;
    }
}
add_action('the_content', 'ztheme_parsedown');

// Pagination
function ztheme_pagenavi($range = 4) {
    global $paged, $wp_query;
    if (@!$max_page) {
        $max_page = $wp_query->max_num_pages;
    }
    if ($max_page > 1) {
        if (!$paged) {
            $paged = 1;
        }
        
        echo '<nav class="flex items-center justify-center gap-2" aria-label="Pagination">';
        
        // Previous page
        if ($paged > 1) {
            echo '<a href="' . get_pagenum_link($paged - 1) . '" class="px-3 py-2 text-sm font-medium text-slate-500 dark:text-slate-400 bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-600 rounded-lg hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors">上一页</a>';
        }
        
        // Page numbers
        if ($max_page > $range) {
            if ($paged < $range) {
                for ($i = 1; $i <= ($range + 1); $i++) {
                    if ($i == $paged) {
                        echo '<a href="' . get_pagenum_link($i) . '" class="px-3 py-2 text-sm font-medium bg-primary-500 text-white border border-primary-500 rounded-lg">' . $i . '</a>';
                    } else {
                        echo '<a href="' . get_pagenum_link($i) . '" class="px-3 py-2 text-sm font-medium text-slate-500 dark:text-slate-400 bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-600 rounded-lg hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors">' . $i . '</a>';
                    }
                }
            } elseif ($paged >= ($max_page - ceil(($range / 2)))) {
                for ($i = $max_page - $range; $i <= $max_page; $i++) {
                    if ($i == $paged) {
                        echo '<a href="' . get_pagenum_link($i) . '" class="px-3 py-2 text-sm font-medium bg-primary-500 text-white border border-primary-500 rounded-lg">' . $i . '</a>';
                    } else {
                        echo '<a href="' . get_pagenum_link($i) . '" class="px-3 py-2 text-sm font-medium text-slate-500 dark:text-slate-400 bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-600 rounded-lg hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors">' . $i . '</a>';
                    }
                }
            } elseif ($paged >= $range && $paged < ($max_page - ceil(($range / 2)))) {
                for ($i = ($paged - ceil($range / 2)); $i <= ($paged + ceil(($range / 2))); $i++) {
                    if ($i == $paged) {
                        echo '<a href="' . get_pagenum_link($i) . '" class="px-3 py-2 text-sm font-medium bg-primary-500 text-white border border-primary-500 rounded-lg">' . $i . '</a>';
                    } else {
                        echo '<a href="' . get_pagenum_link($i) . '" class="px-3 py-2 text-sm font-medium text-slate-500 dark:text-slate-400 bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-600 rounded-lg hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors">' . $i . '</a>';
                    }
                }
            }
        } else {
            for ($i = 1; $i <= $max_page; $i++) {
                if ($i == $paged) {
                    echo '<a href="' . get_pagenum_link($i) . '" class="px-3 py-2 text-sm font-medium bg-primary-500 text-white border border-primary-500 rounded-lg">' . $i . '</a>';
                } else {
                    echo '<a href="' . get_pagenum_link($i) . '" class="px-3 py-2 text-sm font-medium text-slate-500 dark:text-slate-400 bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-600 rounded-lg hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors">' . $i . '</a>';
                }
            }
        }
        
        // Next page
        if ($paged < $max_page) {
            echo '<a href="' . get_pagenum_link($paged + 1) . '" class="px-3 py-2 text-sm font-medium text-slate-500 dark:text-slate-400 bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-600 rounded-lg hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors">下一页</a>';
        }
        
        echo '<span class="px-3 py-2 text-sm text-slate-500 dark:text-slate-400">共 ' . $max_page . ' 页</span>';
        echo '</nav>';
    }
}

// Category display
function ztheme_category() {
    $category = get_the_category();
    $caturl = "/category/" . $category[0]->slug;
    echo "<a href='" . $caturl . "'>" . $category[0]->name . "</a>";
}

function get_ztheme_category() {
    $category = get_the_category();
    return $category[0]->name;
}

// Display thumbnail
function ztheme_thumb() {
    $template_uri = get_template_directory_uri();
    
    // CDN replacement
    if (!empty(of_get_option('cdn'))) {
        $siteurl = get_bloginfo('siteurl');
        $siteurl = str_replace('http://', '', $siteurl);
        $siteurl = str_replace('https://', '', $siteurl);
        $siteurl = rtrim($siteurl, '/');
    }
    
    if (has_post_thumbnail()) {
        $img_id = get_post_thumbnail_id();
        $img_url = wp_get_attachment_image_src($img_id, 'medium');
        $img_url = $img_url[0];
        
        if (!empty(of_get_option('cdn'))) {
            $siteurl = get_bloginfo('siteurl');
            $siteurl = str_replace(array('http://', 'https://'), '', $siteurl);
            $siteurl = rtrim($siteurl, '/');
            $img_url = str_replace("{$siteurl}/wp-content/uploads/", of_get_option('cdn') . "/wp-content/uploads/", $img_url);
        }
        
        echo '<a href="' . get_permalink() . '"><img src="' . $img_url . '" alt="' . get_the_title() . '" class="w-full h-full object-cover" loading="lazy"></a>';
    } else {
        $rand = rand(1, 5);
        $img_url = $template_uri . '/static/images/rand' . $rand . '.jpg';
        
        if (!empty(of_get_option('cdn'))) {
            $siteurl = get_bloginfo('siteurl');
            $siteurl = str_replace(array('http://', 'https://'), '', $siteurl);
            $siteurl = rtrim($siteurl, '/');
            $img_url = str_replace("{$siteurl}/wp-content/themes/", of_get_option('cdn') . "/wp-content/themes/", $img_url);
        }
        
        echo '<a href="' . get_permalink() . '"><img src="' . $img_url . '" alt="' . get_the_title() . '" class="w-full h-full object-cover" loading="lazy"></a>';
    }
}

// Post views
function ztheme_get_post_views($post_id) {
    $count_key = 'views';
    $count = get_post_meta($post_id, $count_key, true);
    if ($count == '') {
        delete_post_meta($post_id, $count_key);
        add_post_meta($post_id, $count_key, '0');
        $count = '0';
    }
    echo number_format_i18n($count);
}

function ztheme_set_post_views() {
    global $post;
    $post_id = @$post->ID;
    $count_key = 'views';
    $count = get_post_meta($post_id, $count_key, true);
    
    if (is_single() || is_page()) {
        if ($count == '') {
            delete_post_meta($post_id, $count_key);
            add_post_meta($post_id, $count_key, '0');
        } else {
            update_post_meta($post_id, $count_key, $count + 1);
        }
    }
}
add_action('get_header', 'ztheme_set_post_views');

// Breadcrumbs
function ztheme_breadcrumbs() {
    $chevron = '<svg class="w-3.5 h-3.5 text-slate-300 dark:text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>';
    $home_icon = '<svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>';
    $before = '<span class="text-slate-400 dark:text-slate-500 font-medium">';
    $after = '</span>';
    
    if (!is_home() && !is_front_page() || is_paged()) {
        echo '<nav class="flex items-center flex-wrap gap-y-1 text-sm" aria-label="Breadcrumb">';
        echo '<a href="' . home_url() . '" class="inline-flex items-center gap-1.5 text-slate-500 dark:text-slate-400 hover:text-primary-500 dark:hover:text-primary-400 transition-colors">' . $home_icon . '首页</a>';
        echo '<span class="mx-1.5">' . $chevron . '</span>';
        
        if (is_category()) {
            global $wp_query;
            $cat_obj = $wp_query->get_queried_object();
            $thisCat = $cat_obj->term_id;
            $thisCat = get_category($thisCat);
            $parentCat = get_category($thisCat->parent);
            if ($thisCat->parent != 0) {
                $cat_code = get_category_parents($parentCat, TRUE, ' <span class="mx-1.5">' . $chevron . '</span> ');
                $cat_code = str_replace('<a', '<a class="text-slate-500 dark:text-slate-400 hover:text-primary-500 dark:hover:text-primary-400 transition-colors"', $cat_code);
                echo $cat_code;
            }
            echo $before . single_cat_title('', false) . $after;
        } elseif (is_single()) {
            if (get_post_type() != 'post') {
                $post_type = get_post_type_object(get_post_type());
                $slug = $post_type->rewrite;
                echo '<a href="' . home_url() . '/' . $slug['slug'] . '/" class="text-slate-500 dark:text-slate-400 hover:text-primary-500 dark:hover:text-primary-400 transition-colors">' . $post_type->labels->singular_name . '</a>';
                echo '<span class="mx-1.5">' . $chevron . '</span>';
                echo $before . get_the_title() . $after;
            } else {
                $cat = get_the_category();
                $cat = $cat[0];
                $cat_code = get_category_parents($cat, TRUE, ' <span class="mx-1.5">' . $chevron . '</span> ');
                $cat_code = str_replace('<a', '<a class="text-slate-500 dark:text-slate-400 hover:text-primary-500 dark:hover:text-primary-400 transition-colors"', $cat_code);
                echo $cat_code;
                echo $before . get_the_title() . $after;
            }
        } elseif (is_page()) {
            echo $before . get_the_title() . $after;
        } elseif (is_search()) {
            echo $before . '搜索结果: ' . get_search_query() . $after;
        } elseif (is_tag()) {
            echo $before . '标签: ' . single_tag_title('', false) . $after;
        } elseif (is_author()) {
            global $author;
            $userdata = get_userdata($author);
            echo $before . '作者: ' . $userdata->display_name . $after;
        } elseif (is_404()) {
            echo $before . '页面未找到' . $after;
        }
        
        if (get_query_var('paged')) {
            if (is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author()) {
                echo ' <span class="text-slate-400 ml-1">(第 ' . get_query_var('paged') . ' 页)</span>';
            }
        }
        
        echo '</nav>';
    }
}

// SEO meta tags
function ztheme_seo() {
    $keywords = !empty(of_get_option('keywords')) ? of_get_option('keywords') : get_bloginfo('name');
    $description = !empty(of_get_option('description')) ? of_get_option('description') : get_bloginfo('description');
    
    if (is_home() || is_front_page()) {
        echo '<meta name="keywords" content="' . esc_attr($keywords) . '" />' . "\n\t";
        echo '<meta name="description" content="' . esc_attr($description) . '" />' . "\n";
    } elseif (is_category() || is_tag()) {
        $cat = get_ztheme_category();
        echo '<meta name="keywords" content="' . esc_attr($cat) . '" />' . "\n\t";
        echo '<meta name="description" content="' . esc_attr($description) . '" />' . "\n";
    } elseif (is_search()) {
        $s = isset($_GET['s']) ? strip_tags($_GET['s']) : '';
        echo '<meta name="keywords" content="' . esc_attr($s) . '" />' . "\n\t";
        echo '<meta name="description" content="' . esc_attr($description) . '" />' . "\n";
    } elseif (is_single()) {
        $keywords = get_the_tag_list('', ', ', '');
        $keywords = explode(",", $keywords);
        $newkey = '';
        foreach ($keywords as $value) {
            $value = strip_tags($value);
            $value = trim($value);
            $newkey = $value . ',' . $newkey;
        }
        $category = get_the_category();
        $newkey = $newkey . $category[0]->name;
        
        global $post;
        $content = strip_tags($post->post_content);
        $description = mb_substr($content, 0, 200, 'UTF-8');
        $description = str_replace(array("\r\n", "\n", "\""), array('', '', "'"), $description);
        $description .= '...';
        
        echo '<meta name="keywords" content="' . esc_attr($newkey) . '" />' . "\n\t";
        echo '<meta name="description" content="' . esc_attr($description) . '" />' . "\n";
    } elseif (is_page()) {
        echo '<meta name="keywords" content="' . esc_attr($keywords) . '" />' . "\n\t";
        echo '<meta name="description" content="' . esc_attr($description) . '" />' . "\n";
    } else {
        echo '<meta name="keywords" content="' . esc_attr($keywords) . '" />' . "\n\t";
        echo '<meta name="description" content="' . esc_attr($description) . '" />' . "\n";
    }
}

// Page title
function ztheme_title() {
    if (is_home() || is_front_page()) {
        bloginfo('name');
        echo ' - ';
        bloginfo('description');
    } elseif (is_category() || is_tag()) {
        $cat = get_ztheme_category();
        echo $cat . ' - ';
        bloginfo('name');
    } elseif (is_search()) {
        $s = isset($_GET['s']) ? strip_tags($_GET['s']) : '';
        echo "【" . $s . "】的搜索结果 - ";
        bloginfo('name');
    } elseif (is_single() || is_page()) {
        the_title();
        echo ' - ';
        bloginfo('name');
    } else {
        bloginfo('name');
        echo ' - ';
        bloginfo('description');
    }
}

// Display articles by category
function ztheme_get_article($cid, $num, $cat_title, $cat_url = '') {
    $cat_url = get_category_link(intval($cid));
    echo '<div class="card p-6">';
    echo '<h3 class="text-lg font-semibold mb-4 pb-2 border-b border-slate-200 dark:border-slate-700"><a href="' . $cat_url . '" class="text-slate-800 dark:text-slate-100 hover:text-primary-500 dark:hover:text-primary-400 transition-colors">' . $cat_title . '</a></h3>';
    echo '<ul class="space-y-2">';
    
    $args = array(
        'cat' => $cid,
        'posts_per_page' => $num,
    );
    query_posts($args);
    if (have_posts()) : while (have_posts()) : the_post();
        $articlelink = get_the_permalink();
        $articletitle = get_the_title();
        echo '<li class="truncate">';
        echo '<a href="' . $articlelink . '" class="text-sm text-slate-600 dark:text-slate-400 hover:text-primary-500 dark:hover:text-primary-400 transition-colors">' . $articletitle . '</a>';
        echo '</li>';
    endwhile; endif;
    wp_reset_query();
    
    echo '</ul>';
    echo '</div>';
}
add_action('wp_article', 'ztheme_get_article');

// Single post info
function ztheme_single_info() {
    global $post;
    $categories = get_the_category($post->ID);
}

// Like button AJAX handler
add_action('wp_ajax_nopriv_ztheme_like', 'ztheme_like');
add_action('wp_ajax_ztheme_like', 'ztheme_like');
function ztheme_like() {
    global $wpdb, $post;
    $id = $_POST["um_id"];
    $action = $_POST["um_action"];
    
    if ($action == 'ding') {
        $raters = get_post_meta($id, 'ztheme_ding', true);
        $expire = time() + 99999999;
        $domain = ($_SERVER['HTTP_HOST'] != 'localhost') ? $_SERVER['HTTP_HOST'] : false;
        setcookie('ztheme_ding_' . $id, $id, $expire, '/', $domain, false);
        
        if (!$raters || !is_numeric($raters)) {
            update_post_meta($id, 'ztheme_ding', 1);
        } else {
            update_post_meta($id, 'ztheme_ding', ($raters + 1));
        }
        
        echo get_post_meta($id, 'ztheme_ding', true);
    }
    
    die;
}
