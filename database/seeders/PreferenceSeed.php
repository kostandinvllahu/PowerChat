<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PreferenceList;

class PreferenceSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $preferences = [
            [
                'name' => 'Sports',
            ],
            [
                'name' => 'Music',
            ],
            [
                'name' => 'Movies',
            ],
            [
                'name' => 'Travel',
            ],
            [
                'name' => 'Food',
            ],
            [
                'name' => 'Fitness',
            ],
            [
                'name' => 'Books',
            ],
            [
                'name' => 'Art',
            ],
            [
                'name' => 'Technology',
            ],
            [
                'name' => 'Fashion',
            ],
            [
                'name' => 'Photography',
            ],
            [
                'name' => 'Gaming',
            ],
            [
                'name' => 'Nature',
            ],
            [
                'name' => 'Science',
            ],
            [
                'name' => 'History',
            ],
            [
                'name' => 'Politics',
            ],
            [
                'name' => 'Pets',
            ],
            [
                'name' => 'Cars',
            ],
            [
                'name' => 'Cooking',
            ],
            [
                'name' => 'Health',
            ],
            [
                'name' => 'Education',
            ],
            [
                'name' => 'Business',
            ],
            [
                'name' => 'Photography',
            ],
            [
                'name' => 'Architecture',
            ],
            [
                'name' => 'Writing',
            ],
            [
                'name' => 'Design',
            ],
            [
                'name' => 'Environment',
            ],
            [
                'name' => 'Parenting',
            ],
            [
                'name' => 'Technology',
            ],
            [
                'name' => 'Fashion',
            ],
        ];

        foreach ($preferences as $preference) {
            PreferenceList::create($preference);
        }
    }
}
