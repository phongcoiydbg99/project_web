<?php
namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;

/**
 * Tests Controller
 *
 * @property \App\Model\Table\TestsTable $Tests
 *
 * @method \App\Model\Entity\Test[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class TestsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Subjects', 'TestRooms']
        ];
        $session_id = $this->request->session()->read('Auth.session_id');
        $tests = $this->paginate($this->Tests->find()->matching('Subjects', function($q) use ($session_id){ return $q->where(['Subjects.session_id' => $session_id]);})->distinct(['start_time','last_time'])->order(['start_time' => 'ASC']));
        $this->set(compact('tests'));
    }

    /**
     * View method
     *
     * @param string|null $id Test id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        // $check_test = explode(" ",$id);
        $test_id = $id;
        $time_id = $session_id = $this->request->session()->read('Auth.time_id');;
        $test = $this->Tests->get($id, [
            'contain' => ['Subjects', 'TestRooms', 'Users','Times']
        ]);
        $session_id = $this->request->session()->read('Auth.session_id');
        $users_tests = TableRegistry::getTableLocator()->get('users_tests');
        $add = $users_tests->newEntity();
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            foreach ($data['user'] as $key => $value)
            {

                if($key != 0)
                {
                    $add->user_id = $key;
                    $add->test_id = $test_id;
                    $check = $users_tests->find()->where(['user_id'=>$key,'test_id'=>$test_id])->first();
                    if(empty($check))
                    {
                      // Danh sách đã đăng kí của sinh viên
                        $user_test= $this->Tests->find()->contain('Times')->matching('Subjects', function($q) use ($session_id){ return $q->where(['Subjects.session_id' => $session_id]);})->matching('Users', function($q) use ($key){ return $q->where(['Users.id' => $key]);});

                        if(!empty($user_test))
                        {
                          // SO sánh thời gian vs các môn mà sinh viên đã đăng kí
                          foreach ($user_test as $key) {
                              if($key->subject_id != $test->subject_id)
                              {
                                  if($key->time->test_day == $test->time->test_day)
                                  {
                                      $start_time = $key->time->start_time;
                                      $last_time = $key->time->last_time;
                                      if (($test->time->start_time > $start_time && $test->time->start_time < $last_time)||($test->time->last_time > $start_time && $test->time->last_time < $last_time) || ($test->time->start_time == $start_time && $test->time->last_time == $last_time))
                                      {
                                          $this->Flash->error("Thời gian đăng ký của sinh viên trùng nhau");
                                          return $this->redirect(['action' => 'view',$id]);
                                      }
                                  }
                              }
                              else 
                              {
                                  $this->Flash->error("Sinh viên đã có môn đăng kí rồi");
                                  return $this->redirect(['action' => 'view',$id]);
                              }                            
                          }
                        } 
                        // thêm tăng chỉ số của số máy
                        $test->computer_registered++;
                        if ($users_tests->save($add))
                        {
                            $this->Tests->save($test);
                            $this->Flash->success(__('Bạn đã thêm thành công'));
                            return $this->redirect(['action' => 'view',$id]);
                        }
                    }
                    else $this->Flash->error(__('Sinh viên bạn thêm đã đăng kí rồi'));
                } else $this->Flash->error(__('Bạn chưa nhập sinh viên'));
            }
        }
        $users = $this->Tests->Users->find('list', ['keyField' => 'id',
        'valueField' => function ($e) {
              return $e->username . '- ' . $e->first_name.' '.$e->last_name ;
          },'limit' => 200])->matching('Subjects', function($q) use ($test){ return $q->where(['Subjects.id' => $test->subject_id,'status'=>0]);
        });
        $this->set(compact('test','users','time_id'));
        $this->set('add', $add);
    }
    public function autoComplete()
    {
      $this->layout = false;
      $session_id = $this->request->session()->read('Auth.session_id');
      if ($this->request->is('ajax')) {
          $data = $this->request->getData();
          $id = $data['id'];
          $users = $this->Tests->Users->find('list', ['keyField' => 'id',
        'valueField' => function ($e) {
              return $e->username . '- ' . $e->first_name.' '.$e->last_name ;
          },'limit' => 200,'conditions' => ['or'=>['username LIKE' => '%'.$data['name'].'%','first_name LIKE' => '%'.$data['name'].'%','last_name LIKE' => '%'.$data['name'].'%']]])->matching('Subjects', function($q) use ($id){ return $q->where(['Subjects.id' => $id,'status'=>0]);});
        $this->set(compact('users'));
      }
    }
    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $test = $this->Tests->newEntity();
        $session_id = $this->request->session()->read('Auth.session_id');
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $data_new = array();
            $data_new = array_merge($data_new,['start_time'=>$data['start_time']]);
            $data_new = array_merge($data_new,['last_time'=>$data['last_time']]);
            
            $test_room = array();
            foreach ($data['testRooms'] as $testRooms) {
              foreach ($testRooms as $key => $value) {
                array_push($test_room,$key);
              }
            }
            $subject = array();
            foreach ($data['subjects'] as $subjects) {
              foreach ($subjects as $key => $value) {
                array_push($subject,$key);
              }
            }
            $n = count($subject);
            for ($i=0; $i < $n; $i++) { 
              $data_save = array();
              $data_save = array_merge($data_save,$data_new);
              $data_save = array_merge($data_save,['test_room_id'=>$test_room[$i]]);
              $data_save = array_merge($data_save,['subject_id'=>$subject[$i]]);
              $test = $this->Tests->patchEntity($test, $data_save);
              if ($this->Tests->save($test)) {
                $this->Flash->success(__('The test has been saved.'));

              }
              $this->Flash->error(__('The test could not be saved. Please, try again.'));
            }
        }
        return $this->redirect(['action' => 'index']);
        $subjects = $this->Tests->Subjects->find('list',['keyField' => 'id',
        'valueField' => function ($e) {
              return $e->code . '- ' . $e->name ;
          },'limit' => 200])->where(['Subjects.session_id'=>$session_id]);
        // dd($subjects->toArray()); die;
        $testRooms = $this->Tests->TestRooms->find('list', ['keyField' => 'id',
        'valueField' => function ($e) {
              return $e->name ;
          },'limit' => 200]);
        $users = $this->Tests->Users->find('list', ['limit' => 200]);
        $this->set(compact('test', 'subjects', 'testRooms', 'users'));
    }

    public function addTests()
    {
      $session_id = $this->request->session()->read('Auth.session_id');
      $this->layout = false;
      if ($this->request->is('ajax')) {
          $data = $this->request->getData();
          $id = $data['id'];
          $subjects = $this->Tests->Subjects->find('list',['keyField' => 'id',
        'valueField' => function ($e) {
              return $e->code . '- ' . $e->name ;
          },'limit' => 200])->where(['Subjects.session_id'=>$session_id]);

          $testRooms = $this->Tests->TestRooms->find('list', ['keyField' => 'id',
        'valueField' => function ($e) {
              return $e->name ;
          },'limit' => 200]);
        $users = $this->Tests->Users->find('list', ['limit' => 200]);
          $this->set(compact('id','subjects','testRooms'));
      }
    }

    public function autoCompleteRoom()
    {
      $this->layout = false;
      $session_id = $this->request->session()->read('Auth.session_id');
      if ($this->request->is('ajax')) {
          $data = $this->request->getData();
          $i = $data['id'];
          $testRooms = $this->Tests->TestRooms->find('list', ['keyField' => 'id',
        'valueField' => function ($e) {
              return $e->name ;
          },'limit' => 200,'conditions' => ['name LIKE' => '%'.$data['name'].'%']]);
          $this->set(compact('testRooms','i'));
      }
    }

    public function autoCompleteSubject()
    {
      $this->layout = false;
      $session_id = $this->request->session()->read('Auth.session_id');
      if ($this->request->is('ajax')) {
          $data = $this->request->getData();
          $i = $data['id'];
          $subjects = $this->Tests->Subjects->find('list',['keyField' => 'id',
          'valueField' => function ($e) {
                return $e->code . '- ' . $e->name ;
            },'limit' => 200,'conditions' => ['or'=>['code LIKE' => '%'.$data['name'].'%','name LIKE' => '%'.$data['name'].'%']]])->where(['Subjects.session_id'=>$session_id]);
          $this->set(compact('subjects','i'));
      }
    }
    /**
     * Edit method
     *
     * @param string|null $id Test id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $test = $this->Tests->get($id, [
            'contain' => ['Users']
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $test = $this->Tests->patchEntity($test, $this->request->getData());
            if ($this->Tests->save($test)) {
                $this->Flash->success(__('The test has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The test could not be saved. Please, try again.'));
        }
        $subjects = $this->Tests->Subjects->find('list', ['limit' => 200]);
        $testRooms = $this->Tests->TestRooms->find('list', ['limit' => 200]);
        $users = $this->Tests->Users->find('list', ['limit' => 200]);
        $this->set(compact('test', 'subjects', 'testRooms', 'users'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Test id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $test = $this->Tests->get($id);
        if ($this->Tests->delete($test)) {
            $this->Flash->success(__('The test has been deleted.'));
        } else {
            $this->Flash->error(__('The test could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
    public function searchTable()
    {
      $this->layout = false;
      $session_id = $this->request->session()->read('Auth.session_id');
      if ($this->request->is('ajax')) {
        $data = $this->request->getData();
        $this->paginate = [
        'contain' => ['Subjects', 'TestRooms']
        ];
        $session_id = $this->request->session()->read('Auth.session_id');
        $tests = $this->paginate($this->Tests->find()->matching('Subjects', function($q) use ($session_id,$data){ return $q->where(['Subjects.session_id' => $session_id,'Subjects.name LIKE'=> '%'.$data['name'].'%']);}));
        $this->set(compact('tests'));
        }
    }
}
