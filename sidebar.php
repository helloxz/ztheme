<!-- DEBUG: sidebar.php start -->
<!-- Sidebar -->
<aside class="w-full lg:w-80 flex-shrink-0">
    <?php
    $avatar   = of_get_option('avatar', get_bloginfo('template_url') . '/static/images/avatar_120.jpg');
    $nickname = of_get_option('nickname', 'admin');
    $region   = of_get_option('region', '火星');
    $about_me = of_get_option('about_me', '一个帅气的小伙子。');
    $wechat   = of_get_option('wechat');
    $qq       = of_get_option('qq');
    $weibo    = of_get_option('weibo');
    $github   = of_get_option('github');
    $twitter  = of_get_option('twitter');
    $qq_group = of_get_option('qq_group');
    ?>

    <!-- Personal info (homepage only) -->
    <?php if (is_home() || is_front_page()): ?>
    <div class="card p-6 mb-6">
        <!-- Avatar -->
        <div class="flex justify-center mb-4">
            <img src="<?php echo esc_url($avatar); ?>" alt="<?php echo esc_attr($nickname); ?>" class="w-20 h-20 rounded-full border-4 border-slate-100 dark:border-slate-700 shadow-lg">
        </div>
        
        <!-- Name and location -->
        <div class="text-center mb-4">
            <h3 class="text-lg font-semibold text-slate-800 dark:text-slate-100"><?php echo esc_html($nickname); ?></h3>
            <p class="text-sm text-slate-500 dark:text-slate-400 flex items-center justify-center gap-1 mt-1">
                <i class="fa-solid fa-location-dot text-sm"></i>
                <?php echo esc_html($region); ?>
            </p>
        </div>
        
        <!-- About me -->
        <div class="bg-slate-50 dark:bg-slate-700/50 rounded-lg p-4 mb-4">
            <p class="text-sm text-slate-600 dark:text-slate-400"><?php echo esc_html($about_me); ?></p>
        </div>
        
        <!-- Social icons -->
        <div class="flex justify-center flex-wrap gap-3">
            <?php if (!empty($wechat)): ?>
            <button type="button" @click="$dispatch('show-wechat', { url: '<?php echo esc_js($wechat); ?>' })" class="w-10 h-10 flex items-center justify-center bg-green-500 text-white rounded-lg hover:bg-green-600 transition-colors" title="微信">
                <i class="fa-brands fa-weixin text-lg" style="color: white"></i>
            </button>
            <?php endif; ?>
            
            <?php if (!empty($qq)): ?>
            <a href="<?php echo esc_url('https://wpa.qq.com/msgrd?v=3&uin=' . rawurlencode($qq) . '&site=qq&menu=yes'); ?>" target="_blank" rel="nofollow" class="w-10 h-10 flex items-center justify-center bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors" title="<?php echo esc_attr('QQ:' . $qq); ?>">
                <i class="fa-brands fa-qq text-lg" style="color: white"></i>
            </a>
            <?php endif; ?>
            
            <?php if (!empty($weibo)): ?>
            <a href="<?php echo esc_url($weibo); ?>" target="_blank" rel="nofollow" class="w-10 h-10 flex items-center justify-center bg-red-500 text-white rounded-lg hover:bg-red-600 transition-colors" title="微博">
                <i class="fa-brands fa-weibo text-lg" style="color: white"></i>
            </a>
            <?php endif; ?>
            
            <?php if (!empty($twitter)): ?>
            <a href="<?php echo esc_url('https://x.com/' . $twitter); ?>" target="_blank" rel="nofollow" class="w-10 h-10 flex items-center justify-center bg-black text-white rounded-lg hover:bg-gray-800 transition-colors" title="X">
                <i class="fa-brands fa-x-twitter text-lg" style="color: white"></i>
            </a>
            <?php endif; ?>
            
            <?php if (!empty($github)): ?>
            <a href="<?php echo esc_url($github); ?>" target="_blank" rel="nofollow" class="w-10 h-10 flex items-center justify-center bg-gray-800 dark:bg-gray-900 text-white rounded-lg hover:bg-gray-900 dark:hover:bg-black transition-colors" title="GitHub">
                <i class="fa-brands fa-github text-lg" style="color: white"></i>
            </a>
            <?php endif; ?>
            
            <?php if (!empty($qq_group)): ?>
            <a href="<?php echo esc_url($qq_group); ?>" target="_blank" rel="nofollow" class="w-10 h-10 flex items-center justify-center bg-blue-400 text-white rounded-lg hover:bg-blue-500 transition-colors" title="QQ群">
                <i class="fa-solid fa-users text-lg" style="color: white"></i>
            </a>
            <?php endif; ?>
        </div>
    </div>
    <?php endif; ?>
    
    <!-- DEBUG: sidebar.php before dynamic_sidebar -->
    <!-- Widgets -->
    <?php if (is_active_sidebar('sidebar1')): ?>
        <?php
        ob_start();
        dynamic_sidebar('sidebar1');
        $sidebar_widgets = ob_get_clean();

        // Keep malformed widget markup from leaking outside the sidebar layout.
        echo force_balance_tags($sidebar_widgets);
        ?>
    <?php endif; ?>
    <!-- DEBUG: sidebar.php after dynamic_sidebar -->

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
</aside>
<!-- DEBUG: sidebar.php end -->
