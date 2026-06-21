<?php get_header(); ?>

<!-- Main content area -->
<div class="flex-1 min-w-0">
    
    <?php if (have_posts()): while (have_posts()): the_post(); ?>
    
    <?php ztheme_render_ad('gg6'); ?>
    
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
                    <i class="fa-regular fa-clock text-sm"></i>
                    发布于：<?php the_time('Y-m-d'); ?>
                </span>
                <?php if (get_the_time('Y-m-d') != get_the_modified_time('Y-m-d')): ?>
                <span class="flex items-center gap-1 text-orange-500">
                    <i class="fa-solid fa-arrows-rotate text-sm"></i>
                    更新于：<?php the_modified_time('Y-m-d'); ?>
                </span>
                <?php endif; ?>
                <span class="flex items-center gap-1">
                    <i class="fa-regular fa-folder text-sm"></i>
                    <?php ztheme_category(); ?>
                </span>
                <span class="flex items-center gap-1">
                    <i class="fa-regular fa-comment text-sm"></i>
                    <a href="#comments" class="hover:text-primary-500 dark:hover:text-primary-400"><?php comments_number('0条评论', '1条评论', '%条评论'); ?></a>
                </span>
                <span class="hidden sm:flex items-center gap-1">
                    <i class="fa-regular fa-eye text-sm"></i>
                    <?php ztheme_get_post_views($post->ID); ?> views
                </span>
                <?php if (current_user_can('manage_options')): ?>
                <span class="flex items-center gap-1">
                    <?php edit_post_link('编辑', '<i class="fa-solid fa-pen-to-square text-sm"></i> ', ''); ?>
                </span>
                <?php endif; ?>
            </div>
        </div>
        
        <!-- Content -->
        <div id="content" class="px-6 md:px-8 py-4 prose prose-slate dark:prose-invert max-w-none">
            <!-- Description notice -->
            <?php if (!empty(of_get_option('single_description'))): ?>
            <div class="mb-6 p-4 bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800 rounded-lg">
                <div class="flex items-start gap-3">
                    <i class="fa-solid fa-circle-info text-base text-amber-500 flex-shrink-0 mt-0.5"></i>
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
        <?php $tags = get_the_tags(); if ($tags): ?>
        <div class="px-6 md:px-8 py-4 border-t border-slate-100 dark:border-slate-700">
            <div class="flex flex-wrap items-center gap-2">
                <i class="fa-solid fa-tag text-sm text-slate-400"></i>
                <?php foreach ($tags as $tag): ?>
                <a href="<?php echo get_tag_link($tag->term_id); ?>" class="px-3 py-1 text-sm bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-400 rounded-full hover:bg-primary-100 dark:hover:bg-primary-900/30 hover:text-primary-600 dark:hover:text-primary-400 transition-colors"><?php echo $tag->name; ?></a>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>
        
        <!-- Previous/Next -->
        <div class="px-6 md:px-8 py-4 border-t border-slate-100 dark:border-slate-700">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="flex items-center gap-3 p-3 bg-slate-50 dark:bg-slate-700/50 rounded-lg">
                    <i class="fa-solid fa-chevron-left text-base text-slate-400 flex-shrink-0"></i>
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
                    <i class="fa-solid fa-chevron-right text-base text-slate-400 flex-shrink-0"></i>
                </div>
            </div>
        </div>
        
        <!-- Like -->
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
                    <i class="fa-regular fa-thumbs-up text-base"></i>
                    赞 <span x-text="count"></span>
                </button>
            </div>
        </div>
    </article>
    
    <div class="mt-8">
        <?php ztheme_render_ad('ad_single_bottom'); ?>
    </div>
    
    <!-- Comments -->
    <div class="mt-8">
        <?php comments_template(); ?>
    </div>
    
    <?php endwhile; endif; ?>
</div>

<?php get_sidebar(); ?>
<?php get_footer(); ?>
