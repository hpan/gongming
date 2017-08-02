<?php

use Illuminate\Database\Seeder;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('articles')->delete();

        for ($i=0; $i < 20; $i++) {
            \App\Article::create([
                'title'   => 'Title '.$i,
                'body'    => 'Body '.$i,
                'name'    => 'name '.$i,
                'images'    => 'images '.$i,
                'address'    => 'address '.$i,
                'mobile'    => 'mobile '.$i,
                'anonymous'    => 0,
                'user_id' => 1,
            ]);
        }
    }
}
