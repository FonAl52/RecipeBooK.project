<?php

namespace Container2x7Nong;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class get_ServiceLocator_6gtTwgqService extends App_KernelDevDebugContainer
{
    /**
     * Gets the private '.service_locator.6gtTwgq' shared service.
     *
     * @return \Symfony\Component\DependencyInjection\ServiceLocator
     */
    public static function do($container, $lazyLoad = true)
    {
        return $container->privates['.service_locator.6gtTwgq'] = new \Symfony\Component\DependencyInjection\Argument\ServiceLocator($container->getService, [
            'manager' => ['services', 'doctrine.orm.default_entity_manager', 'getDoctrine_Orm_DefaultEntityManagerService', false],
            'repository' => ['privates', 'App\\Repository\\RecipeRepository', 'getRecipeRepositoryService', true],
        ], [
            'manager' => '?',
            'repository' => 'App\\Repository\\RecipeRepository',
        ]);
    }
}
