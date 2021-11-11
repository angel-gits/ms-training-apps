<?php

namespace ContainerXRcYof9;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class getGoalControllerService extends App_KernelDevDebugContainer
{
    /**
     * Gets the public 'App\Controller\GoalController' shared autowired service.
     *
     * @return \App\Controller\GoalController
     */
    public static function do($container, $lazyLoad = true)
    {
        include_once \dirname(__DIR__, 4).'/vendor/symfony/framework-bundle/Controller/AbstractController.php';
        include_once \dirname(__DIR__, 4).'/src/Controller/GoalController.php';

        $container->services['App\\Controller\\GoalController'] = $instance = new \App\Controller\GoalController(($container->services['doctrine.orm.default_entity_manager'] ?? $container->load('getDoctrine_Orm_DefaultEntityManagerService')));

        $instance->setContainer(($container->privates['.service_locator.W9y3dzm'] ?? $container->load('get_ServiceLocator_W9y3dzmService'))->withContext('App\\Controller\\GoalController', $container));

        return $instance;
    }
}
