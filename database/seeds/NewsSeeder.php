<?php

use Illuminate\Database\Seeder;

/**
 * Class NewsSeeder
 *
 * @author D3lph1 <d3lph1.contact@gmail.com>
 */
class NewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Models\News\EloquentNews::class, 10)->create();
    }
}
