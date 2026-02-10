<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Setting;

class AboutController extends Controller
{
    public function show()
    {
        $defaults = [
            'header_title' => '',
            'header_subtitle' => '',
            'story_title' => '',
            'story_paragraphs' => [],
            'story_badges' => [],
            'mission_title' => '',
            'mission_body' => '',
            'vision_title' => '',
            'vision_body' => '',
            'values_title' => '',
            'values_subtitle' => '',
            'values' => [],
            'milestones_title' => '',
            'milestones_subtitle' => '',
            'milestones' => [],
            'team_title' => '',
            'team_subtitle' => '',
            'team' => [],
            'achievements_title' => '',
            'achievements_subtitle' => '',
            'achievements' => [],
            'partners_title' => '',
            'partners_subtitle' => '',
            'partners' => [],
            'stats_title' => '',
            'stats_subtitle' => '',
            'stats' => [],
            'cta_title' => '',
            'cta_body' => '',
            'cta_primary_text' => '',
            'cta_primary_url' => '',
            'cta_secondary_text' => '',
            'cta_secondary_url' => '',
        ];

        $settings = Setting::get('website.about', []);
        $content = array_replace_recursive($defaults, is_array($settings) ? $settings : []);

        return response()->json([
            'data' => $content,
        ]);
    }
}
