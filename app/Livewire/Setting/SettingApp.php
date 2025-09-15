<?php

namespace App\Livewire\Setting;

use App\Models\AppSetting;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class SettingApp extends Component
{
    use WithFileUploads;

    public function loadLogo() {
        $this->app_logo = AppSetting::first()->app_logo;
    }

    public $app_name, $app_logo, $current_logo;
    public $show_logo, $show_name;

    public function mount() {
        $setting = AppSetting::first();
        $this->app_name = $setting->app_name;
        $this->current_logo = $setting->app_logo;
        $this->show_logo = (bool) $setting->show_logo; // Pastikan ini dikonversi ke boolean
        $this->show_name = (bool) $setting->show_name;
        
    }

    public function save()
    {
        $setting = AppSetting::first();
        $setting->app_name = $this->app_name;
        $setting->show_logo = $this->show_logo ? 1 : 0; // Pastikan tersimpan sebagai 1/0
        $setting->show_name = $this->show_name ? 1 : 0;

        if ($this->app_logo instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile) {
            if ($setting->app_logo && Storage::disk('public')->exists($setting->app_logo)) {
                Storage::disk('public')->delete($setting->app_logo);
            }
            $path = $this->app_logo->store('logos', 'public');
            $setting->app_logo = $path;
        } else {
            $setting->app_logo = $setting->app_logo;
        }
        $setting->save();
        try {
            $this->dispatch('logo-updated', asset('storage/' . $setting->app_logo));
            $this->dispatch('app-name-updated', $setting->app_name);
                        
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
        session()->flash('success', 'Pengaturan berhasil disimpan.');
    }


    public function render()
    {
        return view('livewire.setting.setting-app');
    }
}
