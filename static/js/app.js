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
            btn.className = 'copy-btn absolute top-3 right-3 p-2 bg-slate-700 hover:bg-slate-600 text-slate-300 hover:text-white rounded-lg';
            btn.innerHTML = `<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"/>
            </svg>`;
            
            // Add click handler
            btn.addEventListener('click', async function() {
                try {
                    await navigator.clipboard.writeText(block.textContent);
                    btn.innerHTML = `<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>`;
                    btn.classList.add('bg-green-600', 'text-white');
                    
                    setTimeout(() => {
                        btn.innerHTML = `<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"/>
                        </svg>`;
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
                        btn.innerHTML = `<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>`;
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
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
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

// Initialize all functions
function initAll() {
    initHighlightAndCopyButtons();
    initImageLightbox();
    initResponsiveTables();
    initExternalLinks();
    initSmoothScroll();
}

// Run on DOM ready
document.addEventListener('DOMContentLoaded', initAll);

// Run on AJAX page load (if using any AJAX navigation)
if (typeof wp !== 'undefined' && wp.customize) {
    wp.customize.bind('preview-ready', initAll);
}
