<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace User\Controller;

use User\Model\UserTable;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use User\Model\User;
use User\Form\UserForm;
use User\Form\LoginForm;

class IndexController extends AbstractActionController
{
     // Add this property:
     private $table;

     // Add this constructor:
     public function __construct(UserTable $table)
     {
         $this->table = $table;
     }
     public function loginAction()
     {
        $form = new LoginForm();
        $form->get('submit')->setValue('Login');
        $request = $this->getRequest();
        if ($request->isPost()) {
            if ($form->isValid($form->setData($request->getPost()))) {
                if ($this->_process($form->getData())) {
                    // We're authenticated! Redirect to the home page
                    $this->_helper->redirector('index', 'index');
                }
            }
        }
        if (!$request->isPost()) {
            return ['form' => $form];
        }
     }
    public function indexAction()
    {
        return new ViewModel([
            'users' => $this->table->fetchAll(),
        ]);
    }
    public function addAction()
    {
        $form = new UserForm();
        $form->get('submit')->setValue('Add');

        $request = $this->getRequest();

        if (!$request->isPost()) {
            return ['form' => $form];
        }

        $user = new User();
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
    protected function _process($values)
    {
        $auth = Zend_Auth::getInstance();
        if ($result->isValid()) {
            $user = $adapter->getResultRowObject();
            $auth->getStorage()->write($user);
            return false;
        }
        return false;
    }
}
