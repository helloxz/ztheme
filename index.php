<?php get_header(); ?>
<!-- DEBUG: index.php start -->

<!-- DEBUG: index.php main content start -->
<!-- Main content area -->
<div class="flex-1 min-w-0">
    <?php
    $recommend_items = array();
    $recommend = of_get_option('home_recommend');
    if (!empty($recommend)) {
        $items = array_filter(explode("\n", trim($recommend)));
        foreach ($items as $item) {
            $parts = array_map('trim', explode('|', $item));
            if (count($parts) >= 3) {
                $recommend_items[] = array(
                    'title' => $parts[0],
                    'desc'  => $parts[1],
                    'link'  => $parts[2],
                );
            }
        }
    }

    $recommend_card_styles = array(
        'border border-blue-200/70 bg-gradient-to-br from-blue-50 via-white to-cyan-50 dark:border-blue-900/60 dark:from-blue-950/40 dark:via-slate-800 dark:to-cyan-950/30',
        'border border-emerald-200/70 bg-gradient-to-br from-emerald-50 via-white to-teal-50 dark:border-emerald-900/60 dark:from-emerald-950/35 dark:via-slate-800 dark:to-teal-950/30',
        'border border-violet-200/70 bg-gradient-to-br from-violet-50 via-white to-indigo-50 dark:border-violet-900/60 dark:from-violet-950/35 dark:via-slate-800 dark:to-indigo-950/30',
    );
    ?>
    
    <!-- Article list -->
    <?php
    $args = array('orderby' => 'date');
    $arms = array_merge($args, $wp_query->query);
    query_posts($arms);
    ?>
    
    <?php if (have_posts()): ?>
    <?php
    $sticky_posts_html = array();
    $regular_posts_html = array();
    while (have_posts()): the_post();
        ob_start();
        if (is_sticky()):
    ?>
        <!-- Sticky post -->
        <article class="card-sticky overflow-hidden">
            <div class="p-4 md:px-5 md:py-3 flex items-center gap-3">
                <span class="sticky-badge">置顶</span>
                <h2 class="text-base md:text-lg font-semibold text-slate-800 dark:text-slate-100 leading-snug flex-1 min-w-0">
                    <a href="<?php the_permalink(); ?>" class="block truncate hover:text-primary-500 dark:hover:text-primary-400 transition-colors">
                        <?php the_title(); ?>
                    </a>
                </h2>
            </div>
        </article>
        <?php else: ?>
        <!-- Normal post -->
        <article class="card overflow-hidden">
            <div class="p-4 md:px-5 md:py-4 min-h-[11.5rem] flex flex-col">
                <!-- Title -->
                <h2 class="text-base md:text-lg font-semibold text-slate-800 dark:text-slate-100 mb-2 leading-snug">
                    <a href="<?php the_permalink(); ?>" class="block truncate md:whitespace-normal md:overflow-visible md:text-ellipsis hover:text-primary-500 dark:hover:text-primary-400 transition-colors">
                        <?php the_title(); ?>
                    </a>
                </h2>
                
                <!-- Meta -->
                <div class="flex flex-wrap items-center gap-x-3 gap-y-2 text-xs text-slate-500 dark:text-slate-400 mb-3">
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
                <p class="text-slate-600 dark:text-slate-400 text-sm leading-6 mb-3 line-clamp-2 min-h-[3rem]">
                    <?php the_content(); ?>
                </p>
                
                <!-- Read more -->
                <div class="mt-auto">
                    <a href="<?php the_permalink(); ?>" class="inline-flex items-center gap-1.5 text-xs font-medium text-primary-500 hover:text-primary-600 dark:hover:text-primary-400 transition-colors group">
                        阅读全文
                        <svg class="w-3.5 h-3.5 group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>
            </div>
        </article>
        <?php endif;
        $article_html = ob_get_clean();
        if (is_sticky()) {
            $sticky_posts_html[] = $article_html;
        } else {
            $regular_posts_html[] = $article_html;
        }
    endwhile;
    ?>
    <div class="space-y-4">
        <?php foreach ($sticky_posts_html as $sticky_post_html): ?>
            <?php echo $sticky_post_html; ?>
        <?php endforeach; ?>

        <?php if (!empty($recommend_items)): ?>
        <section class="hidden lg:block py-2" aria-label="我的产品">
            <div class="grid grid-cols-3 gap-4">
                <?php foreach ($recommend_items as $index => $recommend_item):
                    $card_style = $recommend_card_styles[$index % count($recommend_card_styles)];
                ?>
                <a href="<?php echo esc_url($recommend_item['link']); ?>" rel="nofollow" target="_blank" class="group block rounded-2xl p-5 shadow-sm hover:shadow-lg transition-all duration-300 hover:-translate-y-1 <?php echo esc_attr($card_style); ?>">
                    <div class="flex items-center gap-4">
                        <div class="flex h-11 w-11 flex-shrink-0 items-center justify-center rounded-xl bg-white/80 text-slate-700 shadow-sm ring-1 ring-slate-200/70 dark:bg-slate-900/70 dark:text-slate-200 dark:ring-slate-700/70">
                            <i class="fa-solid fa-cube text-lg"></i>
                        </div>
                        <div class="min-w-0 flex-1">
                            <h3 class="text-lg font-semibold text-slate-800 transition-colors group-hover:text-primary-600 dark:text-slate-100 dark:group-hover:text-primary-400"><?php echo esc_html($recommend_item['title']); ?></h3>
                            <p class="mt-1.5 text-[13px] leading-5 text-slate-600 dark:text-slate-300"><?php echo esc_html($recommend_item['desc']); ?></p>
                        </div>
                    </div>
                </a>
                <?php endforeach; ?>
            </div>
        </section>
        <?php endif; ?>

        <?php ztheme_render_ad('home_gg'); ?>

        <?php foreach ($regular_posts_html as $regular_post_html): ?>
            <?php echo $regular_post_html; ?>
        <?php endforeach; ?>
    </div>
    
    <!-- Pagination -->
    <div class="mt-8">
        <?php ztheme_pagenavi(); ?>
    </div>

    <?php
    // Featured posts (first page only)
    $paged = get_query_var('paged') ? get_query_var('paged') : 1;
    $featured_ids = ($paged <= 1) ? ztheme_get_featured_post_ids() : array();
    if (!empty($featured_ids)):
        $featured_query = new WP_Query(array(
            'post__in'            => $featured_ids,
            'posts_per_page'      => count($featured_ids),
            'orderby'             => 'post__in',
            'ignore_sticky_posts' => 1,
        ));

        if ($featured_query->have_posts()):
    ?>
    <!-- Featured posts -->
    <section class="mt-12">
        <div class="mb-6 text-center">
            <h2 class="text-xl font-semibold text-slate-800 dark:text-slate-100"><i class="fa-solid fa-star text-amber-400 mr-2"></i>精选推荐</h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
            <?php while ($featured_query->have_posts()): $featured_query->the_post(); ?>
            <article class="featured-card group overflow-hidden rounded-2xl bg-white dark:bg-slate-800 border border-slate-200/60 dark:border-slate-700/60 shadow-card hover:shadow-card-hover hover:-translate-y-1 transition-all duration-300">
                <a href="<?php the_permalink(); ?>" class="block aspect-[16/10] overflow-hidden bg-slate-100 dark:bg-slate-700">
                    <?php ztheme_render_featured_card_image(get_the_ID(), get_the_title()); ?>
                </a>
                <div class="p-4 md:p-5 flex flex-col flex-1">
                    <h3 class="text-base font-semibold text-slate-800 dark:text-slate-100 line-clamp-2 leading-snug">
                        <a href="<?php the_permalink(); ?>" class="hover:text-primary-500 dark:hover:text-primary-400 transition-colors"><?php the_title(); ?></a>
                    </h3>
                    <p class="text-sm text-slate-500 dark:text-slate-400 mt-1.5 line-clamp-2 leading-relaxed"><?php echo esc_html(wp_trim_words(get_the_excerpt(), 36)); ?></p>
                    <div class="mt-auto pt-3 flex items-center justify-between text-xs">
                        <span class="inline-flex items-center px-2 py-0.5 rounded bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300 font-medium"><?php echo esc_html(get_ztheme_category()); ?></span>
                        <span class="flex items-center gap-1 text-slate-400 dark:text-slate-500">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <?php the_time('Y-m-d'); ?>
                        </span>
                    </div>
                </div>
            </article>
            <?php endwhile; ?>
        </div>
    </section>
    <?php
            wp_reset_postdata();
        endif;
    endif;
    ?>

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
    

<!-- DEBUG: index.php main content end -->
</div>

<!-- DEBUG: index.php before get_sidebar -->
<?php get_sidebar(); ?>
<!-- DEBUG: index.php after get_sidebar -->
<!-- DEBUG: index.php before get_footer -->
<?php get_footer(); ?>
