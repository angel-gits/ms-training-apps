<?php

namespace ContainerXRcYof9;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class getSecurity_Authentication_Provider_Guard_MainService extends App_KernelDevDebugContainer
{
    /**
     * Gets the private 'security.authentication.provider.guard.main' shared service.
     *
     * @return \Symfony\Component\Security\Guard\Provider\GuardAuthenticationProvider
     *
     * @deprecated Since symfony/security-bundle 5.3: The "security.authentication.provider.guard.main" service is deprecated, use the new authenticator system instead.
     */
    public static function do($container, $lazyLoad = true)
    {
        trigger_deprecation('symfony/security-bundle', '5.3', 'The "security.authentication.provider.guard.main" service is deprecated, use the new authenticator system instead.');

        include_once \dirname(__DIR__, 4).'/vendor/symfony/security-core/User/UserProviderInterface.php';
        include_once \dirname(__DIR__, 4).'/vendor/symfony/security-core/User/PasswordUpgraderInterface.php';
        include_once \dirname(__DIR__, 4).'/vendor/symfony/doctrine-bridge/Security/User/EntityUserProvider.php';
        include_once \dirname(__DIR__, 4).'/vendor/symfony/security-core/User/UserCheckerInterface.php';
        include_once \dirname(__DIR__, 4).'/vendor/symfony/security-core/User/InMemoryUserChecker.php';
        include_once \dirname(__DIR__, 4).'/vendor/symfony/password-hasher/Hasher/UserPasswordHasherInterface.php';
        include_once \dirname(__DIR__, 4).'/vendor/symfony/password-hasher/Hasher/UserPasswordHasher.php';

        return $container->privates['security.authentication.provider.guard.main'] = new \Symfony\Component\Security\Guard\Provider\GuardAuthenticationProvider(new RewindableGenerator(function () use ($container) {
            yield 0 => ($container->privates['App\\Security\\TokenAuthenticator'] ?? ($container->privates['App\\Security\\TokenAuthenticator'] = new \App\Security\TokenAuthenticator()));
        }, 1), new \Symfony\Bridge\Doctrine\Security\User\EntityUserProvider(($container->services['doctrine'] ?? $container->getDoctrineService()), 'App\\Entity\\User', 'email', NULL), 'main', new \Symfony\Component\Security\Core\User\InMemoryUserChecker(), new \Symfony\Component\PasswordHasher\Hasher\UserPasswordHasher(($container->privates['security.password_hasher_factory'] ?? $container->load('getSecurity_PasswordHasherFactoryService'))));
    }
}