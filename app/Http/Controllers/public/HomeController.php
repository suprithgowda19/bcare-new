<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\News;
use App\Models\Activity;
use App\Models\Update;
use App\Models\Service;
use App\Models\About;
use App\Models\Content;
use App\Models\Scheme;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Handle the dynamic Homepage.
     */
    public function index()
    {
        // 1. Fetch only ACTIVE banners for the slider
        $banners = Banner::where('status', 1)
                        ->latest()
                        ->get();
         $news= News::where('status', 'active')->latest()->take(6)->get();
         $activities= Activity::where('status', 'active')->latest()->take(6)->get();
         $updates= Update::where('status', 'active')->latest()->take(6)->get();
         $contents= Content::where('status', 'active')->latest()->take(6)->get();
         $services= Service::where('status', 'active')->latest()->take(6)->get();
         $abouts= About::where('status', 'active')->latest()->take(6)->get();
         $schemes= Scheme::where('status', 'active')->latest()->take(6)->get();
        // 2. You can add more dynamic data here later (News, Events, etc.)
        // $news = News::where('status', 1)->latest()->take(6)->get();

        // 3. Return the home view with the data
        return view('public.home', compact('banners', 'news', 'activities', 'updates', 'contents', 'services', 'abouts', 'schemes'));
    }
}