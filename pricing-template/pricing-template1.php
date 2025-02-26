<style>
    .pricing-container {
        display: flex;
        justify-content: space-between;
        gap: 20px;
        max-width: 100% !important;
        margin: 0 auto;
        padding: 20px;
        flex-wrap: wrap;
    }
    .pricing-box {
        flex: 1;
        padding: 25px;
        border-radius: 15px;
        backdrop-filter: blur(10px);
        background: rgba(255, 255, 255, 0.2);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        text-align: center;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border: 1px solid rgba(255, 255, 255, 0.3);
    }
    .pricing-box:hover {
        transform: translateY(-10px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
    }
    .plan-logo {
        max-width: 80px;
        height: auto;
        margin: 0 auto 15px;
        display: block;
    }
    .pricing-title {
        font-size: 1.7em;
        font-weight: bold;
        color: #222;
        margin-bottom: 15px;
    }
    .pricing-price {
        font-size: 2em;
        font-weight: bold;
        color: <?php echo esc_html($theme_color); ?>;
        margin-bottom: 20px;
    }
    .pricing-features {
        list-style: none;
        padding: 0;
        margin-bottom: 20px;
    }
    .pricing-features li {
        font-size: 1em;
        margin-bottom: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #444;
    }
    .pricing-features li::before {
        content: "✔";
        color: <?php echo esc_html($theme_color); ?>;
        margin-right: 10px;
        font-size: 1.2em;
    }
    .pricing-button {
        padding: 12px 24px;
        background: <?php echo esc_html($theme_color); ?>;
        color: white;
        text-decoration: none;
        border-radius: 30px;
        display: inline-block;
        font-weight: bold;
        transition: background-color 0.3s ease;
    }
    .pricing-button:hover {
        background: <?php echo esc_html($theme_color); ?>;
        filter: brightness(90%);
    }
    @media (max-width: 768px) {
        .pricing-container {
            flex-direction: column;
        }
        .pricing-box {
            width: 100%;
        }
    }
</style>


<div class="pricing-container">
    <!-- Weekly Plan -->
    <div class="pricing-box">
        <?php if (!empty($weekly_logo)) : ?>
            <img src="<?php echo esc_url($weekly_logo); ?>" class="plan-logo" alt="Weekly Plan">
        <?php endif; ?>
        <div class="pricing-title">Weekly Plan</div>
        <div class="pricing-price">
            <span class="price-amount">
                <span class="currency-symbol"><?php echo esc_html($currency); ?></span>
                <?php echo esc_html($weekly_price); ?>/week
            </span>
        </div>
        <ul class="pricing-features">
            <?php foreach ($weekly_features as $feature) {
                echo '<li>' . esc_html($feature) . '</li>';
            } ?>
        </ul>
        <a href="<?php echo esc_html($weekly_link); ?>" class="pricing-button" target="_blank">Get Started</a>
    </div>

    <!-- Monthly Plan -->
    <div class="pricing-box">
        <?php if (!empty($monthly_logo)) : ?>
            <img src="<?php echo esc_url($monthly_logo); ?>" class="plan-logo" alt="Monthly Plan">
        <?php endif; ?>
        <div class="pricing-title">Monthly Plan</div>
        <div class="pricing-price">
            <span class="price-amount">
                <span class="currency-symbol"><?php echo esc_html($currency); ?></span>
                <?php echo esc_html($monthly_price); ?>/month
            </span>
        </div>
        <ul class="pricing-features">
            <?php foreach ($monthly_features as $feature) {
                echo '<li>' . esc_html($feature) . '</li>';
            } ?>
        </ul>
        <a href="<?php echo esc_html($monthly_link); ?>" class="pricing-button" target="_blank">Get Started</a>
    </div>

    <!-- Yearly Plan -->
    <div class="pricing-box">
        <?php if (!empty($yearly_logo)) : ?>
            <img src="<?php echo esc_url($yearly_logo); ?>" class="plan-logo" alt="Yearly Plan">
        <?php endif; ?>
        <div class="pricing-title">Yearly Plan</div>
        <div class="pricing-price">
            <span class="price-amount">
                <span class="currency-symbol"><?php echo esc_html($currency); ?></span>
                <?php echo esc_html($yearly_price); ?>/year
            </span>
        </div>
        <ul class="pricing-features">
            <?php foreach ($yearly_features as $feature) {
                echo '<li>' . esc_html($feature) . '</li>';
            } ?>
        </ul>
        <a href="<?php echo esc_html($yearly_link); ?>" class="pricing-button" target="_blank">Get Started</a>
    </div>
</div>