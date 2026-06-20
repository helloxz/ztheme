<?php get_header(); ?>

<!-- Main content area -->
<div class="flex-1 min-w-0">
    
    <!-- Breadcrumbs -->
    <div class="mb-6">
        <?php ztheme_breadcrumbs(); ?>
    </div>
    
    <?php if (have_posts()): while (have_posts()): the_post(); ?>
    <article class="card overflow-hidden">
        <!-- Header -->
        <div class="p-6 pb-0 md:p-8 md:pb-0">
            <!-- Title -->
            <h1 class="text-2xl md:text-3xl font-bold text-slate-800 dark:text-slate-100 mb-4">
                <?php the_title(); ?>
            </h1>
            
            <!-- Meta -->
            <div class="flex flex-wrap items-center gap-4 text-sm text-slate-500 dark:text-slate-400 mb-6">
                <span class="flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    发布于：<?php the_time('Y-m-d'); ?>
                </span>
                <?php if (get_the_time('Y-m-d') != get_the_modified_time('Y-m-d')): ?>
                <span class="flex items-center gap-1 text-orange-500">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    更新于：<?php the_modified_time('Y-m-d'); ?>
                </span>
                <?php endif; ?>
                <span class="flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/>
                    </svg>
                    <?php ztheme_category(); ?>
                </span>
                <span class="flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                    </svg>
                    <a href="#comments" class="hover:text-primary-500 dark:hover:text-primary-400"><?php comments_number('0条评论', '1条评论', '%条评论'); ?></a>
                </span>
                <span class="hidden sm:flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                    <?php ztheme_get_post_views($post->ID); ?> views
                </span>
                <?php if (current_user_can('manage_options')): ?>
                <span class="flex items-center gap-1">
                    <?php edit_post_link('编辑', '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg> ', ''); ?>
                </span>
                <?php endif; ?>
            </div>
            
            <!-- Ad below title -->
            <?php if (!empty(of_get_option('gg6'))): ?>
            <div class="mb-6">
                <?php echo of_get_option('gg6'); ?>
            </div>
            <?php endif; ?>
        </div>
        
        <!-- Content -->
        <div id="content" class="px-6 md:px-8 py-4 prose prose-slate dark:prose-invert max-w-none">
            <!-- Description notice -->
            <?php if (!empty(of_get_option('single_description'))): ?>
            <div class="mb-6 p-4 bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800 rounded-lg">
                <div class="flex items-start gap-3">
                    <svg class="w-5 h-5 text-amber-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <p class="text-sm text-amber-800 dark:text-amber-200"><?php echo of_get_option('single_description'); ?></p>
                </div>
            </div>
            <?php endif; ?>
            
            <?php the_content(); ?>
        </div>
        
        <!-- Page links -->
        <div class="px-6 md:px-8 py-4">
            <?php
            wp_link_pages(array(
                'before' => '<div class="flex items-center gap-2 mt-6"><span class="text-sm text-slate-500">分页：</span>',
                'after'  => '</div>',
                'link_before' => '<span class="px-3 py-1 text-sm bg-slate-100 dark:bg-slate-700 rounded-lg hover:bg-primary-100 dark:hover:bg-primary-900/30 transition-colors">',
                'link_after'  => '</span>',
            ));
            ?>
        </div>
        
        <!-- Tags -->
        <?php if (get_the_tag_list()): ?>
        <div class="px-6 md:px-8 py-4 border-t border-slate-100 dark:border-slate-700">
            <div class="flex flex-wrap items-center gap-2">
                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                </svg>
                <?php echo get_the_tag_list('', '<span class="px-3 py-1 text-sm bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-400 rounded-full hover:bg-primary-100 dark:hover:bg-primary-900/30 hover:text-primary-600 dark:hover:text-primary-400 transition-colors">', '</span>'); ?>
            </div>
        </div>
        <?php endif; ?>
        
        <!-- Ad above donate -->
        <?php if (!empty(of_get_option('ad_single_bottom'))): ?>
        <div class="px-6 md:px-8 py-4 border-t border-slate-100 dark:border-slate-700">
            <?php echo of_get_option('ad_single_bottom'); ?>
        </div>
        <?php endif; ?>
        
        <!-- Previous/Next -->
        <div class="px-6 md:px-8 py-4 border-t border-slate-100 dark:border-slate-700">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="flex items-center gap-3 p-3 bg-slate-50 dark:bg-slate-700/50 rounded-lg">
                    <svg class="w-5 h-5 text-slate-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                    <div class="min-w-0 flex-1">
                        <p class="text-xs text-slate-500 dark:text-slate-400">上一篇</p>
                        <?php
                        $prev_post = get_previous_post();
                        if (!empty($prev_post)):
                        ?>
                        <a href="<?php echo get_permalink($prev_post->ID); ?>" class="text-sm text-slate-700 dark:text-slate-300 hover:text-primary-500 dark:hover:text-primary-400 truncate block transition-colors"><?php echo $prev_post->post_title; ?></a>
                        <?php else: ?>
                        <span class="text-sm text-slate-400">没有了</span>
                        <?php endif; ?>
                    </div>
                </div>
                
                <div class="flex items-center gap-3 p-3 bg-slate-50 dark:bg-slate-700/50 rounded-lg justify-end text-right">
                    <div class="min-w-0 flex-1">
                        <p class="text-xs text-slate-500 dark:text-slate-400">下一篇</p>
                        <?php
                        $next_post = get_next_post();
                        if (!empty($next_post)):
                        ?>
                        <a href="<?php echo get_permalink($next_post->ID); ?>" class="text-sm text-slate-700 dark:text-slate-300 hover:text-primary-500 dark:hover:text-primary-400 truncate block transition-colors"><?php echo $next_post->post_title; ?></a>
                        <?php else: ?>
                        <span class="text-sm text-slate-400">没有了</span>
                        <?php endif; ?>
                    </div>
                    <svg class="w-5 h-5 text-slate-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </div>
            </div>
        </div>
        
        <!-- Like & Donate -->
        <div class="px-6 md:px-8 py-6 border-t border-slate-100 dark:border-slate-700">
            <div class="flex items-center justify-center gap-4">
                <?php
                $liked = isset($_COOKIE['ztheme_ding_' . get_the_ID()]);
                $like_count = get_post_meta($post->ID, 'ztheme_ding', true) ?: '0';
                ?>
                <button x-data="{ liked: <?php echo $liked ? 'true' : 'false'; ?>, count: <?php echo $like_count; ?> }"
                        @click="if (!liked) { 
                            fetch('/wp-admin/admin-ajax.php', {
                                method: 'POST',
                                headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                                body: 'action=ztheme_like&um_id=<?php the_ID(); ?>&um_action=ding'
                            }).then(r => r.text()).then(data => { count = data; liked = true; });
                        }"
                        :class="liked ? 'bg-slate-100 dark:bg-slate-700 text-slate-400' : 'bg-orange-500 hover:bg-orange-600 text-white'"
                        class="inline-flex items-center gap-2 px-6 py-3 rounded-xl font-medium transition-all duration-300 transform hover:scale-105"
                        :disabled="liked">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"/>
                    </svg>
                    赞 <span x-text="count"></span>
                </button>
                
                <?php if (!empty(of_get_option('donate'))): ?>
                <button @click="$dispatch('show-donate')" class="inline-flex items-center gap-2 px-6 py-3 bg-primary-500 hover:bg-primary-600 text-white rounded-xl font-medium transition-all duration-300 transform hover:scale-105">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    打赏
                </button>
                <?php endif; ?>
            </div>
        </div>
    </article>
    
    <!-- Comments -->
    <div class="mt-8">
        <?php comments_template(); ?>
    </div>
    
    <?php endwhile; endif; ?>
</div>

<!-- Donate modal -->
<?php if (!empty(of_get_option('donate'))): ?>
<div x-data="{ open: false }" 
     @show-donate.window="open = true"
     x-show="open"
     x-transition:enter="transition ease-out duration-200"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition ease-in duration-150"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     x-cloak
     class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm"
     @click.self="open = false">
    <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 max-w-sm mx-4 shadow-xl">
        <h3 class="text-lg font-semibold text-slate-800 dark:text-slate-100 mb-4 text-center">请作者喝杯咖啡吧！</h3>
        <img src="<?php echo of_get_option('donate'); ?>" alt="打赏" class="w-full rounded-lg">
        <button @click="open = false" class="mt-4 w-full btn-outline">关闭</button>
    </div>
</div>
<?php endif; ?>

<?php get_sidebar(); ?>
<?php get_footer(); ?>
