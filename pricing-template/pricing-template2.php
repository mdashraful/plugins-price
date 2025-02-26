<style>

    .pricing-container {
        display: flex;
        justify-content: space-between;
        gap: 20px;
        max-width: 100% !important;
        margin: 0 auto;
        padding: 20px;
    }
    .pricing-box {
        flex: 1;
        padding: 20px;
        border: 1px solid #ddd;
        border-radius: 10px;
        background-color: #ffcc99;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        text-align: center;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .pricing-box:hover {
        transform: translateY(-10px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
    }

    .plan-logo {
        max-width: 70px;
        height: auto;
        margin: 0 auto 15px;
        filter: drop-shadow(0 2px 4px rgba(0,0,0,0.1));
    }
    .pricing-title {
        font-size: 1.5em;
        font-weight: bold;
        margin-bottom: 15px;
        color: #333;
    }
    .pricing-price {
        font-size: 1.8em;
        font-weight: bold;
        color: <?php echo esc_html($theme_color); ?>;
        margin-bottom: 20px;
    }
    .pricing-features {
        list-style: none;
        margin-bottom: 20px;
    }
    .pricing-features li {
        font-size: 1em;
        margin-bottom: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #555;
    }
    .pricing-features li::before {
        content: "\2713";
        color: <?php echo esc_html($theme_color); ?>;
        margin-right: 10px;
        font-size: 1.2em;
    }
    .pricing-button {
        padding: 10px 20px;
        background-color: <?php echo esc_html($theme_color); ?>;
        color: white;
        text-decoration: none;
        border-radius: 5px;
        display: inline-block;
        margin-top: 15px;
        transition: background-color 0.3s ease;
    }
    .pricing-button:hover {
        background-color: #005bb5;
    }
    @media (max-width: 768px) {
        .pricing-container {
            flex-direction: column;
            gap: 30px;
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
                <?php echo esc_html($weekly_price); ?>
                <span class="duration">/week</span>
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
                <?php echo esc_html($monthly_price); ?>
                <span class="duration">/month</span>
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
                <?php echo esc_html($yearly_price); ?>
                <span class="duration">/year</span>
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