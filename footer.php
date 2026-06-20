        <!-- DEBUG: footer.php start -->
        </div>
    </main>
    <!-- DEBUG: footer.php after main -->
    
    <!-- Footer -->
    <footer class="bg-slate-800 dark:bg-slate-950 text-slate-300 mt-16">
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
                <div>
                    <?php dynamic_sidebar('footer3'); ?>
                </div>
                <?php endif; ?>
                
                <?php if (is_active_sidebar('footer4')): ?>
                <div>
                    <?php dynamic_sidebar('footer4'); ?>
                </div>
                <?php endif; ?>
            </div>
        </div>
        
        <!-- Copyright -->
        <div class="border-t border-slate-700 dark:border-slate-800">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
                <div class="text-center text-sm text-slate-400 dark:text-slate-500">
                    <?php echo of_get_option('footer', 'Copyright &copy; ' . date('Y') . '. Theme by <a href="https://www.xiaoz.me/" target="_blank" class="text-primary-400 hover:text-primary-300">ztheme</a>'); ?>
                </div>
            </div>
        </div>
    </footer>
    
    <?php wp_footer(); ?>
</body>
</html>
