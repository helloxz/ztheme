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
            <h1 class="text-2xl md:text-3xl font-bold text-slate-800 dark:text-slate-100 mb-4">
                <?php the_title(); ?>
            </h1>
            
            <div class="flex flex-wrap items-center gap-4 text-sm text-slate-500 dark:text-slate-400 mb-6">
                <span class="flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                    </svg>
                    <?php comments_number('0条评论', '1条评论', '%条评论'); ?>
                </span>
                <span class="flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <?php the_time('Y-m-d'); ?>
                </span>
                <span class="flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                    <?php ztheme_get_post_views($post->ID); ?> views
                </span>
                <?php edit_post_link('编辑', '<span class="flex items-center gap-1"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg> ', '</span>'); ?>
            </div>
        </div>
        
        <!-- Content -->
        <div id="content" class="px-6 md:px-8 py-4 prose prose-slate dark:prose-invert max-w-none">
            <?php the_content(); ?>
        </div>
        
        <!-- Tags -->
        <?php if (get_the_tag_list()): ?>
        <div class="px-6 md:px-8 py-4 border-t border-slate-100 dark:border-slate-700">
            <div class="flex flex-wrap items-center gap-2">
                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                </svg>
                <?php echo get_the_tag_list('', '<span class="px-3 py-1 text-sm bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-400 rounded-full">', '</span>'); ?>
            </div>
        </div>
        <?php endif; ?>
    </article>
    
    <!-- Comments -->
    <div class="mt-8">
        <?php comments_template(); ?>
    </div>
    
    <?php endwhile; endif; ?>
</div>

<?php get_sidebar(); ?>
<?php get_footer(); ?>
