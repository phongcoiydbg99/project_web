<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
/**
 * Users Controller
 *
 *
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UsersController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    // 
    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->Auth->allow(['login']);
        if($this->Auth->user('role') === 'user')
        {
            $this->viewBuilder()->setLayout('user');
        }
    }
    // public function isAuthorized($user = null)
    // {
    //     // All registered users can add articles
    //     // Admin can access every action
    //     // 
    //     if (isset($user['role']) && $user['role'] === 'user') {
    //         return true;
    //     }

    //     $this->redirect(array('controller' => 'users', 'action' => 'index','prefix' => 'admin'));
    //     return parent::isAuthorized($user);
    // }
    public function index()
    {
        $users = $this->paginate($this->Users);
        $this->set(compact('users'));
    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => []
        ]);

        $this->set('user', $user);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $this->set(compact('user'));
    }

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $this->set(compact('user'));
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);
        if ($this->Users->delete($user)) {
            $this->Flash->success(__('The user has been deleted.'));
        } else {
            $this->Flash->error(__('The user could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
    public function login()
    {
        if($this->Auth->user('id'))
        {
            // user already login
            return $this->redirect($this->Auth->redirectUrl());
        }
        else{     
            $login = $this->Users->newEntity();

            if ($this->request->is('post') AND !empty($this->request->getData())) {
                $check_login = $this->Users->patchEntity($login, $this->request->getData(),['validate' => 'login']);
                
                $validator = $check_login->errors();
                
                if (!empty($validator))
                { 
                   $this->Flash->error("Bạn chưa điền đủ thông tin");
                }
                else
                {  
                    $cuser = $this->Auth->identify();
                    if ($cuser) {
                        $this->Auth->setUser($cuser);
                        if($this->Auth->user('role') === 'admin')
                        {
                           return $this->redirect($this->Auth->redirectUrl('/admin'));
                        }
                        else return $this->redirect($this->Auth->redirectUrl('/login'));
                    }
                    $this->Flash->error("Mật khẩu của bạn chưa đúng!");
                }
            }
            // $this->set('validator',$validator);
            $this->set('user',$login);
        }
    }
    public function logout()
    {
        return $this->redirect($this->Auth->logout());
    }
   
}
