<?php get_header(); ?>

<!-- Main content area -->
<div class="flex-1 min-w-0">
    
    <!-- Announcement -->
    <?php if (!empty(of_get_option('home_notice'))): ?>
    <div class="mb-6 p-4 bg-primary-50 dark:bg-primary-900/20 border border-primary-200 dark:border-primary-800 rounded-xl">
        <div class="flex items-start gap-3">
            <div class="flex-shrink-0 mt-0.5">
                <svg class="w-5 h-5 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                </svg>
            </div>
            <div>
                <p class="text-sm text-primary-800 dark:text-primary-200"><?php echo of_get_option('home_notice'); ?></p>
            </div>
        </div>
    </div>
    <?php endif; ?>
    
    <!-- Recommended items -->
    <?php 
    $recommend = of_get_option('home_recommend');
    if (!empty($recommend)): 
        $items = array_filter(explode("\n", trim($recommend)));
        if (!empty($items)):
    ?>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mb-8">
        <?php foreach ($items as $item): 
            $parts = array_map('trim', explode('|', $item));
            if (count($parts) >= 3):
                $title = $parts[0];
                $desc = $parts[1];
                $link = $parts[2];
                $icon = isset($parts[3]) ? $parts[3] : 'link';
                $color = isset($parts[4]) ? $parts[4] : 'blue';
                
                $color_classes = array(
                    'blue'   => 'from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700',
                    'green'  => 'from-emerald-500 to-emerald-600 hover:from-emerald-600 hover:to-emerald-700',
                    'purple' => 'from-purple-500 to-purple-600 hover:from-purple-600 hover:to-purple-700',
                    'orange' => 'from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700',
                    'red'    => 'from-red-500 to-red-600 hover:from-red-600 hover:to-red-700',
                    'teal'   => 'from-teal-500 to-teal-600 hover:from-teal-600 hover:to-teal-700',
                );
                $gradient = isset($color_classes[$color]) ? $color_classes[$color] : $color_classes['blue'];
        ?>
        <a href="<?php echo esc_url($link); ?>" rel="nofollow" target="_blank" class="group block bg-gradient-to-br <?php echo $gradient; ?> rounded-xl p-5 text-white shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
            <div class="flex items-start gap-4">
                <div class="flex-shrink-0 w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                    </svg>
                </div>
                <div class="min-w-0 flex-1">
                    <h3 class="font-semibold text-lg mb-1 group-hover:translate-x-1 transition-transform"><?php echo esc_html($title); ?></h3>
                    <p class="text-sm text-white/80"><?php echo esc_html($desc); ?></p>
                </div>
            </div>
        </a>
        <?php 
            endif;
        endforeach; 
        ?>
    </div>
    <?php 
        endif;
    endif; 
    ?>
    
    <!-- Breadcrumbs (non-homepage) -->
    <?php if (!is_home()): ?>
    <div class="mb-6">
        <?php ztheme_breadcrumbs(); ?>
    </div>
    <?php endif; ?>
    
    <!-- Article list -->
    <?php
    $args = array('orderby' => 'date');
    $arms = array_merge($args, $wp_query->query);
    query_posts($arms);
    ?>
    
    <?php if (have_posts()): ?>
    <div class="space-y-4">
        <?php while (have_posts()): the_post(); ?>
        <article class="card overflow-hidden">
            <div class="flex flex-col md:flex-row">
                <!-- Thumbnail -->
                <div class="md:w-44 lg:w-52 flex-shrink-0">
                    <div class="aspect-[4/3] md:aspect-auto md:h-full">
                        <?php ztheme_thumb(); ?>
                    </div>
                </div>
                
                <!-- Content -->
                <div class="flex-1 p-4">
                    <!-- Sticky badge -->
                    <?php if (is_sticky()): ?>
                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium bg-primary-100 dark:bg-primary-900/30 text-primary-700 dark:text-primary-300 mb-2">
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.828 3.414a2 2 0 012.828 0l.586.586a2 2 0 002.828 0l.586-.586a2 2 0 012.828 2.828l-.586.586a2 2 0 000 2.828l.586.586a2 2 0 01-2.828 2.828l-.586-.586a2 2 0 00-2.828 0l-.586.586a2 2 0 01-2.828-2.828l.586-.586a2 2 0 000-2.828l-.586-.586a2 2 0 010-2.828z"/>
                        </svg>
                        置顶
                    </span>
                    <?php endif; ?>
                    
                    <!-- Title -->
                    <h2 class="text-lg font-semibold text-slate-800 dark:text-slate-100 mb-2">
                        <a href="<?php the_permalink(); ?>" class="hover:text-primary-500 dark:hover:text-primary-400 transition-colors">
                            <?php the_title(); ?>
                        </a>
                    </h2>
                    
                    <!-- Meta -->
                    <div class="flex flex-wrap items-center gap-3 text-xs text-slate-500 dark:text-slate-400 mb-3">
                        <span class="flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/>
                            </svg>
                            <?php ztheme_category(); ?>
                        </span>
                        <span class="flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <?php the_time('Y-m-d'); ?>
                        </span>
                        <span class="flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                            </svg>
                            <?php comments_number('0评论', '1评论', '%评论'); ?>
                        </span>
                        <span class="hidden sm:flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            <?php ztheme_get_post_views($post->ID); ?>
                        </span>
                    </div>
                    
                    <!-- Excerpt -->
                    <p class="text-slate-600 dark:text-slate-400 text-sm leading-relaxed mb-3 line-clamp-2">
                        <?php the_content(); ?>
                    </p>
                    
                    <!-- Read more -->
                    <a href="<?php the_permalink(); ?>" class="inline-flex items-center gap-1.5 text-xs font-medium text-primary-500 hover:text-primary-600 dark:hover:text-primary-400 transition-colors group">
                        阅读全文
                        <svg class="w-3.5 h-3.5 group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>
            </div>
        </article>
        <?php endwhile; ?>
    </div>
    
    <!-- Pagination -->
    <div class="mt-8">
        <?php ztheme_pagenavi(); ?>
    </div>
    
    <?php else: ?>
    <div class="card p-12 text-center">
        <svg class="w-16 h-16 mx-auto text-slate-300 dark:text-slate-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        <h3 class="text-lg font-semibold text-slate-800 dark:text-slate-100 mb-2">暂无文章</h3>
        <p class="text-slate-500 dark:text-slate-400">没有找到相关文章</p>
    </div>
    <?php endif; ?>
    <?php wp_reset_query(); ?>
    
</div>

<?php get_sidebar(); ?>
<?php get_footer(); ?>
