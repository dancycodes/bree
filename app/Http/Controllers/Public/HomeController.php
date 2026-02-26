<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\DonationCtaSection;
use App\Models\FoundationEvent;
use App\Models\FounderProfile;
use App\Models\GalleryPhoto;
use App\Models\HeroSection;
use App\Models\MissionSection;
use App\Models\NewsArticle;
use App\Models\Partner;
use App\Models\PatronProfile;
use App\Models\ProgramCard;
use App\Models\StatCounter;

class HomeController extends Controller
{
    public function index(): mixed
    {
        $hero = HeroSection::active();
        $counters = StatCounter::active()->get();
        $mission = MissionSection::active();
        $programs = ProgramCard::active()->get();
        $latestNews = NewsArticle::published()->with('newsCategory')->limit(3)->get();
        $founder = FounderProfile::active();
        $patron = PatronProfile::active();
        $upcomingEvents = FoundationEvent::upcoming()->limit(3)->get();
        $donationCta = DonationCtaSection::active();
        $galleryPhotos = GalleryPhoto::with('album')
            ->whereHas('album', fn ($q) => $q->where('is_published', true))
            ->orderByDesc('created_at')
            ->limit(8)
            ->get();
        $partners = Partner::published()->get();

        return gale()->view('public.home', compact('hero', 'counters', 'mission', 'programs', 'latestNews', 'founder', 'patron', 'upcomingEvents', 'donationCta', 'galleryPhotos', 'partners'), web: true);
    }
}
