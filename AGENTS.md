# ztheme 主题开发文档

## 主题概述

ztheme 是一个基于 Tailwind CSS 和 Alpine.js 构建的现代化 WordPress 主题，继承自 msimple 主题的核心功能，采用全新的 UI 设计。

## 技术栈

| 组件 | 选择 | 说明 |
|------|------|------|
| CSS 框架 | Tailwind CSS 3.x | Utility-first CSS 框架 |
| JS 交互 | Alpine.js 3.x | 轻量级交互框架，替代 jQuery |
| 图标 | Font Awesome 6.5.1 (Free) | CDN 引入，包含品牌图标和通用图标 |
| 代码高亮 | highlight.js 11.9.0 | 代码语法高亮 |
| 代码主题 | Monokai Sublime | 深色代码主题 |
| Markdown | Parsedown 1.7.4 | Markdown 解析器 |
| 页面预加载 | instant.page 5.2.0 | hover/touch 时预加载，提升页面打开速度 |
| 后端设置 | Options Framework 1.9.1 | 主题设置框架 |

## 文件结构

```
ztheme/
├── style.css                  # 主题声明
├── functions.php              # 核心功能函数
├── core.php                   # 核心业务逻辑（SEO、分页、Markdown等）
├── options.php                # 设置参数定义
├── header.php                 # 头部模板
├── footer.php                 # 底部模板
├── index.php                  # 首页模板
├── single.php                 # 文章页模板
├── page.php                   # 页面模板
├── sidebar.php                # 侧边栏模板
├── comments.php               # 评论模板
├── 404.php                    # 404页面
├── SiteMap.php                # 站点地图模板
├── screenshot.png             # 主题截图
├── tailwind.config.js         # Tailwind 配置
├── package.json               # NPM 配置
├── src/input.css              # Tailwind 源文件
├── dist/styles.css            # 编译后的 CSS
├── inc/                       # Options Framework
├── extend/                    # Parsedown、授权验证等
└── static/
    ├── js/app.js              # 主 JS 文件
    ├── js/highlight.min.js    # 代码高亮
    ├── js/instantpage-5.2.0.js # 页面预加载
    ├── css/monokai-sublime.min.css
    └── images/                # 随机缩略图、头像等
```

## 核心功能

### 继承自 msimple 的功能

- Markdown 解析 (Parsedown)
- SEO 优化（标题/关键词/描述）
- 文章分页
- 分类目录显示
- 随机缩略图
- 文章浏览量统计
- 面包屑导航
- 文章点赞（AJAX）
- 评论邮件通知
- SMTP 邮件配置
- 小工具（侧边栏 + 底部 4 列）
- 导航菜单
- 友情链接
- 彩色标签云
- 垃圾评论过滤
- Gravatar 头像 CDN 缓存
- 搜索关键词屏蔽
- 密码保护文章表单
- 最新评论小工具

### 新增功能

- 暗色/亮色模式切换（本地存储记忆）
- Alpine.js 交互（替代 jQuery）
- Font Awesome 图标系统（CDN 引入）
- 响应式布局（PC/平板/手机）
- 代码块复制按钮
- 图片灯箱查看
- 毛玻璃效果导航栏
- instant.page 页面预加载（hover/touch 时 prefetch）

### 已禁用的功能

- Gutenberg 区块编辑器（使用经典编辑器）
- InstantClick 页面预加载（已替换为 instant.page）
- jQuery 依赖
- 主题授权验证

## 设计规范

### 色彩方案

**亮色模式：**
- 背景：`bg-slate-50` (#f8fafc)
- 卡片：`bg-white` (#ffffff)
- 主色：`bg-blue-500` (#3b82f6)
- 标题：`text-slate-800` (#1e293b)
- 正文：`text-slate-600` (#475669)

**暗色模式：**
- 背景：`dark:bg-slate-900` (#0f172a)
- 卡片：`dark:bg-slate-800` (#1e293b)
- 主色：`dark:text-blue-400` (#60a5fa)
- 标题：`dark:text-slate-100` (#f1f5f9)
- 正文：`dark:text-slate-300` (#cbd5e1)

### 布局结构

```
┌─────────────────────────────────────────────────────────────┐
│  导航栏（毛玻璃效果，固定顶部）                                │
│  [Logo]   [菜单]                [搜索框] [暗色切换] [移动菜单] │
├─────────────────────────────────────────────────────────────┤
│  公告栏（可选）                                               │
├─────────────────────────────────┬───────────────────────────┤
│  推荐选项卡片                    │  侧边栏                   │
│  文章列表（紧凑卡片）            │  - 个人信息               │
│  分页                            │  - 小工具                 │
├─────────────────────────────────┴───────────────────────────┤
│  页脚（版权信息 + 底部小工具）                                │
└─────────────────────────────────────────────────────────────┘
```

### 组件样式

```css
/* 卡片 */
.card {
  @apply bg-white dark:bg-slate-800 rounded-xl shadow-card 
         border border-slate-200/50 dark:border-slate-700/50 
         transition-all duration-300;
}
.card:hover {
  @apply shadow-card-hover -translate-y-0.5;
}

/* 毛玻璃效果 */
.glass {
  @apply backdrop-blur-md bg-white/80 dark:bg-slate-900/80;
}
```

## 设置参数

### 基本设置
- `keywords` - 网站关键词
- `description` - 网站描述
- `footer` - 底部版权（支持 HTML）
- `cdn` - 图片 CDN 加速域名
- `static_cdn` - 静态文件 CDN 开关
- `gravatar` - Gravatar 头像 CDN
- `analysis` - 统计代码

### 首页设置
- `home_notice` - 首页公告内容
- `home_recommend` - 推荐选项（格式：标题|描述|链接|图标名|颜色）

### 个人信息
- `avatar` - 头像 URL
- `nickname` - 昵称
- `region` - 所在地区
- `about_me` - 个人描述
- `wechat` / `qq` / `weibo` / `github` / `twitter` / `qq_group` - 社交链接

### 广告设置
- `gg6` - 文章页标题下方广告
- `single_description` - 文章页描述提示
- `ad_single_bottom` - 打赏上方广告
- `donate` - 打赏二维码图片地址

### SMTP 设置
- `smtp_fromname` - 发件人名称
- `smtp_host` - SMTP 服务器
- `smtp_port` - SMTP 端口
- `smtp_username` - 邮箱用户名
- `smtp_password` - 邮箱密码
- `smtp_protocol` - 发件协议（none/ssl/tls）
- `is_smtp` - 是否启用 SMTP

## 推荐选项格式

```
标题|描述|链接|Font Awesome图标名|颜色
```

示例：
```
ImgURL|开源免费的图床程序|https://imgurl.org/|fa-image|blue
wget.ovh|软件库，只做软件搬运工|https://wget.ovh/|fa-download|green
IPinfo|聚合多接口的IP地址查询工具|https://ip.rss.ink/|fa-map-pin|purple
```

可用颜色：blue、green、purple、orange、red、teal

## CSS 构建

```bash
# 安装依赖
npm install

# 开发模式（监听文件变化）
npm run watch

# 生产模式（压缩）
npm run build
```

## 自定义开发

### 修改颜色主题

编辑 `tailwind.config.js` 中的 `colors.primary` 配置。

### 修改布局

编辑对应的模板文件：
- 首页：`index.php`
- 文章页：`single.php`
- 侧边栏：`sidebar.php`
- 导航栏：`header.php`

### 添加新功能

1. PHP 功能添加到 `functions.php` 或 `core.php`
2. JS 交互添加到 `static/js/app.js`
3. CSS 样式添加到 `src/input.css`（需要重新构建）

## 注意事项

1. 修改 CSS 后需要运行 `npm run build` 重新编译
2. 设置参数使用 `of_get_option('参数名')` 获取
3. 暗色模式使用 Tailwind 的 `dark:` 前缀
4. Alpine.js 组件使用 `x-data`、`x-show` 等指令
5. 图标使用 Font Awesome 6.5.1 (Free)，通过 CDN 引入

## 兼容性

- WordPress 5.9+
- PHP 7.4+
- 现代浏览器（Chrome、Firefox、Safari、Edge）
- 响应式支持（PC、平板、手机）
