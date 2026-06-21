<?php
/**
 * ztheme functions.php
 * Modern WordPress theme with Tailwind CSS and Alpine.js
 */

// Load core functions
get_template_part('core');

// Exclude categories from homepage
function ztheme_exclude_category_home($query) {
    if ($query->is_home) {
        // Add category IDs to exclude, e.g., '-965,-802,-1157'
        // $query->set('cat', '-965,-802,-1157');
    }
    return $query;
}
add_filter('pre_get_posts', 'ztheme_exclude_category_home');

// Register styles and scripts
function ztheme_enqueue_assets() {
    $theme_version = wp_get_theme()->get('Version');
    $template_uri = get_template_directory_uri();
    
    // Main stylesheet (Tailwind CSS)
    wp_enqueue_style('ztheme-style', $template_uri . '/dist/styles.css', array(), $theme_version);
    
    // Theme style.css
    wp_enqueue_style('ztheme-style-css', $template_uri . '/style.css', array(), $theme_version);
    
    // Highlight.js CSS
    wp_enqueue_style('ztheme-highlight', $template_uri . '/static/css/monokai-sublime.min.css', array(), '11.9.0');
    
    // Highlight.js
    wp_enqueue_script('ztheme-highlight', $template_uri . '/static/js/highlight.min.js', array(), '11.9.0', true);
    
    // Alpine.js
    wp_enqueue_script('ztheme-alpine', $template_uri . '/static/js/alpine.min.js', array(), '3.13.0', true);
    
    // Main app JS
    wp_enqueue_script('ztheme-app', $template_uri . '/static/js/app.js', array('ztheme-highlight'), $theme_version, true);
    
    // Comment reply script
    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}
add_action('wp_enqueue_scripts', 'ztheme_enqueue_assets');

// Theme setup
function ztheme_setup() {
    // Register navigation menus
    register_nav_menus(array(
        'header-menu' => __('Header Navigation', 'ztheme'),
        'mobile_menu' => __('Mobile Menu', 'ztheme'),
    ));
    
    // Enable post thumbnails
    add_theme_support('post-thumbnails');
    
    // Title tag support
    add_theme_support('title-tag');
    
    // HTML5 support
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ));
    
    // Custom logo support
    add_theme_support('custom-logo', array(
        'height'      => 60,
        'width'       => 200,
        'flex-height' => true,
        'flex-width'  => true,
    ));
}
add_action('after_setup_theme', 'ztheme_setup');

// Load Options Framework
if (!function_exists('optionsframework_init')) {
    define('OPTIONS_FRAMEWORK_DIRECTORY', get_template_directory_uri() . '/inc/');
    require_once dirname(__FILE__) . '/inc/options-framework.php';
}
add_action('optionsframework_custom_scripts', 'ztheme_optionsframework_custom_scripts');
function ztheme_optionsframework_custom_scripts() {
    // Custom scripts for options framework
}

// Custom Nav Walker for Tailwind CSS
class Ztheme_Nav_Walker extends Walker_Nav_Menu {
    
    function start_lvl(&$output, $depth = 0, $args = array()) {
        $indent = str_repeat("\t", $depth);
        $output .= "\n{$indent}<div class=\"absolute left-0 mt-2 w-48 bg-white dark:bg-slate-800 rounded-xl shadow-lg border border-slate-200 dark:border-slate-700 py-2 z-50 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 transform scale-95 group-hover:scale-100\">\n";
        $output .= "{$indent}<ul class=\"py-1\">\n";
    }
    
    function end_lvl(&$output, $depth = 0, $args = array()) {
        $indent = str_repeat("\t", $depth);
        $output .= "{$indent}</ul>\n";
        $output .= "{$indent}</div>\n";
    }
    
    function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0) {
        $indent = ($depth) ? str_repeat("\t", $depth) : '';
        
        $classes = empty($item->classes) ? array() : (array) $item->classes;
        $classes[] = 'menu-item-' . $item->ID;
        
        $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args));
        
        // Add Tailwind classes based on depth
        if ($depth === 0) {
            $class_names .= ' relative group';
        } else {
            $class_names .= '';
        }
        
        $class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';
        
        $id = apply_filters('nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args, $depth);
        $id = $id ? ' id="' . esc_attr($id) . '"' : '';
        
        $output .= $indent . '<li' . $id . $class_names . '>';
        
        $atts = array();
        $atts['title']  = !empty($item->attr_title) ? $item->attr_title : '';
        $atts['target'] = !empty($item->target) ? $item->target : '';
        $atts['rel']    = !empty($item->xfn) ? $item->xfn : '';
        $atts['href']   = !empty($item->url) ? $item->url : '';
        $atts['class']  = ($depth === 0) ? 'nav-link block' : 'block px-4 py-2 text-sm text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 transition-colors';
        
        if (in_array('current-menu-item', $classes)) {
            $atts['class'] .= ' active';
        }
        
        $atts = apply_filters('nav_menu_link_attributes', $atts, $item, $args, $depth);
        
        $attributes = '';
        foreach ($atts as $attr => $value) {
            if (!empty($value)) {
                $value = ('href' === $attr) ? esc_url($value) : esc_attr($value);
                $attributes .= ' ' . $attr . '="' . $value . '"';
            }
        }
        
        $title = apply_filters('the_title', $item->title, $item->ID);
        $title = apply_filters('nav_menu_item_title', $title, $item, $args, $depth);
        
        $item_output = $args->before;
        $item_output .= '<a' . $attributes . '>';
        $item_output .= $args->link_before . $title . $args->link_after;
        $item_output .= '</a>';
        $item_output .= $args->after;
        
        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
    }
    
    function end_el(&$output, $item, $depth = 0, $args = array()) {
        $output .= "</li>\n";
    }
}

// Mobile menu walker
class Ztheme_Mobile_Walker extends Walker_Nav_Menu {
    
    function start_lvl(&$output, $depth = 0, $args = array()) {
        $indent = str_repeat("\t", $depth);
        $output .= "\n{$indent}<ul class=\"pl-4 space-y-1\">\n";
    }
    
    function end_lvl(&$output, $depth = 0, $args = array()) {
        $indent = str_repeat("\t", $depth);
        $output .= "{$indent}</ul>\n";
    }
    
    function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0) {
        $indent = ($depth) ? str_repeat("\t", $depth) : '';
        
        $classes = empty($item->classes) ? array() : (array) $item->classes;
        $classes[] = 'menu-item-' . $item->ID;
        
        $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args));
        $class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';
        
        $id = apply_filters('nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args, $depth);
        $id = $id ? ' id="' . esc_attr($id) . '"' : '';
        
        $output .= $indent . '<li' . $id . $class_names . '>';
        
        $atts = array();
        $atts['title']  = !empty($item->attr_title) ? $item->attr_title : '';
        $atts['target'] = !empty($item->target) ? $item->target : '';
        $atts['rel']    = !empty($item->xfn) ? $item->xfn : '';
        $atts['href']   = !empty($item->url) ? $item->url : '';
        $atts['class']  = 'block px-4 py-3 text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 rounded-lg transition-colors';
        
        if (in_array('current-menu-item', $classes)) {
            $atts['class'] .= ' text-primary-500 bg-primary-50 dark:bg-primary-900/20';
        }
        
        $atts = apply_filters('nav_menu_link_attributes', $atts, $item, $args, $depth);
        
        $attributes = '';
        foreach ($atts as $attr => $value) {
            if (!empty($value)) {
                $value = ('href' === $attr) ? esc_url($value) : esc_attr($value);
                $attributes .= ' ' . $attr . '="' . $value . '"';
            }
        }
        
        $title = apply_filters('the_title', $item->title, $item->ID);
        $title = apply_filters('nav_menu_item_title', $title, $item, $args, $depth);
        
        $item_output = $args->before;
        $item_output .= '<a' . $attributes . '>';
        $item_output .= $args->link_before . $title . $args->link_after;
        $item_output .= '</a>';
        $item_output .= $args->after;
        
        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
    }
    
    function end_el(&$output, $item, $depth = 0, $args = array()) {
        $output .= "</li>\n";
    }
}

// Add login/logout link to menu (disabled)
// function ztheme_login_logout_link($items, $args) {
//     if ($args->theme_location === 'header-menu' || $args->theme_location === 'mobile_menu') {
//         if (is_user_logged_in()) {
//             $items .= '<li class="menu-item"><a href="/wp-admin/" class="nav-link">后台管理</a></li>';
//         }
//     }
//     return $items;
// }
// add_filter('wp_nav_menu_items', 'ztheme_login_logout_link', 10, 2);

// Register widgets
function ztheme_widgets_init() {
    register_sidebar(array(
        'name'          => 'Sidebar',
        'id'            => 'sidebar1',
        'before_widget' => '<div class="mb-6">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="text-lg font-semibold text-slate-800 dark:text-slate-100 mb-4 pb-2 border-b border-slate-200 dark:border-slate-700">',
        'after_title'   => '</h3>',
    ));
    
    register_sidebar(array(
        'name' => 'Footer Column 1',
        'id'   => 'footer1',
        'before_widget' => '<div class="footer-widget mb-4">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="text-base font-semibold text-white mb-3">',
        'after_title'   => '</h4>',
    ));
    
    register_sidebar(array(
        'name' => 'Footer Column 2',
        'id'   => 'footer2',
        'before_widget' => '<div class="footer-widget mb-4">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="text-base font-semibold text-white mb-3">',
        'after_title'   => '</h4>',
    ));
    
    register_sidebar(array(
        'name' => 'Footer Column 3',
        'id'   => 'footer3',
        'before_widget' => '<div class="footer-widget mb-4">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="text-base font-semibold text-white mb-3">',
        'after_title'   => '</h4>',
    ));
    
    register_sidebar(array(
        'name' => 'Footer Column 4',
        'id'   => 'footer4',
        'before_widget' => '<div class="footer-widget mb-4">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="text-base font-semibold text-white mb-3">',
        'after_title'   => '</h4>',
    ));
}
add_action('widgets_init', 'ztheme_widgets_init');

// Search widget
function ztheme_search_widget() {
?>
<div class="sidebar">
    <form class="relative" action="/" method="GET">
        <input type="text" name="s" placeholder="搜索文章..." class="input-field pr-10" autocomplete="off">
        <button type="submit" class="absolute right-2 top-1/2 -translate-y-1/2 p-1.5 text-slate-400 hover:text-primary-500 transition-colors">
            <i class="fa-solid fa-magnifying-glass text-base"></i>
        </button>
    </form>
</div>
<?php
}

// Recent Comments Widget
class Ztheme_Recent_Comments_Widget extends WP_Widget {
    
    public function __construct() {
        parent::__construct(
            'ztheme_recent_comments',
            '最新评论',
            array('description' => '显示最新评论')
        );
    }
    
    public function widget($args, $instance) {
        echo '<div class="card p-6 mb-6 hidden md:block">';
        if (!empty($instance['title'])) {
            echo $args['before_title'] . apply_filters('widget_title', $instance['title']) . $args['after_title'];
        }
        
        $number = !empty($instance['number']) ? absint($instance['number']) : 5;
        $exclude_admin = !empty($instance['exclude_admin']) ? $instance['exclude_admin'] : false;
        
        $comment_args = array('number' => $number, 'status' => 'approve');
        
        if ($exclude_admin === 'on') {
            $admins = get_users(array('role' => 'Administrator'));
            $admin_comments = get_comments(array('status' => 'approve', 'user_id' => wp_list_pluck($admins, 'ID')));
            $comment_args['comment__not_in'] = wp_list_pluck($admin_comments, 'comment_ID');
        }
        
        $recent_comments = get_comments($comment_args);
        echo '<ul class="space-y-3">';
        foreach ($recent_comments as $comment) {
            $comment_link = get_comment_link($comment);
            echo '<li class="flex items-start gap-3 p-2 -mx-2 rounded-lg hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors">';
            echo get_avatar($comment->comment_author_email, 36, '', '', array('class' => 'rounded-full border-2 border-slate-100 dark:border-slate-600'));
            echo '<div class="min-w-0 flex-1">';
            echo '<a href="' . esc_url($comment_link) . '" class="text-sm font-medium text-slate-700 dark:text-slate-300 hover:text-primary-500 dark:hover:text-primary-400 transition-colors">' . esc_html($comment->comment_author) . '</a>';
            echo '<p class="text-sm text-slate-600 dark:text-slate-400 mt-0.5 truncate">' . mb_substr($comment->comment_content, 0, 50) . '</p>';
            echo '</div>';
            echo '</li>';
        }
        echo '</ul>';
        
        echo '</div>';
    }
    
    public function form($instance) {
        $title = !empty($instance['title']) ? $instance['title'] : '最新评论';
        $number = !empty($instance['number']) ? absint($instance['number']) : 5;
        $exclude_admin = !empty($instance['exclude_admin']) ? $instance['exclude_admin'] : false;
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>">标题:</label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>">
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('number'); ?>">评论数量:</label>
            <input class="widefat" id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="number" value="<?php echo esc_attr($number); ?>">
        </p>
        <p>
            <input class="checkbox" type="checkbox" <?php checked($exclude_admin, 'on'); ?> id="<?php echo $this->get_field_id('exclude_admin'); ?>" name="<?php echo $this->get_field_name('exclude_admin'); ?>">
            <label for="<?php echo $this->get_field_id('exclude_admin'); ?>">排除管理员评论</label>
        </p>
        <?php
    }
    
    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = !empty($new_instance['title']) ? strip_tags($new_instance['title']) : '';
        $instance['number'] = !empty($new_instance['number']) ? absint($new_instance['number']) : 5;
        $instance['exclude_admin'] = !empty($new_instance['exclude_admin']) ? $new_instance['exclude_admin'] : false;
        return $instance;
    }
}

function ztheme_register_recent_comments_widget() {
    register_widget('Ztheme_Recent_Comments_Widget');
}
add_action('widgets_init', 'ztheme_register_recent_comments_widget');

// Recent Posts Widget
class Ztheme_Recent_Posts_Widget extends WP_Widget {
    
    public function __construct() {
        parent::__construct(
            'ztheme_recent_posts',
            '最新文章',
            array('description' => '显示最新发布的文章')
        );
    }
    
    public function widget($args, $instance) {
        echo '<div class="card p-6 mb-6 hidden md:block">';
        
        if (!empty($instance['title'])) {
            echo $args['before_title'] . apply_filters('widget_title', $instance['title']) . $args['after_title'];
        }
        
        $number = !empty($instance['number']) ? absint($instance['number']) : 5;
        
        $recent_posts = wp_get_recent_posts(array(
            'numberposts' => $number,
            'post_status' => 'publish',
            'orderby' => 'post_date',
            'order' => 'DESC'
        ));
        
        echo '<ul class="space-y-3">';
        foreach ($recent_posts as $post) {
            echo '<li class="flex items-start gap-3 p-2 -mx-2 rounded-lg hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors">';
            
            if (has_post_thumbnail($post['ID'])) {
                echo '<a href="' . get_permalink($post['ID']) . '" class="flex-shrink-0">';
                echo get_the_post_thumbnail($post['ID'], 'thumbnail', array('class' => 'w-12 h-12 rounded-lg object-cover'));
                echo '</a>';
            }
            
            echo '<div class="min-w-0 flex-1">';
            echo '<a href="' . get_permalink($post['ID']) . '" class="text-sm text-slate-700 dark:text-slate-300 hover:text-primary-500 dark:hover:text-primary-400 transition-colors truncate block">' . esc_html($post['post_title']) . '</a>';
            echo '<span class="text-xs text-slate-400 dark:text-slate-500">' . get_the_date('Y-m-d', $post['ID']) . '</span>';
            echo '</div>';
            
            echo '</li>';
        }
        echo '</ul>';
        
        echo '</div>';
    }
    
    public function form($instance) {
        $title = !empty($instance['title']) ? $instance['title'] : '最新文章';
        $number = !empty($instance['number']) ? absint($instance['number']) : 5;
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>">标题:</label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>">
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('number'); ?>">文章数量:</label>
            <input class="widefat" id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="number" value="<?php echo esc_attr($number); ?>">
        </p>
        <?php
    }
    
    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = !empty($new_instance['title']) ? strip_tags($new_instance['title']) : '';
        $instance['number'] = !empty($new_instance['number']) ? absint($new_instance['number']) : 5;
        return $instance;
    }
}

function ztheme_register_recent_posts_widget() {
    register_widget('Ztheme_Recent_Posts_Widget');
}
add_action('widgets_init', 'ztheme_register_recent_posts_widget');

// Blogger Recommend Widget
class Ztheme_Blogger_Recommend_Widget extends WP_Widget {
    
    public function __construct() {
        parent::__construct(
            'ztheme_blogger_recommend',
            '博主推荐',
            array('description' => '显示博主推荐的链接列表')
        );
    }
    
    public function widget($args, $instance) {
        echo '<div class="card p-6 mb-6 hidden md:block">';
        
        if (!empty($instance['title'])) {
            echo $args['before_title'] . apply_filters('widget_title', $instance['title']) . $args['after_title'];
        }
        
        if (!empty($instance['content'])) {
            $lines = explode("\n", trim($instance['content']));
            $colors = ['bg-blue-500', 'bg-emerald-500', 'bg-purple-500', 'bg-orange-500', 'bg-pink-500'];
            $color_index = 0;
            
            echo '<div class="space-y-2">';
            foreach ($lines as $line) {
                $line = trim($line);
                if (empty($line)) continue;
                
                $parts = preg_split('/[｜|]/u', $line, 2);
                if (count($parts) === 2) {
                    $name = trim($parts[0]);
                    $url = esc_url(trim($parts[1]));
                    if (!empty($name) && !empty($url)) {
                        $color = $colors[$color_index % count($colors)];
                        $initial = mb_strtoupper(mb_substr($name, 0, 1));
                        echo '<a href="' . $url . '" target="_blank" rel="noopener" title="' . esc_attr($name) . '" class="recommend-card">';
                        echo '<span class="recommend-icon ' . $color . '">' . esc_html($initial) . '</span>';
                        echo '<span class="recommend-name">' . esc_html($name) . '</span>';
                        echo '</a>';
                        $color_index++;
                    }
                }
            }
            echo '</div>';
        }
        
        echo '</div>';
    }
    
    public function form($instance) {
        $title = !empty($instance['title']) ? $instance['title'] : '博主推荐';
        $content = !empty($instance['content']) ? $instance['content'] : '';
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>">标题:</label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>">
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('content'); ?>">链接列表:</label>
            <textarea class="widefat" rows="6" id="<?php echo $this->get_field_id('content'); ?>" name="<?php echo $this->get_field_name('content'); ?>" placeholder="Google|https://google.com&#10;GitHub｜https://github.com"><?php echo esc_textarea($content); ?></textarea>
            <small>格式：名称｜URL，一行一个（支持全角｜和半角|）</small>
        </p>
        <?php
    }
    
    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = !empty($new_instance['title']) ? strip_tags($new_instance['title']) : '';
        $instance['content'] = !empty($new_instance['content']) ? $new_instance['content'] : '';
        return $instance;
    }
}

function ztheme_register_blogger_recommend_widget() {
    register_widget('Ztheme_Blogger_Recommend_Widget');
}
add_action('widgets_init', 'ztheme_register_blogger_recommend_widget');

// Custom password form
function ztheme_password_form() {
    global $post;
    $label = 'pwbox-' . (empty($post->ID) ? rand() : $post->ID);
    $form = '<form class="max-w-md mx-auto" action="' . esc_url(site_url('wp-login.php?action=postpass', 'login_post')) . '" method="post">
    <p class="mb-4 text-slate-600 dark:text-slate-400">' . __("这篇文章受密码保护。请输入密码查看！") . '</p>
    <div class="flex gap-3">
        <input class="input-field flex-1" name="post_password" id="' . $label . '" type="password" placeholder="请输入密码" />
        <button class="btn-primary" type="submit">' . __("提交") . '</button>
    </div>
    </form>';
    return $form;
}
add_filter('the_password_form', 'ztheme_password_form');

// Disable Google Fonts
function ztheme_disable_google_fonts($translations, $text, $context, $domain) {
    if ('Open Sans font: on or off' == $context && 'on' == $text) {
        $translations = 'off';
    }
    return $translations;
}
add_filter('gettext_with_context', 'ztheme_disable_google_fonts', 888, 4);

// Disable Emoji
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('admin_print_scripts', 'print_emoji_detection_script');
remove_action('wp_print_styles', 'print_emoji_styles');
remove_action('admin_print_styles', 'print_emoji_styles');

// Disable pingback
add_filter('xmlrpc_methods', function($methods) {
    unset($methods['pingback.ping']);
    return $methods;
});

// Disable comments privacy consent
add_filter('comment_form_field_cookies', '__return_false');
add_action('set_comment_cookies', 'ztheme_set_cookies', 10, 3);
function ztheme_set_cookies($comment, $user, $cookies_consent) {
    $cookies_consent = true;
    wp_set_comment_cookies($comment, $user, $cookies_consent);
}

// Spam comment filter
function ztheme_comment_spam_check($incoming_comment) {
    $pattern = '/[一-龥]/u';
    if (!preg_match($pattern, $incoming_comment['comment_content'])) {
        wp_die("评论中必须包含中文！");
    }
    $pattern = '/[あ-んア-ン]/u';
    if (preg_match($pattern, $incoming_comment['comment_content'])) {
        wp_die("评论禁止包含日文！");
    }
    return $incoming_comment;
}
add_filter('preprocess_comment', 'ztheme_comment_spam_check');

// Comment URL spam check
function ztheme_url_spamcheck($approved, $commentdata) {
    return (strlen($commentdata['comment_author_url']) > 50) ? 'spam' : $approved;
}
add_filter('pre_comment_approved', 'ztheme_url_spamcheck', 99, 2);

// Gravatar CDN
function ztheme_gravatar_cdn($avatar) {
    if (!empty(of_get_option('gravatar'))) {
        $avatar = str_replace(array("secure.gravatar.com", "0.gravatar.com", "1.gravatar.com", "2.gravatar.com"), of_get_option('gravatar'), $avatar);
    }
    $avatar = str_replace('<img ', '<img loading="lazy" ', $avatar);
    return $avatar;
}
add_filter('get_avatar', 'ztheme_gravatar_cdn', 10, 3);

// Restore link manager
add_filter('pre_option_link_manager_enabled', '__return_true');



// Colorful tag cloud
function ztheme_color_cloud($text) {
    $text = preg_replace_callback('|<a (.+?)>|i', 'ztheme_color_cloud_callback', $text);
    return $text;
}
function ztheme_color_cloud_callback($matches) {
    $text = $matches[1];
    $color = dechex(rand(0, 16777215));
    $pattern = '/style=(\'|")(.*)(\'|")/i';
    $text = preg_replace($pattern, "style=\"color:#{$color};$2;\"", $text);
    return "<a $text>";
}
add_filter('wp_tag_cloud', 'ztheme_color_cloud', 1);

// SMTP settings
if (of_get_option('is_smtp') === 'true') {
    add_action('phpmailer_init', 'ztheme_mail_smtp');
    function ztheme_mail_smtp($phpmailer) {
        $phpmailer->FromName = of_get_option('smtp_fromname');
        $phpmailer->Host = of_get_option('smtp_host');
        $phpmailer->Port = intval(of_get_option('smtp_port'));
        $phpmailer->Username = of_get_option('smtp_username');
        $phpmailer->Password = of_get_option('smtp_password');
        $phpmailer->From = of_get_option('smtp_username');
        $phpmailer->SMTPAuth = true;
        $phpmailer->SMTPSecure = (of_get_option('smtp_protocol') == 'none') ? '' : of_get_option('smtp_protocol');
        $phpmailer->IsSMTP();
    }
}

// Comment reply email notification
function ztheme_comment_mail_notify($comment_id) {
    $admin_email = get_bloginfo('admin_email');
    $comment = get_comment($comment_id);
    $comment_author_email = trim($comment->comment_author_email);
    $parent_id = $comment->comment_parent ? $comment->comment_parent : '';
    $to = $parent_id ? trim(get_comment($parent_id)->comment_author_email) : '';
    $spam_confirmed = $comment->comment_approved;
    
    if (($parent_id != '') && ($spam_confirmed != 'spam') && ($to != $admin_email)) {
        $wp_email = 'no-reply@' . preg_replace('#^www\.#', '', strtolower($_SERVER['SERVER_NAME']));
        $subject = '您在 [' . get_option("blogname") . '] 的留言有了新回复';
        $message = '<div style="max-width:600px;margin:0 auto;padding:20px;">
            <h2 style="color:#1e293b;border-bottom:2px solid #3b82f6;padding-bottom:10px;">留言回复通知</h2>
            <p>亲爱的 ' . trim(get_comment($parent_id)->comment_author) . '，您好！</p>
            <p>您曾在文章《' . get_the_title($comment->comment_post_ID) . '》上发表评论：</p>
            <blockquote style="background:#f1f5f9;padding:15px;border-left:4px solid #3b82f6;margin:15px 0;">' . trim(get_comment($parent_id)->comment_content) . '</blockquote>
            <p>' . trim($comment->comment_author) . ' 给您的回复：</p>
            <blockquote style="background:#f1f5f9;padding:15px;border-left:4px solid #10b981;margin:15px 0;">' . trim($comment->comment_content) . '</blockquote>
            <p><a href="' . htmlspecialchars(get_comment_link($parent_id)) . '" style="color:#3b82f6;">查看完整回复</a></p>
        </div>';
        $from = "From: \"" . get_option('blogname') . "\" <$wp_email>";
        $headers = "$from\nContent-Type: text/html; charset=" . get_option('blog_charset') . "\n";
        wp_mail($to, $subject, $message, $headers);
    }
}
add_action('comment_post', 'ztheme_comment_mail_notify');

// Get real IP
function ztheme_get_ip() {
    if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $real_ip = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
        $_SERVER['REMOTE_ADDR'] = trim($real_ip[0]);
    } elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
        $_SERVER['REMOTE_ADDR'] = $_SERVER['HTTP_CLIENT_IP'];
    }
}
add_action('init', 'ztheme_get_ip');

// UA block
add_action('template_redirect', 'ztheme_ua_block');
function ztheme_ua_block() {
    if (is_admin() || wp_doing_ajax()) return;

    $ua_block_list = of_get_option('ua_block');
    if (empty($ua_block_list)) return;

    $ua = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '';
    if (empty($ua)) return;

    $keywords = array_filter(array_map('trim', explode("\n", str_replace("\r\n", "\n", $ua_block_list))));
    foreach ($keywords as $keyword) {
        if ($keyword !== '' && stripos($ua, $keyword) !== false) {
            status_header(403);
            $protocol = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') ? 'https' : 'http';
            $host = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '';
            $uri = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '';
            $current_url = esc_url($protocol . '://' . $host . $uri);
            $html = file_get_contents(get_template_directory() . '/403.html');
            echo str_replace('{{URL}}', $current_url, $html);
            exit;
        }
    }
}

// Search keyword ban
add_action('admin_init', 'ztheme_search_ban_key_init');
function ztheme_search_ban_key_init() {
    add_settings_field('ztheme_search_key', '搜索关键词屏蔽', 'ztheme_search_key_callback', 'reading');
    register_setting('reading', 'ztheme_search_key');
}
function ztheme_search_key_callback() {
    echo '<textarea name="ztheme_search_key" rows="5" cols="50" class="large-text code">' . get_option('ztheme_search_key') . '</textarea>';
}
add_action('template_redirect', 'ztheme_search_ban');
function ztheme_search_ban() {
    if (is_search()) {
        global $wp_query;
        $ban_keys = get_option('ztheme_search_key');
        if ($ban_keys) {
            $ban_keys = str_replace("\r\n", "|", $ban_keys);
            $keys = explode('|', $ban_keys);
            $search_query = $wp_query->query_vars;
            foreach ($keys as $key) {
                if (stristr($search_query['s'], $key) != false) {
                    wp_die('请不要搜索非法关键字');
                }
            }
        }
    }
}

// Disable autosave and revisions
remove_action('pre_post_update', 'wp_save_post_revision');
add_action('wp_print_scripts', 'ztheme_disable_autosave');
function ztheme_disable_autosave() {
    wp_deregister_script('autosave');
}

// Classic widgets
add_filter('gutenberg_use_widgets_block_editor', '__return_false');
add_filter('use_widgets_block_editor', '__return_false');

// Disable Gutenberg editor, use Classic Editor
add_filter('use_block_editor_for_post', '__return_false');
add_filter('use_block_editor_for_post_type', '__return_false');

// Render ad from option (format: URL\nimgurl\n名称)
function ztheme_render_ad($option_key) {
    $raw = trim(of_get_option($option_key));
    if (empty($raw)) return;

    $lines = array_filter(array_map('trim', explode("\n", $raw)));
    if (count($lines) < 3) return;

    $link_url = esc_url($lines[0]);
    $img_url  = esc_url($lines[1]);
    $name     = esc_html($lines[2]);

    echo '<a href="' . $link_url . '" target="_blank" rel="nofollow noopener" '
       . 'class="block mb-6 rounded-xl overflow-hidden border border-slate-200/60 dark:border-slate-700/60 '
       . 'hover:shadow-lg hover:border-primary-300 dark:hover:border-primary-600 transition-all duration-300 group">';
    echo '<div class="relative">';
    echo '<img src="' . $img_url . '" alt="' . $name . '" class="w-full h-auto object-cover" loading="lazy">';
    echo '<span class="absolute bottom-2 right-2 px-2.5 py-1 text-xs font-medium '
       . 'bg-black/50 text-white/90 rounded-md backdrop-blur-sm '
       . 'group-hover:bg-primary-500/80 transition-colors duration-300">' . $name . '</span>';
    echo '</div>';
    echo '</a>';
}

// Header custom code
function ztheme_header_txt() {
    $header_txt_path = get_template_directory() . '/extend/header.txt';
    if (file_exists($header_txt_path)) {
        echo file_get_contents($header_txt_path);
    }
}
