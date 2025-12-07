<?php

namespace Database\Seeders;

use App\Models\FeatureFlag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FeatureFlagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        FeatureFlag::truncate();

        FeatureFlag::create([
            'key' => 'enable_report_creation',
            'name' => 'Enable Report Creation',
            'description' => 'Controls whether users can create new car damage reports.',
            'enabled' => true,
        ]);

        FeatureFlag::create([
            'key' => 'enable_report_editing',
            'name' => 'Enable Report Editing',
            'description' => 'Controls editing of existing reports.',
            'enabled' => true,
        ]);

        FeatureFlag::create([
            'key' => 'enable_report_deletion',
            'name' => 'Enable Report Deletion',
            'description' => 'Allows deleting reports.',
            'enabled' => false,
        ]);

        FeatureFlag::create([
            'key' => 'enable_report_viewing',
            'name' => 'Show Report Viewing',
            'description' => 'Allows viewing reports.',
            'enabled' => true,
        ]);
    }
}
