<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Routing\Router;
use Cake\Mailer\Email;
use Cake\ORM\TableRegistry;
use Cake\Auth\DefaultPasswordHasher;
use Cake\Utility\Security;
use Cake\Mailer\TransportFactory;
use Cake\Datasource\EntityInterface;
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
        $this->Auth->allow(['login','logout','forgotpassword','resetpassword']);
    }
    public function isAuthorized($user = null)
    {
        // All registered users can add articles
        // Admin can access every action
        // 
        if (isset($user['role']) && $user['role'] === 'user') {
            $this->redirect(array('controller' => 'users', 'action' => 'index','scope' => '/'));
            return true;
        }

        $this->redirect(array('controller' => 'users', 'action' => 'index','prefix' => 'admin'));
        return parent::isAuthorized($user);
    }
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
        $this->viewBuilder()->setLayout('login');
        if($this->Auth->user('id'))
        {
            // user already login
            // return $this->redirect($this->Auth->redirectUrl());
            return $this->redirect(['controller' => 'subjects', 'action' => 'view_test']);
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
                           return $this->redirect(['controller' => 'users', 'action' => 'index','prefix'=>'admin']);
                        }
                        else return $this->redirect(['controller' => 'subjects', 'action' => 'view_test']);
                    }
                    $this->Flash->error("Tài khoản hoặc mật khẩu của bạn chưa đúng!");
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
    public function forgotpassword(){
        $this->viewBuilder()->setLayout('login');
        if ($this->request->is('post')){
            $myemail = $this->request->getData('email');
            $mytoken = Security::hash(Security::randomBytes(25));
            $userTable = TableRegistry::get('Users');
            $user = $userTable->find('all')->where(['email'=>$myemail])->first();
            // dd($user);
            $user->password = '';
            $user->token = $mytoken;
            if($userTable->save($user)){
                $this->Flash->success('reset password link have been sent');
                
                TransportFactory::setConfig('gmail', [
                    'host' => 'ssl://smtp.gmail.com',
                    'port' => 465,
                    'username' => 'projectweb.993@gmail.com',
                    'password' => 'phongcoibg99',
                    'className' => 'Smtp'
                ]);
            }
            $email = new Email('default');
            $email->Transport('gmail');
            $email->emailFormat('html');
            $email->from('projectweb.993@gmail.com', 'Admin');
            $email->subject('please confirm your reset password');
            $email->to($myemail);
            $email->send('hello ' . $myemail . '<br/>Plese click link below to reset your password<br/><br?> <a href="http://localhost/project_web/users/resetpassword/'. $mytoken.'" >Click</a>');


        }


    }

    
    public function resetpassword($token){
        $this->viewBuilder()->setLayout('login');
        if($this->request->is('post')){
            // $hasher = new DefaultPasswordHasher();
            $mypass = $this->request->getData('password');
            // dd($mypass);
            $userTable = TableRegistry::get('users');
            $user = $userTable->find('all')->where(['token'=>$token])->first();
            // dd($userTable->find('all')->where(['token'=>$token])->first());
            $user->password = $mypass;
            if($userTable->save($user)){
                // dd($user->password);
                return $this->redirect(['action'=>'login']);
            }
        }
    }
    public function profile()
    {
        $users = $this->paginate($this->Users);
        $this->set(compact('users'));
    }
}
