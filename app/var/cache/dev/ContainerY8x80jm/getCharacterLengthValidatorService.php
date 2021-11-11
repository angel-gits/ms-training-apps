<?php

namespace ContainerY8x80jm;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class getCharacterLengthValidatorService extends App_KernelDevDebugContainer
{
    /**
     * Gets the private 'App\Validator\Constraints\CharacterLengthValidator' shared autowired service.
     *
     * @return \App\Validator\Constraints\CharacterLengthValidator
     */
    public static function do($container, $lazyLoad = true)
    {
        include_once \dirname(__DIR__, 4).'/vendor/symfony/validator/ConstraintValidatorInterface.php';
        include_once \dirname(__DIR__, 4).'/vendor/symfony/validator/ConstraintValidator.php';
        include_once \dirname(__DIR__, 4).'/src/Validator/Constraints/CharacterLengthValidator.php';

        return $container->privates['App\\Validator\\Constraints\\CharacterLengthValidator'] = new \App\Validator\Constraints\CharacterLengthValidator();
    }
}
