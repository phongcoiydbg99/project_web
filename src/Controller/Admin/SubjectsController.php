<?php
namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\Event\Event;
/**
 * Subjects Controller
 *
 * @property \App\Model\Table\SubjectsTable $Subjects
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
        $subjects = $this->paginate($this->Subjects);

        $this->set(compact('subjects'));
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
            'contain' => ['TestRooms', 'Users']
        ]);

        $this->set('subject', $subject);
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
            $data = $this->request->getData();
            $subject = $this->Subjects->patchEntity($subject, $this->request->getData());
            $check_tests = $this->Subjects->find()->contain(['Tests'])
            ->where(['Subjects.test_day' => $data['test_day']]);
            $check_time = false;
            foreach ($data['tests'] as $key) {
                if ($key['start_time'] < $key['last_time'])
                {
                    foreach ($check_tests as $check_test) {
                        foreach ($check_test->tests as $test) {
                            $start_time = date('H:i',strtotime($test->start_time));
                            $last_time = date('H:i',strtotime($test->last_time));
                            if ($test->test_room_id == $key['test_room_id'])
                            {
                              if (($key['start_time'] > $start_time && $key['start_time']  < $last_time)||($key['last_time']  > $start_time&& $key['last_time']  < $last_time) || ($key['start_time']  == $start_time && $key['last_time']  == $last_time))
                                {
                                    $check_time = true;
                                    $this->Flash->error("Thời gian đăng ký của bạn trùng với môn: ".$check_test->code);
                                }  
                            }
                        }                
                    }
                }
                else 
                {
                    $check_time = true;
                    $this->Flash->error("Thời gian bắt đầu lớn hơn thời gian kết thúc.");
                }
            }
            if ($check_time)
            {
                // $this->Flash->error("Thời gian đăng ký của bạn trùng nhau");
            }
            else
            {
               if ($this->Subjects->save($subject)) {
                $this->Flash->success(__('The subject has been saved.'));

                return $this->redirect(['action' => 'index']);
                }
                $this->Flash->error(__('The subject could not be saved. Please, try again.')); 
            }
        }
        $testRooms = $this->Subjects->TestRooms->find('list', ['limit' => 200]);
        $users = $this->Subjects->Users->find('list', ['limit' => 200]);
        $this->set(compact('subject', 'testRooms', 'users'));
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
            'contain' => ['Tests']
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();
            $tests = $subject->tests;

            $check_tests = $this->Subjects->find()->contain(['Tests'])
            ->where(['Subjects.test_day' => $data['test_day'],'Subjects.id !='=> $id]);

            $check_time = false;


            if(!empty($data['tests']))
            {
              $i = 0;
              foreach ($data['tests'] as $key) {
                
                if ($key['start_time'] < $key['last_time'])
                {
                  $st = date('H:i:s',strtotime($key['start_time']));
                  $lt = date('H:i:s',strtotime($key['last_time']));
                  $temp = $this->Subjects->find()
                              ->matching('Tests', function($q) use ($st,$lt){ 
                                    return $q->where(['Tests.start_time' => $st,'Tests.last_time'=> $lt]);})->first();
                  if (!empty($temp)) 
                  {
                    $data['tests'][$i] = array_merge($key,['id'=> $temp->_matchingData['Tests']['id']]);
                  }            
                  
                    foreach ($check_tests as $check_test) {
                        foreach ($check_test->tests as $test) {
                            $start_time = date('H:i',strtotime($test->start_time));
                            $last_time = date('H:i',strtotime($test->last_time));
                            if ($test->test_room_id == $key['test_room_id'])
                            {
                              if (($key['start_time'] > $start_time && $key['start_time']  < $last_time)||($key['last_time']  > $start_time&& $key['last_time']  < $last_time) || ($key['start_time']  == $start_time && $key['last_time']  == $last_time))
                                {
                                    $check_time = true;
                                    $this->Flash->error("Thời gian đăng ký của bạn trùng với môn: ".$check_test->code);
                                }  
                            }
                            if (!$check_time)
                            {
                              
                            }
                        }                
                    }
                  }
                  else 
                  {
                      $check_time = true;
                      $this->Flash->error("Thời gian bắt đầu lớn hơn thời gian kết thúc.");
                  }
                $i++;
              }  
            }
                  // dd($data); 
            
            if ($check_time)
            {
                // $this->Flash->error("Thời gian đăng ký của bạn trùng nhau");
            }
            else
            {
                $subject = $this->Subjects->patchEntity($subject, $data);
                // dd($subject->toArray());
                if ($this->Subjects->save($subject)) {
                    $this->Flash->success(__('The subject has been saved.'));
                    // foreach ($tests as $test) {
                    //     $this->Subjects->Tests->delete($test);
                    // }
                    return $this->redirect(['action' => 'index']);
                }
                $this->Flash->error(__('The subject could not be saved. Please, try again.'));
            }
        }
        $testRooms = $this->Subjects->TestRooms->find('list', ['limit' => 200]);
        $users = $this->Subjects->Users->find('list', ['limit' => 200]);
        $this->set(compact('subject', 'testRooms', 'users'));
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
    public function addTests()
    {
        $this->layout = false;
        if ($this->request->is('ajax')) {
            $data = $this->request->getData();
            $id = $data['id'];
            $testRooms = $this->Subjects->TestRooms->find('list', ['limit' => 200]);
            $this->set(compact('testRooms','id'));
        }
    }
    public function searchTable()
    {
      $this->layout = false;
      if ($this->request->is('ajax')) {
          $data = $this->request->getData();
          $query = $this->Subjects->find('all',[
              'conditions' => ['name LIKE' => '%'.$data['name'].'%']
          ]);
          $subjects = $this->paginate($query);
          $this->set(compact('subjects'));
      }
    }
    public function deleteTests()
    {
      $this->layout = false;
      if ($this->request->is('ajax')) {
          $data = $this->request->getData();
          $test = $this->Subjects->Tests->get($data['id']);
          $this->Subjects->Tests->delete($test);
      }
    }
}
