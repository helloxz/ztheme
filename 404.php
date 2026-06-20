<?php get_header(); ?>

<!-- Main content area -->
<div class="flex-1 min-w-0">
    
    <div class="card p-12 text-center">
        <div class="mb-8">
            <svg class="w-32 h-32 mx-auto text-slate-300 dark:text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        
        <h1 class="text-4xl font-bold text-slate-800 dark:text-slate-100 mb-4">404</h1>
        <h2 class="text-xl font-semibold text-slate-600 dark:text-slate-400 mb-6">您访问的页面飞到火星上去了！</h2>
        
        <p class="text-slate-500 dark:text-slate-400 mb-8 max-w-md mx-auto">
            抱歉，您访问的页面不存在。可能是链接错误，或者页面已被删除。
        </p>
        
        <div class="flex items-center justify-center gap-4">
            <a href="<?php bloginfo('url'); ?>" class="btn-primary">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                返回首页
            </a>
            <button onclick="history.back()" class="btn-outline">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                返回上页
            </button>
        </div>
    </div>
    
</div>

<?php get_sidebar(); ?>
<?php get_footer(); ?>
