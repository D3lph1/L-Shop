<?php
declare(strict_types = 1);

namespace App\Providers;

use App\Entity\Activation;
use App\Entity\BalanceTransaction;
use App\Entity\Ban;
use App\Entity\Category;
use App\Entity\Distribution;
use App\Entity\Enchantment;
use App\Entity\Item;
use App\Entity\News;
use App\Entity\Page;
use App\Entity\Permission;
use App\Entity\Persistence;
use App\Entity\Product;
use App\Entity\Purchase;
use App\Entity\PurchaseItem;
use App\Entity\Reminder;
use App\Entity\Role;
use App\Entity\Server;
use App\Entity\ShoppingCart;
use App\Entity\User;
use App\Repository\Activation\ActivationRepository;
use App\Repository\Activation\DoctrineActivationRepository;
use App\Repository\BalanceTransaction\BalanceTransactionRepository;
use App\Repository\BalanceTransaction\DoctrineBalanceTransactionRepository;
use App\Repository\Ban\BanRepository;
use App\Repository\Ban\DoctrineBanRepository;
use App\Repository\Category\CategoryRepository;
use App\Repository\Category\DoctrineCategoryRepository;
use App\Repository\Distribution\DistributionRepository;
use App\Repository\Distribution\DoctrineDistributionRepository;
use App\Repository\Enchantment\DoctrineEnchantmentRepository;
use App\Repository\Enchantment\EnchantmentRepository;
use App\Repository\Item\DoctrineItemRepository;
use App\Repository\Item\ItemRepository;
use App\Repository\News\DoctrineNewsRepository;
use App\Repository\News\NewsRepository;
use App\Repository\Page\DoctrinePageRepository;
use App\Repository\Page\PageRepository;
use App\Repository\Permission\DoctrinePermissionRepository;
use App\Repository\Permission\PermissionRepository;
use App\Repository\Persistence\DoctrinePersistenceRepository;
use App\Repository\Persistence\PersistenceRepository;
use App\Repository\Product\DoctrineProductRepository;
use App\Repository\Product\ProductRepository;
use App\Repository\Purchase\DoctrinePurchaseRepository;
use App\Repository\Purchase\PurchaseRepository;
use App\Repository\PurchaseItem\DoctrinePurchaseItemRepository;
use App\Repository\PurchaseItem\PurchaseItemRepository;
use App\Repository\Reminder\DoctrineReminderRepository;
use App\Repository\Reminder\ReminderRepository;
use App\Repository\Role\DoctrineRoleRepository;
use App\Repository\Role\RoleRepository;
use App\Repository\Server\DoctrineServerRepository;
use App\Repository\Server\ServerRepository;
use App\Repository\ShoppingCart\DoctrineShoppingCartRepository;
use App\Repository\ShoppingCart\ShoppingCartRepository;
use App\Repository\User\DoctrineUserRepository;
use App\Repository\User\UserRepository;
use App\Services\Caching\CachingOptions;
use App\Services\Game\Permissions\LuckPerms\Entity\Group;
use App\Services\Game\Permissions\LuckPerms\Entity\GroupPermission;
use App\Services\Game\Permissions\LuckPerms\Entity\Player;
use App\Services\Game\Permissions\LuckPerms\Entity\PlayerPermission;
use App\Services\Game\Permissions\LuckPerms\Repository\Group\DoctrineGroupRepository;
use App\Services\Game\Permissions\LuckPerms\Repository\Group\GroupRepository;
use App\Services\Game\Permissions\LuckPerms\Repository\GroupPermission\DoctrineGroupPermissionRepository;
use App\Services\Game\Permissions\LuckPerms\Repository\GroupPermission\GroupPermissionRepository;
use App\Services\Game\Permissions\LuckPerms\Repository\Player\DoctrinePlayerRepository;
use App\Services\Game\Permissions\LuckPerms\Repository\Player\PlayerRepository;
use App\Services\Game\Permissions\LuckPerms\Repository\PlayerPermission\DoctrinePlayerPermissionRepository;
use App\Services\Game\Permissions\LuckPerms\Repository\PlayerPermission\PlayerPermissionRepository;
use App\Services\Settings\Repository\Doctrine\DoctrineRepository;
use App\Services\Settings\Repository\Repository;
use App\Services\Settings\Setting;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\ClassMetadata;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $config = $this->app->make(\Illuminate\Contracts\Config\Repository::class);

        $repositories = [
            UserRepository::class => [
                'concrete' => DoctrineUserRepository::class,
                'entity' => User::class,
                'caching' => [
                    'enabled' => $config->get('cache.options.users.enabled'),
                    'lifetime' => $config->get('cache.options.users.lifetime')
                ]
            ],
            RoleRepository::class => [
                'concrete' => DoctrineRoleRepository::class,
                'entity' => Role::class,
                'caching' => [
                    'enabled' => $config->get('cache.options.roles.enabled'),
                    'lifetime' => $config->get('cache.options.roles.lifetime')
                ]
            ],
            PermissionRepository::class => [
                'concrete' => DoctrinePermissionRepository::class,
                'entity' => Permission::class,
                'caching' => [
                    'enabled' => $config->get('cache.options.permissions.enabled'),
                    'lifetime' => $config->get('cache.options.permissions.lifetime')
                ]
            ],
            PersistenceRepository::class => [
                'concrete' => DoctrinePersistenceRepository::class,
                'entity' => Persistence::class
            ],
            ActivationRepository::class => [
                'concrete' => DoctrineActivationRepository::class,
                'entity' => Activation::class
            ],
            BanRepository::class => [
                'concrete' => DoctrineBanRepository::class,
                'entity' => Ban::class
            ],
            ReminderRepository::class => [
                'concrete' => DoctrineReminderRepository::class,
                'entity' => Reminder::class
            ],
            ServerRepository::class => [
                'concrete' => DoctrineServerRepository::class,
                'entity' => Server::class,
                'caching' => [
                    'enabled' => $config->get('cache.options.servers.enabled'),
                    'lifetime' => $config->get('cache.options.servers.lifetime')
                ]
            ],
            CategoryRepository::class => [
                'concrete' => DoctrineCategoryRepository::class,
                'entity' => Category::class,
                'caching' => [
                    'enabled' => $config->get('cache.options.categories.enabled'),
                    'lifetime' => $config->get('cache.options.categories.lifetime')
                ]
            ],
            ItemRepository::class => [
                'concrete' => DoctrineItemRepository::class,
                'entity' => Item::class,
                'caching' => [
                    'enabled' => $config->get('cache.options.items.enabled'),
                    'lifetime' => $config->get('cache.options.items.lifetime')
                ]
            ],
            ProductRepository::class => [
                'concrete' => DoctrineProductRepository::class,
                'entity' => Product::class,
                'caching' => [
                    'enabled' => $config->get('cache.options.products.enabled'),
                    'lifetime' => $config->get('cache.options.products.lifetime')
                ]
            ],
            NewsRepository::class => [
                'concrete' => DoctrineNewsRepository::class,
                'entity' => News::class
            ],
            PageRepository::class => [
                'concrete' => DoctrinePageRepository::class,
                'entity' => Page::class,
                'caching' => [
                    'enabled' => $config->get('cache.options.pages.enabled'),
                    'lifetime' => $config->get('cache.options.pages.lifetime')
                ]
            ],
            EnchantmentRepository::class => [
                'concrete' => DoctrineEnchantmentRepository::class,
                'entity' => Enchantment::class
            ],
            PurchaseRepository::class => [
                'concrete' => DoctrinePurchaseRepository::class,
                'entity' => Purchase::class
            ],
            PurchaseItemRepository::class => [
                'concrete' => DoctrinePurchaseItemRepository::class,
                'entity' => PurchaseItem::class
            ],
            BalanceTransactionRepository::class => [
                'concrete' => DoctrineBalanceTransactionRepository::class,
                'entity' => BalanceTransaction::class
            ],
            DistributionRepository::class => [
                'concrete' => DoctrineDistributionRepository::class,
                'entity' => Distribution::class
            ],
            ShoppingCartRepository::class => [
                'concrete' => DoctrineShoppingCartRepository::class,
                'entity' => ShoppingCart::class
            ],
            Repository::class => [
                'concrete' => DoctrineRepository::class,
                'entity' => Setting::class,
                'caching' => [
                    'enabled' => $config->get('cache.options.settings.enabled'),
                    'lifetime' => $config->get('cache.options.settings.lifetime')
                ]
            ],
            GroupRepository::class => [
                'concrete' => DoctrineGroupRepository::class,
                'entity' => Group::class
            ],
            PlayerRepository::class => [
                'concrete' => DoctrinePlayerRepository::class,
                'entity' => Player::class
            ],
            GroupPermissionRepository::class => [
                'concrete' => DoctrineGroupPermissionRepository::class,
                'entity' => GroupPermission::class
            ],
            PlayerPermissionRepository::class => [
                'concrete' => DoctrinePlayerPermissionRepository::class,
                'entity' => PlayerPermission::class
            ],
        ];

        foreach ($repositories as $key => $value) {
            $this->app->when($value['concrete'])
                ->needs(EntityRepository::class)
                ->give(function () use ($value) {
                    return $this->buildEntityRepository($value['entity']);
                });
            if (isset($value['caching'])) {
                $enabled = $value['caching']['enabled'];
                $lifetime = $value['caching']['lifetime'];

                $this->app->when($value['concrete'])
                    ->needs(CachingOptions::class)
                    ->give(function () use ($enabled, $lifetime) {
                        return (new CachingOptions($enabled))
                            ->setLifetime($lifetime);
                    });
            }
            $this->app->singleton($key, $value['concrete']);
        }
    }

    private function buildEntityRepository(string $entity)
    {
        return new EntityRepository(
            $this->app->make(EntityManagerInterface::class),
            new ClassMetadata($entity)
        );
    }
}
