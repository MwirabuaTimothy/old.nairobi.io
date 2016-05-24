<?php

use Carbon\Carbon;
use App\Blog;
use App\Tag;
use App\Star;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class BlogsTableSeeder extends Seeder
{

    public function run()
    {
        $faker = Faker::create();

        foreach (range(1, 20) as $index) {
            $user_id = rand(1, 2);
            $blog = Blog::create([
                'user_id' => $user_id,
                'title' => $faker->sentence,
                'body' => $faker->paragraph,
                'notes' => $faker->paragraph,
                'category_id' => rand(1, 14),
                'highlighted' => rand(0, 1),
                'public' => 1,
                'views' => rand(0, 100),
                'created_at' => Carbon::now()->subDays(rand(0, 28))->toDateTimeString()
            ]);
            
            // seed tags
            foreach (range(1, rand(1, 5)) as $index) {
                $blog->tags()->save(Tag::find(rand(1, 18))); //to seed pivot table
            }

            // seed stars
            $stars = rand(1, 100);
            for ($i=1; $i<=$stars; $i++) {
                Star::create([
                    'user_id' => $i,
                    'blog_id' => $blog->id
                ]);
            }
        }
    }
}
