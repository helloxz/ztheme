<!DOCTYPE html>
<html lang="zh-cmn-Hans" x-data="{ dark: localStorage.getItem('theme') === 'dark' }" :class="{ 'dark': dark }" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=5">
    <title><?php ztheme_title(); ?></title>
    <?php ztheme_seo(); ?>
    <script>
        (function() {
            var theme = localStorage.getItem('theme');
            if (theme === 'dark') {
                document.documentElement.classList.add('dark');
            } else if (theme === 'light') {
                document.documentElement.classList.remove('dark');
            }
        })();
    </script>
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/static/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/dist/styles.css?v=<?php echo wp_get_theme()->get('Version'); ?>">
    <?php if (!empty(of_get_option('analysis'))): ?>
    <script><?php echo of_get_option('analysis'); ?></script>
    <?php endif; ?>
    <?php ztheme_header_txt(); ?>
    <?php wp_head(); ?>
</head>
<body class="min-h-screen bg-slate-50 dark:bg-slate-900 text-slate-600 dark:text-slate-300 transition-colors duration-300">
    
    <!-- Back to top button -->
    <div x-data="{ show: false }" 
         @scroll.window="show = (window.scrollY > 300)"
         x-show="show"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 translate-y-4"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 translate-y-4"
         class="fixed bottom-8 right-8 z-50">
        <button @click="window.scrollTo({ top: 0, behavior: 'smooth' })" class="flex items-center justify-center w-12 h-12 bg-primary-500 hover:bg-primary-600 text-white rounded-full shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1" title="返回顶部">
            <i class="fa-solid fa-arrow-up text-base"></i>
        </button>
    </div>
    
    <!-- Header -->
    <header id="top" class="sticky top-0 z-40 glass border-b border-slate-200/50 dark:border-slate-700/50 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <!-- Logo + Navigation (left side) -->
                <div class="flex items-center gap-8">
                    <!-- Logo -->
                    <div class="flex-shrink-0">
                        <a href="<?php bloginfo('url'); ?>" class="flex items-center gap-3 group">
                            <?php if (has_custom_logo()): ?>
                                <?php the_custom_logo(); ?>
                            <?php else: ?>
                                <div class="w-8 h-8 bg-primary-500 rounded-lg flex items-center justify-center">
                                    <span class="text-white font-bold text-lg"><?php echo mb_substr(get_bloginfo('name'), 0, 1); ?></span>
                                </div>
                                <div>
                                    <h1 class="text-lg font-bold text-slate-800 dark:text-slate-100 group-hover:text-primary-500 dark:group-hover:text-primary-400 transition-colors"><?php bloginfo('name'); ?></h1>
                                </div>
                            <?php endif; ?>
                        </a>
                    </div>
                    
                    <!-- PC Navigation -->
                    <nav class="hidden xl:block">
                        <?php
                        wp_nav_menu(array(
                            'theme_location' => 'header-menu',
                            'menu_class'     => 'flex items-center gap-1',
                            'walker'         => new Ztheme_Nav_Walker(),
                            'container'      => false,
                            'fallback_cb'    => false,
                        ));
                        ?>
                    </nav>
                </div>
                
                <!-- Right side: Search + Dark mode -->
                <div class="flex items-center gap-2">
                    <!-- Search (desktop) -->
                    <div class="hidden xl:block">
                        <form action="/" method="GET" class="relative">
                            <input type="text" name="s" placeholder="搜索..." class="w-48 lg:w-56 px-4 py-2 text-sm bg-slate-100 dark:bg-slate-800 border-0 rounded-lg focus:ring-2 focus:ring-primary-500 focus:bg-white dark:focus:bg-slate-700 outline-none transition-all">
                            <button type="submit" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-primary-500 transition-colors">
                                <i class="fa-solid fa-magnifying-glass text-sm"></i>
                            </button>
                        </form>
                    </div>
                    
                    <!-- Dark mode toggle -->
                    <button @click="dark = !dark; localStorage.setItem('theme', dark ? 'dark' : 'light')" class="inline-flex items-center justify-center py-2 px-3 bg-slate-100 dark:bg-slate-800 text-slate-500 dark:text-slate-400 hover:text-primary-500 dark:hover:text-primary-400 rounded-lg transition-all" title="切换暗色模式">
                        <i x-show="!dark" class="fa-solid fa-moon text-sm"></i>
                        <i x-show="dark" x-cloak class="fa-solid fa-sun text-sm"></i>
                    </button>
                    
                    <!-- Mobile buttons -->
                    <div class="flex items-center gap-2 xl:hidden">
                        <!-- Search button (mobile) -->
                        <button @click="$dispatch('toggle-search')" class="inline-flex items-center justify-center py-2 px-3 bg-slate-100 dark:bg-slate-800 text-slate-500 dark:text-slate-400 hover:text-primary-500 dark:hover:text-primary-400 rounded-lg transition-all">
                            <i class="fa-solid fa-magnifying-glass text-sm"></i>
                        </button>
                        
                        <!-- Mobile menu button -->
                        <button x-data="{ mobileMenu: false }" @click="mobileMenu = !mobileMenu; $dispatch('toggle-mobile-menu', { open: mobileMenu })" class="inline-flex items-center justify-center py-2 px-3 bg-slate-100 dark:bg-slate-800 text-slate-500 dark:text-slate-400 hover:text-primary-500 dark:hover:text-primary-400 rounded-lg transition-all">
                            <i x-show="!mobileMenu" class="fa-solid fa-bars text-sm"></i>
                            <i x-show="mobileMenu" x-cloak class="fa-solid fa-xmark text-sm"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Mobile menu -->
        <div x-data="{ open: false }" 
             @toggle-mobile-menu.window="open = $event.detail.open"
             x-show="open"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 -translate-y-4"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 -translate-y-4"
             x-cloak
             class="xl:hidden border-t border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800">
            <div class="px-4 py-4 space-y-2">
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'mobile_menu',
                    'menu_class'     => 'space-y-1',
                    'walker'         => new Ztheme_Mobile_Walker(),
                    'container'      => false,
                    'fallback_cb'    => false,
                ));
                ?>
            </div>
        </div>
    </header>
    
    <!-- Mobile search overlay -->
    <div x-data="{ open: false }" 
         @toggle-search.window="open = !open"
         x-show="open"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         x-cloak
         class="fixed inset-0 z-50 bg-black/50 backdrop-blur-sm xl:hidden"
         @click.self="open = false">
        <div class="p-4">
            <form action="/" method="GET" class="relative">
                <input type="text" name="s" placeholder="搜索文章..." class="w-full px-5 py-4 text-lg bg-white dark:bg-slate-800 rounded-xl shadow-xl outline-none focus:ring-2 focus:ring-primary-500" autofocus>
                <button type="submit" class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400">
                    <i class="fa-solid fa-magnifying-glass text-lg"></i>
                </button>
            </form>
        </div>
    </div>
    
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <?php if ((is_home() || is_front_page()) && !empty(of_get_option('home_notice'))): ?>
        <div class="mb-6 p-4 bg-primary-50 dark:bg-primary-900/20 border border-primary-200 dark:border-primary-800 rounded-xl">
            <div class="flex items-center gap-3">
                    <div class="flex-shrink-0">
                        <i class="fa-solid fa-bell text-base text-primary-500"></i>
                    </div>
                    <div>
                        <p class="text-sm text-primary-800 dark:text-primary-200"><?php echo of_get_option('home_notice'); ?></p>
                    </div>
                </div>
        </div>
        <?php endif; ?>

        <?php if (!is_home() && !is_front_page() || is_paged()): ?>
        <!-- Breadcrumbs - Full width bar -->
        <div class="mb-6 px-4 py-3 bg-slate-100 dark:bg-slate-800/50 rounded-lg">
            <?php ztheme_breadcrumbs(); ?>
        </div>
        <?php endif; ?>

        <div class="flex flex-col lg:flex-row gap-8">
