<?php
/**
 * Template Name: 站点地图
 */
?>
<!DOCTYPE html>
<html lang="zh-cmn-Hans">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>站点地图 - <?php bloginfo('name'); ?></title>
    <meta name="keywords" content="站点地图,<?php bloginfo('name'); ?>" />
    <link rel="canonical" href="<?php echo get_permalink(); ?>" />
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/dist/styles.css">
</head>
<body class="bg-slate-50 dark:bg-slate-900 text-slate-600 dark:text-slate-300">
    <div class="max-w-4xl mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold text-center text-slate-800 dark:text-slate-100 mb-8">
            <?php bloginfo('name'); ?> - 站点地图
        </h1>
        
        <!-- Navigation -->
        <nav class="mb-8 p-4 bg-white dark:bg-slate-800 rounded-xl shadow-sm">
            <a href="<?php bloginfo('url'); ?>" class="text-primary-500 hover:text-primary-600"><?php bloginfo('name'); ?></a>
            <span class="mx-2 text-slate-400">»</span>
            <span>站点地图</span>
        </nav>
        
        <!-- Latest Posts -->
        <div class="mb-8 p-6 bg-white dark:bg-slate-800 rounded-xl shadow-sm">
            <h2 class="text-xl font-semibold text-slate-800 dark:text-slate-100 mb-4 pb-2 border-b border-slate-200 dark:border-slate-700">最新文章</h2>
            <ul class="space-y-2">
                <?php
                $myposts = get_posts('numberposts=-1&orderby=post_date&order=DESC');
                foreach ($myposts as $post):
                ?>
                <li class="py-2 border-b border-slate-100 dark:border-slate-700 last:border-0">
                    <a href="<?php the_permalink(); ?>" target="_blank" class="text-slate-600 dark:text-slate-400 hover:text-primary-500 dark:hover:text-primary-400 transition-colors">
                        <?php the_title(); ?>
                    </a>
                    <span class="text-xs text-slate-400 ml-2"><?php the_time('Y-m-d'); ?></span>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>
        
        <!-- Categories -->
        <div class="mb-8 p-6 bg-white dark:bg-slate-800 rounded-xl shadow-sm">
            <h2 class="text-xl font-semibold text-slate-800 dark:text-slate-100 mb-4 pb-2 border-b border-slate-200 dark:border-slate-700">分类目录</h2>
            <ul class="space-y-2">
                <?php wp_list_categories('title_li=&orderby=count&order=DESC&show_count=1'); ?>
            </ul>
        </div>
        
        <!-- Pages -->
        <div class="mb-8 p-6 bg-white dark:bg-slate-800 rounded-xl shadow-sm">
            <h2 class="text-xl font-semibold text-slate-800 dark:text-slate-100 mb-4 pb-2 border-b border-slate-200 dark:border-slate-700">页面</h2>
            <ul class="space-y-2">
                <?php wp_page_menu(array('title_li' => '')); ?>
            </ul>
        </div>
        
        <!-- Footer -->
        <div class="text-center text-sm text-slate-400">
            <p>最后更新：<?php
                global $wpdb;
                $last = $wpdb->get_results("SELECT MAX(post_modified) AS MAX_m FROM $wpdb->posts WHERE (post_type = 'post' OR post_type = 'page') AND (post_status = 'publish' OR post_status = 'private')");
                echo date('Y-m-d H:i:s', strtotime($last[0]->MAX_m));
            ?></p>
            <p class="mt-2">
                <a href="<?php bloginfo('url'); ?>" class="text-primary-500 hover:text-primary-600">返回首页</a>
            </p>
        </div>
    </div>
</body>
</html>
