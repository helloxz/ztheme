<?php
/**
 * Options Framework Settings
 * Compatible with msimple settings to preserve existing options
 */

function optionsframework_option_name() {
    $option_name = get_option('stylesheet');
    $option_name = preg_replace("/\W/", "_", strtolower($option_name));
    return $option_name;
}

function optionsframework_options() {
    // SMTP protocol options
    $smtp_protocol_arr = array(
        'none' => __('无', 'ztheme'),
        'ssl'  => __('SSL', 'ztheme'),
        'tls'  => __('TLS', 'ztheme'),
    );
    
    // SMTP enable options
    $is_smtp_arr = array(
        'false' => __('否', 'ztheme'),
        'true'  => __('是', 'ztheme'),
    );
    
    $options = array();
    
    // Basic Settings
    $options[] = array(
        'name' => '基本设置',
        'type' => 'heading',
    );
    
    $options[] = array(
        'name' => __('网站关键词', 'ztheme'),
        'desc' => __('多个关键词请用英文逗号分隔', 'ztheme'),
        'id'   => 'keywords',
        'std'  => 'ztheme',
        'type' => 'text',
    );
    
    $options[] = array(
        'name' => __('网站描述', 'ztheme'),
        'desc' => __('一般不超过200字', 'ztheme'),
        'id'   => 'description',
        'std'  => '使用ztheme主题，现代化设计，支持Markdown写作。',
        'type' => 'textarea',
    );
    
    $options[] = array(
        'name' => __('底部版权', 'ztheme'),
        'desc' => __('支持HTML代码', 'ztheme'),
        'id'   => 'footer',
        'std'  => 'Copyright &copy; ' . date('Y') . '. Theme by <a href="https://www.xiaoz.me/" target="_blank" class="text-primary-400 hover:text-primary-300">ztheme</a>',
        'type' => 'textarea',
    );
    
    $options[] = array(
        'name' => __('图片加速', 'ztheme'),
        'desc' => __('替换文章中的图片为CDN地址，请填写CDN加速域名，比如：cdn.example.com（注意：不需要http://）', 'ztheme'),
        'id'   => 'cdn',
        'std'  => '',
        'type' => 'text',
    );
    
    $options[] = array(
        'name' => __('静态文件CDN', 'ztheme'),
        'desc' => __('启用后将从CDN加载静态文件', 'ztheme'),
        'id'   => 'static_cdn',
        'std'  => '',
        'type' => 'checkbox',
    );
    
    $options[] = array(
        'name' => __('Gravatar头像加速', 'ztheme'),
        'desc' => __('替换Gravatar头像为第三方CDN，注意不需要http://', 'ztheme'),
        'id'   => 'gravatar',
        'std'  => 'gravatar.loli.net',
        'type' => 'text',
    );
    
    $options[] = array(
        'name' => __('统计代码', 'ztheme'),
        'desc' => __('请输入统计代码', 'ztheme'),
        'id'   => 'analysis',
        'std'  => '',
        'type' => 'textarea',
    );
    
    // Homepage Settings
    $options[] = array(
        'name' => '首页设置',
        'type' => 'heading',
    );
    
    $options[] = array(
        'name' => __('首页公告', 'ztheme'),
        'desc' => __('首页公告内容，留空则不显示公告', 'ztheme'),
        'id'   => 'home_notice',
        'std'  => '',
        'type' => 'textarea',
    );
    
    $options[] = array(
        'name' => __('首页推荐选项', 'ztheme'),
        'desc' => __('格式：标题|描述|链接，每行一个。前端使用固定图标，仅桌面端显示；旧格式中多出的字段会自动忽略', 'ztheme'),
        'id'   => 'home_recommend',
        'std'  => 'ImgURL|开源免费的图床程序|https://imgurl.org/
wget.ovh|软件库，只做软件搬运工|https://wget.ovh/
IPinfo|聚合多接口的IP地址查询工具|https://ip.rss.ink/',
        'type' => 'textarea',
    );
    
    $options[] = array(
        'name' => __('首页赞助商', 'ztheme'),
        'desc' => __('格式：名称|链接|图片URL，每行一个。仅首页底部友情链接上方显示', 'ztheme'),
        'id'   => 'home_sponsors',
        'std'  => '',
        'type' => 'textarea',
    );

    // Category settings (reserved)
    $options[] = array(
        'name' => __('首页分类目录1', 'ztheme'),
        'desc' => __('格式为"分类目录ID|分类目录名|图标名称|颜色"（备用）', 'ztheme'),
        'id'   => 'cat1',
        'std'  => '',
        'type' => 'text',
    );
    
    $options[] = array(
        'name' => __('首页分类目录2', 'ztheme'),
        'desc' => __('格式为"分类目录ID|分类目录名|图标名称|颜色"（备用）', 'ztheme'),
        'id'   => 'cat2',
        'std'  => '',
        'type' => 'text',
    );
    
    $options[] = array(
        'name' => __('首页分类目录3', 'ztheme'),
        'desc' => __('格式为"分类目录ID|分类目录名|图标名称|颜色"（备用）', 'ztheme'),
        'id'   => 'cat3',
        'std'  => '',
        'type' => 'text',
    );
    
    $options[] = array(
        'name' => __('首页分类目录4', 'ztheme'),
        'desc' => __('格式为"分类目录ID|分类目录名|图标名称|颜色"（备用）', 'ztheme'),
        'id'   => 'cat4',
        'std'  => '',
        'type' => 'text',
    );
    
    // Personal Info
    $options[] = array(
        'name' => '个人信息',
        'type' => 'heading',
    );
    
    $options[] = array(
        'name' => __('您的头像', 'ztheme'),
        'desc' => __('请输入头像URL地址，建议大小为120x120', 'ztheme'),
        'id'   => 'avatar',
        'std'  => '',
        'type' => 'text',
    );
    
    $options[] = array(
        'name' => __('您的昵称', 'ztheme'),
        'desc' => __('请取个霸气的名字', 'ztheme'),
        'id'   => 'nickname',
        'std'  => 'admin',
        'type' => 'text',
    );
    
    $options[] = array(
        'name' => __('所在地区', 'ztheme'),
        'desc' => __('用于首页右侧显示', 'ztheme'),
        'id'   => 'region',
        'std'  => '火星',
        'type' => 'text',
    );
    
    $options[] = array(
        'name' => __('个人描述', 'ztheme'),
        'desc' => __('用于首页右侧显示', 'ztheme'),
        'id'   => 'about_me',
        'std'  => '一个帅气的小伙子。',
        'type' => 'textarea',
    );
    
    $options[] = array(
        'name' => __('微信', 'ztheme'),
        'desc' => __('填写微信二维码图片地址', 'ztheme'),
        'id'   => 'wechat',
        'std'  => '',
        'type' => 'text',
    );
    
    $options[] = array(
        'name' => __('QQ', 'ztheme'),
        'desc' => __('填写QQ号码', 'ztheme'),
        'id'   => 'qq',
        'std'  => '',
        'type' => 'text',
    );
    
    $options[] = array(
        'name' => __('微博', 'ztheme'),
        'desc' => __('填写微博链接', 'ztheme'),
        'id'   => 'weibo',
        'std'  => '',
        'type' => 'text',
    );
    
    $options[] = array(
        'name' => __('Github', 'ztheme'),
        'desc' => __('填写Github链接', 'ztheme'),
        'id'   => 'github',
        'std'  => '',
        'type' => 'text',
    );
    
    $options[] = array(
        'name' => __('X (Twitter)', 'ztheme'),
        'desc' => __('填写X用户ID，例如：xiaozblog', 'ztheme'),
        'id'   => 'twitter',
        'std'  => '',
        'type' => 'text',
    );
    
    $options[] = array(
        'name' => __('QQ群链接', 'ztheme'),
        'desc' => __('填写QQ群链接', 'ztheme'),
        'id'   => 'qq_group',
        'std'  => '',
        'type' => 'text',
    );
    
    // Advertisement Settings
    $options[] = array(
        'name' => '广告设置',
        'type' => 'heading',
    );
    
    $options[] = array(
        'name' => __('文章页顶部广告', 'ztheme'),
        'desc' => __('格式：每3行为一组（链接URL、图片URL、广告名称），留空不显示', 'ztheme'),
        'id'   => 'gg6',
        'std'  => '',
        'type' => 'textarea',
    );
    
    $options[] = array(
        'name' => __('文章页标题下面的描述', 'ztheme'),
        'desc' => __('留空则不显示', 'ztheme'),
        'id'   => 'single_description',
        'std'  => '',
        'type' => 'text',
    );
    
    $options[] = array(
        'name' => __('文章页底部广告', 'ztheme'),
        'desc' => __('格式：每3行为一组（链接URL、图片URL、广告名称），留空不显示', 'ztheme'),
        'id'   => 'ad_single_bottom',
        'std'  => '',
        'type' => 'textarea',
    );
    
    $options[] = array(
        'name' => __('首页广告', 'ztheme'),
        'desc' => __('格式：每3行为一组（链接URL、图片URL、广告名称），留空不显示', 'ztheme'),
        'id'   => 'home_ad',
        'std'  => '',
        'type' => 'textarea',
    );
    
    // SMTP Settings
    $options[] = array(
        'name' => 'SMTP设置',
        'type' => 'heading',
    );
    
    $options[] = array(
        'name' => __('发件人', 'ztheme'),
        'desc' => __('发件人昵称', 'ztheme'),
        'id'   => 'smtp_fromname',
        'std'  => '',
        'type' => 'text',
    );
    
    $options[] = array(
        'name' => __('SMTP服务器', 'ztheme'),
        'desc' => __('填写SMTP服务器地址', 'ztheme'),
        'id'   => 'smtp_host',
        'std'  => '',
        'type' => 'text',
    );
    
    $options[] = array(
        'name' => __('SMTP端口', 'ztheme'),
        'desc' => __('SSL协议一般为465端口', 'ztheme'),
        'id'   => 'smtp_port',
        'std'  => 465,
        'type' => 'text',
    );
    
    $options[] = array(
        'name' => __('用户名', 'ztheme'),
        'desc' => __('邮箱用户名', 'ztheme'),
        'id'   => 'smtp_username',
        'std'  => '',
        'type' => 'text',
    );
    
    $options[] = array(
        'name' => __('密码', 'ztheme'),
        'desc' => __('邮箱SMTP专属密码', 'ztheme'),
        'id'   => 'smtp_password',
        'std'  => '',
        'type' => 'password',
    );
    
    $options[] = array(
        'name' => __('发件协议', 'ztheme'),
        'desc' => __('请选择发件协议', 'ztheme'),
        'id'   => 'smtp_protocol',
        'std'  => 'none',
        'type' => 'select',
        'options' => $smtp_protocol_arr,
    );
    
    $options[] = array(
        'name' => __('是否启用SMTP', 'ztheme'),
        'desc' => '',
        'id'   => 'is_smtp',
        'std'  => 'false',
        'type' => 'radio',
        'options' => $is_smtp_arr,
    );
    
    return $options;
}
