<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AnalyticsController extends Controller
{
    public function index(Request $request)
    {
        $metrics = [
            ['label' => 'Page Views',      'value' => '1.2M',  'change' => '14.2%', 'up' => true,  'pct' => 72, 'color' => '#22d3ee'],
            ['label' => 'Bounce Rate',     'value' => '38.4%', 'change' => '2.1%',  'up' => false, 'pct' => 38, 'color' => '#f472b6'],
            ['label' => 'Avg. Session',    'value' => '4m 12s', 'change' => '0.8%', 'up' => true,  'pct' => 55, 'color' => '#a78bfa'],
            ['label' => 'New Visitors',    'value' => '68.3%', 'change' => '5.6%',  'up' => true,  'pct' => 68, 'color' => '#4ade80'],
        ];

        if ($request->ajax()) {
            return view('pages.analytics', compact('metrics'))->renderSections()['content'];
        }

        return view('pages.analytics', compact('metrics'));
    }
}
