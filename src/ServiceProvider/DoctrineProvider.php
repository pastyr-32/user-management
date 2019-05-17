<?php
declare(strict_types=1);

namespace Nerdery\ServiceProvider;

use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Cache\FilesystemCache;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Doctrine\ORM\Tools\Setup;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

/**
 * A ServiceProvider for registering services related to
 * Doctrine in a DI container.
 *
 * If the project had custom repositories (e.g. UserRepository)
 * they could be registered here.
 */
class DoctrineProvider implements ServiceProviderInterface
{
    /**
     * {@inheritdoc}
     */
    public function register(Container $container)
    {
        $container[EntityManager::class] = function (Container $container): EntityManager {
            $config = Setup::createAnnotationMetadataConfiguration(
                $container['settings']['doctrine']['metadata_dirs'],
                $container['settings']['doctrine']['dev_mode']
            );
            $config->setMetadataDriverImpl(
                new AnnotationDriver(
                    new AnnotationReader,
                    $container['settings']['doctrine']['metadata_dirs']
                )
            );
            $config->setMetadataCacheImpl(
                new FilesystemCache(
                    $container['settings']['doctrine']['cache_dir']
                )
            );
            return EntityManager::create(
                $container['settings']['doctrine']['connection'],
                $config
            );
        };
    }
}