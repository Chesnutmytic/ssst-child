/**
 * ssst Coffee Shop - Main JavaScript
 *
 * Animasi ringan: SVG draw, scroll reveal, nav hamburger,
 * tab menu, copy promo code. Tanpa framework besar.
 * Semua animasi menghormati prefers-reduced-motion.
 *
 * @package ssst-child
 */

/* ─── Periksa prefers-reduced-motion ─── */
const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

/* ─── Tunggu DOM siap ─── */
document.addEventListener('DOMContentLoaded', () => {
    initScrollReveal();
    initStickyHeader();
    initMobileNav();
    initMenuTabs();
    initPromoCodeCopy();
    initSvgDraw();
    initCartCount();
    initSmoothScroll();
});

/* ─────────────────────────────────────────────
   1. SCROLL REVEAL
   Tambahkan class .is-visible saat elemen masuk viewport.
   Gunakan IntersectionObserver agar performa baik.
   ───────────────────────────────────────────── */
function initScrollReveal() {
    if (prefersReducedMotion) {
        // Langsung tampilkan semua elemen
        document.querySelectorAll('.ssst-reveal, .ssst-stagger').forEach(el => {
            el.classList.add('is-visible');
        });
        return;
    }

    const observerOptions = {
        root: null,
        rootMargin: '0px 0px -60px 0px',
        threshold: 0.08,
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('is-visible');
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);

    document.querySelectorAll('.ssst-reveal, .ssst-stagger').forEach(el => {
        observer.observe(el);
    });
}

/* ─────────────────────────────────────────────
   2. STICKY HEADER SHADOW
   Tambahkan class .is-scrolled saat halaman di-scroll.
   ───────────────────────────────────────────── */
function initStickyHeader() {
    const header = document.querySelector('.ssst-header');
    if (!header) return;

    const toggle = () => {
        header.classList.toggle('is-scrolled', window.scrollY > 20);
    };

    // Gunakan passive listener untuk performa scroll
    window.addEventListener('scroll', toggle, { passive: true });
    toggle(); // Cek state awal
}

/* ─────────────────────────────────────────────
   3. MOBILE NAV (Hamburger)
   ───────────────────────────────────────────── */
function initMobileNav() {
    const hamburger = document.querySelector('.ssst-hamburger');
    const drawer    = document.querySelector('.ssst-nav-drawer');

    if (!hamburger || !drawer) return;

    hamburger.addEventListener('click', () => {
        const isOpen = hamburger.getAttribute('aria-expanded') === 'true';
        hamburger.setAttribute('aria-expanded', String(!isOpen));
        drawer.classList.toggle('is-open', !isOpen);

        // Cegah scroll body saat drawer terbuka
        document.body.style.overflow = isOpen ? '' : 'hidden';
    });

    // Tutup drawer saat klik link di dalamnya
    drawer.querySelectorAll('a').forEach(link => {
        link.addEventListener('click', () => {
            hamburger.setAttribute('aria-expanded', 'false');
            drawer.classList.remove('is-open');
            document.body.style.overflow = '';
        });
    });

    // Tutup drawer dengan tombol Escape
    document.addEventListener('keydown', e => {
        if (e.key === 'Escape' && drawer.classList.contains('is-open')) {
            hamburger.setAttribute('aria-expanded', 'false');
            drawer.classList.remove('is-open');
            document.body.style.overflow = '';
            hamburger.focus();
        }
    });
}

/* ─────────────────────────────────────────────
   4. TAB MENU (filter kategori menu)
   ───────────────────────────────────────────── */
function initMenuTabs() {
    const tabs       = document.querySelectorAll('.ssst-menu__tab');
    const menuItems  = document.querySelectorAll('.ssst-menu-item');

    if (!tabs.length || !menuItems.length) return;

    tabs.forEach(tab => {
        tab.addEventListener('click', () => {
            const filter = tab.dataset.filter;

            // Update tab active state
            tabs.forEach(t => {
                t.classList.remove('is-active');
                t.setAttribute('aria-selected', 'false');
            });
            tab.classList.add('is-active');
            tab.setAttribute('aria-selected', 'true');

            // Filter items
            menuItems.forEach(item => {
                const category = item.dataset.category;
                const show     = filter === 'all' || category === filter;

                if (prefersReducedMotion) {
                    item.style.display = show ? '' : 'none';
                } else {
                    if (show) {
                        item.style.display  = '';
                        item.style.opacity  = '0';
                        item.style.transform = 'translateY(8px)';
                        requestAnimationFrame(() => {
                            item.style.transition = 'opacity 250ms, transform 250ms';
                            item.style.opacity    = '1';
                            item.style.transform  = 'translateY(0)';
                        });
                    } else {
                        item.style.opacity  = '0';
                        item.style.transform = 'translateY(-4px)';
                        setTimeout(() => { item.style.display = 'none'; }, 200);
                    }
                }
            });
        });
    });
}

/* ─────────────────────────────────────────────
   5. COPY PROMO CODE
   ───────────────────────────────────────────── */
function initPromoCodeCopy() {
    document.querySelectorAll('.ssst-promo-card__code').forEach(codeEl => {
        codeEl.setAttribute('role', 'button');
        codeEl.setAttribute('tabindex', '0');
        codeEl.title = 'Klik untuk salin kode';

        const original = codeEl.dataset.originalCode || codeEl.textContent.trim();
        codeEl.dataset.originalCode = original;

        const handleCopy = () => {
            const code = codeEl.dataset.originalCode || codeEl.textContent.trim();
            if (!code) return;

            const notifyCopied = () => {
                codeEl.textContent = 'Tersalin!';
                codeEl.style.backgroundColor = 'var(--c-success-bg)';
                codeEl.style.borderColor = 'var(--c-success)';
                codeEl.style.color = 'var(--c-success)';
                setTimeout(() => {
                    codeEl.textContent = original;
                    codeEl.style.backgroundColor = '';
                    codeEl.style.borderColor = '';
                    codeEl.style.color = '';
                }, 2000);
            };

            if (navigator.clipboard && navigator.clipboard.writeText) {
                navigator.clipboard.writeText(code).then(notifyCopied).catch(() => {
                    const range = document.createRange();
                    range.selectNode(codeEl);
                    window.getSelection().removeAllRanges();
                    window.getSelection().addRange(range);
                    document.execCommand('copy');
                    window.getSelection().removeAllRanges();
                    notifyCopied();
                });
            } else {
                const range = document.createRange();
                range.selectNode(codeEl);
                window.getSelection().removeAllRanges();
                window.getSelection().addRange(range);
                document.execCommand('copy');
                window.getSelection().removeAllRanges();
                notifyCopied();
            }
        };

        codeEl.addEventListener('click',  handleCopy);
        codeEl.addEventListener('keydown', e => {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                handleCopy();
            }
        });
    });
}

/* ─────────────────────────────────────────────
   6. SVG DRAW ANIMATION
   Animasi "menggambar" garis SVG saat elemen masuk viewport.
   ───────────────────────────────────────────── */
function initSvgDraw() {
    if (prefersReducedMotion) return;

    const svgEls = document.querySelectorAll('.ssst-svg-draw');
    if (!svgEls.length) return;

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('is-visible');
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.2 });

    svgEls.forEach(el => observer.observe(el));
}

/* ─────────────────────────────────────────────
   7. CART COUNT LIVE UPDATE
   Sinkronkan hitungan keranjang dari AJAX.
   WooCommerce sudah emit event cart_page_refreshed.
   ───────────────────────────────────────────── */
function initCartCount() {
    // Update hitungan dari data yang di-localize
    if (typeof SSST !== 'undefined' && SSST.cartCount !== undefined) {
        updateCartDisplay(parseInt(SSST.cartCount, 10) || 0);
    }

    // Dengarkan event WooCommerce cart fragment update
    document.body.addEventListener('wc_fragments_refreshed', refreshCartCount);
    document.body.addEventListener('added_to_cart',          refreshCartCount);
    document.body.addEventListener('removed_from_cart',       refreshCartCount);
}

function refreshCartCount() {
    // WooCommerce memperbarui DOM .ssst-cart-count via cart fragments (lihat functions.php)
    // Kita hanya perlu sync tampilan badge
    const countEl = document.querySelector('.ssst-cart-count');
    if (!countEl) return;

    const count = parseInt(countEl.textContent.trim(), 10) || 0;
    updateCartDisplay(count);
}

function updateCartDisplay(count) {
    document.querySelectorAll('.ssst-cart-count').forEach(el => {
        el.textContent = count > 0 ? count : '';
        el.classList.toggle('is-empty', count === 0);
        el.setAttribute('aria-label',
            count === 0
                ? 'Keranjang kosong'
                : `${count} item di keranjang`
        );
    });
}

/* ─────────────────────────────────────────────
   8. SMOOTH SCROLL untuk anchor link
   ───────────────────────────────────────────── */
function initSmoothScroll() {
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            const target = document.querySelector(this.getAttribute('href'));
            if (!target) return;

            e.preventDefault();

            const headerHeight = document.querySelector('.ssst-header')?.offsetHeight || 0;
            const targetTop    = target.getBoundingClientRect().top + window.scrollY - headerHeight - 16;

            if (prefersReducedMotion) {
                window.scrollTo({ top: targetTop });
            } else {
                window.scrollTo({ top: targetTop, behavior: 'smooth' });
            }

            // Set focus untuk aksesibilitas
            target.setAttribute('tabindex', '-1');
            target.focus({ preventScroll: true });
        });
    });
}

/* ─────────────────────────────────────────────
   9. ANALYTICS TRACKING untuk tombol marketplace
   Data attribute: data-ssst-track="marketplace"
                   data-ssst-platform="tokopedia"
                   data-ssst-product="nama-produk"
   ───────────────────────────────────────────── */
document.querySelectorAll('[data-ssst-track]').forEach(el => {
    el.addEventListener('click', function() {
        const event = {
            type    : this.dataset.ssstTrack,
            platform: this.dataset.ssstPlatform || '',
            product : this.dataset.ssstProduct  || '',
            url     : this.href || '',
        };

        // Google Analytics 4 (jika tersedia)
        if (typeof gtag === 'function') {
            gtag('event', 'marketplace_click', {
                event_category : 'Outbound',
                event_label    : event.platform,
                product_name   : event.product,
                link_url       : event.url,
            });
        }

        // Simpan klik ke server untuk statistik internal (per marketplace).
        if (typeof SSST !== 'undefined' && SSST.ajaxUrl && SSST.nonce) {
            try {
                const payload = new URLSearchParams({
                    action  : 'ssst_track_click',
                    nonce   : SSST.nonce,
                    platform: event.platform,
                    product : event.product,
                });

                if (navigator.sendBeacon) {
                    navigator.sendBeacon(SSST.ajaxUrl, payload);
                } else {
                    fetch(SSST.ajaxUrl, { method: 'POST', body: payload, keepalive: true });
                }
            } catch (err) {
                /* Statistik tidak boleh menghalangi pengguna menuju marketplace. */
            }
        }

        // Fallback: console.log di development
        if (typeof SSST !== 'undefined' && window.location.hostname === 'localhost') {
            console.log('[ssst analytics]', event);
        }
    });
});
