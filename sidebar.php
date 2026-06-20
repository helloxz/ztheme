<!-- Sidebar -->
<aside class="w-full lg:w-80 flex-shrink-0">
    <!-- Personal info (homepage only) -->
    <?php if (is_home() || is_front_page()): ?>
    <div class="card p-6 mb-6">
        <!-- Avatar -->
        <div class="flex justify-center mb-4">
            <img src="<?php echo of_get_option('avatar', get_bloginfo('template_url') . '/static/images/avatar_120.jpg'); ?>" alt="<?php echo of_get_option('nickname', 'admin'); ?>" class="w-20 h-20 rounded-full border-4 border-slate-100 dark:border-slate-700 shadow-lg">
        </div>
        
        <!-- Name and location -->
        <div class="text-center mb-4">
            <h3 class="text-lg font-semibold text-slate-800 dark:text-slate-100"><?php echo of_get_option('nickname', 'admin'); ?></h3>
            <p class="text-sm text-slate-500 dark:text-slate-400 flex items-center justify-center gap-1 mt-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                <?php echo of_get_option('region', '火星'); ?>
            </p>
        </div>
        
        <!-- About me -->
        <div class="bg-slate-50 dark:bg-slate-700/50 rounded-lg p-4 mb-4">
            <p class="text-sm text-slate-600 dark:text-slate-400"><?php echo of_get_option('about_me', '一个帅气的小伙子。'); ?></p>
        </div>
        
        <!-- Social icons -->
        <div class="flex justify-center flex-wrap gap-3">
            <?php if (!empty(of_get_option('wechat'))): ?>
            <a href="javascript:;" @click="$dispatch('show-wechat', { url: '<?php echo of_get_option('wechat'); ?>' })" class="w-10 h-10 flex items-center justify-center bg-green-500 text-white rounded-lg hover:bg-green-600 transition-colors" title="微信">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M8.691 2.188C3.891 2.188 0 5.476 0 9.53c0 2.212 1.17 4.203 3.002 5.55a.59.59 0 01.213.665l-.39 1.48c-.019.07-.048.141-.048.213 0 .163.13.295.29.295a.326.326 0 00.167-.054l1.903-1.114a.864.864 0 01.717-.098 10.16 10.16 0 002.837.403c.276 0 .543-.027.811-.05-.857-2.578.157-4.972 1.932-6.446 1.703-1.415 3.882-1.98 5.853-1.838-.576-3.583-4.196-6.348-8.596-6.348zM5.785 5.991c.642 0 1.162.529 1.162 1.18a1.17 1.17 0 01-1.162 1.178A1.17 1.17 0 014.623 7.17c0-.651.52-1.18 1.162-1.18zm5.813 0c.642 0 1.162.529 1.162 1.18a1.17 1.17 0 01-1.162 1.178 1.17 1.17 0 01-1.162-1.178c0-.651.52-1.18 1.162-1.18zm5.34 2.867c-1.797-.052-3.746.512-5.28 1.786-1.72 1.428-2.687 3.72-1.78 6.22.942 2.453 3.666 4.229 6.884 4.229.826 0 1.622-.12 2.361-.336a.722.722 0 01.598.082l1.584.926a.272.272 0 00.14.047c.134 0 .24-.111.24-.247 0-.06-.023-.12-.038-.177l-.327-1.233a.582.582 0 01-.023-.156.49.49 0 01.201-.398C23.024 18.48 24 16.82 24 14.98c0-3.21-2.931-5.837-6.656-6.088V8.89c-.135-.01-.27-.027-.407-.03zm-2.53 3.274c.535 0 .969.44.969.982a.976.976 0 01-.969.983.976.976 0 01-.969-.983c0-.542.434-.982.97-.982zm4.844 0c.535 0 .969.44.969.982a.976.976 0 01-.969.983.976.976 0 01-.969-.983c0-.542.434-.982.97-.982z"/>
                </svg>
            </a>
            <?php endif; ?>
            
            <?php if (!empty(of_get_option('qq'))): ?>
            <a href="https://wpa.qq.com/msgrd?v=3&uin=<?php echo of_get_option('qq'); ?>&site=qq&menu=yes" target="_blank" rel="nofollow" class="w-10 h-10 flex items-center justify-center bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors" title="QQ:<?php echo of_get_option('qq'); ?>">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12.003 2c-2.265 0-6.29 1.364-6.29 7.325v1.195S3.55 14.96 3.55 17.474c0 .665.17 1.025.435 1.025.16 0 .397-.115.69-.465.065-.075.155-.22.27-.425.355-.635.74-1.48 1.035-2.1.225.775.71 1.715 1.365 2.54.37.47.78.865 1.2 1.14.42.275.85.415 1.26.415.44 0 .87-.15 1.24-.445.415-.325.795-.775 1.115-1.31.515.75 1.085 1.375 1.655 1.785.39.28.785.44 1.155.445h.03c.37-.005.735-.165 1.1-.445.57-.41 1.14-1.035 1.655-1.785.32.535.7.985 1.115 1.31.37.295.8.445 1.24.445.41 0 .84-.14 1.26-.415.42-.275.83-.67 1.2-1.14.65-.825 1.135-1.765 1.365-2.54.295.62.68 1.465 1.035 2.1.115.205.205.35.27.425.295.35.53.465.69.465.265 0 .435-.36.435-1.025 0-2.514-2.166-6.974-2.166-6.974V9.325C18.293 3.364 14.268 2 12.003 2z"/>
                </svg>
            </a>
            <?php endif; ?>
            
            <?php if (!empty(of_get_option('weibo'))): ?>
            <a href="<?php echo of_get_option('weibo'); ?>" target="_blank" rel="nofollow" class="w-10 h-10 flex items-center justify-center bg-red-500 text-white rounded-lg hover:bg-red-600 transition-colors" title="微博">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M10.098 20.323c-3.977.391-7.414-1.406-7.672-4.02-.259-2.609 2.759-5.047 6.74-5.441 3.979-.394 7.413 1.404 7.671 4.018.259 2.6-2.759 5.049-6.739 5.443zM20.196 9.4a4.068 4.068 0 00-4.568-.894.758.758 0 01-.955-.371.76.76 0 01.37-.957 5.588 5.588 0 016.275 1.229 5.558 5.558 0 011.218 6.283.759.759 0 01-.954.372.76.76 0 01-.37-.956 4.06 4.06 0 00-.016-4.706z"/>
                    <path d="M17.736 11.012a2.527 2.527 0 00-2.84-.557.473.473 0 01-.594-.231.474.474 0 01.23-.596 3.473 3.473 0 013.904.767 3.458 3.458 0 01.758 3.908.473.473 0 01-.594.232.474.474 0 01-.23-.596 2.518 2.518 0 00-.634-2.927z"/>
                </svg>
            </a>
            <?php endif; ?>
            
            <?php if (!empty(of_get_option('github'))): ?>
            <a href="<?php echo of_get_option('github'); ?>" target="_blank" rel="nofollow" class="w-10 h-10 flex items-center justify-center bg-gray-800 text-white rounded-lg hover:bg-gray-900 transition-colors" title="GitHub">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/>
                </svg>
            </a>
            <?php endif; ?>
            
            <?php if (!empty(of_get_option('qq_group'))): ?>
            <a href="<?php echo of_get_option('qq_group'); ?>" target="_blank" rel="nofollow" class="w-10 h-10 flex items-center justify-center bg-blue-400 text-white rounded-lg hover:bg-blue-500 transition-colors" title="QQ群">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
            </a>
            <?php endif; ?>
            
            <a href="/feed" target="_blank" rel="nofollow" class="w-10 h-10 flex items-center justify-center bg-orange-500 text-white rounded-lg hover:bg-orange-600 transition-colors" title="RSS订阅">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 5c7.18 0 13 5.82 13 13M6 11a7 7 0 017 7m-6 0a1 1 0 110-2 1 1 0 010 2z"/>
                </svg>
            </a>
        </div>
    </div>
    <?php endif; ?>
    
    <!-- Widgets -->
    <?php if (is_active_sidebar('sidebar1')): ?>
        <?php dynamic_sidebar('sidebar1'); ?>
    <?php endif; ?>
</aside>

<!-- Wechat modal -->
<div x-data="{ open: false, url: '' }" 
     @show-wechat.window="open = true; url = $event.detail.url"
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
        <h3 class="text-lg font-semibold text-slate-800 dark:text-slate-100 mb-4">扫码添加微信</h3>
        <img :src="url" alt="微信二维码" class="w-full rounded-lg">
        <button @click="open = false" class="mt-4 w-full btn-outline">关闭</button>
    </div>
</div>
