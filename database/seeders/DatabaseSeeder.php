<?php

namespace Database\Seeders;

use App\Models\Chapter;
use App\Models\Content;
use App\Models\Course;
use App\Models\File;
use App\Models\Level;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::factory(10)->create();
        Level::factory(6)->create();
        Chapter::factory(6)->create();
        Course::factory(6)->create();
        Content::factory(6)->create();
        File::factory(6)->create();
    }
}
