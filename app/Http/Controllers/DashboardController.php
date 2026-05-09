<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $activity = [
            ['icon' => '↑', 'bg' => 'rgba(34,211,238,.12)',  'msg' => 'Taylor W. completed a $240 purchase',      'time' => '2 min ago'],
            ['icon' => '⬡', 'bg' => 'rgba(167,139,250,.12)', 'msg' => 'Maya L. upgraded to Pro plan',              'time' => '18 min ago'],
            ['icon' => '⚠', 'bg' => 'rgba(244,114,182,.12)', 'msg' => 'Payment failed — Order #1082',               'time' => '34 min ago'],
            ['icon' => '✓', 'bg' => 'rgba(74,222,128,.12)',  'msg' => 'Server deployment successful',               'time' => '1 hr ago'],
            ['icon' => '◉', 'bg' => 'rgba(251,191,36,.12)',  'msg' => '12 new products added in batch',            'time' => '3 hr ago'],
        ];

        $orders = [
            ['id' => '1089', 'customer' => 'Taylor W.',  'amount' => '$240.00', 'status' => 'Completed', 'status_color' => '#4ade80', 'status_bg' => 'rgba(74,222,128,.1)',   'date' => '2025-05-09'],
            ['id' => '1088', 'customer' => 'Maya L.',    'amount' => '$89.00',  'status' => 'Pending',   'status_color' => '#fbbf24', 'status_bg' => 'rgba(251,191,36,.1)',   'date' => '2025-05-08'],
            ['id' => '1087', 'customer' => 'Sam R.',     'amount' => '$1,999',  'status' => 'Completed', 'status_color' => '#4ade80', 'status_bg' => 'rgba(74,222,128,.1)',   'date' => '2025-05-08'],
            ['id' => '1086', 'customer' => 'Jordan K.',  'amount' => '$149.00', 'status' => 'Failed',    'status_color' => '#f87171', 'status_bg' => 'rgba(248,113,113,.1)',  'date' => '2025-05-07'],
            ['id' => '1085', 'customer' => 'Alex M.',    'amount' => '$59.00',  'status' => 'Completed', 'status_color' => '#4ade80', 'status_bg' => 'rgba(74,222,128,.1)',   'date' => '2025-05-07'],
        ];

        // AJAX request → return only the content fragment (no layout wrapper)
        if ($request->ajax()) {
            return view('pages.dashboard', compact('activity', 'orders'))->renderSections()['content'];
        }

        return view('pages.dashboard', compact('activity', 'orders'));
    }
}
