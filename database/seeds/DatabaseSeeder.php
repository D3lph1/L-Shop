<?php
declare(strict_types = 1);

use Illuminate\Database\Seeder;

/**
 * Class DatabaseSeeder
 *
 * @author D3lph1 <d3lph1.contact@gmail.com>
 */
class DatabaseSeeder extends Seeder
{
    public function __construct(
        \App\Repositories\Ban\BanRepositoryInterface $ban,
        \App\Repositories\Cart\CartRepositoryInterface $cart,
        \App\Repositories\Category\CategoryRepositoryInterface $category,
        \App\Repositories\Item\ItemRepositoryInterface $item,
        \App\Repositories\News\NewsRepositoryInterface $news,
        \App\Repositories\Page\PageRepositoryInterface $page,
        \App\Repositories\Payment\PaymentRepositoryInterface $payment,
        \App\Repositories\Product\ProductRepositoryInterface $product,
        \App\Repositories\Server\ServerRepositoryInterface $server,
        \App\Repositories\Persistence\PersistenceRepositoryInterface $persistence,
        \Cartalyst\Sentinel\Sentinel $sentinel,
        \Illuminate\Cache\CacheManager $cache
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
        $persistence->truncate();

        /** @var \App\Repositories\User\UserRepositoryInterface $userRepository */
        $userRepository = $sentinel->getUserRepository();
        $userRepository->truncate();

        /** @var \App\Repositories\Role\RoleRepositoryInterface $roleRepository */
        $roleRepository = $sentinel->getRoleRepository();
        $roleRepository->truncate();

        DB::table('settings')->truncate();
        DB::table('activations')->truncate();
        DB::table('reminders')->truncate();
        DB::table('throttle')->truncate();
        DB::table('role_users')->truncate();

        $cache->flush();
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call(SettingsSeeder::class);
        $this->call(UsersSeeder::class);
        $this->call(NewsSeeder::class);
        $this->call(PagesSeeder::class);
        $this->call(ServersSeeder::class);
        $this->call(ItemsAndProductsSeeder::class);
        $this->call(PaymentsSeeder::class);
    }
}
