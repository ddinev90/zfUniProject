<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Users\Controller;

use Users\Model\UsersTable;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Users\Model\Users;
use Users\Form\UsersForm;

class IndexController extends AbstractActionController
{
     // Add this property:
     private $table;

     // Add this constructor:
     public function __construct(UsersTable $table)
     {
         $this->table = $table;
     }
    public function indexAction()
    {
        return new ViewModel([
            'users' => $this->table->fetchAll(),
        ]);
    }
    public function addAction()
    {
        $form = new UsersForm();
        $form->get('submit')->setValue('Add');

        $request = $this->getRequest();

        if (! $request->isPost()) {
            return ['form' => $form];
        }

        $user = new Users();
        $form->setData($request->getPost());

        if (! $form->isValid()) {
            return ['form' => $form];
        }

        $user->exchangeArray($form->getData());
        $this->table->saveUser($user);
        return $this->redirect()->toRoute('users');
    }

    public function editAction()
    {
        $Id = (int) $this->params()->fromRoute('id',0);
    
        try{
            $user = $this->table->getUser($Id);
        }
        catch (Exception $e){
            exit('Error');
        }
        $form = new UsersForm();
        $form -> bind($user);
        

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
        return $this->redirect()->toRoute('users');
    }

    public function deleteAction()
    {
        $Id = (int) $this->params()->fromRoute('id',0);
        try{
            $this->table->deleteUser($Id);
        }
        catch (Exception $e){
            exit('Error');
        }
        return $this->redirect()->toRoute('users');
    }
}
