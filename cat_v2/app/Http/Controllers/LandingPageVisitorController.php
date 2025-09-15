<?php

namespace App\Http\Controllers;

use App\Models\LandingPage;
use App\Models\LandingPageFeature;
use App\Models\LandingPageHighlight;
use App\Models\AppShowcase;
use App\Models\Setting; // Tambahkan ini
use Illuminate\Support\Facades\View;

class LandingPageVisitorController extends Controller
{
    public function index()
    {
        $setting = Setting::first();

        $theme = 'theme_' . ($setting->theme ?? 1); 

        if (!View::exists("landing_page.$theme.index")) {
            abort(404, "Tampilan untuk tema '$theme' tidak ditemukan.");
        }

        return view("landing_page.$theme.index", [
            'setting' => $setting,
            'landingPage' => LandingPage::first(),
            'features' => LandingPageFeature::all(),
            'highlights' => LandingPageHighlight::first(),
            'showcases' => AppShowcase::orderBy('order')->get(),
        ]);
    }
}
