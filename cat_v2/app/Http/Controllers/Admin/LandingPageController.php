<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use App\Models\Gallery;
use App\Models\AppShowcase;
use App\Models\LandingPage;
use App\Models\MemberLevel;
use Illuminate\Http\Request;
use App\Models\MemberBenefit;
use App\Models\LandingPageFeature;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\LandingPageHighlight;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class LandingPageController extends Controller
{
    public function index()
    {
        $landingPage = LandingPage::firstOrCreate([]);
        $features = LandingPageFeature::all();
        $highlights = LandingPageHighlight::firstOrCreate([]);  
        $showcases = AppShowcase::orderBy('order')->get();

        return Inertia::render('Admin/LandingPage/Index', [
            'landingPage' => $landingPage,
            'features' => $features,
            'highlights' => $highlights,
            'showcases' => $showcases,
            'flash' => [
                'message' => session('message'),
                'type' => session('type')
            ]
        ]);
    }

    public function highlightEditor()
    {
        $highlights = LandingPageHighlight::firstOrCreate([]);
        
        return Inertia::render('Admin/LandingPage/HighlightEditor', [
            'highlights' => $highlights,
            'flash' => [
                'message' => session('message'),
                'type' => session('type')
            ]
        ]);
    }

    public function showcaseEditor()
    {
        $showcases = AppShowcase::orderBy('order')->get();
        
        return Inertia::render('Admin/LandingPage/AppShowcase', [
            'showcases' => $showcases,
            'flash' => [
                'message' => session('message'),
                'type' => session('type')
            ]
        ]);
    }

    public function updateHero(Request $request)
    {
        $validated = $request->validate([
            'hero_title' => 'required|string|max:255',
            'hero_description' => 'required|string',
        ]);

        $landingPage = LandingPage::firstOrCreate([]);
        $landingPage->update($validated);

        return redirect()->back()->with([
            'message' => 'Hero section berhasil diperbarui',
            'type' => 'success'
        ]);
    }

    public function updateFeature(Request $request, $id = null)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $feature = $id ? LandingPageFeature::findOrFail($id) : new LandingPageFeature();
        $feature->fill($validated)->save();

        return redirect()->back()->with([
            'message' => 'Fitur berhasil disimpan',
            'type' => 'success'
        ]);
    }

    public function deleteFeature($id)
    {
        LandingPageFeature::findOrFail($id)->delete();

        return redirect()->back()->with([
            'message' => 'Fitur berhasil dihapus',
            'type' => 'success'
        ]);
    }

    public function updateHighlights(Request $request)
    {
        $validated = $request->validate([
            'title1' => 'required|string|max:255',
            'description1' => 'required|string',
            'title2' => 'required|string|max:255',
            'description2' => 'required|string',
            'title3' => 'required|string|max:255',
            'description3' => 'required|string',
        ]);

        $highlights = LandingPageHighlight::firstOrCreate([]);
        $highlights->update($validated);

        return redirect()->back()->with([
            'message' => 'Highlight features berhasil diperbarui',
            'type' => 'success'
        ]);
    }

    public function storeShowcase(Request $request)
{
    $validator = Validator::make($request->all(), [
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'thumbnail' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ]);

    if ($validator->fails()) {
        return redirect()->back()
            ->withErrors($validator)
            ->withInput()
            ->with([
                'message' => 'Validasi gagal. Silakan periksa form Anda.',
                'type' => 'error'
            ]);
    }

    try {
        $thumbnailPath = $request->file('thumbnail')->store('app_showcases', 'public');

        AppShowcase::create([
            'title' => $request->title,
            'description' => $request->description,
            'thumbnail' => $thumbnailPath,
            'order' => AppShowcase::count() + 1,
        ]);

        return redirect()->back()->with([
            'message' => 'App Showcase berhasil ditambahkan',
            'type' => 'success'
        ]);

    } catch (\Exception $e) {
        Log::error('Error storing showcase: ' . $e->getMessage());

        if (isset($thumbnailPath)) {
            Storage::disk('public')->delete($thumbnailPath);
        }

        return redirect()->back()
            ->withInput()
            ->with([
                'message' => 'Terjadi kesalahan sistem. Silakan coba lagi.',
                'type' => 'error'
            ]);
    }
}


    public function updateShowcase(Request $request, AppShowcase $appShowcase)
{
    $validator = Validator::make($request->all(), [
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ]);

    if ($validator->fails()) {
        return redirect()->back()
            ->withErrors($validator)
            ->withInput()
            ->with([
                'message' => 'Validasi gagal. Silakan periksa form Anda.',
                'type' => 'error'
            ]);
    }

    try {
        $data = [
            'title' => $request->title,
            'description' => $request->description,
        ];

        if ($request->hasFile('thumbnail')) {
            if ($appShowcase->thumbnail) {
                Storage::disk('public')->delete($appShowcase->thumbnail);
            }

            $thumbnailPath = $request->file('thumbnail')->store('app_showcases', 'public');
            $data['thumbnail'] = $thumbnailPath;
        }

        $appShowcase->update($data);

        return redirect()->back()->with([
            'message' => 'App Showcase berhasil diperbarui',
            'type' => 'success'
        ]);

    } catch (\Exception $e) {
        Log::error('Error updating showcase: ' . $e->getMessage());
        return redirect()->back()
            ->withInput()
            ->with([
                'message' => 'Terjadi kesalahan sistem. Silakan coba lagi.',
                'type' => 'error'
            ]);
    }
}


    public function deleteShowcase(AppShowcase $appShowcase)
    {
        try {
            if ($appShowcase->thumbnail) {
                $thumbnailPath = str_replace('/storage', 'public', $appShowcase->thumbnail);
                Storage::delete($thumbnailPath);
            }

            $appShowcase->delete();

            // Reorder sisa showcase
            AppShowcase::orderBy('order')->get()->each(function($showcase, $index) {
                $showcase->update(['order' => $index + 1]);
            });

            return redirect()->back()->with([
                'message' => 'App Showcase berhasil dihapus',
                'type' => 'success'
            ]);

        } catch (\Exception $e) {
            Log::error('Error deleting showcase: ' . $e->getMessage());
            return redirect()->back()->with([
                'message' => 'Gagal menghapus showcase. Silakan coba lagi.',
                'type' => 'error'
            ]);
        }
    }

    public function updateShowcaseOrder(Request $request)
    {
        try {
            $request->validate([
                'showcases' => 'required|array',
            ]);

            foreach ($request->showcases as $index => $showcaseId) {
                AppShowcase::where('id', $showcaseId)->update(['order' => $index + 1]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Urutan berhasil diperbarui'
            ]);

        } catch (\Exception $e) {
            Log::error('Error updating showcase order: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui urutan'
            ], 500);
        }
    }
    public function manageMemberBenefits()
{
    $levels = MemberLevel::with('benefits')->get();
    $benefits = MemberBenefit::all();

    return Inertia::render('Admin/LandingPage/MemberBenefit', [
        'levels' => $levels,
        'benefits' => $benefits,
        'flash' => [ 
            'message' => session('message'),
            'type' => session('type')
        ]
    ]);
}

public function updateMemberBenefits(Request $request)
{
    $data = $request->input('levels');

    foreach ($data as $levelId => $benefitIds) {
        $level = MemberLevel::find($levelId);
        if ($level) {
            $level->benefits()->sync($benefitIds);
        }
    }

    return redirect()->back()->with([
        'type' => 'success',
        'message' => 'Data berhasil disimpan.'
    ]);
}

public function galleryEditor()
{
    $galleries = Gallery::orderBy('order')->get();
    return Inertia::render('Admin/LandingPage/GalleryIndex', [
        'galleries' => $galleries
    ]);
}

public function storeGallery(Request $request)
{
    $request->validate([
        'image' => 'required|image|mimes:jpg,jpeg,png,jpg,gif,svg|max:2048',
    ]);

    $path = $request->file('image')->store('gallery', 'public');

    Gallery::create([
        'image' => $path,
        'order' => Gallery::count() + 1,
    ]);

    return back()->with('message', 'Foto berhasil ditambahkan');
}

public function deleteGallery(Gallery $gallery)
{
    if ($gallery->image) {
        Storage::disk('public')->delete($gallery->image);
    }
    $gallery->delete();

    return back()->with('message', 'Foto berhasil dihapus');
}
public function updateGallery(Request $request, Gallery $gallery)
{
    $request->validate([
        'image' => 'required|image|mimes:jpg,jpeg,png,gif,svg|max:2048',
    ]);

    if ($gallery->image) {
        Storage::disk('public')->delete($gallery->image);
    }

    $path = $request->file('image')->store('gallery', 'public');

    $gallery->update([
        'image' => $path,
    ]);

    return back()->with('message', 'Foto berhasil diperbarui');
}



}