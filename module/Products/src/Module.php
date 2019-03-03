<?php

namespace Products;

use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\ModuleManager\Feature\ConfigProviderInterface;



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
                        Model\ProductsTable::class => function($container) {
                            $tableGateway = $container->get(Model\ProductsTableGateway::class);
                            return new Model\ProductsTable($tableGateway);
                        },
                        Model\ProductsTableGateway::class => function ($container) {
                            $dbAdapter = $container->get(AdapterInterface::class);
                            $resultSetPrototype = new ResultSet();
                            $resultSetPrototype->setArrayObjectPrototype(new Model\Products());
                            return new TableGateway('product', $dbAdapter, null, $resultSetPrototype);
                        },
                ],
           ];
        }

        public function getControllerConfig()
        {
           return [
                'factories' => [
                        Controller\IndexController::class => function($container) {
                            return new Controller\IndexController(
                                    $container->get(Model\ProductsTable::class)
                            );
                        },
                ],
           ];
        }
}
