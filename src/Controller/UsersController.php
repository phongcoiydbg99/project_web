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
        // bất kỳ ai cũng có thể truy cập kể cả khi không có tài khoản
        $this->Auth->allow(['login','logout','forgotpassword','resetpassword']);
    }
    public function isAuthorized($user = null)
    {
        // admin và user đều có thể xem sửa thông tin cá nhân
        if($this->request->action === 'profile' || $this->request->action === 'editProfile' || $this->request->action === 'firstlogin'||$this->request->action === 'changepassword'){
            return true;
        }
        // nếu tài khoản đăng nhập là user cho phép tài khoản có thể truy cập vào chức năng của user
        if (isset($user['role']) && $user['role'] === 'user') {
            $this->redirect(array('controller' => 'users', 'action' => 'index','scope' => '/'));
            return true;
        }
        // nếu tài khoản đăng nhập là admin chuyển hướng tới trang quản lý
        if (isset($user['role']) && $user['role'] === 'admin') {
            $this->redirect(array('controller' => 'users', 'action' => 'index','prefix' => 'admin'));
        }
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

    // đăng nhập
    public function login()
    {
        $this->viewBuilder()->setLayout('login');
        if($this->Auth->user('id'))
        {
            // nếu user đã đăng nhập => trở về trang chủ
            return $this->redirect(['controller' => 'subjects', 'action' => 'view_test']);
        }
        else{
            $login = $this->Users->newEntity();

            if ($this->request->is('post') AND !empty($this->request->getData())) {
                $check_login = $this->Users->patchEntity($login, $this->request->getData(),['validate' => 'login']);
                $validator = $check_login->errors();
                // nếu có lỗi xảy ra đưa ra thông báo lỗi
                if (!empty($validator))
                {
                   $this->Flash->error("Bạn chưa điền đủ thông tin");
                }
                else
                {
                    $cuser = $this->Auth->identify();
                    if ($cuser) {
                        $this->Auth->setUser($cuser);
                        // nếu tài khoản là admin chuyển hướng đến trang quản lý
                        if($this->Auth->user('role') === 'admin')
                        {
                           return $this->redirect(['controller' => 'sessions', 'action' => 'index','prefix'=>'admin']);
                        }
                        // nếu là user đăng nhập lần đầu(chưa có email) chuyển hướng tới trang đổi mật khẩu và thêm email
                        // nếu đã đăng nhập trước đó chuyển hướng đến trang chủ của user
                        else
                        {
                            // dd($this->Auth->user('email'));
                            if($this->Auth->user('email') === ''){
                                return $this->redirect(['controller' => 'users', 'action' => 'firstlogin']);
                            }
                            return $this->redirect(['controller' => 'subjects', 'action' => 'view_test']);
                        } 
                    }
                    $this->Flash->error("Tài khoản hoặc mật khẩu của bạn chưa đúng!");
                }
            }
            // $this->set('validator',$validator);
            $this->set('user',$login);
        }
    }
    // đăng xuất
    public function logout()
    {
        $this->request->session()->write('Auth.session_id', 0); 
        return $this->redirect($this->Auth->logout());
    }
    // quên mật khẩu
    public function forgotpassword(){
        $this->viewBuilder()->setLayout('login');
        $users = $this->Users->newEntity();
        // tạo 1 mã token và gán cho tài khoản có địa chỉ email nhập vào token này
        // nếu không tài khoản nào đăng ký email này thì thông báo lỗi
        // nếu email tồn tại gửi thư kèm link reset password
        // link reset password có chứa token được gán vào tài khoản
        if ($this->request->is('post')){
            $myemail = $this->request->getData('email');
            $mytoken = Security::hash(Security::randomBytes(25));
            $userTable = TableRegistry::get('Users');
            $user = $userTable->find('all')->where(['email'=>$myemail])->first();
            if(!empty($myemail))
            {
                if(!empty($user))
                {
                    $user->password = '';
                    $user->token = $mytoken;
                    $users = $user;
                    if($userTable->save($users)){
                        $this->Flash->success('địa chỉ thay đổi mật khẩu đã được gửi.');
                        
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
                else $this->Flash->error('Email của bạn không tồn tại');     
            } else $this->Flash->error('Bạn chưa điền đủ thông tin');         
        }
        $this->set(compact('users'));
    }

    // reset password
    public function resetpassword($token){
        $this->viewBuilder()->setLayout('login');
        $users = $this->Users->newEntity();
        // tìm tài khoản muốn reset password bằng token đằng sau link url
        if($this->request->is('post')){
            $cuser = $this->Users->patchEntity($users, $this->request->getData(),['validate' => 'firstlogin']);
            $mypass = $this->request->getData('password');
            $userTable = TableRegistry::get('users');
            $user = $userTable->find('all')->where(['token'=>$token])->first();
            $user->password = $mypass;
            $cuser = $user;
            if(!$users->errors()){
                if($userTable->save($cuser))    
                {  
                    $this->Flash->success(__('Thông tin đã được lưu.'));
                    return $this->redirect(['action'=>'login']);
                }
            }
            else $this->Flash->error('Thông tin chưa được lưu.');
        }
        $this->set(compact('users'));
    }

    // những tài khoản lần đầu đăng nhập sẽ được chuyển hướng tới trang đổi mật khẩu và thêm email để tìm lại mật khẩu sau này
    public function firstlogin()
    {
        $user = $this->Users->get($this->Auth->user('id'), [
            'contain' => ['Subjects']
        ]);
        $check = false;
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->getData(),['validate'=>'firstLogin']);
             // dd($user->errors());
            if ($this->Users->save($user)) {

                $this->Auth->setUser($user);
                $this->Flash->success(__('Thông tin đã được lưu.'));

                return $this->redirect(['controller'=>'users','action' => 'profile']);
            }
            else {
                $check =true;
                // $this->Flash->error($user->errors()['email']['vaildFormat']);
                // debug($user->errors()['email']['vaildFormat']); die;

            }
            if(!$check)
            $this->Flash->error(__('Thông tin chưa được lưu, xin hãy thử lại.'));
        }
        $subjects = $this->Users->Subjects->find('list', ['limit' => 200]);
        $this->set(compact('user', 'subjects'));
    }

    // hiển thị thông tin user
    public function profile()
    {
        $users = $this->paginate($this->Users);
        $user = $this->Users->get($this->Auth->user('id'), [
            'contain' => ['Subjects', 'Tests']
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->getData(),['validate'=>'profile']);
            if ($this->Users->save($user)) {
                $this->Auth->setUser($user);
                $this->Flash->success(__('Thông tin đã được lưu.'));
                return $this->redirect(['controller'=>'users','action' => 'profile']);
            }
            $this->Flash->error(__('Thông tin chưa được lưu, xin hãy thử lại.'));
        }
        $subjects = $this->Users->Subjects->find('list', ['limit' => 200]);
        $tests = $this->Users->Tests->find('list', ['limit' => 200]);
        $this->set(compact('user', 'subjects', 'tests'));
        $this->set(compact('users'));
    }

    // chỉnh sửa thông tin user
    public function editProfile($id = null)
    {
        $this->layout = false;

        if ($this->request->is('ajax')) {
            $data = $this->request->getData();
            $user = $this->Users->get($this->Auth->user('id'), [
                'contain' => ['Subjects', 'Tests']
            ]);
            $this->set(compact('user'));
        }
        
    }

    // đổi mật khẩu
    public function changepassword()
    {
        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $user = $this->Users->patchEntity($this->Users->get($this->Auth->user('id')),
                [
                    'password1' => $this->request->data['password1'],
                    'password2' => $this->request->data['password2'],
                ],['validate'=>'changePassword']);
            if($data['password1'] == '' || $data['password2'] == '' || $data['password3'] == '' )
            { $this->Flash->error(__('Bạn cần điền đầy đủ thông tin')); 
            }
            else{
                if ((new DefaultPasswordHasher)->check($data['password1'],$this->Users->get($this->Auth->user('id'))->password) )
                {
                    if($data['password2'] === $data['password3'])
                    {
                        $user->password = $data['password2'];
                        if ($this->Users->save($user)) {
                            $this->Flash->success(__('Thông tin đã được lưu.'));

                            return $this->redirect(['action' => 'profile']);
                        }
                        $this->Flash->error(__('Thông tin chưa được lưu, xin hãy thử lại.'));
                    } else $this->Flash->error(__('Mật khẩu mới nhập sai'));
                } else $this->Flash->error(__('Mật khẩu cũ không đúng'));
            }
        }
        $this->set(compact('user'));
    }    
}
