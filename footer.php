        </div>
    </main>
    
    <!-- Footer -->
    <footer class="bg-slate-800 dark:bg-slate-950 text-slate-300 mt-16">
        <!-- Sponsors (homepage only) -->
        <?php if (is_home() && !is_paged()): ?>
        <?php
        $home_sponsors = of_get_option('home_sponsors');
        $sponsor_lines = !empty($home_sponsors) ? array_filter(explode("\n", trim($home_sponsors))) : array();
        $sponsor_items = array();

        foreach ($sponsor_lines as $sponsor_line) {
            $sponsor_parts = array_map('trim', explode('|', $sponsor_line));
            if (count($sponsor_parts) < 3 || empty($sponsor_parts[0]) || empty($sponsor_parts[1]) || empty($sponsor_parts[2])) {
                continue;
            }
            $sponsor_items[] = array(
                'name'  => $sponsor_parts[0],
                'link'  => $sponsor_parts[1],
                'image' => $sponsor_parts[2],
            );
        }

        if (!empty($sponsor_items)):
        ?>
        <div>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-5">
                <div class="flex flex-wrap items-center gap-3">
                    <span class="hidden sm:flex items-center gap-1.5 text-sm text-slate-400 dark:text-slate-500 flex-shrink-0">
                        <i class="fa-solid fa-handshake-angle text-xs"></i>
                        赞助商
                    </span>
                    <?php foreach ($sponsor_items as $sponsor_item): ?>
                    <a href="<?php echo esc_url($sponsor_item['link']); ?>"
                       target="_blank"
                       rel="nofollow noopener"
                       class="inline-flex h-12 w-32 items-center justify-center rounded-lg border border-slate-600/70 bg-slate-700/40 px-3 py-2 hover:border-slate-500 hover:bg-slate-700/70 transition-colors"
                       title="<?php echo esc_attr($sponsor_item['name']); ?>">
                        <img src="<?php echo esc_url($sponsor_item['image']); ?>"
                             alt="<?php echo esc_attr($sponsor_item['name']); ?>"
                             class="max-h-8 max-w-full object-contain">
                    </a>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="h-px bg-gradient-to-r from-transparent via-slate-600/50 to-transparent"></div>
        </div>
        <?php endif; ?>
        <?php endif; ?>

        <!-- Friend links (homepage only) -->
        <?php if (is_home() && !is_paged()): ?>
        <?php
        $bookmarks = get_bookmarks(array(
            'orderby'        => 'name',
            'order'          => 'ASC',
            'limit'          => -1,
            'hide_invisible' => 1,
        ));
        if (!empty($bookmarks)):
        ?>
        <div>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
                <div class="flex flex-wrap items-center gap-3">
                    <span class="flex items-center gap-1.5 text-sm text-slate-400 dark:text-slate-500 flex-shrink-0">
                        <i class="fa-solid fa-link text-xs"></i>
                        友情链接
                    </span>
                    <?php foreach ($bookmarks as $bookmark): ?>
                    <a href="<?php echo esc_url($bookmark->link_url); ?>" 
                       target="_blank" 
                       rel="nofollow noopener"
                       class="px-3 py-1 text-xs text-slate-300 dark:text-slate-400 bg-slate-700/50 dark:bg-slate-800/80 hover:bg-slate-600/50 dark:hover:bg-slate-700/80 hover:text-white rounded-full transition-colors">
                        <?php echo esc_html($bookmark->link_name); ?>
                    </a>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="h-px bg-gradient-to-r from-transparent via-slate-600/50 to-transparent"></div>
        </div>
        <?php endif; ?>
        <?php endif; ?>
        
        <!-- Footer widgets -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                <?php if (is_active_sidebar('footer1')): ?>
                <div>
                    <?php dynamic_sidebar('footer1'); ?>
                </div>
                <?php endif; ?>
                
                <?php if (is_active_sidebar('footer2')): ?>
                <div>
                    <?php dynamic_sidebar('footer2'); ?>
                </div>
                <?php endif; ?>
                
                <?php if (is_active_sidebar('footer3')): ?>
                <div class="hidden lg:block">
                    <?php dynamic_sidebar('footer3'); ?>
                </div>
                <?php endif; ?>
                
                <?php if (is_active_sidebar('footer4')): ?>
                <div class="hidden lg:block">
                    <?php dynamic_sidebar('footer4'); ?>
                </div>
                <?php endif; ?>
            </div>
        </div>
        
        <!-- Copyright -->
        <div class="h-px bg-gradient-to-r from-transparent via-slate-600/50 to-transparent"></div>
        <div>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
                <div class="copyright-links text-center text-[13px] text-slate-400 dark:text-slate-500">
                    <?php echo of_get_option('footer', 'Copyright &copy; ' . date('Y') . '. Theme by <a href="https://blog.xiaoz.org/" target="_blank" class="text-slate-300 dark:text-slate-400 hover:text-white dark:hover:text-white">Ztheme</a>'); ?>
                </div>
            </div>
        </div>
    </footer>
    
    <?php wp_footer(); ?>
</body>
</html>
