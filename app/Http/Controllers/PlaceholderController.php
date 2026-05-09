<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PlaceholderController extends Controller
{
    private array $pages = [
        'reports'  => ['title' => 'Reports',  'sub' => 'Generated reports and exports',       'icon' => '◷'],
        'users'    => ['title' => 'Users',    'sub' => 'Manage user accounts and permissions', 'icon' => '⬟'],
        'calendar' => ['title' => 'Calendar', 'sub' => 'Schedule and events',                  'icon' => '▦'],
        'settings' => ['title' => 'Settings', 'sub' => 'System configuration',                 'icon' => '⚙'],
        'security' => ['title' => 'Security', 'sub' => 'Access control and audit logs',        'icon' => '⬡'],
    ];

    public function __call(string $method, array $args): mixed
    {
        /** @var Request $request */
        $request  = $args[0];
        $meta     = $this->pages[$method] ?? ['title' => ucfirst($method), 'sub' => '', 'icon' => '◉'];

        $data = [
            'pageTitle' => $meta['title'],
            'pageSub'   => $meta['sub'],
            'icon'      => $meta['icon'],
        ];

        if ($request->ajax()) {
            return view('pages.placeholder', $data)->renderSections()['content'];
        }

        return view('pages.placeholder', $data);
    }
}
