<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;
use Cake\I18n\Time;
use Cake\Datasource\ConnectionManager;
/**
 * Subjects Controller
 *
 *
 * @method \App\Model\Entity\Subject[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class SubjectsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $sessions = TableRegistry::getTableLocator()->get('sessions');
        $session = $sessions->find()->where(['choose'=> 1])->first();
        $session_id = $session['choose'];
        $this->request->session()->write('Auth.session_id', $session_id); 

        $query = $this->Subjects->find()->contain(['Tests.TestRooms','Tests.Users','Tests.Times'])->matching('Users', function($q){ return $q->where(['Users.id' => $this->Auth->user('id')]);
        })->where(['Subjects.session_id'=>$session_id])->order(['Subjects.name' => 'ASC']);

        $subjects = $this->paginate($query);
        // dd($query->toArray());
        $id = $this->Auth->user('id');
        $users_tests = TableRegistry::getTableLocator()->get('users_tests');
        $tests = TableRegistry::getTableLocator()->get('tests');
        $test_rooms = TableRegistry::getTableLocator()->get('test_rooms');
        
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $test_times = Array();

            foreach ($data['subject'] as $index => $value) {
                $test_temp = $this->Subjects->Tests->get($value, [
                    'contain' => ['Times']
                ]);
                $test_day = date('d:m:Y',strtotime($test_temp['time']['test_day']));
                $start_time = date('H:i',strtotime($test_temp['time']['start_time']));
                $last_time = date('H:i',strtotime($test_temp['time']['last_time']));

                if (!empty($test_times))
                {
                    foreach($test_times as $test_time)
                    {
                        if ($test_day == $test_time[0])
                        {
                            if (($start_time > $test_time[1] && $start_time < $test_time[2])||($last_time > $test_time[1]&& $last_time < $test_time[2]) || ($start_time == $test_time[1] && $last_time == $test_time[2]))
                                {
                                    $this->Flash->error("Thời gian đăng ký của bạn trùng nhau");
                                    return $this->redirect(['action' => 'index']);
                                }
                        }
                    }
                }
                array_push($test_times,[$test_day,$start_time,$last_time]); 
            }
            $arr_id = array();
            foreach ($subjects as $subject)
            {
                foreach ($subject->tests as $test)
                    {
                        if(!empty($test->users) && $test->users[0]['id'] === $id)
                        {
                            array_push($arr_id,$test['id']);
                        }
                    }
            }
            // dump($arr_id);
            // dump($data['subject']);
            $check_error = false;
            $check_user_test = $users_tests->find()->where(['user_id'=> $this->Auth->user('id')])->toArray();
            if (!empty($arr_id)) {
                    foreach ($arr_id as $key) {
                        $test = $tests->get($key);
                        if ($test->computer_registered != 0) $test->computer_registered--;
                        $tests->save($test);
                    }
                }
            $user_test_id = '';
            $test_id = '';
            foreach ($data['subject'] as $index => $value) {
                if (!empty($check_user_test)) {
                    foreach ($check_user_test as $key) {
                        if($key['test_id'] == $value) 
                        {
                            $user_test_id = $key['id'];
                        }
                    }
                }

                if ($user_test_id != '') $users_test = $users_tests->get($user_test_id);
                else $users_test = $users_tests->newEntity();

                $users_test->user_id = $this->Auth->user('id');
                $users_test->test_id = (int)$value;

                $test = $tests->get($value);
                $test_room = $test_rooms->get($test->test_room_id);
                $test->computer_registered++;
                if($test_room->total_computer >= $test->computer_registered)
                {
                    $tests->save($test);
                    if ($user_test_id == ''){
                        $test = $tests->get($value);
                        foreach ($arr_id as $key) {
                            $check_test = $tests->get($key);
                            if($check_test->subject_id == $test->subject_id)
                            {
                                $check = $users_tests->find()->where(['user_id'=> $this->Auth->user('id'),'test_id'=> $check_test->id])->first();
                                $users_test = $users_tests->get($check->id);
                                $users_test->test_id = (int)$value;
                            }
                        }
                    }
                    if (!$users_tests->save($users_test)) 
                    { 
                        $check_error = true;
                    }
                }
                else {
                        $check_error = true;
                        $test = $tests->get($value);
                        foreach ($arr_id as $key) {
                            $check_test = $tests->get($key);
                            if($check_test->subject_id == $test->subject_id)
                            {
                                $check_test->computer_registered++;
                                $tests->save($check_test);
                            }
                        }
                        $this->Flash->error('Số lượng đăng kí đầy');
                    }
                $user_test_id = '';
            }
            if(!$check_error) $this->Flash->success(__('Bạn đã đăng ký thành công'));
            return $this->redirect(['action' => 'viewTest']);
        }
        $this->set(compact(['subjects','id','session']));
    }

    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->Auth->allow(['login']);

    }

    /**
     * View method
     *
     * @param string|null $id Subject id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $subject = $this->Subjects->get($id, [
            'contain' => []
        ]);

        $this->set('subject', $subject);
    }
    public function viewTest()
    {
        $sessions = TableRegistry::getTableLocator()->get('sessions');
        $session = $sessions->find()->where(['choose'=> 1])->first();
        $session_id = $session['choose'];
        $query = $this->Subjects->find()->contain(['Tests.TestRooms','Tests.Times','Tests.Users'])->matching('Users', function($q){ return $q->where(['Users.id' => $this->Auth->user('id')]);
        })->where(['Subjects.session_id'=>$session_id])->order(['Subjects.name' => 'ASC']);
        $subjects = $this->paginate($query);
        $id = $this->Auth->user('id');
        $this->set(compact(['subjects','id']));
    }
    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $subject = $this->Subjects->newEntity();
        if ($this->request->is('post')) {
            $subject = $this->Subjects->patchEntity($subject, $this->request->getData(), ['associated' => ['Users']]);
            if ($this->Subjects->save($subject, ['associated' => ['Users']])) {
                $this->Flash->success(__('The subject has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The subject could not be saved. Please, try again.'));
        }
        $this->set(compact('subject'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Subject id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $subject = $this->Subjects->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $subject = $this->Subjects->patchEntity($subject, $this->request->getData());
            if ($this->Subjects->save($subject)) {
                $this->Flash->success(__('The subject has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The subject could not be saved. Please, try again.'));
        }
        $this->set(compact('subject'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Subject id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $subject = $this->Subjects->get($id);
        if ($this->Subjects->delete($subject)) {
            $this->Flash->success(__('The subject has been deleted.'));
        } else {
            $this->Flash->error(__('The subject could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
    public function deleteTest($id = null)
    {
        $users_tests = TableRegistry::getTableLocator()->get('users_tests');
        $this->request->allowMethod(['post', 'delete']);
        $users_test = $users_tests->get($id);
        if ($users_tests->delete($users_test)) {
            $this->Flash->success(__('The subject has been deleted.'));
        } else {
            $this->Flash->error(__('The subject could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
    public function checkBox()
    {
        $this->layout = false;
        if ($this->request->is('ajax')) {
            $data = $this->request->getData();
            $subject_id = $data['subject_id'];
            $test_room_id = $data['test_room_id'];
            $id = $data['id'];
            $subjects = $this->paginate($this->Subjects->find()->contain(['TestRooms'])
            ->matching('TestRooms', function($q) use ($test_room_id){ return $q->where(['TestRooms.id' => $test_room_id]);})
            ->matching('Tests', function($q) use ($id) { return $q->where(['Tests.id' => $id]);}));
            
            $this->set(compact('subjects'));
        }
    }
    public function checkTesttime()
    {
        $this->layout = false;
        $session_id = $this->request->session()->read('Auth.session_id');
        if ($this->request->is('ajax')) {
            $data = $this->request->getData();
            $query = $this->Subjects->find()->contain(['Tests.TestRooms','Tests.Users','Tests.Times'])->matching('Users', function($q){ return $q->where(['Users.id' => $this->Auth->user('id')]);
            })->where(['Subjects.id'=>$data['subject_id'],'Subjects.session_id'=>$session_id]);
            $subjects = $this->paginate($query);
            // dd($subjects);
            // dd($data['check_name']);
        $this->set('check_name', $data['check_name']);
        $this->set('subjects', $subjects);
        }
    }
    public function checkTestday()
    {
        $this->layout = false;
        $session_id = $this->request->session()->read('Auth.session_id');
        if ($this->request->is('ajax')) {
            $data = $this->request->getData();
            $query = $this->Subjects->find()->contain(['Tests.TestRooms','Tests.Users','Tests.Times'])->matching('Users', function($q){ return $q->where(['Users.id' => $this->Auth->user('id')]);
            })->where(['Subjects.id'=>$data['subject_id'],'Subjects.session_id'=>$session_id]);
            $subjects = $this->paginate($query);
            // dd($subjects);
            // dd($data['check_name']);
        $this->set('check_day', $data['check_name']);
        $this->set('subjects', $subjects);
        }
    }
    public function checkTest()
    {
        $this->layout = false;
        $session_id = $this->request->session()->read('Auth.session_id');
        if ($this->request->is('ajax')) {
            $data = $this->request->getData();
            $tests = $this->Subjects->Tests->get($data['id'],['contain'=>'TestRooms'])->toArray();
            $this->set('tests', $tests);
        }
    }
}
