<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Category;
use App\Models\User;

class PostSeeder extends Seeder
{
    public function run(): void
    {
        $total = 50000;
        $chunkSize = 5000;
        $now = now();

        // Ensure we have some categories
        if (Category::count() === 0) {
            $categories = [];
            foreach (['Technology', 'Lifestyle', 'Business', 'Health', 'Travel'] as $cat) {
                $categories[] = [
                    'name' => $cat,
                    'slug' => Str::slug($cat),
                    'status' => 'active',
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }
            DB::table('categories')->insert($categories);
        }

        $categoryIds = Category::pluck('id')->toArray();
        $userIds = User::pluck('id')->toArray();
        
        // Fallback user if none exists (though DatabaseSeeder creates one)
        if (empty($userIds)) {
            $userId = DB::table('users')->insertGetId([
                'name' => 'System Auto',
                'email' => 'auto@system.com',
                'password' => bcrypt('password'),
                'created_at' => $now,
                'updated_at' => $now,
            ]);
            $userIds = [$userId];
        }

        for ($i = 0; $i < $total; $i += $chunkSize) {
            $posts = [];
            for ($j = 0; $j < $chunkSize; $j++) {
                $status = ['draft', 'published', 'archived'][rand(0, 2)];
                $posts[] = [
                    'category_id' => $categoryIds[array_rand($categoryIds)],
                    'user_id' => $userIds[array_rand($userIds)],
                    'title' => 'Blog Post ' . Str::random(8),
                    'slug' => Str::slug('Blog Post ' . Str::random(8) . '-' . uniqid()),
                    'excerpt' => 'This is a short excerpt for the post.',
                    'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
                    'status' => $status,
                    'published_at' => $status === 'published' ? $now : null,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }
            DB::table('posts')->insert($posts);
        }
    }
}
