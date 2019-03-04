<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace User;

use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\Authentication\Adapter\DbTable as DbAuthAdapter;
use Zend\Authentication\AuthenticationService;
use Zend\Session\Container;
use Zend\Authentication\Adapter\DbTable\CredentialTreatmentAdapter;

class Module implements ConfigProviderInterface
{
    const VERSION = '3.0.3-dev';
    
    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }
    public function getServiceConfig()
    {
       return [
            'factories' => [
                    Model\UserTable::class => function($container) {
                        $tableGateway = $container->get(Model\UsersTableGateway::class);
                        return new Model\UserTable($tableGateway);
                    },
                    Model\UsersTableGateway::class => function ($container) {
                        $dbAdapter = $container->get(AdapterInterface::class);
                        $resultSetPrototype = new ResultSet();
                        $resultSetPrototype->setArrayObjectPrototype(new Model\User());
                        return new TableGateway('user', $dbAdapter, null, $resultSetPrototype);
                    },
                    AuthenticationService::class => AuthenticationServiceFactory::class,
            ],
       ];
    }
    public function getControllerConfig()
    {
       return [
            'factories' => [
                    Controller\IndexController::class => function($container) {
                        return new Controller\IndexController(
                                $container->get(Model\UserTable::class)
                        );
                    },
            ],
       ];
    }
}
