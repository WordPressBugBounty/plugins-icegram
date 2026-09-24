<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Fraunces:wght@600;700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
  :root {
    --purple: #6C2BD9;
    --purple-dark: #3E1671;
    --ink: #17121F;
    --gray: #6B7280;
    --green: #0D9D6D;
    --amber: #C9700A;
    --amber-bg: #FDF1E1;
    --border: #ECE8E1;
  }

  /* ===== Overlay ===== */
  .ig-dialog-overlay {
    position: fixed;
    inset: 0;
    background-color: #fffc;
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 50;
    padding: 24px;
    backdrop-filter: blur(4px);
  }

  /* ===== Dialog shell ===== */
  .ig-dialog-content {
    position: relative;
    background: #ffffff;
    padding: 0;
    max-width: 890px;
    width: 100%;
    border: 0;
    border-radius: 12px;
    overflow: hidden;
    max-height: 92vh;
    box-shadow: 0 20px 60px rgba(0,0,0,0.25);
  }

  .close-btn {
    position: absolute;
    top: 12px;
    right: 12px;
    z-index: 20;
    display: flex;
    align-items: center;
    justify-content: center;
    width: 28px;
    height: 28px;
    color: #6B7280;
    background: transparent;
    border: none;
    outline: none;
    cursor: pointer;
    transition: color 0.15s ease;
  }

  .close-btn:hover { color: #17121F; }
  .close-btn svg { width: 16px; height: 16px; }

  .dialog-body {
    display: flex;
    overflow-y: auto;
    max-height: 92vh;
  }

  /* ===== Left: image panel ===== */
  .dialog-image-side {
    position: relative;
    background: #000;
    display: none;
    flex-shrink: 0;
  }

  @media (min-width: 768px) {
    .dialog-image-side { display: block; }
  }

  .dialog-image-side img {
    width: 280px;
    height: 100%;
    object-fit: cover;
    display: block;
  }

  .image-gradient {
    pointer-events: none;
    position: absolute;
    inset: 0;
    background: linear-gradient(to bottom,
      rgba(23,18,31,0) 45%,
      rgba(23,18,31,0.78) 100%);
  }

  .image-caption {
    position: absolute;
    left: 18px;
    right: 18px;
    bottom: 20px;
    z-index: 10;
    color: #ffffff;
  }

  .stars-row {
    display: flex;
    gap: 3px;
    margin-bottom: 8px;
  }

  .stars-row svg {
    width: 14px;
    height: 14px;
    fill: #FBBF24;
  }

  .image-caption p {
    margin: 0;
    font-size: 12.5px;
    line-height: 1.5;
    font-weight: 500;
    color: rgba(255,255,255,0.9);
  }

  .image-caption strong { font-weight: 700; }

  /* ===== Right: content panel ===== */
  .dialog-content-side {
    flex: 1;
    background: #ffffff;
    padding: 16px;
    display: flex;
    flex-direction: column;
    border-radius: 0 12px 12px 0;
    box-shadow: 0px 4px 6px 0px rgba(0,0,0,0.09);
    min-width: 0;
  }

  .dialog-header {
    display: flex;
    flex-direction: column;
    gap: 4px;
    margin-bottom: 10px;
  }

  .eyebrow {
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 0.09em;
    text-transform: uppercase;
    color: var(--purple);
    margin: 0 0 10px 0;
  }

  .dialog-title {
    font-family: 'Fraunces', serif;
    font-weight: 600;
    font-size: 24px;
    line-height: 1.18;
    letter-spacing: -0.01em;
    margin: 0 0 8px 0;
    color: var(--ink);
  }

  .dialog-desc {
    font-size: 14px;
    line-height: 1.55;
    color: var(--gray);
    margin: 0 0 20px 0;
    max-width: 54ch;
  }

  /* ===== Pricing card ===== */
  .pricing-card {
    position: relative;
    border-radius: 16px;
    background: linear-gradient(to bottom, #FBFAF8 0%, #ffffff 60%);
    border: 1px solid var(--border);
    box-shadow: 0 1px 0 rgba(23,18,31,0.02);
    margin-bottom: 18px;
    overflow: visible;
  }

  .best-value-badge {
    position: absolute;
    top: -12px;
    right: 22px;
    background: var(--purple);
    color: #ffffff;
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 0.04em;
    padding: 6px 12px;
    border-radius: 7px;
    transform: rotate(3deg);
    box-shadow: 0 6px 14px -4px rgba(108,43,217,0.55);
  }

  .price-block {
    display: flex;
    align-items: flex-end;
    justify-content: space-between;
    gap: 12px;
    flex-wrap: wrap;
    padding: 16px 24px 12px 24px;
  }

  .price-plan-name {
    font-family: 'Fraunces', serif;
    font-weight: 600;
    font-size: 19px;
    margin: 0 0 6px 0;
    color: var(--ink);
  }

  .price-figures {
    display: flex;
    align-items: baseline;
    gap: 8px;
  }

  .price-old {
    font-size: 15px;
    color: var(--gray);
    text-decoration: line-through;
    text-decoration-color: #C7C1B8;
  }

  .price-new {
    font-family: 'Fraunces', serif;
    font-weight: 700;
    font-size: 34px;
    letter-spacing: -0.01em;
    color: var(--ink);
  }

  .price-period {
    font-size: 13px;
    font-weight: 500;
    color: var(--gray);
  }

  .save-badge {
    background: #EAF9F2;
    color: var(--green);
    font-size: 12px;
    font-weight: 700;
    padding: 6px 10px;
    border-radius: 999px;
    white-space: nowrap;
  }

  .lock-notice {
    display: flex;
    align-items: center;
    gap: 7px;
    margin: 2px 24px 20px 24px;
    background: var(--amber-bg);
    color: var(--amber);
    font-size: 12.5px;
    font-weight: 600;
    padding: 8px 12px;
    border-radius: 9px;
  }

  .lock-notice svg { width: 14px; height: 14px; flex: none; }

  /* perforation divider */
  .perforation {
    position: relative;
    height: 1px;
    margin-bottom: 4px;
  }

  .perforation-line {
    height: 1px;
    width: 100%;
    background-image: radial-gradient(circle, var(--border) 1.6px, transparent 1.6px);
    background-size: 9px 1px;
    background-repeat: repeat-x;
    background-position: 24px 0;
  }

  .perf-notch {
    position: absolute;
    top: -9px;
    width: 18px;
    height: 18px;
    border-radius: 999px;
    background: #fdfdfc;
    border: 1px solid var(--border);
  }

  .perf-notch.left { left: -9px; }
  .perf-notch.right { right: -9px; }

  .feature-list {
    list-style: none;
    margin: 0;
    display: grid;
    gap: 7px;
    padding: 18px 24px 22px 24px;
  }

  .feature-list li {
    display: flex;
    align-items: flex-start;
    gap: 10px;
    font-size: 12.5px;
    line-height: 1.3;
  }

  .feature-list svg {
    width: 15px;
    height: 15px;
    margin-top: 1px;
    flex: none;
    color: var(--green);
  }

  .feature-list b {
    font-weight: 600;
    color: var(--ink);
  }

  .feature-list .feature-desc { color: var(--gray); }

  /* ===== CTA button ===== */
  .upgrade-btn {
    width: 100%;
    border: none;
    border-radius: 12px;
    background: linear-gradient(to bottom, var(--purple), var(--purple-dark));
    color: #ffffff;
    font-family: 'Inter', sans-serif;
    font-weight: 700;
    font-size: 15px;
    padding: 12px 18px;
    cursor: pointer;
    box-shadow: 0 12px 24px -10px rgba(108,43,217,0.55);
    transition: transform 0.15s ease-out, box-shadow 0.15s ease-out;
    outline: none;
  }

  .upgrade-btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 16px 28px -10px rgba(108,43,217,0.6);
  }

  @media (max-width: 767px) {
    .dialog-content-side { border-radius: 12px; }
  }
</style>

<div class="ig-dialog-overlay" style="display: none;">
  <div class="ig-dialog-content">

    <button class="close-btn" aria-label="Close" onclick="document.querySelector('.ig-dialog-overlay').style.display='none'">
      <svg viewBox="0 0 14 14" fill="none">
        <path d="M1 1L13 13M13 1L1 13" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
      </svg>
    </button>

    <div class="dialog-body">

      <!-- Left Side - Image -->
      <div class="dialog-image-side">
        <img src="<?php echo esc_url( ICEGRAM_PLUGIN_URL . 'lite/assets/images/upsell/upgrade-popup-bg.png') ?>" alt="Hero">
        <div class="image-gradient"></div>

        <div class="image-caption">
          <div class="stars-row">
            <svg viewBox="0 0 20 20"><path d="M10 1l2.6 5.9 6.4.6-4.8 4.3 1.4 6.2L10 14.8 4.4 18l1.4-6.2L1 7.5l6.4-.6L10 1z"/></svg>
            <svg viewBox="0 0 20 20"><path d="M10 1l2.6 5.9 6.4.6-4.8 4.3 1.4 6.2L10 14.8 4.4 18l1.4-6.2L1 7.5l6.4-.6L10 1z"/></svg>
            <svg viewBox="0 0 20 20"><path d="M10 1l2.6 5.9 6.4.6-4.8 4.3 1.4 6.2L10 14.8 4.4 18l1.4-6.2L1 7.5l6.4-.6L10 1z"/></svg>
            <svg viewBox="0 0 20 20"><path d="M10 1l2.6 5.9 6.4.6-4.8 4.3 1.4 6.2L10 14.8 4.4 18l1.4-6.2L1 7.5l6.4-.6L10 1z"/></svg>
            <svg viewBox="0 0 20 20"><path d="M10 1l2.6 5.9 6.4.6-4.8 4.3 1.4 6.2L10 14.8 4.4 18l1.4-6.2L1 7.5l6.4-.6L10 1z"/></svg>
          </div>
          <p><strong><?php echo esc_html__('10000+ businesses', 'icegram'); ?></strong> <?php echo esc_html__('use Icegram Engage to capture more leads, grow their audience, and increase conversions.', 'icegram'); ?></p>
        </div>
      </div>

      <!-- Right Side - Content -->
      <div class="dialog-content-side">

        <div class="dialog-header">
          <p class="eyebrow"><?php echo esc_html__('Premium feature', 'icegram');?></p>
          <h1 class="dialog-title"><?php echo esc_html__('You just found a Max feature &#x2728;', 'icegram');?></h1>
          <p class="dialog-desc"><?php echo esc_html__('Show the right popup to the right visitor. Get advanced targeting, exit-intent campaigns, more display rules, and powerful conversion tools to grow your leads and sales.', 'icegram'); ?></p>
        </div>

        <div class="pricing-card">
          <div class="best-value-badge"><?php echo esc_html__('BEST VALUE', 'icegram'); ?></div>

          <div class="price-block">
            <div>
              <p class="price-plan-name"><?php echo esc_html__('Max • Full Access', 'icegram'); ?></p>
              <div class="price-figures">
                <span class="price-old"><?php echo esc_html__('$229', 'icegram'); ?></span>
                <span class="price-new"><?php echo esc_html__('$99', 'icegram'); ?></span>
                <span class="price-period"><?php echo esc_html__('/ year', 'icegram'); ?></span>
              </div>
            </div>
            <span class="save-badge"><?php echo esc_html__('Save 57%', 'icegram'); ?></span>
          </div>

          <div class="lock-notice">
            <svg viewBox="0 0 20 20" fill="none">
              <circle cx="10" cy="10" r="8" stroke="currentColor" stroke-width="1.6"/>
              <path d="M10 6v4l3 2" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
            </svg>
            <?php echo esc_html__('Launch pricing is locked in for the life of your subscription.', 'icegram'); ?>
          </div>

          <div class="perforation">
            <div class="perforation-line"></div>
            <div class="perf-notch left"></div>
            <div class="perf-notch right"></div>
          </div>

          <ul class="feature-list">
            <li>
              <svg viewBox="0 0 20 20" fill="none"><path d="M4 10.5l4 4 8-9" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
              <span><b><?php echo esc_html__('Exit-intent & behavior targeting', 'icegram'); ?></b> — <span class="feature-desc"><?php echo esc_html__('reach visitors at the right moment.', 'icegram'); ?></span></span>
            </li>
            <li>
              <svg viewBox="0 0 20 20" fill="none"><path d="M4 10.5l4 4 8-9" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
              <span><b><?php echo esc_html__('A/B split testing', 'icegram'); ?></b> — <span class="feature-desc"><?php echo esc_html__('see which version actually converts. Exit intent & user behaviou targeting', 'icegram'); ?></span></span>
            </li>
            <li>
              <svg viewBox="0 0 20 20" fill="none"><path d="M4 10.5l4 4 8-9" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
              <span><b><?php echo esc_html__('Detailed reports & analytics', 'icegram'); ?></b> — <span class="feature-desc"><?php echo esc_html__('see what works and improve every campaign.', 'icegram'); ?></span></span>
            </li>
            <li>
              <svg viewBox="0 0 20 20" fill="none"><path d="M4 10.5l4 4 8-9" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
              <span><b><?php echo esc_html__('100+ high-converting templates', 'icegram'); ?></b> — <span class="feature-desc"><?php echo esc_html__('Badges, stickies, ribbons, inline messages & more to grab attention.', 'icegram'); ?></span></span>
            </li>
            <li>
              <svg viewBox="0 0 20 20" fill="none"><path d="M4 10.5l4 4 8-9" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
              <span><b><?php echo esc_html__('Trusted by 20,000+ sites using Icegram Max', 'icegram'); ?></b> — <span class="feature-desc"><?php echo esc_html__('backed by hundreds of five-star reviews.', 'emai-subscribers'); ?></span></span>
            </li>
          </ul>
        </div>

        <a href="<?php echo esc_url( admin_url( 'edit.php?post_type=ig_campaign&page=icegram-upgrade' ) ); ?>" target="_blank">
          <button class="upgrade-btn" id="upsell-upgrade-btn"><?php echo esc_html__('Upgrade to Max - $99/year', 'icegram'); ?></button>
        </a>
      </div>

    </div>

  </div>
</div>