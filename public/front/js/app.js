(function () {
    'use strict';

    var doc = document;
    var $ = function (sel, root) { return (root || doc).querySelector(sel); };
    var $$ = function (sel, root) { return Array.prototype.slice.call((root || doc).querySelectorAll(sel)); };
    var locale = doc.documentElement.lang === 'ar' ? 'ar-AE' : 'en-AE';
    var fmt = function (n) { return Math.round(n).toLocaleString(locale.replace('ar-AE', 'en-AE')); };

    // Header shadow on scroll
    var header = $('#siteHeader');
    var onScroll = function () { header && header.classList.toggle('is-scrolled', window.scrollY > 8); };
    window.addEventListener('scroll', onScroll, { passive: true });
    onScroll();

    // Mobile drawer
    var drawer = $('#drawer');
    var toggleDrawer = function (open) {
        if (!drawer) return;
        drawer.classList.toggle('is-open', open);
        drawer.setAttribute('aria-hidden', open ? 'false' : 'true');
        doc.body.style.overflow = open ? 'hidden' : '';
    };
    $$('[data-drawer-open]').forEach(function (b) { b.addEventListener('click', function () { toggleDrawer(true); }); });
    $$('[data-drawer-close]').forEach(function (b) { b.addEventListener('click', function () { toggleDrawer(false); }); });
    doc.addEventListener('keydown', function (e) { if (e.key === 'Escape') toggleDrawer(false); });

    // Reveal on scroll
    if ('IntersectionObserver' in window) {
        var io = new IntersectionObserver(function (entries) {
            entries.forEach(function (en) {
                if (en.isIntersecting) { en.target.classList.add('is-visible'); io.unobserve(en.target); }
            });
        }, { rootMargin: '0px 0px -8% 0px' });
        $$('.reveal').forEach(function (el) { io.observe(el); });

        // Count-up numbers
        var counter = new IntersectionObserver(function (entries) {
            entries.forEach(function (en) {
                if (!en.isIntersecting) return;
                var el = en.target, target = parseInt(el.dataset.count, 10) || 0, start = performance.now();
                var tick = function (now) {
                    var p = Math.min(1, (now - start) / 1400);
                    el.textContent = fmt(target * (1 - Math.pow(1 - p, 3)));
                    if (p < 1) requestAnimationFrame(tick);
                };
                requestAnimationFrame(tick);
                counter.unobserve(el);
            });
        }, { threshold: .5 });
        $$('[data-count]').forEach(function (el) { counter.observe(el); });
    } else {
        $$('.reveal').forEach(function (el) { el.classList.add('is-visible'); });
    }

    // Service tabs
    $$('[data-tabs]').forEach(function (wrap) {
        var tabs = $$('.tab', wrap);
        var cards = $$('[data-category]', doc.getElementById(wrap.dataset.tabs));
        tabs.forEach(function (tab) {
            tab.addEventListener('click', function () {
                tabs.forEach(function (t) { t.classList.toggle('is-active', t === tab); t.setAttribute('aria-selected', t === tab); });
                wrap.scrollTo({ left: tab.offsetLeft - (wrap.clientWidth - tab.offsetWidth) / 2, behavior: 'smooth' });
                cards.forEach(function (c) { c.hidden = tab.dataset.filter !== 'all' && c.dataset.category !== tab.dataset.filter; });
            });
        });
    });

    // Steppers (+ / -)
    $$('.stepper').forEach(function (st) {
        var input = $('input', st), out = $('output', st);
        var min = parseInt(input.min, 10), max = parseInt(input.max, 10);
        $$('button', st).forEach(function (btn) {
            btn.addEventListener('click', function () {
                var v = Math.min(max, Math.max(min, (parseInt(input.value, 10) || 0) + parseInt(btn.dataset.step, 10)));
                input.value = v; out.textContent = v;
                input.dispatchEvent(new Event('change', { bubbles: true }));
            });
        });
    });

    // Hero quick estimate
    var quick = $('#quickEstimate');
    if (quick) {
        var visaPrice = parseInt(quick.dataset.visa, 10) || 0;
        var updateQuick = function () {
            var j = $('input[name="jurisdiction"]:checked', quick);
            var visas = parseInt($('input[name="visas"]', quick).value, 10) || 0;
            var total = (j ? parseInt(j.dataset.price, 10) : 0) + visas * visaPrice;
            $('[data-total]', quick).textContent = fmt(total);
            var link = $('[data-link]', quick);
            link.href = link.dataset.base + '?jurisdiction=' + (j ? j.value : '') + '&visas=' + visas;
        };
        quick.addEventListener('change', updateQuick);
        updateQuick();
    }

    // Full calculator wizard
    var calc = $('#calcForm');
    if (calc) {
        var steps = $$('.calc-step', calc);
        var current = 0;
        var bar = $('#calcProgress');
        var label = $('#calcStepLabel');
        var prev = $('[data-prev]', calc), next = $('[data-next]', calc), submit = $('[data-submit]', calc);
        var summary = $('#calcSummary');

        var selections = function () {
            var lines = [];
            ['jurisdiction', 'activity', 'office'].forEach(function (g) {
                var el = $('input[name="' + g + '"]:checked', calc);
                lines.push({ g: g, title: el ? el.dataset.title : null, price: el ? +el.dataset.price : 0 });
            });
            var visas = +$('input[name="visas"]', calc).value || 0;
            var share = +$('input[name="shareholders"]', calc).value || 1;
            lines.push({ g: 'visas', title: String(visas), price: visas * (+calc.dataset.visa || 0) });
            lines.push({ g: 'shareholders', title: String(share), price: Math.max(0, share - 1) * (+calc.dataset.shareholder || 0) });
            $$('input[name="extras[]"]:checked', calc).forEach(function (el) {
                lines.push({ g: 'extra', title: el.dataset.title, price: +el.dataset.price });
            });
            return lines;
        };

        var render = function () {
            var lines = selections(), total = 0;
            lines.forEach(function (l) { total += l.price; });
            $('[data-total]', summary).textContent = fmt(total);
            $$('[data-line]', summary).forEach(function (li) {
                var match = lines.filter(function (l) { return l.g === li.dataset.line; })[0];
                $('span:last-child', li).textContent = match && match.title ? match.title : summary.dataset.empty;
            });
            var extras = lines.filter(function (l) { return l.g === 'extra'; });
            var exLi = $('[data-extras]', summary);
            exLi.hidden = !extras.length;
            $('span:last-child', exLi).textContent = extras.map(function (l) { return l.title; }).join('، ');
        };

        var stepValid = function (i) {
            var required = steps[i].dataset.require;
            return !required || !!$('input[name="' + required + '"]:checked', calc);
        };

        var show = function (i) {
            current = i = Math.max(0, Math.min(steps.length - 1, i));
            steps.forEach(function (s, idx) { s.classList.toggle('is-active', idx === i); });
            bar.style.width = ((i + 1) / steps.length * 100) + '%';
            label.textContent = i + 1;
            prev.disabled = i === 0;
            next.hidden = i === steps.length - 1;
            submit.hidden = i !== steps.length - 1;
            next.disabled = !stepValid(i);
        };

        calc.addEventListener('change', function (e) {
            render();
            next.disabled = !stepValid(current);
            // Auto-advance after picking a single-choice card
            if (e.target.type === 'radio' && current < steps.length - 1) {
                var from = current;
                setTimeout(function () { if (current === from) show(from + 1); }, 260);
            }
        });
        next.addEventListener('click', function () { if (stepValid(current)) show(current + 1); });
        prev.addEventListener('click', function () { if (current > 0) show(current - 1); });

        render();
        var firstOpen = steps.findIndex(function (s, i) { return !stepValid(i); });
        show(calc.dataset.errors === '1' ? steps.length - 1 : (firstOpen === -1 ? 0 : firstOpen));
    }

    // Captcha refresh
    $$('[data-captcha-reload]').forEach(function (btn) {
        btn.addEventListener('click', function () {
            fetch(btn.dataset.captchaReload).then(function (r) { return r.json(); }).then(function (d) {
                $('[data-captcha-img]').innerHTML = d.captcha;
            });
        });
    });
    // Sliders: arrows, dots (one per page of cards) and a slow autoplay that pauses on interaction
    $$('[data-slider]').forEach(function (slider) {
        var track = $('[data-slider-track]', slider);
        var prev = $('[data-slider-prev]', slider);
        var next = $('[data-slider-next]', slider);
        var dotsBox = $('[data-slider-dots]', slider);
        var nav = $('.slider-nav', slider);
        var rtl = getComputedStyle(track).direction === 'rtl';
        var timer = null;
        var items = track.children;
        var step = function () { return items.length > 1 ? Math.abs(items[1].offsetLeft - items[0].offsetLeft) : track.clientWidth; };
        var perView = function () { return Math.max(1, Math.round(track.clientWidth / step())); };
        var pages = function () { return Math.max(1, items.length - perView() + 1); };
        var pos = function () { return Math.round(Math.abs(track.scrollLeft) / step()); };
        var go = function (i) { track.scrollTo({ left: (rtl ? -1 : 1) * i * step() }); };

        var build = function () {
            dotsBox.innerHTML = '';
            for (var i = 0; i < pages(); i++) {
                var d = doc.createElement('button');
                d.type = 'button';
                d.setAttribute('aria-label', String(i + 1));
                d.addEventListener('click', go.bind(null, i));
                dotsBox.appendChild(d);
            }
            nav.hidden = pages() < 2;
            update();
        };
        var update = function () {
            var p = Math.min(pos(), pages() - 1);
            $$('button', dotsBox).forEach(function (d, i) { d.classList.toggle('is-active', i === p); });
            prev.disabled = p <= 0;
            next.disabled = p >= pages() - 1;
        };

        prev.addEventListener('click', function () { go(pos() - 1); });
        next.addEventListener('click', function () { go(pos() + 1); });
        track.addEventListener('scroll', update, { passive: true });
        window.addEventListener('resize', build);

        var stop = function () { clearInterval(timer); timer = null; };
        var start = function () {
            if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;
            stop();
            timer = setInterval(function () { go(pos() >= pages() - 1 ? 0 : pos() + 1); }, 6000);
        };
        ['mouseenter', 'touchstart', 'focusin'].forEach(function (e) { slider.addEventListener(e, stop, { passive: true }); });
        slider.addEventListener('mouseleave', start);

        build();
        start();
    });
})();
