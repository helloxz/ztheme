<?php get_header(); ?>

<!-- Main content area -->
<div class="flex-1 min-w-0">
    
    <?php if (have_posts()): while (have_posts()): the_post(); ?>
    
    <?php ztheme_render_ad('gg6'); ?>
    
    <article class="card overflow-hidden">
        <!-- Header -->
        <div class="p-6 pb-0 md:p-8 md:pb-0">
            <h1 class="text-2xl md:text-3xl font-bold text-slate-800 dark:text-slate-100 mb-4">
                <?php the_title(); ?>
            </h1>
            
            <div class="flex flex-wrap items-center gap-4 text-sm text-slate-500 dark:text-slate-400 mb-6">
                <span class="flex items-center gap-1">
                    <i class="fa-regular fa-comment text-sm"></i>
                    <?php comments_number('0条评论', '1条评论', '%条评论'); ?>
                </span>
                <span class="flex items-center gap-1">
                    <i class="fa-regular fa-calendar text-sm"></i>
                    <?php the_time('Y-m-d'); ?>
                </span>
                <span class="flex items-center gap-1">
                    <i class="fa-regular fa-eye text-sm"></i>
                    <?php ztheme_get_post_views($post->ID); ?> views
                </span>
                <?php edit_post_link('编辑', '<span class="flex items-center gap-1"><i class="fa-solid fa-pen-to-square text-sm"></i> ', '</span>'); ?>
            </div>
        </div>
        
        <!-- Content -->
        <div id="content" class="px-6 md:px-8 py-4 prose prose-slate dark:prose-invert max-w-none">
            <?php the_content(); ?>
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
