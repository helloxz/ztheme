<?php get_header(); ?>

<!-- Main content area -->
<div class="flex-1 min-w-0">
    
    <div class="card p-12 text-center">
        <div class="mb-8">
            <i class="fa-regular fa-face-frown text-8xl mx-auto text-slate-300 dark:text-slate-600"></i>
        </div>
        
        <h1 class="text-4xl font-bold text-slate-800 dark:text-slate-100 mb-4">404</h1>
        <h2 class="text-xl font-semibold text-slate-600 dark:text-slate-400 mb-6">您访问的页面飞到火星上去了！</h2>
        
        <p class="text-slate-500 dark:text-slate-400 mb-8 max-w-md mx-auto">
            抱歉，您访问的页面不存在。可能是链接错误，或者页面已被删除。
        </p>
        
        <div class="flex items-center justify-center gap-4">
            <a href="<?php bloginfo('url'); ?>" class="btn-primary">
                <i class="fa-solid fa-house text-sm mr-2"></i>
                返回首页
            </a>
            <button onclick="history.back()" class="btn-outline">
                <i class="fa-solid fa-arrow-left text-sm mr-2"></i>
                返回上页
            </button>
        </div>
    </div>
    
</div>

<?php get_sidebar(); ?>
<?php get_footer(); ?>
