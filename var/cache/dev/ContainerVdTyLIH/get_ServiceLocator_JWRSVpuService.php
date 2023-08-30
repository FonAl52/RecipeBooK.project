<?php

namespace ContainerVdTyLIH;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class get_ServiceLocator_JWRSVpuService extends App_KernelDevDebugContainer
{
    /**
     * Gets the private '.service_locator.JWRSVpu' shared service.
     *
     * @return \Symfony\Component\DependencyInjection\ServiceLocator
     */
    public static function do($container, $lazyLoad = true)
    {
        return $container->privates['.service_locator.JWRSVpu'] = new \Symfony\Component\DependencyInjection\Argument\ServiceLocator($container->getService, [
            'recipeRepository' => ['privates', '.errored.8C6C9Jp', NULL, 'Cannot determine controller argument for "App\\Controller\\HomeController::index()": the $recipeRepository argument is type-hinted with the non-existent class or interface: "App\\Controller\\RecipeRepository". Did you forget to add a use statement?'],
        ], [
            'recipeRepository' => '?',
        ]);
    }
}
