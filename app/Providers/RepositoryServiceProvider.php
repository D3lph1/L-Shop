<?php
declare(strict_types = 1);

namespace App\Providers;

use App\Models\Ban\BanInterface;
use App\Models\Ban\EloquentBan;
use App\Models\Cart\CartInterface;
use App\Models\Cart\EloquentCart;
use App\Models\Category\CategoryInterface;
use App\Models\Category\EloquentCategory;
use App\Models\Item\EloquentItem;
use App\Models\Item\ItemInterface;
use App\Models\News\EloquentNews;
use App\Models\News\NewsInterface;
use App\Models\Page\EloquentPage;
use App\Models\Page\PageInterface;
use App\Models\Payment\EloquentPayment;
use App\Models\Payment\PaymentInterface;
use App\Models\Product\EloquentProduct;
use App\Models\Product\ProductInterface;
use App\Models\Role\EloquentRole;
use App\Models\Server\EloquentServer;
use App\Models\Server\ServerInterface;
use App\Models\User\EloquentUser;
use App\Models\User\UserInterface;
use App\Repositories\Activation\ActivationRepositoryInterface;
use App\Repositories\Activation\EloquentActivationRepository;
use App\Repositories\Ban\BanRepositoryInterface;
use App\Repositories\Ban\EloquentBanRepository;
use App\Repositories\Cart\CartRepositoryInterface;
use App\Repositories\Cart\EloquentCartRepository;
use App\Repositories\Category\CategoryRepositoryInterface;
use App\Repositories\Category\EloquentCategoryRepository;
use App\Repositories\Item\EloquentItemRepository;
use App\Repositories\Item\ItemRepositoryInterface;
use App\Repositories\News\EloquentNewsRepository;
use App\Repositories\News\NewsRepositoryInterface;
use App\Repositories\Page\EloquentPageRepository;
use App\Repositories\Page\PageRepositoryInterface;
use App\Repositories\Payment\EloquentPaymentRepository;
use App\Repositories\Payment\PaymentRepositoryInterface;
use App\Repositories\Persistence\EloquentPersistenceRepository;
use App\Repositories\Persistence\PersistenceRepositoryInterface;
use App\Repositories\Product\EloquentProductRepository;
use App\Repositories\Product\ProductRepositoryInterface;
use App\Repositories\Reminder\EloquentReminderRepository;
use App\Repositories\Reminder\ReminderRepositoryInterface;
use App\Repositories\Role\EloquentRoleRepository;
use App\Repositories\Role\RoleRepositoryInterface;
use App\Repositories\Server\EloquentServerRepository;
use App\Repositories\Server\ServerRepositoryInterface;
use App\Repositories\User\EloquentUserRepository;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Contracts\Container\Container;
use Illuminate\Support\ServiceProvider;

/**
 * Class RepositoryServiceProvider
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 * @package App\Providers
 */
class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(UserInterface::class, EloquentUser::class);
        $this->app->bind(BanInterface::class, EloquentBan::class);
        $this->app->bind(CartInterface::class, EloquentCart::class);
        $this->app->bind(ServerInterface::class, EloquentServer::class);
        $this->app->bind(CategoryInterface::class, EloquentCategory::class);
        $this->app->bind(ItemInterface::class, EloquentItem::class);
        $this->app->bind(NewsInterface::class, EloquentNews::class);
        $this->app->bind(PageInterface::class, EloquentPage::class);
        $this->app->bind(PaymentInterface::class, EloquentPayment::class);
        $this->app->bind(ProductInterface::class, EloquentProduct::class);

        $this->app->singleton(BanRepositoryInterface::class, EloquentBanRepository::class);
        $this->app->singleton(PageRepositoryInterface::class, EloquentPageRepository::class);
        $this->app->singleton(NewsRepositoryInterface::class, EloquentNewsRepository::class);
        $this->app->singleton(ServerRepositoryInterface::class, EloquentServerRepository::class);
        $this->app->singleton(CategoryRepositoryInterface::class, EloquentCategoryRepository::class);
        $this->app->singleton(CartRepositoryInterface::class, EloquentCartRepository::class);
        $this->app->singleton(ItemRepositoryInterface::class, EloquentItemRepository::class);
        $this->app->singleton(UserRepositoryInterface::class, function ($app) {
            /** @var Container $app */
            return $app->make(EloquentUserRepository::class, ['model' => EloquentUser::class]);
        });
        $this->app->singleton(PaymentRepositoryInterface::class, EloquentPaymentRepository::class);
        $this->app->singleton(ProductRepositoryInterface::class, EloquentProductRepository::class);
        $this->app->singleton(RoleRepositoryInterface::class, function ($app) {
            /** @var Container $app */
            return $app->make(EloquentRoleRepository::class, ['model' => EloquentRole::class]);
        });
        $this->app->singleton(ActivationRepositoryInterface::class, EloquentActivationRepository::class);
        $this->app->singleton(PersistenceRepositoryInterface::class, EloquentPersistenceRepository::class);
        $this->app->singleton(ReminderRepositoryInterface::class, EloquentReminderRepository::class);
    }
}
