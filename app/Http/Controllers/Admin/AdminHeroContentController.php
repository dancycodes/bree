<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DonationCtaSection;
use App\Models\HeroSection;
use Illuminate\Http\Request;

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
            'bg_image_path' => 'required|string|max:255',
        ]);

        $hero = HeroSection::where('is_active', true)->firstOrFail();
        $hero->update(array_map('strip_tags', $validated));

        return gale()->dispatch('toast', ['message' => 'Hero mis à jour', 'type' => 'success']);
    }

    public function updateCta(Request $request): mixed
    {
        $this->authorize('content.edit');

        $validated = $request->validateState([
            'cta_headline_fr' => 'required|string|max:200',
            'cta_headline_en' => 'required|string|max:200',
            'cta_copy_fr' => 'required|string|max:500',
            'cta_copy_en' => 'required|string|max:500',
            'cta_bg_path' => 'required|string|max:255',
        ]);

        $cta = DonationCtaSection::where('is_active', true)->firstOrFail();
        $cta->update([
            'headline_fr' => strip_tags($validated['cta_headline_fr']),
            'headline_en' => strip_tags($validated['cta_headline_en']),
            'copy_fr' => strip_tags($validated['cta_copy_fr']),
            'copy_en' => strip_tags($validated['cta_copy_en']),
            'bg_image_path' => strip_tags($validated['cta_bg_path']),
        ]);

        return gale()->dispatch('toast', ['message' => 'Section don mise à jour', 'type' => 'success']);
    }
}
