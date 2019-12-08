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

        $query = $this->Subjects->find()->contain(['TestRooms','Tests.TestRooms','Tests.Users'])->matching('Users', function($q){ return $q->where(['Users.id' => $this->Auth->user('id')]);
        })->where(['Subjects.session_id'=>$session_id])->order(['Subjects.test_day' => 'ASC']);

        $subjects = $this->paginate($query);
        $id = $this->Auth->user('id');
        $users_tests = TableRegistry::getTableLocator()->get('users_tests');
        $tests = TableRegistry::getTableLocator()->get('tests');
        $test_rooms = TableRegistry::getTableLocator()->get('test_rooms');
        
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $test_times = Array();

            foreach ($data['subject'] as $index => $value) {
                $test_day = date('d:m:Y',strtotime($this->Subjects->get($index)->test_day));
                $start_time = date('H:i',strtotime($tests->get($value)->start_time));
                $last_time = date('H:i',strtotime($tests->get($value)->last_time));

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
            // dd($test_times);
            $check_error = false;
            $q = $users_tests->find()->where(['user_id'=> $this->Auth->user('id')])->toArray();
            $i =0;
            foreach ($data['subject'] as $index => $value) {
                if (!empty($q[$i])) {
                    $users_test = $users_tests->get($q[$i]['id']);
                    $test = $tests->get($q[$i]['test_id']);
                    if ($test->computer_registered != 0) $test->computer_registered--;
                    $tests->save($test);
                }
                else $users_test = $users_tests->newEntity();
                $users_test->user_id = $this->Auth->user('id');
                $users_test->test_id = (int)$value;
                $test = $tests->get($value);
                $test_room = $test_rooms->get($test->test_room_id);
                $test->computer_registered++;
                if($test_room->total_computer >= $test->computer_registered)
                {
                    $tests->save($test);
                    if (!$users_tests->save($users_test)) 
                    { 
                        $check_error = true;
                    }
                }
                else 
                    {
                        $check_error = true;
                        $test = $tests->get($q[$i]['test_id']);
                        $test->computer_registered++;
                        $tests->save($test);
                    }
                $i++;
            }
            if(!$check_error) $this->Flash->success(__('The subject has been saved.'));
            else $this->Flash->error(__('The subject could not be saved. Please, try again.'));
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
        $query = $this->Subjects->find()->contain(['Tests.TestRooms','Tests.Users'])->matching('Users', function($q){ return $q->where(['Users.id' => $this->Auth->user('id')]);
        })->where(['Subjects.session_id'=>$session_id])->order(['Subjects.test_day' => 'ASC']);
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
        if ($this->request->is('ajax')) {
            $data = $this->request->getData();
            $query = $this->Subjects->find()->contain(['TestRooms','Tests.TestRooms','Tests.Users'])->matching('Users', function($q){ return $q->where(['Users.id' => $this->Auth->user('id')]);
            })->where(['Subjects.id'=>$data['subject_id']]);
            $subjects = $this->paginate($query);
            // dd($subjects);
            // dd($data['check_name']);
        $this->set('check_name', $data['check_name']);
        $this->set('subjects', $subjects);
        }
    }
}
