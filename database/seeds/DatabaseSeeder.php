<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function __construct(
        \App\Repositories\BanRepository $ban,
        \App\Repositories\CartRepository $cart,
        \App\Repositories\CategoryRepository $category,
        \App\Repositories\ItemRepository $item,
        \App\Repositories\NewsRepository $news,
        \App\Repositories\PageRepository $page,
        \App\Repositories\PaymentRepository $payment,
        \App\Repositories\ProductRepository $product,
        \App\Repositories\ServerRepository $server,
        \App\Repositories\UserRepository $user,
        \Cartalyst\Sentinel\Sentinel $sentinel
    )
    {
        // Truncate storage data.
        $ban->truncate();
        $cart->truncate();
        $category->truncate();
        $item->truncate();
        $news->truncate();
        $page->truncate();
        $payment->truncate();
        $product->truncate();
        $server->truncate();
        $user->truncate();
        $sentinel->getRoleRepository()->createModel()->truncate();
        DB::table('settings')->truncate();
        DB::table('activations')->truncate();
        DB::table('bans')->truncate();
        DB::table('persistences')->truncate();
        DB::table('reminders')->truncate();
        DB::table('throttle')->truncate();
        DB::table('role_users')->truncate();
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(SettingsSeeder::class);
        $this->call(UsersSeeder::class);
        $this->call(NewsSeeder::class);
        $this->call(PagesSeeder::class);
        $this->call(ServersSeeder::class);
        $this->call(ItemsAndProductsSeeder::class);
    }
}
