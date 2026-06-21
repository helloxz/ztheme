/**
 * ztheme app.js
 * Main JavaScript file with Alpine.js interactions
 */

// Code highlighting and copy buttons
function initHighlightAndCopyButtons() {
    document.querySelectorAll('pre code').forEach((block) => {
        // Highlight if not already done
        if (!block.dataset.highlighted) {
            hljs.highlightElement(block);
            block.dataset.highlighted = 'yes';
        }
        
        // Add copy button if not exists
        if (!block.parentNode.querySelector('.copy-btn')) {
            const pre = block.parentNode;
            if (pre.style.position !== 'relative') {
                pre.style.position = 'relative';
            }
            
            // Create copy button
            const btn = document.createElement('button');
            btn.className = 'copy-btn absolute top-3 right-3 w-8 h-8 flex items-center justify-center bg-slate-700 hover:bg-slate-600 text-slate-300 hover:text-white rounded-lg leading-none';
            btn.innerHTML = '<i class="fa-regular fa-copy text-sm"></i>';
            
            // Add click handler
            btn.addEventListener('click', async function() {
                try {
                    await navigator.clipboard.writeText(block.textContent);
                    btn.innerHTML = '<i class="fa-solid fa-check text-sm"></i>';
                    btn.classList.add('bg-green-600', 'text-white');
                    
                    setTimeout(() => {
                        btn.innerHTML = '<i class="fa-regular fa-copy text-sm"></i>';
                        btn.classList.remove('bg-green-600', 'text-white');
                    }, 2000);
                } catch (err) {
                    // Fallback for older browsers
                    const textArea = document.createElement('textarea');
                    textArea.value = block.textContent;
                    textArea.style.position = 'fixed';
                    textArea.style.left = '-9999px';
                    document.body.appendChild(textArea);
                    textArea.select();
                    try {
                        document.execCommand('copy');
                        btn.innerHTML = '<i class="fa-solid fa-check text-sm"></i>';
                    } catch (e) {
                        console.error('Copy failed:', e);
                    }
                    document.body.removeChild(textArea);
                }
            });
            
            pre.appendChild(btn);
        }
    });
}

// Image lightbox
function initImageLightbox() {
    const content = document.getElementById('content');
    if (!content) return;
    
    // Create lightbox container
    const lightbox = document.createElement('div');
    lightbox.id = 'lightbox';
    lightbox.className = 'fixed inset-0 z-50 hidden items-center justify-center bg-black/90 backdrop-blur-sm cursor-zoom-out';
    lightbox.innerHTML = `
        <img id="lightbox-img" class="max-w-[90vw] max-h-[90vh] object-contain rounded-lg shadow-2xl" src="" alt="">
        <button class="absolute top-4 right-4 p-2 text-white/80 hover:text-white bg-black/50 rounded-full transition-colors" onclick="closeLightbox()">
            <i class="fa-solid fa-xmark text-lg"></i>
        </button>
    `;
    document.body.appendChild(lightbox);
    
    // Add click handlers to images
    content.querySelectorAll('img').forEach(img => {
        img.style.cursor = 'zoom-in';
        img.addEventListener('click', () => {
            const lightboxEl = document.getElementById('lightbox');
            const lightboxImg = document.getElementById('lightbox-img');
            lightboxImg.src = img.src;
            lightboxImg.alt = img.alt;
            lightboxEl.classList.remove('hidden');
            lightboxEl.classList.add('flex');
            document.body.style.overflow = 'hidden';
        });
    });
    
    // Close on click
    lightbox.addEventListener('click', closeLightbox);
    
    // Close on escape
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') closeLightbox();
    });
}

function closeLightbox() {
    const lightbox = document.getElementById('lightbox');
    if (lightbox) {
        lightbox.classList.add('hidden');
        lightbox.classList.remove('flex');
        document.body.style.overflow = '';
    }
}

// Table responsive wrapper
function initResponsiveTables() {
    document.querySelectorAll('#content table').forEach(table => {
        if (!table.parentNode.classList.contains('overflow-x-auto')) {
            const wrapper = document.createElement('div');
            wrapper.className = 'overflow-x-auto my-4 rounded-lg border border-slate-200 dark:border-slate-700';
            table.parentNode.insertBefore(wrapper, table);
            wrapper.appendChild(table);
            table.classList.add('w-full', 'text-sm');
        }
    });
}

// External links
function initExternalLinks() {
    document.querySelectorAll('#content a').forEach(link => {
        if (link.hostname !== window.location.hostname && !link.hasAttribute('target')) {
            link.setAttribute('target', '_blank');
            link.setAttribute('rel', 'noopener noreferrer');
        }
    });
}

// Smooth scroll for anchor links
function initSmoothScroll() {
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            const targetId = this.getAttribute('href');
            if (targetId === '#') return;
            
            const target = document.querySelector(targetId);
            if (target) {
                e.preventDefault();
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
}

// Comment info localStorage
function saveCommentInfo() {
    const author = document.getElementById('author');
    const email = document.getElementById('email');
    const url = document.getElementById('url');
    
    if (author || email || url) {
        const commentInfo = {
            author: author?.value || '',
            email: email?.value || '',
            url: url?.value || ''
        };
        localStorage.setItem('ztheme_comment_info', JSON.stringify(commentInfo));
    }
}

function loadCommentInfo() {
    const saved = localStorage.getItem('ztheme_comment_info');
    if (!saved) return;
    
    try {
        const info = JSON.parse(saved);
        const author = document.getElementById('author');
        const email = document.getElementById('email');
        const url = document.getElementById('url');
        
        if (author && info.author) author.value = info.author;
        if (email && info.email) email.value = info.email;
        if (url && info.url) url.value = info.url;
    } catch (e) {}
}

// Comment form validation
function initCommentValidation() {
    const form = document.getElementById('commentform');
    if (!form) return;
    
    loadCommentInfo();
    
    form.addEventListener('submit', function(e) {
        const comment = document.getElementById('comment');
        const author = document.getElementById('author');
        const email = document.getElementById('email');
        
        clearAllErrors();
        window._firstErrorField = null;
        
        if (comment && comment.value.trim().length < 2) {
            showError(comment, '评论内容至少需要2个字');
        }
        
        if (author && !author.value.trim()) {
            showError(author, '请输入昵称');
        }
        
        if (email && !email.value.trim()) {
            showError(email, '请输入邮箱');
        } else if (email && !isValidEmail(email.value)) {
            showError(email, '请输入正确的邮箱格式');
        }
        
        if (document.querySelector('.comment-error')) {
            e.preventDefault();
            return;
        }
        
        saveCommentInfo();
        
        const submitBtn = form.querySelector('.btn-primary');
        if (submitBtn) {
            submitBtn.disabled = true;
            submitBtn.classList.add('opacity-60', 'cursor-not-allowed');
            const originalText = submitBtn.textContent;
            submitBtn.textContent = '请稍候...';
            
            setTimeout(() => {
                submitBtn.disabled = false;
                submitBtn.classList.remove('opacity-60', 'cursor-not-allowed');
                submitBtn.textContent = originalText;
            }, 10000);
        }
    });
    
    ['comment', 'author', 'email'].forEach(id => {
        const field = document.getElementById(id);
        if (field) {
            field.addEventListener('input', function() {
                removeError(this);
            });
        }
    });
}

function showError(field, message) {
    const error = document.createElement('p');
    error.className = 'comment-error';
    error.style.cssText = 'color:#ef4444;font-size:0.75rem;margin-top:0.25rem;';
    error.textContent = message;
    field.parentNode.appendChild(error);
    field.style.borderColor = '#ef4444';
    if (!window._firstErrorField) {
        window._firstErrorField = field;
        field.focus();
    }
}

function removeError(field) {
    const error = field.parentNode.querySelector('.comment-error');
    if (error) error.remove();
    field.style.borderColor = '';
}

function clearAllErrors() {
    document.querySelectorAll('.comment-error').forEach(el => el.remove());
    document.querySelectorAll('#commentform input, #commentform textarea').forEach(el => {
        el.style.borderColor = '';
    });
}

function isValidEmail(email) {
    return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
}

// Initialize all functions
function initAll() {
    initHighlightAndCopyButtons();
    initImageLightbox();
    initResponsiveTables();
    initExternalLinks();
    initSmoothScroll();
    initCommentValidation();
}

// Run on DOM ready
document.addEventListener('DOMContentLoaded', initAll);

// Run on AJAX page load (if using any AJAX navigation)
if (typeof wp !== 'undefined' && wp.customize) {
    wp.customize.bind('preview-ready', initAll);
}

