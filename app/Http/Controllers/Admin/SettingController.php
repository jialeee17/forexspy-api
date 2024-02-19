<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateSettingRequest;
use GeneralSettings;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SettingController extends Controller
{
    public function edit()
    {
        $settings = collect(app(GeneralSettings::class));

        return Inertia::render('Admin/Settings/Index', compact('settings'));
    }

    public function update(UpdateSettingRequest $request)
    {
        $data = $request->validated();
        $settings = app(GeneralSettings::class);

        $settings->site_name = $data['site_name'];
        $settings->site_active = $data['site_active'];
        $settings->affiliate_distribution_frequency = $data['affiliate_distribution_frequency'];
        $settings->affiliate_distribution_percentage = $data['affiliate_distribution_percentage'];
        $settings->affiliate_transaction_distribution_percentage = $data['affiliate_transaction_distribution_percentage'];
        $settings->customer_over_withdraw_amount_manual_transfer = $data['customer_over_withdraw_amount_manual_transfer'];
        $settings->customer_within_withdraw_amount_instant_api_transfer = $data['customer_within_withdraw_amount_instant_api_transfer'];
        $settings->save();
    }
}
