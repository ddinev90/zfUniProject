<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Products\Controller;

use Products\Model\ProductsTable;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Products\Form\ProductsForm;
use Products\Model\Products;
use Zend\Session\Container;
use Zend\Cache\StorageFactory;
use Zend\Session\SessionManager;
class IndexController extends AbstractActionController
{
    // Add this property:
    private $table;

    // Add this constructor:
    public function __construct(ProductsTable $table)
    {
        $this->table = $table;
    }
    public function indexAction()
    {
        $container = new Container('loginCookies');
        $value = $container->logged;
        if($value){
            return new ViewModel([
            'products' => $this->table->fetchAll(),
         ]);
        }else{
            return $this->redirect()->toUrl('/user/login');
        }
    }
    public function addAction()
    {
        $container = new Container('loginCookies');
        $value = $container->logged;
        if($value){
        $form = new ProductsForm();
        $form->get('submit')->setValue('Add');

        $request = $this->getRequest();

        if (! $request->isPost()) {
            return ['form' => $form];
        }

        $product = new Products();
        $form->setData($request->getPost());

        if (! $form->isValid()) {
            return ['form' => $form];
        }

        $product->exchangeArray($form->getData());
        $this->table->saveProduct($product);
        return $this->redirect()->toRoute('products');
    }else{
        return $this->redirect()->toUrl('/user/login');
    }
    }

    public function editAction()
    {
        $container = new Container('loginCookies');
        $value = $container->logged;
        if($value){
        $Id = (int) $this->params()->fromRoute('id',0);
    
        try{
            $product = $this->table->getProduct($Id);
        }
        catch (Exception $e){
            exit('Error');
        }
        $form = new ProductsForm();
        $form -> bind($product);
        

        $request = $this->getRequest();
        if(!$request->isPost()){
            return new ViewModel([
                'form'=>$form,
                'id'=>$Id
            ]);
        }

        $form -> setData($request->getPost());
        if(!$form.isValid()){
            exit("Error");
        }
        $this->table->update($post);
        return $this->redirect()->toRoute('products');
    }else{
        return $this->redirect()->toUrl('/user/login');
    }
    }

    public function deleteAction()
    {
        $container = new Container('loginCookies');
        $value = $container->logged;
        if($value){
        $Id = (int) $this->params()->fromRoute('id',0);
        try{
            $this->table->deleteProduct($Id);
        }
        catch (Exception $e){
            exit('Error');
        }
        return $this->redirect()->toRoute('products');
    }else{
        return $this->redirect()->toUrl('/user/login');
    }
    }
}
