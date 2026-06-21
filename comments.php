<?php
/**
 * Comments template
 */

if (!defined('ABSPATH')) {
    exit;
}

if (post_password_required()) {
    return;
}

// Custom comment callback
function ztheme_comment($comment, $args, $depth) {
    $GLOBALS['comment'] = $comment;
    $tag = ('div' === $args['style']) ? 'div' : 'li';
    $parent_comment_id = $comment->comment_parent;
    $parent_comment = $parent_comment_id ? get_comment($parent_comment_id) : null;
    $is_child = $depth >= 2;
    ?>
    <<?php echo $tag; ?> <?php comment_class(empty($args['has_children']) ? '' : 'parent'); ?> id="comment-<?php comment_ID() ?>">
        <article id="div-comment-<?php comment_ID(); ?>" class="comment-body <?php echo $is_child ? 'comment-child' : 'comment-parent'; ?>">
            <div class="flex gap-3">
                <!-- Avatar -->
                <div class="flex-shrink-0">
                    <?php if (0 != $args['avatar_size']) echo get_avatar($comment, $args['avatar_size'], '', '', array('class' => 'rounded-full')); ?>
                </div>
                
                <div class="flex-1 min-w-0">
                    <!-- Comment meta -->
                    <div class="flex flex-wrap items-center gap-2 mb-1.5">
                        <span class="font-semibold text-slate-800 dark:text-slate-100 text-sm">
                            <?php printf('%s', get_comment_author_link()); ?>
                        </span>
                        <?php if ($parent_comment): ?>
                        <span class="text-xs text-slate-400">
                            <i class="fa-solid fa-reply fa-flip-horizontal text-[10px] mr-0.5"></i>
                            <?php echo htmlspecialchars(get_comment_author($parent_comment_id)); ?>
                        </span>
                        <?php endif; ?>
                        <time datetime="<?php comment_time('c'); ?>" class="text-xs text-slate-400">
                            <?php echo get_comment_date('Y-m-d H:i'); ?>
                        </time>
                        <?php if ('0' == $comment->comment_approved): ?>
                        <span class="text-xs text-amber-500 bg-amber-50 dark:bg-amber-900/20 px-1.5 py-0.5 rounded">等待审核</span>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Comment content -->
                    <div class="text-slate-600 dark:text-slate-400 text-sm leading-relaxed mb-2 break-words">
                        <?php comment_text(); ?>
                    </div>
                    
                    <!-- Reply link -->
                    <div class="flex items-center gap-4">
                        <?php comment_reply_link(array_merge($args, array(
                            'add_below' => 'div-comment',
                            'depth'     => $depth,
                            'max_depth' => $args['max_depth'],
                            'before'    => '',
                            'after'     => '',
                        ))); ?>
                    </div>
                </div>
            </div>
        </article>
    <?php
}
?>

<div id="comments" class="card p-6 md:p-8">
    <?php comment_form(array(
        'class_form'    => 'space-y-4',
        'class_submit'  => 'btn-primary',
        'label_submit'  => '发表评论',
        'comment_field' => '<div class="mb-4"><textarea id="comment" name="comment" class="input-field min-h-[100px]" placeholder="请输入评论内容..." required></textarea></div>',
        'fields'        => array(
            'author' => '<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4"><div><input type="text" name="author" id="author" class="input-field" placeholder="昵称 *" required></div>',
            'email'  => '<div><input type="email" name="email" id="email" class="input-field" placeholder="邮箱 *" required></div>',
            'url'    => '<div><input type="url" name="url" id="url" class="input-field" placeholder="网站（选填）"></div></div>',
        ),
    )); ?>
    
    <?php if (have_comments()): ?>
    <hr class="my-6 border-slate-200 dark:border-slate-700">
    
    <h3 class="text-lg font-semibold text-slate-800 dark:text-slate-100 mb-6">
        已有 <?php echo get_comments_number(); ?> 条评论
    </h3>
    
    <ol class="comment-list">
        <?php
        wp_list_comments(array(
            'style'       => 'ol',
            'short_ping'  => true,
            'avatar_size' => 40,
            'callback'    => 'ztheme_comment',
        ));
        ?>
    </ol>
    
    <?php
    $cpage = get_query_var('cpage', 1);
    $max_cpage = get_comment_pages_count();
    if ($max_cpage > 1):
    ?>
    <nav class="flex items-center justify-center gap-3 mt-6">
        <?php if ($cpage < $max_cpage): ?>
        <a href="<?php echo esc_url(get_comments_pagenum_link($cpage + 1)); ?>" class="btn-outline text-sm">
            <i class="fa-solid fa-chevron-left text-xs mr-1"></i> 更早的评论
        </a>
        <?php endif; ?>
        <?php if ($cpage > 1): ?>
        <a href="<?php echo esc_url(get_comments_pagenum_link($cpage - 1)); ?>" class="btn-primary text-sm">
            较新的评论 <i class="fa-solid fa-chevron-right text-xs ml-1"></i>
        </a>
        <?php endif; ?>
    </nav>
    <?php endif; ?>
    
    <?php if (!comments_open()): ?>
    <p class="mt-6 text-center text-slate-400 dark:text-slate-500 text-sm"><i class="fas fa-comment-slash mr-1"></i> 评论已关闭</p>
    <?php endif; ?>
    
    <?php elseif (!comments_open()): ?>
    <p class="text-center text-slate-400 dark:text-slate-500 text-sm"><i class="fas fa-comment-slash mr-1"></i> 评论已关闭</p>
    
    <?php endif; ?>
</div>
