<?php
declare(strict_types = 1);

namespace App\Providers;

use App\Entity\Activation;
use App\Entity\Category;
use App\Entity\Enchantment;
use App\Entity\Item;
use App\Entity\News;
use App\Entity\Page;
use App\Entity\Permission;
use App\Entity\Persistence;
use App\Entity\Product;
use App\Entity\Reminder;
use App\Entity\Role;
use App\Entity\Server;
use App\Entity\User;
use App\Repository\Activation\ActivationRepository;
use App\Repository\Activation\DoctrineActivationRepository;
use App\Repository\Category\CategoryRepository;
use App\Repository\Category\DoctrineCategoryRepository;
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
use App\Repository\Reminder\DoctrineReminderRepository;
use App\Repository\Reminder\ReminderRepository;
use App\Repository\Role\DoctrineRoleRepository;
use App\Repository\Role\RoleRepository;
use App\Repository\Server\DoctrineServerRepository;
use App\Repository\Server\ServerRepository;
use App\Repository\User\DoctrineUserRepository;
use App\Repository\User\UserRepository;
use App\Services\Settings\Repository\Doctrine\DoctrineRepository;
use App\Services\Settings\Repository\Repository;
use App\Services\Settings\Setting;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\ClassMetadata;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    private $repositories = [
        UserRepository::class => [
            'concrete' => DoctrineUserRepository::class,
            'entity' => User::class
        ],
        RoleRepository::class => [
            'concrete' => DoctrineRoleRepository::class,
            'entity' => Role::class
        ],
        PermissionRepository::class => [
            'concrete' => DoctrinePermissionRepository::class,
            'entity' => Permission::class
        ],
        PersistenceRepository::class => [
            'concrete' => DoctrinePersistenceRepository::class,
            'entity' => Persistence::class
        ],
        ActivationRepository::class => [
            'concrete' => DoctrineActivationRepository::class,
            'entity' => Activation::class
        ],
        ReminderRepository::class => [
            'concrete' => DoctrineReminderRepository::class,
            'entity' => Reminder::class
        ],
        ServerRepository::class => [
            'concrete' => DoctrineServerRepository::class,
            'entity' => Server::class
        ],
        CategoryRepository::class => [
            'concrete' => DoctrineCategoryRepository::class,
            'entity' => Category::class
        ],
        ItemRepository::class => [
            'concrete' => DoctrineItemRepository::class,
            'entity' => Item::class
        ],
        ProductRepository::class => [
            'concrete' => DoctrineProductRepository::class,
            'entity' => Product::class
        ],
        NewsRepository::class => [
            'concrete' => DoctrineNewsRepository::class,
            'entity' => News::class
        ],
        PageRepository::class => [
            'concrete' => DoctrinePageRepository::class,
            'entity' => Page::class
        ],
        EnchantmentRepository::class => [
            'concrete' => DoctrineEnchantmentRepository::class,
            'entity' => Enchantment::class
        ],
        Repository::class => [
            'concrete' => DoctrineRepository::class,
            'entity' => Setting::class
        ]
    ];

    public function boot(): void
    {
        foreach ($this->repositories as $key => $value) {
            $this->app->when($value['concrete'])
                ->needs(EntityRepository::class)
                ->give(function () use ($value) {
                    return $this->buildEntityRepository($value['entity']);
                });
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
