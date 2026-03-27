import './bootstrap';

document.addEventListener('DOMContentLoaded', () => {
    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                entry.target.classList.add('is-visible');
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.12 });

    document.querySelectorAll('.reveal').forEach((element) => observer.observe(element));

    document.querySelectorAll('[data-image-shell]').forEach((shell) => {
        const image = shell.querySelector('img');
        if (!image) return;

        const markLoaded = () => shell.classList.add('loaded');
        if (image.complete) {
            markLoaded();
        } else {
            image.addEventListener('load', markLoaded, { once: true });
        }
    });

    const mobileDrawer = document.querySelector('[data-mobile-drawer]');
    const mobileBackdrop = document.querySelector('[data-mobile-backdrop]');
    const mobileToggle = document.querySelector('[data-mobile-toggle]');

    const setMobileDrawer = (isOpen) => {
        if (!mobileDrawer || !mobileBackdrop || !mobileToggle) return;

        mobileDrawer.classList.toggle('hidden', !isOpen);
        mobileBackdrop.classList.toggle('hidden', !isOpen);
        document.body.classList.toggle('overflow-hidden', isOpen);
        mobileToggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
    };

    mobileToggle?.addEventListener('click', () => setMobileDrawer(true));
    mobileBackdrop?.addEventListener('click', () => setMobileDrawer(false));
    document.querySelectorAll('[data-mobile-close]').forEach((button) => {
        button.addEventListener('click', () => setMobileDrawer(false));
    });

    const dropdowns = document.querySelectorAll('[data-dropdown]');
    const closeDropdowns = () => {
        dropdowns.forEach((dropdown) => {
            dropdown.querySelector('[data-dropdown-panel]')?.classList.add('hidden');
            dropdown.querySelector('[data-dropdown-trigger]')?.setAttribute('aria-expanded', 'false');
        });
    };

    dropdowns.forEach((dropdown) => {
        const trigger = dropdown.querySelector('[data-dropdown-trigger]');
        const panel = dropdown.querySelector('[data-dropdown-panel]');
        if (!trigger || !panel) return;

        trigger.addEventListener('click', (event) => {
            event.stopPropagation();
            const isHidden = panel.classList.contains('hidden');
            closeDropdowns();
            panel.classList.toggle('hidden', !isHidden);
            trigger.setAttribute('aria-expanded', isHidden ? 'true' : 'false');
        });
    });

    document.addEventListener('click', (event) => {
        if (!event.target.closest('[data-dropdown]')) {
            closeDropdowns();
        }
    });

    const heroSlider = document.querySelector('[data-home-slider]');
    if (heroSlider) {
        const slides = Array.from(heroSlider.querySelectorAll('[data-slide]'));
        const dots = Array.from(document.querySelectorAll('[data-slide-dot]'));
        let activeIndex = slides.findIndex((slide) => slide.classList.contains('is-active'));
        activeIndex = activeIndex >= 0 ? activeIndex : 0;

        const activateSlide = (index) => {
            slides.forEach((slide, slideIndex) => {
                slide.classList.toggle('is-active', slideIndex === index);
            });

            dots.forEach((dot, dotIndex) => {
                dot.classList.toggle('is-active', dotIndex === index);
            });

            activeIndex = index;
        };

        dots.forEach((dot) => {
            dot.addEventListener('click', () => {
                activateSlide(Number(dot.dataset.slideIndex || 0));
            });
        });

        if (slides.length > 1) {
            window.setInterval(() => {
                activateSlide((activeIndex + 1) % slides.length);
            }, 5000);
        }
    }

    document.querySelectorAll('[data-product-gallery]').forEach((gallery) => {
        const mainImage = gallery.querySelector('[data-product-main-image]');
        const zoomFrame = gallery.querySelector('[data-product-zoom]');
        const thumbs = gallery.querySelectorAll('[data-product-thumb]');
        if (!mainImage || !zoomFrame) return;

        thumbs.forEach((thumb) => {
            thumb.addEventListener('click', () => {
                const nextSrc = thumb.dataset.imageSrc;
                if (!nextSrc) return;

                mainImage.src = nextSrc;
                thumbs.forEach((item) => item.classList.remove('is-active'));
                thumb.classList.add('is-active');
            });
        });

        zoomFrame.addEventListener('mousemove', (event) => {
            const bounds = zoomFrame.getBoundingClientRect();
            const x = ((event.clientX - bounds.left) / bounds.width) * 100;
            const y = ((event.clientY - bounds.top) / bounds.height) * 100;
            mainImage.style.transformOrigin = `${x}% ${y}%`;
            mainImage.style.transform = 'scale(1.45)';
        });

        zoomFrame.addEventListener('mouseleave', () => {
            mainImage.style.transformOrigin = 'center center';
            mainImage.style.transform = 'scale(1)';
        });
    });

    document.querySelectorAll('[data-product-tabs]').forEach((tabsRoot) => {
        const triggers = tabsRoot.querySelectorAll('[data-tab-trigger]');
        const panels = tabsRoot.querySelectorAll('[data-tab-panel]');

        triggers.forEach((trigger) => {
            trigger.addEventListener('click', () => {
                const target = trigger.dataset.tabTrigger;

                triggers.forEach((button) => {
                    button.classList.toggle('is-active', button === trigger);
                });

                panels.forEach((panel) => {
                    panel.classList.toggle('hidden', panel.dataset.tabPanel !== target);
                });
            });
        });
    });

    const dashboardSidebar = document.querySelector('[data-dashboard-sidebar]');
    const dashboardBackdrop = document.querySelector('[data-dashboard-backdrop]');
    const dashboardToggle = document.querySelector('[data-dashboard-toggle]');
    const compactSidebarMedia = window.matchMedia('(max-width: 1023px)');

    const syncSidebarState = (expanded) => {
        if (!dashboardSidebar) return;

        const shouldExpand = compactSidebarMedia.matches ? expanded : true;
        dashboardSidebar.classList.toggle('is-collapsed', !shouldExpand);
        dashboardSidebar.classList.toggle('is-expanded', shouldExpand);
        dashboardBackdrop?.classList.toggle('hidden', !compactSidebarMedia.matches || !shouldExpand);
        document.body.classList.toggle('overflow-hidden', compactSidebarMedia.matches && shouldExpand);
        dashboardToggle?.setAttribute('aria-expanded', shouldExpand ? 'true' : 'false');
    };

    syncSidebarState(false);

    dashboardToggle?.addEventListener('click', () => {
        const isExpanded = dashboardSidebar?.classList.contains('is-expanded');
        syncSidebarState(!isExpanded);
    });

    dashboardBackdrop?.addEventListener('click', () => syncSidebarState(false));
    compactSidebarMedia.addEventListener('change', () => syncSidebarState(false));

    const uploadInput = document.querySelector('[data-product-upload-input]');
    const uploadPreview = document.querySelector('[data-product-upload-preview]');

    uploadInput?.addEventListener('change', (event) => {
        const file = event.target.files?.[0];
        if (!file || !uploadPreview) return;

        const nextUrl = URL.createObjectURL(file);
        uploadPreview.src = nextUrl;
        uploadPreview.onload = () => URL.revokeObjectURL(nextUrl);
    });

    document.querySelectorAll('[data-auth-password-toggle]').forEach((toggle) => {
        toggle.addEventListener('click', () => {
            const wrap = toggle.closest('.auth-password-wrap');
            const input = wrap?.querySelector('[data-auth-password-input]');
            if (!input) return;

            const showPassword = input.type === 'password';
            input.type = showPassword ? 'text' : 'password';
            toggle.textContent = showPassword ? 'Hide' : 'Show';
        });
    });
});
