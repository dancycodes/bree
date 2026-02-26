<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DonationCtaSection;
use App\Models\HeroSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminHeroContentController extends Controller
{
    public function index(): mixed
    {
        $this->authorize('content.edit');

        $hero = HeroSection::firstOrCreate(
            ['is_active' => true],
            [
                'tagline_fr' => '',
                'tagline_en' => '',
                'subtitle_fr' => '',
                'subtitle_en' => '',
                'cta1_label_fr' => '',
                'cta1_label_en' => '',
                'cta1_url' => '/programmes',
                'cta2_label_fr' => '',
                'cta2_label_en' => '',
                'cta2_url' => '/faire-un-don',
                'bg_image_path' => 'images/sections/hero.jpg',
            ]
        );

        $cta = DonationCtaSection::firstOrCreate(
            ['is_active' => true],
            [
                'headline_fr' => '',
                'headline_en' => '',
                'copy_fr' => '',
                'copy_en' => '',
                'bg_image_path' => 'images/sections/donate.jpg',
            ]
        );

        return gale()->view('admin.hero.index', compact('hero', 'cta'), web: true);
    }

    public function updateHero(Request $request): mixed
    {
        $this->authorize('content.edit');

        $validated = $request->validateState([
            'tagline_fr' => 'required|string|max:200',
            'tagline_en' => 'required|string|max:200',
            'subtitle_fr' => 'required|string|max:500',
            'subtitle_en' => 'required|string|max:500',
            'cta1_label_fr' => 'required|string|max:80',
            'cta1_label_en' => 'required|string|max:80',
            'cta1_url' => 'required|string|max:500',
            'cta2_label_fr' => 'required|string|max:80',
            'cta2_label_en' => 'required|string|max:80',
            'cta2_url' => 'required|string|max:500',
        ]);

        $hero = HeroSection::where('is_active', true)->firstOrFail();
        $hero->update(array_map('strip_tags', $validated));

        return gale()->dispatch('toast', ['message' => 'Hero mis à jour', 'type' => 'success']);
    }

    public function uploadHeroImage(Request $request): mixed
    {
        $this->authorize('content.edit');

        $request->validate(['hero_image' => 'required|image|mimes:jpeg,jpg,png,webp|max:5120']);

        $hero = HeroSection::where('is_active', true)->firstOrFail();

        if ($hero->bg_image_path && str_starts_with($hero->bg_image_path, 'storage/')) {
            $old = str_replace('storage/', '', $hero->bg_image_path);
            if (Storage::disk('public')->exists($old)) {
                Storage::disk('public')->delete($old);
            }
        }

        $path = $request->file('hero_image')->store('hero', 'public');
        $hero->update(['bg_image_path' => 'storage/'.$path]);

        return gale()->redirect(route('admin.hero.index'));
    }

    public function updateCta(Request $request): mixed
    {
        $this->authorize('content.edit');

        $validated = $request->validateState([
            'cta_headline_fr' => 'required|string|max:200',
            'cta_headline_en' => 'required|string|max:200',
            'cta_copy_fr' => 'required|string|max:500',
            'cta_copy_en' => 'required|string|max:500',
        ]);

        $cta = DonationCtaSection::where('is_active', true)->firstOrFail();
        $cta->update([
            'headline_fr' => strip_tags($validated['cta_headline_fr']),
            'headline_en' => strip_tags($validated['cta_headline_en']),
            'copy_fr' => strip_tags($validated['cta_copy_fr']),
            'copy_en' => strip_tags($validated['cta_copy_en']),
        ]);

        return gale()->dispatch('toast', ['message' => 'Section don mise à jour', 'type' => 'success']);
    }

    public function uploadCtaImage(Request $request): mixed
    {
        $this->authorize('content.edit');

        $request->validate(['cta_image' => 'required|image|mimes:jpeg,jpg,png,webp|max:5120']);

        $cta = DonationCtaSection::where('is_active', true)->firstOrFail();

        if ($cta->bg_image_path && str_starts_with($cta->bg_image_path, 'storage/')) {
            $old = str_replace('storage/', '', $cta->bg_image_path);
            if (Storage::disk('public')->exists($old)) {
                Storage::disk('public')->delete($old);
            }
        }

        $path = $request->file('cta_image')->store('cta', 'public');
        $cta->update(['bg_image_path' => 'storage/'.$path]);

        return gale()->redirect(route('admin.hero.index'));
    }
}
