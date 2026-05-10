<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PlaceholderController extends Controller
{
    private array $pages = [
        'profile'    => ['title' => 'Profile',    'sub' => 'Manage your account settings', 'icon' => '👤'],
        'appearance' => ['title' => 'Appearance', 'sub' => 'Customize your interface',      'icon' => '🎨'],
    ];

    public function __call(string $method, array $args): mixed
    {
        $request  = request();
        $meta     = $this->pages[$method] ?? ['title' => ucfirst($method), 'sub' => '', 'icon' => '◉'];

        $data = [
            'pageTitle' => $meta['title'],
            'pageSub'   => $meta['sub'],
            'icon'      => $meta['icon'],
        ];

        if (view()->exists("pages.$method")) {
            $view = "pages.$method";
        } else {
            $view = "pages.placeholder";
        }

        if ($request->ajax()) {
            return view($view, $data)->renderSections()['content'];
        }

        return view($view, $data);
    }
}
