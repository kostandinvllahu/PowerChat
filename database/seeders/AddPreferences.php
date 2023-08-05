<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Preference;

class AddPreferences extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $preferenceIds = range(1, 30);
        $userIds = range(3, 102);

        $preferenceIndex = 0;

        foreach ($userIds as $userId) {
            $preferenceId = $preferenceIds[$preferenceIndex];

            Preference::create([
                'userId' => $userId,
                'preference_id' => $preferenceId,
            ]);

            $preferenceIndex = ($preferenceIndex + 1) % 30;
        }
    }
}
