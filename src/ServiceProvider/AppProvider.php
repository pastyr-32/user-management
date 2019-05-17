<?php
declare(strict_types=1);

namespace Nerdery\ServiceProvider;

use Doctrine\ORM\EntityManager;
use Nerdery\Action\CreateUser;
use Nerdery\Action\DeleteUser;
use Nerdery\Action\Index;
use Nerdery\Action\ListUsers;
use Nerdery\Action\ReadUser;
use Nerdery\Action\SearchUsers;
use Nerdery\Action\UpdateUser;
use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Slim\App;

/**
 * A ServiceProvider for registering services related
 * to Slim such as request handlers, routing and the
 * App service itself.
 */
class AppProvider implements ServiceProviderInterface
{
    /**
     * {@inheritdoc}
     */
    public function register(Container $container)
    {
        /** Register Dependencies */
        $container[Index::class] = function (Container $container): Index {
            return new Index($container[EntityManager::class]);
        };

        $container[CreateUser::class] = function (Container $container): CreateUser {
            return new CreateUser($container[EntityManager::class]);
        };

        $container[ReadUser::class] = function (Container $container): ReadUser {
            return new ReadUser($container[EntityManager::class]);
        };

        $container[UpdateUser::class] = function (Container $container): UpdateUser {
            return new UpdateUser($container[EntityManager::class]);
        };

        $container[DeleteUser::class] = function (Container $container): DeleteUser {
            return new DeleteUser($container[EntityManager::class]);
        };

        $container[ListUsers::class] = function (Container $container): ListUsers {
            return new ListUsers($container[EntityManager::class]);
        };

        $container[SearchUsers::class] = function (Container $container): SearchUsers {
            return new SearchUsers($container[EntityManager::class]);
        };

        /** Initialize App */
        $container[App::class] = function (Container $container): App {
            $app = new App($container);

            /** Configure CORS */
            $app->options('/{routes:.+}', function ($request, $response, $args) {
                return $response;
            });
            $app->add(function ($req, $res, $next) {
                $response = $next($req, $res);
                return $response
                    ->withHeader('Access-Control-Allow-Origin', '*')
                    ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
                    ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
            });

            /** Register Endpoints */
            $app->get('/', Index::class)->setName('index');
            $app->get('/user/search', SearchUsers::class)->setName("search");
            $app->get('/user', ListUsers::class)->setName("list");
            $app->post('/user', CreateUser::class)->setName("create");
            $app->get('/user/{id}', ReadUser::class)->setName("read");
            $app->put('/user/{id}', UpdateUser::class)->setName("update");
            $app->delete('/user/{id}', DeleteUser::class)->setName("delete");

            return $app;
        };
    }
}