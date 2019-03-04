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
use Zend\Session\Container;
use Zend\Cache\StorageFactory;
use Zend\Session\SessionManager;

use RuntimeException;
class IndexController extends AbstractActionController
{
     // Add this property:
     private $table;
     // Add this constructor:
     public function __construct(UserTable $table)
     {
         $this->table = $table;
     }
     public function logoutAction()
     {
        $sessionContainer = new Container('loginCookies');
        unset($sessionContainer->logged);
        return $this->redirect()->toUrl('/user/login');
     }
     public function loginAction()
     {
        $form = new LoginForm();
        $form->get('submit')->setValue('Login');
        $request = $this->getRequest();
        if (!$request->isPost()) {
            return ['form' => $form];
        }
            $user = new User();
            $form->setData($request->getPost());
            if (!$form->isValid()) {
                return ['form' => $form];
            }
            $user->exchangeArray($form->getData());
                if ($this->table->validateUser($user)) {

                    $sessionContainer = new Container('loginCookies');
                    $sessionContainer->logged = true;
                    return $this->redirect('/module/user/index');
              }
              return $this->redirect()->toUrl('/user/login');
     }
    public function indexAction()
    {
        $container = new Container('loginCookies');
        $value = $container->logged;
        if($value){
            return new ViewModel([
            'users' => $this->table->fetchAll(),
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
    else{
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
            $this->table->deleteUser($Id);
        }
        catch (Exception $e){
            exit('Error');
        }
        return $this->redirect()->toRoute('users');
    }else{
        return $this->redirect()->toUrl('/user/login');
    }
    }
}
