<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Categories\Controller;

use Categories\Model\CategoriesTable;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Categories\Form\CategoriesForm;
use Categories\Model\Categories;
use Zend\Session\Container;
use Zend\Cache\StorageFactory;
use Zend\Session\SessionManager;
class IndexController extends AbstractActionController
{
    // Add this property:
    private $table;

    // Add this constructor:
    public function __construct(CategoriesTable $table)
    {
        $this->table = $table;
    }
    public function indexAction()
    {
        $container = new Container('loginCookies');
        $value = $container->logged;
        if($value){
        return new ViewModel([
            'categories' => $this->table->fetchAll(),
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
        $form = new CategoriesForm();
        $form->get('submit')->setValue('Add');

        $request = $this->getRequest();

        if (! $request->isPost()) {
            return ['form' => $form];
        }

        $category = new Categories();
        $form->setData($request->getPost());

        if (! $form->isValid()) {
            return ['form' => $form];
        }

        $category->exchangeArray($form->getData());
        $this->table->saveCategory($category);
        return $this->redirect()->toRoute('categories');
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
            $category = $this->table->getCategory($Id);
        }
        catch (Exception $e){
            exit('Error');
        }
        $form = new CategoriesForm();
        $form -> bind($category);
        

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
        return $this->redirect()->toRoute('categories');
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
            $this->table->deleteCategory($Id);
        }
        catch (Exception $e){
            exit('Error');
        }
        return $this->redirect()->toRoute('categories');
    }else{
        return $this->redirect()->toUrl('/user/login'); 
    }
    }
}
