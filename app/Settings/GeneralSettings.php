<?php

use Spatie\LaravelSettings\Settings;

class GeneralSettings extends Settings
{
    public string $site_name;
    public bool $site_active;
    public int $affiliate_distribution_frequency;
    public int $affiliate_distribution_percentage;
    public int $affiliate_transaction_distribution_percentage;
    public int $customer_over_withdraw_amount_manual_transfer;
    public int $customer_within_withdraw_amount_instant_api_transfer;

    public static function group(): string
    {
        return 'general';
    }
}
