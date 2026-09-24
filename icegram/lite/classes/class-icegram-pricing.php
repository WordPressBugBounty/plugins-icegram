<?php

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Icegram_Pricing {

	public static function ig_show_pricing() {
        $utm_medium = get_option('ig_upsell_flow') == 'popup' ? 'popup' : 'pricing';
        ?>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link href="https://fonts.googleapis.com/css2?family=Petrona:wght@400;500;600;700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
        <style type="text/css">
            :root {
                --purple: #5E19CF;
                --purple-dark: #6d28d9;
                --purple-darker: #4c1d95;
                --purple-border: #CDB8F0;
                --purple-bg: #EFE8FA;
                --gray-text: #737373;
                --green-bg: #DCFCE7;
                --green-text: #2f7c53;
            }

            * { box-sizing: border-box; }

            body {
                margin: 0;
                font-family: 'Inter', sans-serif;
                /* background: #ffffff; */
                color: #0A0A0A;
            }

            .ig-page {
                width: 100%;
                min-height: 100vh;
                padding: 28px 24px;
                display: flex;
                flex-direction: column;
                gap: 28px;
            }

            .serif {
                font-family: 'Petrona', serif;
            }

            /* ===== Top summary banner ===== */
            .ig-pricing-section {
                width: 100%;
                display: flex;
                flex-direction: column;
                align-items: center;
                gap: 28px;
            }

            .ig-pricing-wrape {
                width: 100%;
                margin: 0 auto;
                overflow: hidden;
            }

            .ig-hero-banner {
                margin-bottom: 12px;
                display: flex;
                align-items: center;
                justify-content: space-between;
                border-radius: 14px;
                border: 1px solid var(--purple-border);
                background: var(--purple-bg);
                padding: 36px 40px;
                box-shadow: 0 1px 3px rgba(0,0,0,0.10), 0 1px 2px -1px rgba(0,0,0,0.10);
                flex-wrap: wrap;
                gap: 16px;
            }

            .ig-hero-banner .content { max-width: 700px; }

            .ig-hero-banner h1 {
                margin: 0 0 16px 0;
                font-size: 35px;
                font-weight: 600;
                line-height: 41px;
                color: #0A0A0A;
            }

            .ig-hero-banner p {
                margin: 0;
                font-weight: 400;
                color: var(--gray-text);
                font-size: 16px;
                line-height: 24px;
                max-width: 42rem;
            }

            .ig-stats-row {
                display: flex;
                border-top: 1px solid #e5e7eb;
                background: #ffffff;
                border-radius: 15px;
                flex-wrap: wrap;
            }

            .ig-stat {
                flex: 1;
                min-width: 140px;
                border-right: 1px solid #e5e7eb;
                padding: 20px 10px;
                text-align: center;
            }

            .ig-stat:last-child { border-right: none; }

            .ig-stat .num {
                margin-bottom: 4px;
                font-family: 'Petrona', serif;
                font-size: 24px;
                color: var(--purple);
                font-weight: 700;
            }

            .ig-stat .label {
                font-size: 12px;
                letter-spacing: 1px;
                color: #7c7c7c;
                margin-top: 15px;
            }

            /* ===== Plan card section ===== */
            .ig-plan-section { width: 100%; padding: 32px 0; }

            .ig-plan-section h2 {
                font-size: 18px;
                font-weight: 600;
                margin: 0 0 4px 0;
                line-height: 28px;
            }

            .ig-plan-section .ig-subtitle {
                font-size: 14px;
                color: #6b6b80;
                line-height: 1.5;
                margin: 0 0 1rem 0;
            }

            .ig-plan-card {
                width: 100%;
                background: #ffffff;
                border: 2px solid var(--purple-dark);
                border-radius: 14px;
                position: relative;
                display: grid;
                grid-template-columns: 280px 1fr;
                overflow: hidden;
            }

            .ig-plan-left {
                background: linear-gradient(to bottom right, var(--purple-dark), var(--purple-darker));
                padding: 32px 28px;
                display: flex;
                flex-direction: column;
                justify-content: space-between;
                color: #fff;
            }

            .ig-plan-left .eyebrow {
                font-size: 10px;
                font-weight: 600;
                color: rgba(255,255,255,0.65);
                text-transform: uppercase;
                letter-spacing: 0.05em;
                margin-bottom: 6px;
            }

            .ig-plan-left .plan-name {
                font-family: 'Petrona', serif;
                font-size: 40px;
                color: #ffffff;
                font-weight: 600;
                line-height: 1;
                margin: 0;
            }

            .ig-plan-left .plan-desc {
                font-size: 12.5px;
                color: rgba(255,255,255,0.75);
                margin-top: 8px;
                line-height: 1.5;
            }

            .ig-price-row {
                display: flex;
                align-items: baseline;
                gap: 4px;
                margin-top: 25px;
            }

            .ig-price-row .currency {
                vertical-align: top;
                font-size: 28px;
                color: #ffffff;
            }

            .ig-price-row .amount {
                font-family: 'Petrona', serif;
                font-size: 56px;
                line-height: 1;
                color: #ffffff;
            }

            .ig-price-caption {
                font-size: 12px;
                color: rgba(255,255,255,0.65);
                margin-top: 4px;
                margin-bottom: 20px;
            }

            .ig-btn-max {
                margin-bottom: 30px;
                width: 100%;
                display: block;
                text-align: center;
                text-decoration: none;
                border-radius: 8px;
                font-size: 18px;
                font-weight: 600;
                color: var(--purple);
                border: 1px solid #ffffff;
                background: #ffffff;
                padding: 16px 10px;
                cursor: pointer;
                transition: background-color 0.2s ease, color 0.2s ease;
            }

            .ig-btn-max:hover {
                background: transparent;
                color: #ffffff;
            }

            .ig-plan-right {
                padding: 28px 32px;
                display: flex;
                flex-direction: column;
                justify-content: flex-start;
            }

            .ig-plan-blurb {
                background: #f3f0ff;
                border-radius: 8px;
                padding: 10px 14px;
                font-size: 14px;
                color: #4c3b8a;
                margin-bottom: 48px;
                line-height: 1.5;
            }

            .ig-feature-grid {
                list-style: none;
                margin: 0;
                padding: 0;
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 10px 20px;
            }

            .ig-feature-grid li {
                display: flex;
                align-items: flex-start;
            }

            .ig-check-badge {
                margin-right: 12px;
                flex-shrink: 0;
                display: flex;
                height: 22px;
                width: 22px;
                align-items: center;
                justify-content: center;
                border-radius: 999px;
                background: #efe8fa;
                font-size: 13px;
                font-weight: 700;
                color: var(--purple);
            }

            .ig-feature-grid .feature-text {
                font-size: 16px;
                color: #4d4d4d;
                font-weight: 500;
            }

            /* ===== Feature comparison table ===== */
            .ig-compare-section { width: 100%; margin-bottom: 24px; }

            .ig-compare-heading { margin-bottom: 30px; }

            .ig-compare-heading .title {
                font-size: 18px;
                line-height: 28px;
                color: #2b2b2b;
                font-weight: 600;
                margin: 0;
            }

            .ig-compare-heading .desc {
                font-size: 16px;
                line-height: 1.6;
                color: #757575;
            }

            .ig-compare-table {
                overflow: hidden;
                padding: 16px;
                background: #ffffff;
                border-radius: 15px;
            }

            .ig-ig-compare-row-head {
                display: flex;
                background: #F1F5F9;
                border-radius: 8px;
                padding: 18px 14px;
                font-size: 12px;
                font-weight: 600;
                color: var(--gray-text);
                line-height: 16px;
            }

            .ig-ig-compare-row-head .col-feature { flex: 2.8; font-size: 17px; font-weight: 600; }
            .ig-ig-compare-row-head .col-plan { flex: 1; text-align: center; font-size: 17px; font-weight: 600; }

            .ig-compare-row {
                display: flex;
                align-items: center;
                border-bottom: 1px solid #E5E5E5;
                padding: 16px 14px;
            }

            .ig-compare-row:last-child { border-bottom: none; }

            .ig-compare-row .col-feature { flex: 2.8; padding-right: 20px; }

            .ig-compare-row .feature-title {
                margin: 0;
                font-size: 17px;
                font-weight: 600;
                color: #0A0A0A;
                line-height: 2;
            }

            .ig-compare-row .feature-desc {
                font-size: 14px;
                line-height: 1.6;
                color: #7b847c;
            }

            .ig-compare-row .col-plan {
                flex: 1;
                text-align: center;
            }

            .ig-dash {
                font-size: 30px;
                color: #6f766f;
            }

            .ig-badge-green {
                display: inline-block;
                border-radius: 10px;
                background: #DCFCE7;
                padding: 7px 14px;
                font-size: 12px;
                font-weight: 600;
                color: #171717;
            }

            .ig-check-badge-green {
                display: inline-flex;
                height: 22px;
                width: 22px;
                align-items: center;
                justify-content: center;
                border-radius: 999px;
                background: var(--green-bg);
                font-size: 13px;
                font-weight: 700;
                color: var(--green-text);
            }

            /* ===== Testimonials ===== */
            .ig-testimonials-wrap { width: 100%; margin: 0 auto; }

            .ig-testimonials-heading { margin-bottom: 28px; }

            .ig-testimonials-heading .title {
                font-size: 18px;
                line-height: 28px;
                color: #2b2b2b;
                font-weight: 600;
                margin: 0;
            }

            .ig-testimonials-heading .desc {
                font-size: 16px;
                line-height: 1.6;
                color: #7a7a7a;
            }

            .ig-testimonial-cards {
                margin-bottom: 18px;
                display: flex;
                flex-direction: column;
                align-items: center;
            }

            .ig-slider {
                width: 100%;
                display: flex;
                gap: 20px;
                overflow-x: auto;
                scroll-snap-type: x mandatory;
                -webkit-overflow-scrolling: touch;
            }

            .ig-slider::-webkit-scrollbar { display: none; }

            .ig-slide {
                flex: 0 0 100%;
                scroll-snap-align: start;
                overflow: hidden;
                border-radius: 18px;
                border: 1px solid #dfe4de;
                background: #ffffff;
                padding: 24px;
            }

            @media (min-width: 900px) {
                .ig-slide { flex: 0 0 calc(50.333% - 14px); }
            }

            .ig-slider.dragging { scroll-snap-type: none; user-select: none; }

            .ig-stars {
                display: flex;
                gap: 4px;
                align-items: center;
                margin-top: 4px;
                margin-bottom: 18px;
            }

            .ig-stars svg { width: 16px; height: 16px; }

            .ig-testimonial-quote {
                margin-bottom: 28px;
                font-family: 'Petrona', serif;
                font-size: 17px;
                font-style: italic;
                line-height: 1.9;
                color: #444;
            }

            .ig-testimonial-author { display: flex; align-items: center; }

            .ig-avatar {
                margin-right: 14px;
                display: flex;
                height: 42px;
                width: 42px;
                align-items: center;
                justify-content: center;
                border-radius: 999px;
                background: #efe8fa;
                font-size: 14px;
                font-weight: 700;
                color: var(--purple);
                flex-shrink: 0;
            }

            .ig-author-name {
                margin-bottom: 4px;
                font-size: 18px;
                font-weight: 600;
                color: #2d2d2d;
            }

            .ig-author-role { font-size: 15px; color: #808080; }

            .ig-carousel-dots {
                display: flex;
                align-items: center;
                justify-content: center;
                margin: 24px 0;
            }

            .ig-dots-track {
                position: relative;
                width: 85px;
                height: 8px;
                cursor: pointer;
                display: flex;
            }

            .ig-dots-bg {
                position: absolute;
                left: 0; top: 0;
                width: 100%; height: 8px;
                background: #e4e4e7;
                border-radius: 100px;
            }

            .ig-dots-fill {
                position: absolute;
                left: 0; top: 0;
                height: 8px;
                background: #27272a;
                border-radius: 100px;
                transition: width 0.3s ease;
                width: 28.33px;
            }

            .ig-dot-hit {
                position: absolute;
                top: 0;
                height: 8px;
                width: 28.33px;
                z-index: 2;
            }

            /* ===== ig-guarantee ===== */
            .ig-guarantee {
                display: flex;
                align-items: flex-start;
                border-radius: 18px;
                border: 1px solid var(--purple-border);
                background: var(--purple-bg);
                padding: 24px;
            }

            .ig-guarantee-icon {
                margin-right: 18px;
                display: flex;
                height: 54px;
                width: 54px;
                min-width: 54px;
                align-items: center;
                justify-content: center;
                border-radius: 999px;
                background: var(--purple);
                color: #fff;
            }

            .ig-guarantee-icon svg { width: 28px; height: 28px; }

            .ig-guarantee-title {
                margin-bottom: 4px;
                font-family: 'Petrona', serif;
                font-size: 32px;
                font-weight: 600;
                color: #0A0A0A;
                line-height: 32px;
            }

            .ig-guarantee-desc {
                font-size: 17px;
                line-height: 1.8;
                color: #4f6c59;
            }

            /* ===== CTA panel ===== */
            .ig-cta-wrap { width: 100%; margin: 0 auto; }

            .ig-cta-panel {
                border-radius: 22px;
                border: 1px solid #dfe4de;
                background: #ffffff;
                padding: 42px 38px;
            }

            .ig-cta-heaading {
                margin-bottom: 34px;
                max-width: 760px;
                font-family: 'Petrona', serif;
                font-size: 30px;
                line-height: normal;
                color: #56615a;
                font-weight: 400;
            }

            .ig-cta-heaading strong {
                font-weight: 600;
                font-size: 32px;
                color: #000000;
            }

            .ig-ig-cta-points {
                margin-bottom: 38px;
                display: flex;
                gap: 40px;
                flex-wrap: wrap;
            }

            .ig-cta-col { flex: 1; min-width: 260px; display: flex; flex-direction: column; gap: 28px; }

            .ig-cta-point { display: flex; align-items: flex-start; }

            .ig-cta-dot {
                margin-right: 14px;
                margin-top: 10px;
                height: 9px; width: 9px; min-width: 9px;
                border-radius: 999px;
                background: var(--purple);
            }

            .ig-cta-point-text {
                font-size: 17px;
                font-weight: 500;
                line-height: 1.7;
                color: #56615a;
            }

            .ig-btn-cta {
                display: inline-flex;
                align-items: center;
                text-decoration: none;
                border-radius: 8px;
                font-size: 14px;
                font-weight: 600;
                padding: 20px 20px;
                background: var(--purple);
                color: #ffffff;
                border: 1px solid var(--purple);
                transition: background-color 0.2s ease, color 0.2s ease;
                cursor: pointer;
            }

            .ig-btn-cta:hover { background: transparent; color: var(--purple); }

            .ig-btn-cta .arrow-icon { margin-left: 10px !important; font-size: 22px; position: relative; width: auto; bottom: 0; }

            /* ===== Help & support ===== */
            .ig-help-section {
                width: 100%;
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
            }

            .ig-help-title {
                font-weight: 600;
                color: #000;
                font-size: 24px;
                line-height: 32px;
                letter-spacing: -0.02em;
                width: 100%;
                text-align: left;
                margin-bottom: 16px;
            }

            .ig-help-cards {
                display: flex;
                flex-direction: row;
                gap: 0;
                align-items: stretch;
                justify-content: center;
                width: 100%;
                margin: 0 auto;
            }

            .ig-contact-cards {
                background: #ffffff;
                display: flex;
                flex-direction: column;
                align-items: flex-start;
                justify-content: flex-start;
                padding: 24px;
                border-radius: 12px 0 0 12px;
                width: 340px;
                border: 1px solid #e2e8f0;
                box-shadow: 0 1px 2px rgba(0,0,0,0.05);
                flex-shrink: 0;
            }

            .ig-card-header { display: flex; gap: 8px; align-items: center; }

            .ig-card-header .icon { width: 24px; height: 24px; }

            .ig-card-header .title {
                font-weight: 600;
                font-size: 18px;
                line-height: 28px;
                color: #27272a;
            }

            .ig-contact-cards p {
                font-weight: 500;
                font-size: 14px;
                line-height: 24px;
                color: #a1a1aa;
                margin-top: 12px;
            }

            .ig-btn-email {
                border: 1px solid var(--purple);
                color: var(--purple);
                padding: 8px 16px;
                border-radius: 8px;
                font-size: 14px;
                font-weight: 500;
                box-shadow: 0 1px 2px rgba(0,0,0,0.05);
                display: flex;
                align-items: center;
                gap: 8px;
                width: fit-content;
                text-decoration: none;
                margin-top: 24px;
            }

            .ig-btn-email svg { width: 18px; height: 18px; }

            .ig-faq-card {
                background: #ffffff;
                display: flex;
                flex-direction: column;
                align-items: flex-start;
                justify-content: flex-start;
                padding: 24px;
                border-radius: 0 12px 12px 0;
                flex-grow: 1;
                min-width: 320px;
                border: 1px solid #e2e8f0;
                border-left: none;
                box-shadow: 0 1px 2px rgba(0,0,0,0.05);
            }

            .ig-faq-card p { font-weight: 500; font-size: 14px; line-height: 24px; color: #a1a1aa; margin-top: 12px; margin-bottom: 0; }

            .ig-faq-divider { width: 100%; border-bottom: 1px solid #e4e4e7; margin: 20px 0; }

            .ig-faq-list { width: 100%; display: flex; flex-direction: column; gap: 25px; }

            .ig-faq-item { width: 100%; }

            .ig-faq-question {
                display: flex;
                align-items: center;
                justify-content: space-between;
                width: 100%;
                padding: 12px 0;
                cursor: pointer;
                background: none;
                border: none;
                text-align: left;
            }

            .ig-faq-question span {
                font-weight: 600;
                font-size: 14px;
                line-height: 20px;
                color: #111027;
            }

            .ig-faq-toggle-icon { width: 20px; height: 20px; flex-shrink: 0; }

            .ig-faq-answer {
                overflow: hidden;
                max-height: 0;
                opacity: 0;
                transition: max-height 0.3s ease, opacity 0.3s ease;
            }

            .ig-faq-item.open .ig-faq-answer {
                max-height: 400px;
                opacity: 1;
            }

            .ig-faq-answer p {
                font-weight: 400;
                font-size: 14px;
                line-height: 20px;
                color: #71717a;
                padding-bottom: 12px;
                margin: 0;
            }

            .ig-faq-item-divider {
                width: 100%;
                height: 1px;
                background: #e4e4e7;
            }

            @media (max-width: 800px) {
                .ig-plan-card { grid-template-columns: 1fr; }
                .ig-feature-grid { grid-template-columns: 1fr; }
                .ig-help-cards { flex-direction: column; }
                .ig-contact-cards, .ig-faq-card { width: 100%; border-radius: 12px; border-left: 1px solid #e2e8f0; }
            }
        </style>
        
        
        <div class="ig-page">

            <!-- Pricing Table Section -->
            <div class="ig-pricing-section">

                <div class="ig-pricing-wrape">

                    <div class="ig-hero-banner">
                        <div class="content">
                        <h1 class="serif"><?php echo esc_html__('Grow your digital tribe with Icegram Engage', 'icegram'); ?></h1>
                        <p><?php echo esc_html__('Turn more visitors into subscribers and customers with dynamic popups, smart targeting, personalized messages, and powerful conversion tools — all without coding.', 'icegram'); ?></p>
                        </div>
                    </div>

                    <div class="ig-stats-row">
                        <div class="ig-stat">
                        <div class="num serif"><?php echo esc_html__('20,000+', 'icegram'); ?></div>
                        <div class="label"><?php echo esc_html__('ACTIVE INSTALLS', 'icegram'); ?></div>
                        </div>
                        <div class="ig-stat">
                        <div class="num serif"><?php echo esc_html__('4.7★', 'icegram'); ?></div>
                        <div class="label"><?php echo esc_html__('WORDPRESS RATING', 'icegram'); ?></div>
                        </div>
                        <div class="ig-stat">
                        <div class="num serif"><?php echo esc_html__('$8.25/mo', 'icegram'); ?></div>
                        <div class="label"><?php echo esc_html__('MAX BILLED YEARLY', 'icegram'); ?></div>
                        </div>
                        <div class="ig-stat">
                        <div class="num serif"><?php echo esc_html__('30 days', 'icegram'); ?></div>
                        <div class="label"><?php echo esc_html__('MONEY-BACK', 'icegram'); ?></div>
                        </div>
                    </div>

                </div>

                <!-- PLAN CARD -->
                <div class="ig-plan-section">
                <h2><?php echo esc_html__('More power. Less guesswork.', 'icegram');?></h2>
                <p class="ig-subtitle"><?php echo esc_html__('Switch or cancel anytime.', 'icegram');?></p>

                <div class="ig-plan-card">

                    <div class="ig-plan-left">
                    <div>
                        <div class="eyebrow"><?php echo esc_html__('For Stores, Agencies &amp; Growing Teams', 'icegram');?></div>
                        <div class="plan-name serif"><?php echo esc_html__('Max', 'icegram');?></div>
                        <div class="plan-desc"><?php echo esc_html__('For businesses that want smarter targeting and higher conversions.', 'icegram');?></div>
                    </div>
                    <div>
                        <div class="ig-price-row">
                        <span class="currency serif"><?php echo esc_html__('$', 'icegram');?></span>
                        <span class="amount serif"><?php echo esc_html__('99', 'icegram');?></span>
                        </div>
                        <div class="ig-price-caption"><?php echo esc_html__('per year &nbsp;—&nbsp; about $8 per month', 'icegram');?></div>
                        <a href="https://www.icegram.com/?buy-now=16542&qty=1&with-cart=1&page=6&utm_source=en-in-app&utm_medium=<?php echo esc_attr( $utm_medium ); ?>&utm_campaign=max-only" target="_blank" rel="noopener noreferrer" class="ig-btn-max"><?php echo esc_html__('Get Max', 'icegram');?></a>
                    </div>
                    </div>

                    <div class="ig-plan-right">
                    <div class="ig-plan-blurb"><?php echo esc_html__('Advanced targeting, deeper insights, and design freedom that runs without you.', 'icegram');?></div>
                    <ul class="ig-feature-grid">
                        <li><div class="ig-check-badge">✓</div><div class="feature-text"><?php echo esc_html__('Multiple campaign types & popup designs', 'icegram');?></div></li>
                        <li><div class="ig-check-badge">✓</div><div class="feature-text"><?php echo esc_html__('Page-level & device targeting', 'icegram');?></div></li>
                        <li><div class="ig-check-badge">✓</div><div class="feature-text"><?php echo esc_html__('Content lockers', 'icegram');?></div></li>
                        <li><div class="ig-check-badge">✓</div><div class="feature-text"><?php echo esc_html__('Visitor behavior-based targeting', 'icegram');?></div></li>
                        <li><div class="ig-check-badge">✓</div><div class="feature-text"><?php echo esc_html__('Advanced campaign display rules', 'icegram');?></div></li>
                        <li><div class="ig-check-badge">✓</div><div class="feature-text"><?php echo esc_html__('Lead capture & email form integrations', 'icegram');?></div></li>
                        <li><div class="ig-check-badge">✓</div><div class="feature-text"><?php echo esc_html__('Scroll, time-delay & inactivity triggers', 'icegram');?></div></li>
                        <li><div class="ig-check-badge">✓</div><div class="feature-text"><?php echo esc_html__('Campaigns on third-party sites', 'icegram');?></div></li>
                        <li><div class="ig-check-badge">✓</div><div class="feature-text"><?php echo esc_html__('Specific page targeting', 'icegram');?></div></li>
                        <li><div class="ig-check-badge">✓</div><div class="feature-text"><?php echo esc_html__('VIP Support (Email + Facebook)', 'icegram');?></div></li>
                    </ul>
                    </div>

                </div>
                </div>

                <!-- FEATURE COMPARISON -->
                <div class="ig-compare-section">

                    <div class="ig-compare-heading">
                        <div class="title"><?php echo esc_html__('What you can do with each plan', 'icegram');?></div>
                        <div class="desc"><?php echo esc_html__('Every feature here is built to turn more visitors into subscribers and customers.', 'icegram');?></div>
                    </div>

                    <div class="ig-compare-table">

                        <div class="ig-ig-compare-row-head">
                        <div class="col-feature"><?php echo esc_html__('Feature', 'icegram');?></div>
                        <div class="col-plan"><?php echo esc_html__('Free', 'icegram');?></div>
                        <div class="col-plan"><?php echo esc_html__('Max', 'icegram');?></div>
                        </div>

                        <div class="ig-compare-row">
                        <div class="col-feature">
                            <p class="feature-title"><?php echo esc_html__('Popup & message formats', 'icegram');?></p>
                            <div class="feature-desc"><?php echo esc_html__('Popups, header/footer bars, messengers and toasts', 'icegram');?></div>
                        </div>
                        <div class="col-plan"><span class="ig-check-badge-green">✓</span></div>
                        <div class="col-plan"><span class="ig-check-badge-green">✓</span></div>
                        </div>

                        <div class="ig-compare-row">
                        <div class="col-feature">
                            <p class="feature-title"><?php echo esc_html__('Design themes', 'icegram');?></p>
                            <div class="feature-desc"><?php echo esc_html__('Ready-made templates for every campaign style', 'icegram');?></div>
                        </div>
                        <div class="col-plan"><span class="ig-badge-green"><?php echo esc_html__('Simple', 'icegram');?></span></div>
                        <div class="col-plan"><span class="ig-badge-green"><?php echo esc_html__('100+ Elegant + Premium', 'icegram');?></span></div>
                        </div>

                        <div class="ig-compare-row">
                        <div class="col-feature">
                            <p class="feature-title"><?php echo esc_html__('Targeting rules', 'icegram');?></p>
                            <div class="feature-desc"><?php echo esc_html__('Decide who sees a campaign, and when', 'icegram');?></div>
                        </div>
                        <div class="col-plan"><span class="ig-badge-green"><?php echo esc_html__('Basic', 'icegram');?></span></div>
                        <div class="col-plan"><span class="ig-badge-green"><?php echo esc_html__('Exit intent, behavior & geographic', 'icegram');?></span></div>
                        </div>

                        <div class="ig-compare-row">
                        <div class="col-feature">
                            <p class="feature-title"><?php echo esc_html__('A/B split testing', 'icegram');?></p>
                            <div class="feature-desc"><?php echo esc_html__('Find the version that actually converts', 'icegram');?></div>
                        </div>
                        <div class="col-plan"><span class="ig-dash">–</span></div>
                        <div class="col-plan"><span class="ig-check-badge-green">✓</span></div>
                        </div>

                        <div class="ig-compare-row">
                        <div class="col-feature">
                            <p class="feature-title"><?php echo esc_html__('Countdown timer & after-CTA control', 'icegram');?></p>
                            <div class="feature-desc"><?php echo esc_html__('Add urgency, then decide what happens after a click', 'icegram');?></div>
                        </div>
                        <div class="col-plan"><span class="ig-dash">–</span></div>
                        <div class="col-plan"><span class="ig-check-badge-green">✓</span></div>
                        </div>

                        <div class="ig-compare-row">
                        <div class="col-feature">
                            <p class="feature-title"><?php echo esc_html__('Reports &amp; analytics', 'icegram');?></p>
                            <div class="feature-desc"><?php echo esc_html__('Impression vs. conversion reports plus top 5 ig-stats', 'icegram');?></div>
                        </div>
                        <div class="col-plan"><span class="ig-dash">–</span></div>
                        <div class="col-plan"><span class="ig-check-badge-green">✓</span></div>
                        </div>

                    </div>

                </div>

            </div>

            <!-- TESTIMONIALS -->
            <div class="ig-testimonials-wrap">

                <div class="ig-testimonials-heading">
                <div class="title"><?php echo esc_html__( 'Used by people who rely on email for growth', 'icegram' ); ?></div>
                <div class="desc"><?php echo esc_html__( 'Real feedback from active users on WordPress.org', 'icegram' ); ?></div>
                </div>

                <div class="ig-testimonial-cards">
                <div class="ig-slider" id="ig-slider">

                    <div class="ig-slide">
                    <div class="ig-stars">
                        <!-- 5 ig-stars -->
                        <svg viewBox="0 0 20 20" fill="#f5a623"><polygon points="10,1 12.6,7.2 19.5,7.6 14,12 15.8,18.8 10,15 4.2,18.8 6,12 0.5,7.6 7.4,7.2"/></svg>
                        <svg viewBox="0 0 20 20" fill="#f5a623"><polygon points="10,1 12.6,7.2 19.5,7.6 14,12 15.8,18.8 10,15 4.2,18.8 6,12 0.5,7.6 7.4,7.2"/></svg>
                        <svg viewBox="0 0 20 20" fill="#f5a623"><polygon points="10,1 12.6,7.2 19.5,7.6 14,12 15.8,18.8 10,15 4.2,18.8 6,12 0.5,7.6 7.4,7.2"/></svg>
                        <svg viewBox="0 0 20 20" fill="#f5a623"><polygon points="10,1 12.6,7.2 19.5,7.6 14,12 15.8,18.8 10,15 4.2,18.8 6,12 0.5,7.6 7.4,7.2"/></svg>
                        <svg viewBox="0 0 20 20" fill="#f5a623"><polygon points="10,1 12.6,7.2 19.5,7.6 14,12 15.8,18.8 10,15 4.2,18.8 6,12 0.5,7.6 7.4,7.2"/></svg>
                    </div>
                    <div class="ig-testimonial-quote"><?php echo esc_html__( 'This tool is helping us keep our organization alive and well in the Covid 19 pandemic. Thanks for making it so easy for us to spread the word to our members. Plus it is easy to use and the free themes are fun to help fit our messages as we need them.', 'icegram' ); ?></div>
                    <div class="ig-testimonial-author">
                        <div class="ig-avatar"><?php echo esc_html__( 'M', 'icegram' ); ?></div>
                        <div>
                        <div class="ig-author-name"><?php echo esc_html__( 'Mimdoc', 'icegram' ); ?></div>
                        </div>
                    </div>
                    </div>

                    <div class="ig-slide">
                    <div class="ig-stars">
                        <svg viewBox="0 0 20 20" fill="#f5a623"><polygon points="10,1 12.6,7.2 19.5,7.6 14,12 15.8,18.8 10,15 4.2,18.8 6,12 0.5,7.6 7.4,7.2"/></svg>
                        <svg viewBox="0 0 20 20" fill="#f5a623"><polygon points="10,1 12.6,7.2 19.5,7.6 14,12 15.8,18.8 10,15 4.2,18.8 6,12 0.5,7.6 7.4,7.2"/></svg>
                        <svg viewBox="0 0 20 20" fill="#f5a623"><polygon points="10,1 12.6,7.2 19.5,7.6 14,12 15.8,18.8 10,15 4.2,18.8 6,12 0.5,7.6 7.4,7.2"/></svg>
                        <svg viewBox="0 0 20 20" fill="#f5a623"><polygon points="10,1 12.6,7.2 19.5,7.6 14,12 15.8,18.8 10,15 4.2,18.8 6,12 0.5,7.6 7.4,7.2"/></svg>
                        <svg viewBox="0 0 20 20" fill="#f5a623"><polygon points="10,1 12.6,7.2 19.5,7.6 14,12 15.8,18.8 10,15 4.2,18.8 6,12 0.5,7.6 7.4,7.2"/></svg>
                    </div>
                    <div class="ig-testimonial-quote"><?php echo esc_html__( 'This is the best lead capture I’ve ever seen. After try a lot of different plugins I finally found a product that is made with Internet Marketing in mind. You can create different campaigns and test what type of lead capture is the best for a particular offer. I’m about to change every WP site I build to use your solutions. Great job guys!', 'icegram' ); ?></div>
                    <div class="ig-testimonial-author">
                        <div class="ig-avatar"><?php echo esc_html__( 'SD', 'icegram' ); ?></div>
                        <div>
                        <div class="ig-author-name"><?php echo esc_html__( 'SuperDivulga', 'icegram' ); ?></div>
                        </div>
                    </div>
                    </div>

                    <div class="ig-slide">
                    <div class="ig-stars">
                        <svg viewBox="0 0 20 20" fill="#f5a623"><polygon points="10,1 12.6,7.2 19.5,7.6 14,12 15.8,18.8 10,15 4.2,18.8 6,12 0.5,7.6 7.4,7.2"/></svg>
                        <svg viewBox="0 0 20 20" fill="#f5a623"><polygon points="10,1 12.6,7.2 19.5,7.6 14,12 15.8,18.8 10,15 4.2,18.8 6,12 0.5,7.6 7.4,7.2"/></svg>
                        <svg viewBox="0 0 20 20" fill="#f5a623"><polygon points="10,1 12.6,7.2 19.5,7.6 14,12 15.8,18.8 10,15 4.2,18.8 6,12 0.5,7.6 7.4,7.2"/></svg>
                        <svg viewBox="0 0 20 20" fill="#f5a623"><polygon points="10,1 12.6,7.2 19.5,7.6 14,12 15.8,18.8 10,15 4.2,18.8 6,12 0.5,7.6 7.4,7.2"/></svg>
                        <svg viewBox="0 0 20 20" fill="#f5a623"><polygon points="10,1 12.6,7.2 19.5,7.6 14,12 15.8,18.8 10,15 4.2,18.8 6,12 0.5,7.6 7.4,7.2"/></svg>
                    </div>
                    <div class="ig-testimonial-quote"><?php echo esc_html__( 'I found this plug-in as a result of using Email Subscribers & Newsletters. It’s a great add-on to this plug-in. Fairly easy to use, with options to change and implement on your site in almost every way. I’m glad I found it and even more happy to be using it. Highly recommended.', 'icegram' ); ?></div>
                    <div class="ig-testimonial-author">
                        <div class="ig-avatar"><?php echo esc_html__( 'CR', 'icegram' ); ?></div>
                        <div>
                        <div class="ig-author-name"><?php echo esc_html__( 'Chris Richard', 'icegram' ); ?></div>
                        </div>
                    </div>
                    </div>

                </div>
                </div>

                <div class="ig-carousel-dots">
                <div class="ig-dots-track" id="dotsTrack">
                    <div class="ig-dots-bg"></div>
                    <div class="ig-dots-fill" id="dotsFill"></div>
                    <div class="ig-dot-hit" data-idx="0" style="left:0;"></div>
                    <div class="ig-dot-hit" data-idx="1" style="left:28.33px;"></div>
                    <div class="ig-dot-hit" data-idx="2" style="left:56.66px;"></div>
                </div>
                </div>

                <!-- ig-guarantee -->
                <div class="ig-guarantee">
                <div class="ig-guarantee-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2 L4 5 V11 C4 16 7.5 20.5 12 22 C16.5 20.5 20 16 20 11 V5 Z"/></svg>
                </div>
                <div>
                    <div class="ig-guarantee-title serif"><?php echo esc_html__( '30-day money-back guarantee', 'icegram' ); ?></div>
                    <div class="ig-guarantee-desc"><?php echo esc_html__( 'Not happy in the first 30 days? We refund you in full — no forms, no questions, no waiting. You take zero risk upgrading today.', 'icegram' ); ?></div>
                </div>
                </div>

            </div>

            <!-- CTA -->
            <div class="ig-cta-wrap">
                <div class="ig-cta-panel">

                <div class="ig-cta-heaading serif"><strong><?php echo esc_html__( 'Your popups can do more, and we make that easy.', 'icegram' ); ?></strong></div>

                <div class="ig-ig-cta-points">
                    <div class="ig-cta-col">
                    <div class="ig-cta-point">
                        <div class="ig-cta-dot"></div>
                        <div class="ig-cta-point-text"><?php echo esc_html__( 'Convert visitors instead of losing them to bounce', 'icegram' ); ?></div>
                    </div>
                    <div class="ig-cta-point">
                        <div class="ig-cta-dot"></div>
                        <div class="ig-cta-point-text"><?php echo esc_html__( 'Stop guessing — target by behavior, geography and intent', 'icegram' ); ?></div>
                    </div>
                    </div>
                    <div class="ig-cta-col">
                    <div class="ig-cta-point">
                        <div class="ig-cta-dot"></div>
                        <div class="ig-cta-point-text"><?php echo esc_html__( 'Test what works with real A/B and conversion data', 'icegram' ); ?></div>
                    </div>
                    <div class="ig-cta-point">
                        <div class="ig-cta-dot"></div>
                        <div class="ig-cta-point-text"><?php echo esc_html__( 'Bring visitors back with countdown urgency and smart timing', 'icegram' ); ?></div>
                    </div>
                    </div>
                </div>

                <a href="https://www.icegram.com/?buy-now=16542&qty=1&with-cart=1&page=6&utm_source=en-in-app&utm_medium=<?php echo esc_attr( $utm_medium ); ?>&utm_campaign=max-only" target="_blank" rel="noopener noreferrer" class="ig-btn-cta">
                    <span><?php echo esc_html__( 'Start converting visitors', 'icegram' ); ?></span>
                    <span class="arrow-icon">→</span>
                </a>

                </div>
            </div>

            <!-- Help & Support -->
            <section class="ig-help-section">
                <p class="ig-help-title"><?php echo esc_html__( 'Help & support', 'icegram' ); ?></p>
                <div class="ig-help-cards">

                <!-- Contact Card -->
                <div class="ig-contact-cards">
                    <div class="ig-card-header">
                    <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="#5E19CF" stroke-width="2"><path d="M21 8l-9 6-9-6"/><rect x="3" y="5" width="18" height="14" rx="2"/></svg>
                    <span class="title"><?php echo esc_html__( 'Reach us out for any queries', 'icegram' ); ?></span>
                    </div>
                    <p><?php echo esc_html__( 'Have questions for us, email us and our team of experts will get back to you within 24 hours', 'icegram' ); ?></p>
                    <a href="mailto:hello@icegram.com?subject=Support Request - Icegram Express" class="ig-btn-email">
                    <svg viewBox="0 0 24 24" fill="none" stroke="#5E19CF" stroke-width="2"><path d="M21 8l-9 6-9-6"/><rect x="3" y="5" width="18" height="14" rx="2"/></svg>
                    <?php echo esc_html__( 'Email us', 'icegram' ); ?>
                    </a>
                </div>

                <!-- FAQ Card -->
                <div class="ig-faq-card">
                    <div class="ig-card-header">
                    <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="#27272a" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="9"></circle>
                    <path d="M9.5 9a2.5 2.5 0 0 1 5 0c0 1.5-2 1.8-2 3.3"></path>
                    <line x1="12" y1="16.5" x2="12" y2="16.6"></line>
                    </svg>
                    <span class="title"><?php echo esc_html__( 'FAQ', 'icegram' ); ?></span>
                    </div>
                    <p><?php echo esc_html__( 'Find solutions to your queries', 'icegram' ); ?></p>
                    <div class="ig-faq-divider"></div>

                    <div class="ig-faq-list" id="faqList">

                        <div class="ig-faq-item">
                            <button class="ig-faq-question" type="button">
                                <span><?php echo esc_html__( 'Messages look broken / formatting is weird…', 'icegram' ); ?></span>
                                <span class="icon-slot">
                                    <svg class="ig-faq-toggle-icon" viewBox="0 0 24 24" fill="none" stroke="#71717a" stroke-width="2">
                                        <line x1="12" y1="5" x2="12" y2="19"/>
                                        <line x1="5" y1="12" x2="19" y2="12"/>
                                    </svg>
                                </span>
                            </button>
                            <div class="ig-faq-answer">
                                <p><?php echo esc_html__( 'This is most likely due to CSS conflicts with the current theme. We suggest using simple formatting for messages. You can also write custom CSS in your theme to fix any problems.', 'icegram' ); ?></p>
                            </div>
                            <div class="ig-faq-item-divider"></div>
                        </div>

                        <div class="ig-faq-item">
                            <button class="ig-faq-question" type="button">
                                <span><?php echo esc_html__( 'Extra Line Breaks / Paragraphs in messages…', 'icegram' ); ?></span>
                                <span class="icon-slot">
                                    <svg class="ig-faq-toggle-icon" viewBox="0 0 24 24" fill="none" stroke="#71717a" stroke-width="2">
                                        <line x1="12" y1="5" x2="12" y2="19"/>
                                        <line x1="5" y1="12" x2="19" y2="12"/>
                                    </svg>
                                </span>
                            </button>
                            <div class="ig-faq-answer">
                                <p><?php echo esc_html__( 'Go to HTML mode in content editor and pull your custom HTML code all together in one line. Don’t leave blank lines between two tags. That should fix it.', 'icegram' ); ?></p>
                            </div>
                            <div class="ig-faq-item-divider"></div>
                        </div>

                        <div class="ig-faq-item">
                            <button class="ig-faq-question" type="button">
                                <span><?php echo esc_html__( 'How do I add custom CSS for messages?', 'icegram' ); ?></span>
                                <span class="icon-slot">
                                    <svg class="ig-faq-toggle-icon" viewBox="0 0 24 24" fill="none" stroke="#71717a" stroke-width="2">
                                        <line x1="12" y1="5" x2="12" y2="19"/>
                                        <line x1="5" y1="12" x2="19" y2="12"/>
                                    </svg>
                                </span>
                            </button>
                            <div class="ig-faq-answer">
                                <p><?php echo esc_html__( 'You can use custom CSS/JS inline in your message HTML. You can also use your theme’s custom JS / CSS feature to add your changes.', 'icegram' ); ?></p>
                            </div>
                            <div class="ig-faq-item-divider"></div>
                        </div>

                        <div class="ig-faq-item">
                            <button class="ig-faq-question" type="button">
                                <span><?php echo esc_html__( 'Optin Forms / Mailing service integration…', 'icegram' ); ?></span>
                                <span class="icon-slot">
                                    <svg class="ig-faq-toggle-icon" viewBox="0 0 24 24" fill="none" stroke="#71717a" stroke-width="2">
                                        <line x1="12" y1="5" x2="12" y2="19"/>
                                        <line x1="5" y1="12" x2="19" y2="12"/>
                                    </svg>
                                </span>
                            </button>
                            <div class="ig-faq-answer">
                                <p><?php echo esc_html__( 'You can embed any opt-in / subscription form to your Icegram Engage messages using HTML code. You may even use a shortcode if you are using a WP plugin from your newsletter/lead capture service. Use the “Embed Form” button above the text editor to paste in HTML code from your mailing list service and let Icegram Engage automatically “clean it up” for usage in Icegram Engage messages.', 'icegram' ); ?></p>
                            </div>
                            <div class="ig-faq-item-divider"></div>
                        </div>

                        <div class="ig-faq-item">
                            <button class="ig-faq-question" type="button">
                                <span><?php echo esc_html__( 'Preview does not work / not refreshing…', 'icegram' ); ?></span>
                                <span class="icon-slot">
                                    <svg class="ig-faq-toggle-icon" viewBox="0 0 24 24" fill="none" stroke="#71717a" stroke-width="2">
                                        <line x1="12" y1="5" x2="12" y2="19"/>
                                        <line x1="5" y1="12" x2="19" y2="12"/>
                                    </svg>
                                </span>
                            </button>
                            <div class="ig-faq-answer">
                                <p><?php echo esc_html__( 'Doing a browser refresh while previewing will not show your most recent changes. Click the ‘Preview’ button to see a preview with your latest changes.', 'icegram' ); ?></p>
                            </div>
                            <div class="ig-faq-item-divider"></div>
                        </div>

                        <div class="ig-faq-item">
                            <button class="ig-faq-question" type="button">
                                <span><?php echo esc_html__( 'Can I use shortcodes in a message?', 'icegram' ); ?></span>
                                <span class="icon-slot">
                                    <svg class="ig-faq-toggle-icon" viewBox="0 0 24 24" fill="none" stroke="#71717a" stroke-width="2">
                                        <line x1="12" y1="5" x2="12" y2="19"/>
                                        <line x1="5" y1="12" x2="19" y2="12"/>
                                    </svg>
                                </span>
                            </button>
                            <div class="ig-faq-answer">
                                <p><?php echo esc_html__( 'Yes! Messages support shortcodes. You may need to adjust CSS so the shortcode output looks good in your message.', 'icegram' ); ?></p>
                            </div>
                            <!-- no divider after the last item -->
                        </div>

                    </div>
                </div>

                </div>
            </section>

        </div>

        <script>

            // ===== FAQ accordion =====
            const plusIcon = '<svg class="ig-faq-toggle-icon" viewBox="0 0 24 24" fill="none" stroke="#71717a" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>';
            const minusIcon = '<svg class="ig-faq-toggle-icon" viewBox="0 0 24 24" fill="none" stroke="#71717a" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"/></svg>';

            document.querySelectorAll('#faqList .ig-faq-item').forEach((faqItem) => {
                const questionBtn = faqItem.querySelector('.ig-faq-question');
                const iconSlot = faqItem.querySelector('.icon-slot');

                questionBtn.addEventListener('click', () => {
                    const isOpen = faqItem.classList.contains('open');

                    // close all
                    document.querySelectorAll('#faqList .ig-faq-item').forEach(el => {
                        el.classList.remove('open');
                        el.querySelector('.icon-slot').innerHTML = plusIcon;
                    });

                    if (!isOpen) {
                        faqItem.classList.add('open');
                        iconSlot.innerHTML = minusIcon;
                    }
                });
            });

            // ===== Testimonial carousel (simple scroll-snap + dots + mouse drag) =====
            const slider = document.getElementById('ig-slider');
            const slides = slider.querySelectorAll('.ig-slide');
            const dotsFill = document.getElementById('dotsFill');
            const dotHits = document.querySelectorAll('.ig-dot-hit');
            const dotWidth = 100 / 2;
            let currentSlide = 0;

            function updateDots() {
                dotsFill.style.width = ((currentSlide + 1) * dotWidth) + 'px';
            }

            function goToSlide(idx) {
                currentSlide = idx;
                const slide = slides[idx];
                if (slide) {
                slider.scrollTo({ left: slide.offsetLeft, behavior: 'smooth' });
                }
                updateDots();
            }

            dotHits.forEach(hit => {
                hit.addEventListener('click', () => {
                goToSlide(parseInt(hit.getAttribute('data-idx'), 10));
                });
            });

            slider.addEventListener('scroll', () => {
                // roughly detect which slide is in view
                let closestIdx = 0;
                let closestDist = Infinity;
                slides.forEach((s, i) => {
                const dist = Math.abs(s.offsetLeft - slider.scrollLeft);
                if (dist < closestDist) {
                    closestDist = dist;
                    closestIdx = i;
                }
                });
                if (closestIdx !== currentSlide) {
                currentSlide = closestIdx;
                updateDots();
                }
            });

            // ----- Mouse drag to scroll -----
            let isDown = false;
            let startX = 0;
            let scrollStart = 0;
            let hasDragged = false;

            slider.style.cursor = 'grab';

            slider.addEventListener('mousedown', (e) => {
                isDown = true;
                hasDragged = false;
                slider.classList.add('dragging');
                slider.style.cursor = 'grabbing';
                startX = e.pageX - slider.offsetLeft;
                scrollStart = slider.scrollLeft;
            });

            window.addEventListener('mouseup', () => {
                if (!isDown) return;
                isDown = false;
                slider.classList.remove('dragging');
                slider.style.cursor = 'grab';

                // snap to nearest slide after releasing
                if (hasDragged) {
                    goToSlide(currentSlide);
                }
            });

            slider.addEventListener('mouseleave', () => {
                if (isDown) {
                    isDown = false;
                    slider.classList.remove('dragging');
                    slider.style.cursor = 'grab';
                    if (hasDragged) goToSlide(currentSlide);
                }
            });

            slider.addEventListener('mousemove', (e) => {
                if (!isDown) return;
                e.preventDefault();
                const x = e.pageX - slider.offsetLeft;
                const walk = x - startX;
                if (Math.abs(walk) > 5) hasDragged = true;
                slider.scrollLeft = scrollStart - walk;
            });

            // Prevent text/image selection while dragging
            slider.addEventListener('dragstart', (e) => e.preventDefault());

            updateDots();
        </script>
        <?php
	}
}

new Icegram_Pricing();
