<?php

namespace ContainerY8x80jm;
include_once \dirname(__DIR__, 4).'/vendor/doctrine/persistence/lib/Doctrine/Persistence/ObjectManager.php';
include_once \dirname(__DIR__, 4).'/vendor/doctrine/orm/lib/Doctrine/ORM/EntityManagerInterface.php';
include_once \dirname(__DIR__, 4).'/vendor/doctrine/orm/lib/Doctrine/ORM/EntityManager.php';

class EntityManager_9a5be93 extends \Doctrine\ORM\EntityManager implements \ProxyManager\Proxy\VirtualProxyInterface
{
    /**
     * @var \Doctrine\ORM\EntityManager|null wrapped object, if the proxy is initialized
     */
    private $valueHoldera5f82 = null;

    /**
     * @var \Closure|null initializer responsible for generating the wrapped object
     */
    private $initializer43572 = null;

    /**
     * @var bool[] map of public properties of the parent class
     */
    private static $publicPropertiesa494e = [
        
    ];

    public function getConnection()
    {
        $this->initializer43572 && ($this->initializer43572->__invoke($valueHoldera5f82, $this, 'getConnection', array(), $this->initializer43572) || 1) && $this->valueHoldera5f82 = $valueHoldera5f82;

        return $this->valueHoldera5f82->getConnection();
    }

    public function getMetadataFactory()
    {
        $this->initializer43572 && ($this->initializer43572->__invoke($valueHoldera5f82, $this, 'getMetadataFactory', array(), $this->initializer43572) || 1) && $this->valueHoldera5f82 = $valueHoldera5f82;

        return $this->valueHoldera5f82->getMetadataFactory();
    }

    public function getExpressionBuilder()
    {
        $this->initializer43572 && ($this->initializer43572->__invoke($valueHoldera5f82, $this, 'getExpressionBuilder', array(), $this->initializer43572) || 1) && $this->valueHoldera5f82 = $valueHoldera5f82;

        return $this->valueHoldera5f82->getExpressionBuilder();
    }

    public function beginTransaction()
    {
        $this->initializer43572 && ($this->initializer43572->__invoke($valueHoldera5f82, $this, 'beginTransaction', array(), $this->initializer43572) || 1) && $this->valueHoldera5f82 = $valueHoldera5f82;

        return $this->valueHoldera5f82->beginTransaction();
    }

    public function getCache()
    {
        $this->initializer43572 && ($this->initializer43572->__invoke($valueHoldera5f82, $this, 'getCache', array(), $this->initializer43572) || 1) && $this->valueHoldera5f82 = $valueHoldera5f82;

        return $this->valueHoldera5f82->getCache();
    }

    public function transactional($func)
    {
        $this->initializer43572 && ($this->initializer43572->__invoke($valueHoldera5f82, $this, 'transactional', array('func' => $func), $this->initializer43572) || 1) && $this->valueHoldera5f82 = $valueHoldera5f82;

        return $this->valueHoldera5f82->transactional($func);
    }

    public function commit()
    {
        $this->initializer43572 && ($this->initializer43572->__invoke($valueHoldera5f82, $this, 'commit', array(), $this->initializer43572) || 1) && $this->valueHoldera5f82 = $valueHoldera5f82;

        return $this->valueHoldera5f82->commit();
    }

    public function rollback()
    {
        $this->initializer43572 && ($this->initializer43572->__invoke($valueHoldera5f82, $this, 'rollback', array(), $this->initializer43572) || 1) && $this->valueHoldera5f82 = $valueHoldera5f82;

        return $this->valueHoldera5f82->rollback();
    }

    public function getClassMetadata($className)
    {
        $this->initializer43572 && ($this->initializer43572->__invoke($valueHoldera5f82, $this, 'getClassMetadata', array('className' => $className), $this->initializer43572) || 1) && $this->valueHoldera5f82 = $valueHoldera5f82;

        return $this->valueHoldera5f82->getClassMetadata($className);
    }

    public function createQuery($dql = '')
    {
        $this->initializer43572 && ($this->initializer43572->__invoke($valueHoldera5f82, $this, 'createQuery', array('dql' => $dql), $this->initializer43572) || 1) && $this->valueHoldera5f82 = $valueHoldera5f82;

        return $this->valueHoldera5f82->createQuery($dql);
    }

    public function createNamedQuery($name)
    {
        $this->initializer43572 && ($this->initializer43572->__invoke($valueHoldera5f82, $this, 'createNamedQuery', array('name' => $name), $this->initializer43572) || 1) && $this->valueHoldera5f82 = $valueHoldera5f82;

        return $this->valueHoldera5f82->createNamedQuery($name);
    }

    public function createNativeQuery($sql, \Doctrine\ORM\Query\ResultSetMapping $rsm)
    {
        $this->initializer43572 && ($this->initializer43572->__invoke($valueHoldera5f82, $this, 'createNativeQuery', array('sql' => $sql, 'rsm' => $rsm), $this->initializer43572) || 1) && $this->valueHoldera5f82 = $valueHoldera5f82;

        return $this->valueHoldera5f82->createNativeQuery($sql, $rsm);
    }

    public function createNamedNativeQuery($name)
    {
        $this->initializer43572 && ($this->initializer43572->__invoke($valueHoldera5f82, $this, 'createNamedNativeQuery', array('name' => $name), $this->initializer43572) || 1) && $this->valueHoldera5f82 = $valueHoldera5f82;

        return $this->valueHoldera5f82->createNamedNativeQuery($name);
    }

    public function createQueryBuilder()
    {
        $this->initializer43572 && ($this->initializer43572->__invoke($valueHoldera5f82, $this, 'createQueryBuilder', array(), $this->initializer43572) || 1) && $this->valueHoldera5f82 = $valueHoldera5f82;

        return $this->valueHoldera5f82->createQueryBuilder();
    }

    public function flush($entity = null)
    {
        $this->initializer43572 && ($this->initializer43572->__invoke($valueHoldera5f82, $this, 'flush', array('entity' => $entity), $this->initializer43572) || 1) && $this->valueHoldera5f82 = $valueHoldera5f82;

        return $this->valueHoldera5f82->flush($entity);
    }

    public function find($className, $id, $lockMode = null, $lockVersion = null)
    {
        $this->initializer43572 && ($this->initializer43572->__invoke($valueHoldera5f82, $this, 'find', array('className' => $className, 'id' => $id, 'lockMode' => $lockMode, 'lockVersion' => $lockVersion), $this->initializer43572) || 1) && $this->valueHoldera5f82 = $valueHoldera5f82;

        return $this->valueHoldera5f82->find($className, $id, $lockMode, $lockVersion);
    }

    public function getReference($entityName, $id)
    {
        $this->initializer43572 && ($this->initializer43572->__invoke($valueHoldera5f82, $this, 'getReference', array('entityName' => $entityName, 'id' => $id), $this->initializer43572) || 1) && $this->valueHoldera5f82 = $valueHoldera5f82;

        return $this->valueHoldera5f82->getReference($entityName, $id);
    }

    public function getPartialReference($entityName, $identifier)
    {
        $this->initializer43572 && ($this->initializer43572->__invoke($valueHoldera5f82, $this, 'getPartialReference', array('entityName' => $entityName, 'identifier' => $identifier), $this->initializer43572) || 1) && $this->valueHoldera5f82 = $valueHoldera5f82;

        return $this->valueHoldera5f82->getPartialReference($entityName, $identifier);
    }

    public function clear($entityName = null)
    {
        $this->initializer43572 && ($this->initializer43572->__invoke($valueHoldera5f82, $this, 'clear', array('entityName' => $entityName), $this->initializer43572) || 1) && $this->valueHoldera5f82 = $valueHoldera5f82;

        return $this->valueHoldera5f82->clear($entityName);
    }

    public function close()
    {
        $this->initializer43572 && ($this->initializer43572->__invoke($valueHoldera5f82, $this, 'close', array(), $this->initializer43572) || 1) && $this->valueHoldera5f82 = $valueHoldera5f82;

        return $this->valueHoldera5f82->close();
    }

    public function persist($entity)
    {
        $this->initializer43572 && ($this->initializer43572->__invoke($valueHoldera5f82, $this, 'persist', array('entity' => $entity), $this->initializer43572) || 1) && $this->valueHoldera5f82 = $valueHoldera5f82;

        return $this->valueHoldera5f82->persist($entity);
    }

    public function remove($entity)
    {
        $this->initializer43572 && ($this->initializer43572->__invoke($valueHoldera5f82, $this, 'remove', array('entity' => $entity), $this->initializer43572) || 1) && $this->valueHoldera5f82 = $valueHoldera5f82;

        return $this->valueHoldera5f82->remove($entity);
    }

    public function refresh($entity)
    {
        $this->initializer43572 && ($this->initializer43572->__invoke($valueHoldera5f82, $this, 'refresh', array('entity' => $entity), $this->initializer43572) || 1) && $this->valueHoldera5f82 = $valueHoldera5f82;

        return $this->valueHoldera5f82->refresh($entity);
    }

    public function detach($entity)
    {
        $this->initializer43572 && ($this->initializer43572->__invoke($valueHoldera5f82, $this, 'detach', array('entity' => $entity), $this->initializer43572) || 1) && $this->valueHoldera5f82 = $valueHoldera5f82;

        return $this->valueHoldera5f82->detach($entity);
    }

    public function merge($entity)
    {
        $this->initializer43572 && ($this->initializer43572->__invoke($valueHoldera5f82, $this, 'merge', array('entity' => $entity), $this->initializer43572) || 1) && $this->valueHoldera5f82 = $valueHoldera5f82;

        return $this->valueHoldera5f82->merge($entity);
    }

    public function copy($entity, $deep = false)
    {
        $this->initializer43572 && ($this->initializer43572->__invoke($valueHoldera5f82, $this, 'copy', array('entity' => $entity, 'deep' => $deep), $this->initializer43572) || 1) && $this->valueHoldera5f82 = $valueHoldera5f82;

        return $this->valueHoldera5f82->copy($entity, $deep);
    }

    public function lock($entity, $lockMode, $lockVersion = null)
    {
        $this->initializer43572 && ($this->initializer43572->__invoke($valueHoldera5f82, $this, 'lock', array('entity' => $entity, 'lockMode' => $lockMode, 'lockVersion' => $lockVersion), $this->initializer43572) || 1) && $this->valueHoldera5f82 = $valueHoldera5f82;

        return $this->valueHoldera5f82->lock($entity, $lockMode, $lockVersion);
    }

    public function getRepository($entityName)
    {
        $this->initializer43572 && ($this->initializer43572->__invoke($valueHoldera5f82, $this, 'getRepository', array('entityName' => $entityName), $this->initializer43572) || 1) && $this->valueHoldera5f82 = $valueHoldera5f82;

        return $this->valueHoldera5f82->getRepository($entityName);
    }

    public function contains($entity)
    {
        $this->initializer43572 && ($this->initializer43572->__invoke($valueHoldera5f82, $this, 'contains', array('entity' => $entity), $this->initializer43572) || 1) && $this->valueHoldera5f82 = $valueHoldera5f82;

        return $this->valueHoldera5f82->contains($entity);
    }

    public function getEventManager()
    {
        $this->initializer43572 && ($this->initializer43572->__invoke($valueHoldera5f82, $this, 'getEventManager', array(), $this->initializer43572) || 1) && $this->valueHoldera5f82 = $valueHoldera5f82;

        return $this->valueHoldera5f82->getEventManager();
    }

    public function getConfiguration()
    {
        $this->initializer43572 && ($this->initializer43572->__invoke($valueHoldera5f82, $this, 'getConfiguration', array(), $this->initializer43572) || 1) && $this->valueHoldera5f82 = $valueHoldera5f82;

        return $this->valueHoldera5f82->getConfiguration();
    }

    public function isOpen()
    {
        $this->initializer43572 && ($this->initializer43572->__invoke($valueHoldera5f82, $this, 'isOpen', array(), $this->initializer43572) || 1) && $this->valueHoldera5f82 = $valueHoldera5f82;

        return $this->valueHoldera5f82->isOpen();
    }

    public function getUnitOfWork()
    {
        $this->initializer43572 && ($this->initializer43572->__invoke($valueHoldera5f82, $this, 'getUnitOfWork', array(), $this->initializer43572) || 1) && $this->valueHoldera5f82 = $valueHoldera5f82;

        return $this->valueHoldera5f82->getUnitOfWork();
    }

    public function getHydrator($hydrationMode)
    {
        $this->initializer43572 && ($this->initializer43572->__invoke($valueHoldera5f82, $this, 'getHydrator', array('hydrationMode' => $hydrationMode), $this->initializer43572) || 1) && $this->valueHoldera5f82 = $valueHoldera5f82;

        return $this->valueHoldera5f82->getHydrator($hydrationMode);
    }

    public function newHydrator($hydrationMode)
    {
        $this->initializer43572 && ($this->initializer43572->__invoke($valueHoldera5f82, $this, 'newHydrator', array('hydrationMode' => $hydrationMode), $this->initializer43572) || 1) && $this->valueHoldera5f82 = $valueHoldera5f82;

        return $this->valueHoldera5f82->newHydrator($hydrationMode);
    }

    public function getProxyFactory()
    {
        $this->initializer43572 && ($this->initializer43572->__invoke($valueHoldera5f82, $this, 'getProxyFactory', array(), $this->initializer43572) || 1) && $this->valueHoldera5f82 = $valueHoldera5f82;

        return $this->valueHoldera5f82->getProxyFactory();
    }

    public function initializeObject($obj)
    {
        $this->initializer43572 && ($this->initializer43572->__invoke($valueHoldera5f82, $this, 'initializeObject', array('obj' => $obj), $this->initializer43572) || 1) && $this->valueHoldera5f82 = $valueHoldera5f82;

        return $this->valueHoldera5f82->initializeObject($obj);
    }

    public function getFilters()
    {
        $this->initializer43572 && ($this->initializer43572->__invoke($valueHoldera5f82, $this, 'getFilters', array(), $this->initializer43572) || 1) && $this->valueHoldera5f82 = $valueHoldera5f82;

        return $this->valueHoldera5f82->getFilters();
    }

    public function isFiltersStateClean()
    {
        $this->initializer43572 && ($this->initializer43572->__invoke($valueHoldera5f82, $this, 'isFiltersStateClean', array(), $this->initializer43572) || 1) && $this->valueHoldera5f82 = $valueHoldera5f82;

        return $this->valueHoldera5f82->isFiltersStateClean();
    }

    public function hasFilters()
    {
        $this->initializer43572 && ($this->initializer43572->__invoke($valueHoldera5f82, $this, 'hasFilters', array(), $this->initializer43572) || 1) && $this->valueHoldera5f82 = $valueHoldera5f82;

        return $this->valueHoldera5f82->hasFilters();
    }

    /**
     * Constructor for lazy initialization
     *
     * @param \Closure|null $initializer
     */
    public static function staticProxyConstructor($initializer)
    {
        static $reflection;

        $reflection = $reflection ?? new \ReflectionClass(__CLASS__);
        $instance   = $reflection->newInstanceWithoutConstructor();

        \Closure::bind(function (\Doctrine\ORM\EntityManager $instance) {
            unset($instance->config, $instance->conn, $instance->metadataFactory, $instance->unitOfWork, $instance->eventManager, $instance->proxyFactory, $instance->repositoryFactory, $instance->expressionBuilder, $instance->closed, $instance->filterCollection, $instance->cache);
        }, $instance, 'Doctrine\\ORM\\EntityManager')->__invoke($instance);

        $instance->initializer43572 = $initializer;

        return $instance;
    }

    protected function __construct(\Doctrine\DBAL\Connection $conn, \Doctrine\ORM\Configuration $config, \Doctrine\Common\EventManager $eventManager)
    {
        static $reflection;

        if (! $this->valueHoldera5f82) {
            $reflection = $reflection ?? new \ReflectionClass('Doctrine\\ORM\\EntityManager');
            $this->valueHoldera5f82 = $reflection->newInstanceWithoutConstructor();
        \Closure::bind(function (\Doctrine\ORM\EntityManager $instance) {
            unset($instance->config, $instance->conn, $instance->metadataFactory, $instance->unitOfWork, $instance->eventManager, $instance->proxyFactory, $instance->repositoryFactory, $instance->expressionBuilder, $instance->closed, $instance->filterCollection, $instance->cache);
        }, $this, 'Doctrine\\ORM\\EntityManager')->__invoke($this);

        }

        $this->valueHoldera5f82->__construct($conn, $config, $eventManager);
    }

    public function & __get($name)
    {
        $this->initializer43572 && ($this->initializer43572->__invoke($valueHoldera5f82, $this, '__get', ['name' => $name], $this->initializer43572) || 1) && $this->valueHoldera5f82 = $valueHoldera5f82;

        if (isset(self::$publicPropertiesa494e[$name])) {
            return $this->valueHoldera5f82->$name;
        }

        $realInstanceReflection = new \ReflectionClass('Doctrine\\ORM\\EntityManager');

        if (! $realInstanceReflection->hasProperty($name)) {
            $targetObject = $this->valueHoldera5f82;

            $backtrace = debug_backtrace(false, 1);
            trigger_error(
                sprintf(
                    'Undefined property: %s::$%s in %s on line %s',
                    $realInstanceReflection->getName(),
                    $name,
                    $backtrace[0]['file'],
                    $backtrace[0]['line']
                ),
                \E_USER_NOTICE
            );
            return $targetObject->$name;
        }

        $targetObject = $this->valueHoldera5f82;
        $accessor = function & () use ($targetObject, $name) {
            return $targetObject->$name;
        };
        $backtrace = debug_backtrace(true, 2);
        $scopeObject = isset($backtrace[1]['object']) ? $backtrace[1]['object'] : new \ProxyManager\Stub\EmptyClassStub();
        $accessor = $accessor->bindTo($scopeObject, get_class($scopeObject));
        $returnValue = & $accessor();

        return $returnValue;
    }

    public function __set($name, $value)
    {
        $this->initializer43572 && ($this->initializer43572->__invoke($valueHoldera5f82, $this, '__set', array('name' => $name, 'value' => $value), $this->initializer43572) || 1) && $this->valueHoldera5f82 = $valueHoldera5f82;

        $realInstanceReflection = new \ReflectionClass('Doctrine\\ORM\\EntityManager');

        if (! $realInstanceReflection->hasProperty($name)) {
            $targetObject = $this->valueHoldera5f82;

            $targetObject->$name = $value;

            return $targetObject->$name;
        }

        $targetObject = $this->valueHoldera5f82;
        $accessor = function & () use ($targetObject, $name, $value) {
            $targetObject->$name = $value;

            return $targetObject->$name;
        };
        $backtrace = debug_backtrace(true, 2);
        $scopeObject = isset($backtrace[1]['object']) ? $backtrace[1]['object'] : new \ProxyManager\Stub\EmptyClassStub();
        $accessor = $accessor->bindTo($scopeObject, get_class($scopeObject));
        $returnValue = & $accessor();

        return $returnValue;
    }

    public function __isset($name)
    {
        $this->initializer43572 && ($this->initializer43572->__invoke($valueHoldera5f82, $this, '__isset', array('name' => $name), $this->initializer43572) || 1) && $this->valueHoldera5f82 = $valueHoldera5f82;

        $realInstanceReflection = new \ReflectionClass('Doctrine\\ORM\\EntityManager');

        if (! $realInstanceReflection->hasProperty($name)) {
            $targetObject = $this->valueHoldera5f82;

            return isset($targetObject->$name);
        }

        $targetObject = $this->valueHoldera5f82;
        $accessor = function () use ($targetObject, $name) {
            return isset($targetObject->$name);
        };
        $backtrace = debug_backtrace(true, 2);
        $scopeObject = isset($backtrace[1]['object']) ? $backtrace[1]['object'] : new \ProxyManager\Stub\EmptyClassStub();
        $accessor = $accessor->bindTo($scopeObject, get_class($scopeObject));
        $returnValue = $accessor();

        return $returnValue;
    }

    public function __unset($name)
    {
        $this->initializer43572 && ($this->initializer43572->__invoke($valueHoldera5f82, $this, '__unset', array('name' => $name), $this->initializer43572) || 1) && $this->valueHoldera5f82 = $valueHoldera5f82;

        $realInstanceReflection = new \ReflectionClass('Doctrine\\ORM\\EntityManager');

        if (! $realInstanceReflection->hasProperty($name)) {
            $targetObject = $this->valueHoldera5f82;

            unset($targetObject->$name);

            return;
        }

        $targetObject = $this->valueHoldera5f82;
        $accessor = function () use ($targetObject, $name) {
            unset($targetObject->$name);

            return;
        };
        $backtrace = debug_backtrace(true, 2);
        $scopeObject = isset($backtrace[1]['object']) ? $backtrace[1]['object'] : new \ProxyManager\Stub\EmptyClassStub();
        $accessor = $accessor->bindTo($scopeObject, get_class($scopeObject));
        $accessor();
    }

    public function __clone()
    {
        $this->initializer43572 && ($this->initializer43572->__invoke($valueHoldera5f82, $this, '__clone', array(), $this->initializer43572) || 1) && $this->valueHoldera5f82 = $valueHoldera5f82;

        $this->valueHoldera5f82 = clone $this->valueHoldera5f82;
    }

    public function __sleep()
    {
        $this->initializer43572 && ($this->initializer43572->__invoke($valueHoldera5f82, $this, '__sleep', array(), $this->initializer43572) || 1) && $this->valueHoldera5f82 = $valueHoldera5f82;

        return array('valueHoldera5f82');
    }

    public function __wakeup()
    {
        \Closure::bind(function (\Doctrine\ORM\EntityManager $instance) {
            unset($instance->config, $instance->conn, $instance->metadataFactory, $instance->unitOfWork, $instance->eventManager, $instance->proxyFactory, $instance->repositoryFactory, $instance->expressionBuilder, $instance->closed, $instance->filterCollection, $instance->cache);
        }, $this, 'Doctrine\\ORM\\EntityManager')->__invoke($this);
    }

    public function setProxyInitializer(\Closure $initializer = null) : void
    {
        $this->initializer43572 = $initializer;
    }

    public function getProxyInitializer() : ?\Closure
    {
        return $this->initializer43572;
    }

    public function initializeProxy() : bool
    {
        return $this->initializer43572 && ($this->initializer43572->__invoke($valueHoldera5f82, $this, 'initializeProxy', array(), $this->initializer43572) || 1) && $this->valueHoldera5f82 = $valueHoldera5f82;
    }

    public function isProxyInitialized() : bool
    {
        return null !== $this->valueHoldera5f82;
    }

    public function getWrappedValueHolderValue()
    {
        return $this->valueHoldera5f82;
    }
}

if (!\class_exists('EntityManager_9a5be93', false)) {
    \class_alias(__NAMESPACE__.'\\EntityManager_9a5be93', 'EntityManager_9a5be93', false);
}
