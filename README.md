# ztheme

一款基于 Tailwind CSS + Alpine.js 构建的现代化 WordPress 博客主题，采用全新 UI 设计，简约而不简单。

![CleanShot 2026-06-21 at 17.08.00@2x.png](https://img.rss.ink/2026/06/21/Jb9KU2bb.png)

## 特点

- **Markdown 写作** — 原生支持 Markdown 语法，写作更高效
- **暗色/亮色模式** — 一键切换，自动记忆偏好
- **毛玻璃导航栏** — 固定顶部，现代质感
- **内置代码高亮 + 一键复制** — 技术博客友好
- **图片灯箱查看** — 点击图片大图浏览
- **SEO 优化** — 自动提取标题、关键词、描述
- **面包屑导航** — 清晰的文章层级路径
- **文章点赞 & 浏览统计** — 互动与数据一目了然
- **评论邮件通知** — 内置支持 SMTP，收到回复即时通知
- **响应式布局** — 完美适配手机、平板、电脑
- **可视化后台设置** — 无需改代码，后台轻松配置
- **经典编辑器** — 禁用 Gutenberg，回归简洁写作体验
- **UA屏蔽** — 可设置屏蔽特定 UA 访问，提升安全性

## 技术栈

| 组件 | 选择 |
|------|------|
| CSS 框架 | Tailwind CSS 3.x |
| JS 交互 | Alpine.js 3.x |
| 图标 | Font Awesome 6.5.1 |
| 代码高亮 | highlight.js 11.9.0 |
| Markdown | Parsedown 1.7.4 |
| 后台设置 | Options Framework 1.9.1 |

## 安装

1. 下载主题 zip 包，或克隆本仓库到 WordPress 的 `wp-content/themes/` 目录
2. 进入 WordPress 后台 → 外观 → 主题，启用 **ztheme**
3. 进入 外观 → 主题设置，根据需要配置各项参数

## 开发构建

如需自定义样式，修改 `src/input.css` 后重新编译：

```bash
# 安装依赖
npm install

# 开发模式（监听文件变化）
npm run watch

# 生产模式（压缩输出）
npm run build
```

## 兼容性

- WordPress 5.9+
- PHP 7.4+
- 现代浏览器（Chrome、Firefox、Safari、Edge）

## 联系方式

- 博客：[https://blog.xiaoz.org](https://blog.xiaoz.org)
- X (Twitter)：[https://x.com/xiaozblog](https://x.com/xiaozblog)
