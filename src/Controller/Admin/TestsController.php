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
        $tests = $this->paginate($this->Tests->find()->matching('Subjects', function($q) use ($session_id){ return $q->where(['Subjects.session_id' => $session_id]);}));
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
        $test = $this->Tests->get($id, [
            'contain' => ['Subjects', 'TestRooms', 'Users']
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
                    $add->test_id = $id;
                    $check = $users_tests->find()->where(['user_id'=>$key,'test_id'=>$id])->first();
                    // dd($check); die;
                    if(empty($check))
                    {
                        $user_test= $this->Tests->find()->matching('Subjects', function($q) use ($session_id){ return $q->where(['Subjects.session_id' => $session_id]);})->matching('Users', function($q) use ($key){ return $q->where(['Users.id' => $key]);});
                        foreach ($user_test as $key) {
                            if($key->subject_id != $test->subject_id)
                            {
                                if($key->_matchingData['Subjects']->test_day == $test->subject->test_day)
                                {
                                    $start_time = $key->start_time;
                                    $last_time = $key->last_time;
                                    if (($test->start_time > $start_time && $test->start_time < $last_time)||($test->last_time > $start_time && $test->last_time < $last_time) || ($test->start_time == $start_time && $test->last_time == $last_time))
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
          },'limit' => 200])->matching('Subjects', function($q) use ($test){ return $q->where(['Subjects.id' => $test->subject_id]);
        });
        $this->set(compact('test','users'));
        $this->set('add', $add);
    }
    public function autoComplete()
    {
      $this->layout = false;
      $session_id = $this->request->session()->read('Auth.session_id');
      if ($this->request->is('ajax')) {
          $data = $this->request->getData();
          $users = $this->Tests->Users->find('list', ['keyField' => 'id',
        'valueField' => function ($e) {
              return $e->username . '- ' . $e->first_name.' '.$e->last_name ;
          },'limit' => 200,'conditions' => ['or'=>['username LIKE' => '%'.$data['name'].'%','first_name LIKE' => '%'.$data['name'].'%','last_name LIKE' => '%'.$data['name'].'%']]]);
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
        if ($this->request->is('post')) {
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
