<?php
/**
 * A helper file for Laravel 5, to provide autocomplete information to your IDE
 * Generated for Laravel 5.5.36 on 2018-05-09.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 * @see https://github.com/barryvdh/laravel-ide-helper
 */
namespace  {
    exit("This file should not be included, only analyzed by your IDE");
}

namespace Intervention\Image\Facades { 

    class Image {
        
        /**
         * Overrides configuration settings
         *
         * @param array $config
         * @static 
         */ 
        public static function configure($config = array())
        {
            return \Intervention\Image\ImageManager::configure($config);
        }
        
        /**
         * Initiates an Image instance from different input types
         *
         * @param mixed $data
         * @return \Intervention\Image\Image 
         * @static 
         */ 
        public static function make($data)
        {
            return \Intervention\Image\ImageManager::make($data);
        }
        
        /**
         * Creates an empty image canvas
         *
         * @param integer $width
         * @param integer $height
         * @param mixed $background
         * @return \Intervention\Image\Image 
         * @static 
         */ 
        public static function canvas($width, $height, $background = null)
        {
            return \Intervention\Image\ImageManager::canvas($width, $height, $background);
        }
        
        /**
         * Create new cached image and run callback
         * (requires additional package intervention/imagecache)
         *
         * @param \Closure $callback
         * @param integer $lifetime
         * @param boolean $returnObj
         * @return \Image 
         * @static 
         */ 
        public static function cache($callback, $lifetime = null, $returnObj = false)
        {
            return \Intervention\Image\ImageManager::cache($callback, $lifetime, $returnObj);
        }
         
    }
 
}

namespace LaravelDoctrine\ORM\Facades { 

    class Registry {
        
        /**
         * 
         *
         * @param $manager
         * @param array $settings
         * @static 
         */ 
        public static function addManager($manager, $settings = array())
        {
            return \LaravelDoctrine\ORM\IlluminateRegistry::addManager($manager, $settings);
        }
        
        /**
         * 
         *
         * @param $connection
         * @param array $settings
         * @static 
         */ 
        public static function addConnection($connection, $settings = array())
        {
            return \LaravelDoctrine\ORM\IlluminateRegistry::addConnection($connection, $settings);
        }
        
        /**
         * Gets the default connection name.
         *
         * @return string The default connection name.
         * @static 
         */ 
        public static function getDefaultConnectionName()
        {
            return \LaravelDoctrine\ORM\IlluminateRegistry::getDefaultConnectionName();
        }
        
        /**
         * Gets the named connection.
         *
         * @param string $name The connection name (null for the default one).
         * @return object 
         * @static 
         */ 
        public static function getConnection($name = null)
        {
            return \LaravelDoctrine\ORM\IlluminateRegistry::getConnection($name);
        }
        
        /**
         * 
         *
         * @param string $name
         * @return bool 
         * @static 
         */ 
        public static function connectionExists($name)
        {
            return \LaravelDoctrine\ORM\IlluminateRegistry::connectionExists($name);
        }
        
        /**
         * Gets an array of all registered connections.
         *
         * @return array An array of Connection instances.
         * @static 
         */ 
        public static function getConnections()
        {
            return \LaravelDoctrine\ORM\IlluminateRegistry::getConnections();
        }
        
        /**
         * Gets all connection names.
         *
         * @return array An array of connection names.
         * @static 
         */ 
        public static function getConnectionNames()
        {
            return \LaravelDoctrine\ORM\IlluminateRegistry::getConnectionNames();
        }
        
        /**
         * Gets the default object manager name.
         *
         * @return string The default object manager name.
         * @static 
         */ 
        public static function getDefaultManagerName()
        {
            return \LaravelDoctrine\ORM\IlluminateRegistry::getDefaultManagerName();
        }
        
        /**
         * Gets a named object manager.
         *
         * @param string $name The object manager name (null for the default one).
         * @return \Doctrine\Common\Persistence\ObjectManager 
         * @static 
         */ 
        public static function getManager($name = null)
        {
            return \LaravelDoctrine\ORM\IlluminateRegistry::getManager($name);
        }
        
        /**
         * 
         *
         * @param string $name
         * @return bool 
         * @static 
         */ 
        public static function managerExists($name)
        {
            return \LaravelDoctrine\ORM\IlluminateRegistry::managerExists($name);
        }
        
        /**
         * Gets all connection names.
         *
         * @return array An array of connection names.
         * @static 
         */ 
        public static function getManagerNames()
        {
            return \LaravelDoctrine\ORM\IlluminateRegistry::getManagerNames();
        }
        
        /**
         * Gets an array of all registered object managers.
         *
         * @return \Doctrine\Common\Persistence\ObjectManager[] An array of ObjectManager instances
         * @static 
         */ 
        public static function getManagers()
        {
            return \LaravelDoctrine\ORM\IlluminateRegistry::getManagers();
        }
        
        /**
         * Resets a named object manager.
         * 
         * This method is useful when an object manager has been closed
         * because of a rollbacked transaction AND when you think that
         * it makes sense to get a new one to replace the closed one.
         * Be warned that you will get a brand new object manager as
         * the existing one is not useable anymore. This means that any
         * other object with a dependency on this object manager will
         * hold an obsolete reference. You can inject the registry instead
         * to avoid this problem.
         *
         * @param string|null $name The object manager name (null for the default one).
         * @return \Doctrine\Common\Persistence\ObjectManager 
         * @static 
         */ 
        public static function resetManager($name = null)
        {
            return \LaravelDoctrine\ORM\IlluminateRegistry::resetManager($name);
        }
        
        /**
         * Resolves a registered namespace alias to the full namespace.
         * 
         * This method looks for the alias in all registered object managers.
         *
         * @param string $alias The alias.
         * @throws ORMException
         * @return string The full namespace.
         * @static 
         */ 
        public static function getAliasNamespace($alias)
        {
            return \LaravelDoctrine\ORM\IlluminateRegistry::getAliasNamespace($alias);
        }
        
        /**
         * Gets the ObjectRepository for an persistent object.
         *
         * @param string $persistentObject The name of the persistent object.
         * @param string $persistentManagerName The object manager name (null for the default one).
         * @return \Doctrine\Common\Persistence\ObjectRepository 
         * @static 
         */ 
        public static function getRepository($persistentObject, $persistentManagerName = null)
        {
            return \LaravelDoctrine\ORM\IlluminateRegistry::getRepository($persistentObject, $persistentManagerName);
        }
        
        /**
         * Gets the object manager associated with a given class.
         *
         * @param string $class A persistent object class name.
         * @return \Doctrine\Common\Persistence\ObjectManager|null 
         * @static 
         */ 
        public static function getManagerForClass($class)
        {
            return \LaravelDoctrine\ORM\IlluminateRegistry::getManagerForClass($class);
        }
        
        /**
         * 
         *
         * @param string $defaultManager
         * @static 
         */ 
        public static function setDefaultManager($defaultManager)
        {
            return \LaravelDoctrine\ORM\IlluminateRegistry::setDefaultManager($defaultManager);
        }
        
        /**
         * 
         *
         * @param string $defaultConnection
         * @static 
         */ 
        public static function setDefaultConnection($defaultConnection)
        {
            return \LaravelDoctrine\ORM\IlluminateRegistry::setDefaultConnection($defaultConnection);
        }
         
    }

    class Doctrine {
        
        /**
         * 
         *
         * @return string 
         * @static 
         */ 
        public static function getDefaultManagerName()
        {
            return \LaravelDoctrine\ORM\DoctrineManager::getDefaultManagerName();
        }
        
        /**
         * 
         *
         * @param $callback
         * @static 
         */ 
        public static function onResolve($callback)
        {
            return \LaravelDoctrine\ORM\DoctrineManager::onResolve($callback);
        }
        
        /**
         * 
         *
         * @param string|null $connection
         * @param string|callable $callback
         * @static 
         */ 
        public static function extend($connection, $callback)
        {
            return \LaravelDoctrine\ORM\DoctrineManager::extend($connection, $callback);
        }
        
        /**
         * 
         *
         * @param string|callable $callback
         * @static 
         */ 
        public static function extendAll($callback)
        {
            return \LaravelDoctrine\ORM\DoctrineManager::extendAll($callback);
        }
        
        /**
         * 
         *
         * @param $namespace
         * @param string|null $connection
         * @static 
         */ 
        public static function addNamespace($namespace, $connection = null)
        {
            return \LaravelDoctrine\ORM\DoctrineManager::addNamespace($namespace, $connection);
        }
        
        /**
         * 
         *
         * @param array $paths
         * @param string|null $connection
         * @static 
         */ 
        public static function addPaths($paths = array(), $connection = null)
        {
            return \LaravelDoctrine\ORM\DoctrineManager::addPaths($paths, $connection);
        }
        
        /**
         * 
         *
         * @param array $mappings
         * @param string|null $connection
         * @static 
         */ 
        public static function addMappings($mappings = array(), $connection = null)
        {
            return \LaravelDoctrine\ORM\DoctrineManager::addMappings($mappings, $connection);
        }
        
        /**
         * 
         *
         * @param null $connection
         * @param \LaravelDoctrine\ORM\ManagerRegistry $registry
         * @return \LaravelDoctrine\ORM\MappingDriver 
         * @static 
         */ 
        public static function getMetaDataDriver($connection, $registry)
        {
            return \LaravelDoctrine\ORM\DoctrineManager::getMetaDataDriver($connection, $registry);
        }
         
    }

    class EntityManager {
        
        /**
         * {@inheritDoc}
         *
         * @static 
         */ 
        public static function getConnection()
        {
            return \Doctrine\ORM\EntityManager::getConnection();
        }
        
        /**
         * Gets the metadata factory used to gather the metadata of classes.
         *
         * @return \Doctrine\ORM\Mapping\ClassMetadataFactory 
         * @static 
         */ 
        public static function getMetadataFactory()
        {
            return \Doctrine\ORM\EntityManager::getMetadataFactory();
        }
        
        /**
         * {@inheritDoc}
         *
         * @static 
         */ 
        public static function getExpressionBuilder()
        {
            return \Doctrine\ORM\EntityManager::getExpressionBuilder();
        }
        
        /**
         * {@inheritDoc}
         *
         * @static 
         */ 
        public static function beginTransaction()
        {
            return \Doctrine\ORM\EntityManager::beginTransaction();
        }
        
        /**
         * {@inheritDoc}
         *
         * @static 
         */ 
        public static function getCache()
        {
            return \Doctrine\ORM\EntityManager::getCache();
        }
        
        /**
         * {@inheritDoc}
         *
         * @static 
         */ 
        public static function transactional($func)
        {
            return \Doctrine\ORM\EntityManager::transactional($func);
        }
        
        /**
         * {@inheritDoc}
         *
         * @static 
         */ 
        public static function commit()
        {
            return \Doctrine\ORM\EntityManager::commit();
        }
        
        /**
         * {@inheritDoc}
         *
         * @static 
         */ 
        public static function rollback()
        {
            return \Doctrine\ORM\EntityManager::rollback();
        }
        
        /**
         * Returns the ORM metadata descriptor for a class.
         * 
         * The class name must be the fully-qualified class name without a leading backslash
         * (as it is returned by get_class($obj)) or an aliased class name.
         * 
         * Examples:
         * MyProject\Domain\User
         * sales:PriceRequest
         * 
         * Internal note: Performance-sensitive method.
         *
         * @param string $className
         * @return \Doctrine\ORM\Mapping\ClassMetadata 
         * @static 
         */ 
        public static function getClassMetadata($className)
        {
            return \Doctrine\ORM\EntityManager::getClassMetadata($className);
        }
        
        /**
         * {@inheritDoc}
         *
         * @static 
         */ 
        public static function createQuery($dql = '')
        {
            return \Doctrine\ORM\EntityManager::createQuery($dql);
        }
        
        /**
         * {@inheritDoc}
         *
         * @static 
         */ 
        public static function createNamedQuery($name)
        {
            return \Doctrine\ORM\EntityManager::createNamedQuery($name);
        }
        
        /**
         * {@inheritDoc}
         *
         * @static 
         */ 
        public static function createNativeQuery($sql, $rsm)
        {
            return \Doctrine\ORM\EntityManager::createNativeQuery($sql, $rsm);
        }
        
        /**
         * {@inheritDoc}
         *
         * @static 
         */ 
        public static function createNamedNativeQuery($name)
        {
            return \Doctrine\ORM\EntityManager::createNamedNativeQuery($name);
        }
        
        /**
         * {@inheritDoc}
         *
         * @static 
         */ 
        public static function createQueryBuilder()
        {
            return \Doctrine\ORM\EntityManager::createQueryBuilder();
        }
        
        /**
         * Flushes all changes to objects that have been queued up to now to the database.
         * 
         * This effectively synchronizes the in-memory state of managed objects with the
         * database.
         * 
         * If an entity is explicitly passed to this method only this entity and
         * the cascade-persist semantics + scheduled inserts/removals are synchronized.
         *
         * @param null|object|array $entity
         * @return void 
         * @throws \Doctrine\ORM\OptimisticLockException If a version check on an entity that
         *         makes use of optimistic locking fails.
         * @static 
         */ 
        public static function flush($entity = null)
        {
            \Doctrine\ORM\EntityManager::flush($entity);
        }
        
        /**
         * Finds an Entity by its identifier.
         *
         * @param string $entityName The class name of the entity to find.
         * @param mixed $id The identity of the entity to find.
         * @param integer|null $lockMode One of the \Doctrine\DBAL\LockMode::* constants
         *                                  or NULL if no specific lock mode should be used
         *                                  during the search.
         * @param integer|null $lockVersion The version of the entity to find when using
         *                                  optimistic locking.
         * @return object|null The entity instance or NULL if the entity can not be found.
         * @throws OptimisticLockException
         * @throws ORMInvalidArgumentException
         * @throws TransactionRequiredException
         * @throws ORMException
         * @static 
         */ 
        public static function find($entityName, $id, $lockMode = null, $lockVersion = null)
        {
            return \Doctrine\ORM\EntityManager::find($entityName, $id, $lockMode, $lockVersion);
        }
        
        /**
         * {@inheritDoc}
         *
         * @static 
         */ 
        public static function getReference($entityName, $id)
        {
            return \Doctrine\ORM\EntityManager::getReference($entityName, $id);
        }
        
        /**
         * {@inheritDoc}
         *
         * @static 
         */ 
        public static function getPartialReference($entityName, $identifier)
        {
            return \Doctrine\ORM\EntityManager::getPartialReference($entityName, $identifier);
        }
        
        /**
         * Clears the EntityManager. All entities that are currently managed
         * by this EntityManager become detached.
         *
         * @param string|null $entityName if given, only entities of this type will get detached
         * @return void 
         * @static 
         */ 
        public static function clear($entityName = null)
        {
            \Doctrine\ORM\EntityManager::clear($entityName);
        }
        
        /**
         * {@inheritDoc}
         *
         * @static 
         */ 
        public static function close()
        {
            return \Doctrine\ORM\EntityManager::close();
        }
        
        /**
         * Tells the EntityManager to make an instance managed and persistent.
         * 
         * The entity will be entered into the database at or before transaction
         * commit or as a result of the flush operation.
         * 
         * NOTE: The persist operation always considers entities that are not yet known to
         * this EntityManager as NEW. Do not pass detached entities to the persist operation.
         *
         * @param object $entity The instance to make managed and persistent.
         * @return void 
         * @throws ORMInvalidArgumentException
         * @static 
         */ 
        public static function persist($entity)
        {
            \Doctrine\ORM\EntityManager::persist($entity);
        }
        
        /**
         * Removes an entity instance.
         * 
         * A removed entity will be removed from the database at or before transaction commit
         * or as a result of the flush operation.
         *
         * @param object $entity The entity instance to remove.
         * @return void 
         * @throws ORMInvalidArgumentException
         * @static 
         */ 
        public static function remove($entity)
        {
            \Doctrine\ORM\EntityManager::remove($entity);
        }
        
        /**
         * Refreshes the persistent state of an entity from the database,
         * overriding any local changes that have not yet been persisted.
         *
         * @param object $entity The entity to refresh.
         * @return void 
         * @throws ORMInvalidArgumentException
         * @static 
         */ 
        public static function refresh($entity)
        {
            \Doctrine\ORM\EntityManager::refresh($entity);
        }
        
        /**
         * Detaches an entity from the EntityManager, causing a managed entity to
         * become detached.  Unflushed changes made to the entity if any
         * (including removal of the entity), will not be synchronized to the database.
         * 
         * Entities which previously referenced the detached entity will continue to
         * reference it.
         *
         * @param object $entity The entity to detach.
         * @return void 
         * @throws ORMInvalidArgumentException
         * @static 
         */ 
        public static function detach($entity)
        {
            \Doctrine\ORM\EntityManager::detach($entity);
        }
        
        /**
         * Merges the state of a detached entity into the persistence context
         * of this EntityManager and returns the managed copy of the entity.
         * 
         * The entity passed to merge will not become associated/managed with this EntityManager.
         *
         * @param object $entity The detached entity to merge into the persistence context.
         * @return object The managed copy of the entity.
         * @throws ORMInvalidArgumentException
         * @static 
         */ 
        public static function merge($entity)
        {
            return \Doctrine\ORM\EntityManager::merge($entity);
        }
        
        /**
         * {@inheritDoc}
         *
         * @todo Implementation need. This is necessary since $e2 = clone $e1; throws an E_FATAL when access anything on $e:
         * Fatal error: Maximum function nesting level of '100' reached, aborting!
         * @static 
         */ 
        public static function copy($entity, $deep = false)
        {
            return \Doctrine\ORM\EntityManager::copy($entity, $deep);
        }
        
        /**
         * {@inheritDoc}
         *
         * @static 
         */ 
        public static function lock($entity, $lockMode, $lockVersion = null)
        {
            return \Doctrine\ORM\EntityManager::lock($entity, $lockMode, $lockVersion);
        }
        
        /**
         * Gets the repository for an entity class.
         *
         * @param string $entityName The name of the entity.
         * @return \Doctrine\ORM\EntityRepository The repository class.
         * @static 
         */ 
        public static function getRepository($entityName)
        {
            return \Doctrine\ORM\EntityManager::getRepository($entityName);
        }
        
        /**
         * Determines whether an entity instance is managed in this EntityManager.
         *
         * @param object $entity
         * @return boolean TRUE if this EntityManager currently manages the given entity, FALSE otherwise.
         * @static 
         */ 
        public static function contains($entity)
        {
            return \Doctrine\ORM\EntityManager::contains($entity);
        }
        
        /**
         * {@inheritDoc}
         *
         * @static 
         */ 
        public static function getEventManager()
        {
            return \Doctrine\ORM\EntityManager::getEventManager();
        }
        
        /**
         * {@inheritDoc}
         *
         * @static 
         */ 
        public static function getConfiguration()
        {
            return \Doctrine\ORM\EntityManager::getConfiguration();
        }
        
        /**
         * {@inheritDoc}
         *
         * @static 
         */ 
        public static function isOpen()
        {
            return \Doctrine\ORM\EntityManager::isOpen();
        }
        
        /**
         * {@inheritDoc}
         *
         * @static 
         */ 
        public static function getUnitOfWork()
        {
            return \Doctrine\ORM\EntityManager::getUnitOfWork();
        }
        
        /**
         * {@inheritDoc}
         *
         * @static 
         */ 
        public static function getHydrator($hydrationMode)
        {
            return \Doctrine\ORM\EntityManager::getHydrator($hydrationMode);
        }
        
        /**
         * {@inheritDoc}
         *
         * @static 
         */ 
        public static function newHydrator($hydrationMode)
        {
            return \Doctrine\ORM\EntityManager::newHydrator($hydrationMode);
        }
        
        /**
         * {@inheritDoc}
         *
         * @static 
         */ 
        public static function getProxyFactory()
        {
            return \Doctrine\ORM\EntityManager::getProxyFactory();
        }
        
        /**
         * {@inheritDoc}
         *
         * @static 
         */ 
        public static function initializeObject($obj)
        {
            return \Doctrine\ORM\EntityManager::initializeObject($obj);
        }
        
        /**
         * Factory method to create EntityManager instances.
         *
         * @param mixed $conn An array with the connection parameters or an existing Connection instance.
         * @param \Doctrine\ORM\Configuration $config The Configuration instance to use.
         * @param \Doctrine\ORM\EventManager $eventManager The EventManager instance to use.
         * @return \EntityManager The created EntityManager.
         * @throws \InvalidArgumentException
         * @throws ORMException
         * @static 
         */ 
        public static function create($conn, $config, $eventManager = null)
        {
            return \Doctrine\ORM\EntityManager::create($conn, $config, $eventManager);
        }
        
        /**
         * {@inheritDoc}
         *
         * @static 
         */ 
        public static function getFilters()
        {
            return \Doctrine\ORM\EntityManager::getFilters();
        }
        
        /**
         * {@inheritDoc}
         *
         * @static 
         */ 
        public static function isFiltersStateClean()
        {
            return \Doctrine\ORM\EntityManager::isFiltersStateClean();
        }
        
        /**
         * {@inheritDoc}
         *
         * @static 
         */ 
        public static function hasFilters()
        {
            return \Doctrine\ORM\EntityManager::hasFilters();
        }
         
    }
 
}


namespace  { 

    class Image extends \Intervention\Image\Facades\Image {}

    class Registry extends \LaravelDoctrine\ORM\Facades\Registry {}

    class Doctrine extends \LaravelDoctrine\ORM\Facades\Doctrine {}

    class EntityManager extends \LaravelDoctrine\ORM\Facades\EntityManager {}
 
}



