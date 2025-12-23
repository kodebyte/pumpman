<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Contracts\SettingRepositoryInterface;
use App\Services\SettingService;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function __construct(
        protected SettingRepositoryInterface $settingRepo,
        protected SettingService $settingService
    ) {}

    public function index()
    {
        $settings = $this->settingRepo->getAllPlucked();
        
        return view('admin.pages.setting.index', compact('settings'));
    }

    public function update(
        Request $request
    )
    {
        try {
            $data = $request->except(['_token', '_method']);

            $this->settingService->update($data);
        } catch (\Exception $e) {
            \Log::error('Settings update error: ' . $e->getMessage());

            return back()
                    ->with('error', 'Failed to update settings.');
        }

        return to_route('admin.settings.index')
                ->with('success', 'Settings updated successfully');
    }
}