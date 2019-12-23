<?php
namespace App\Controller\Admin;

use App\Controller\AppController;

/**
 * Times Controller
 *
 *
 * @method \App\Model\Entity\Time[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class TimesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Tests','Tests.Subjects','Tests.TestRooms']
        ];
        $session_id = $this->request->session()->read('Auth.session_id');
        $times = $this->paginate($this->Times->find()->where(['Times.session_id'=>$session_id])->order(['test_day'=>'ASC']));

        $this->set(compact('times'));
    }

    /**
     * View method
     *
     * @param string|null $id Time id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $time = $this->Times->get($id, [
            'contain' => ['Tests','Tests.Subjects','Tests.TestRooms'],
        ]);
        $test = $this->Times->Tests->newEntity();
        $session_id = $this->request->session()->read('Auth.session_id');
        if ($this->request->is(['patch', 'post', 'put'])) {
            $time = $this->Times->patchEntity($time, $this->request->getData());
            $time->test_day = $this->request->getData('test_day');
            if ($this->Times->save($time)) {
                $this->Flash->success(__('Ca thi đã được sửa'));

                return $this->redirect(['action' => 'view',$id]);
            }
            $this->Flash->error(__('Kiểu thời gian của bạn không đúng'));
        }
        $subjects = $this->Times->Tests->Subjects->find('list',['keyField' => 'id',
        'valueField' => function ($e) {
              return $e->code . '- ' . $e->name ;
          },'limit' => 200])->where(['Subjects.session_id'=>$session_id]);
        // dd($subjects->toArray()); die;
        $testRooms = $this->Times->Tests->TestRooms->find('list', ['keyField' => 'id',
        'valueField' => function ($e) {
              return $e->name ;
          },'limit' => 200]);
        $this->set(compact('subjects', 'testRooms'));
        $this->set('time', $time);
        $this->set('test', $test);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $time = $this->Times->newEntity();
        $session_id = $this->request->session()->read('Auth.session_id');
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $data_new = array();
            $data_new = array_merge($data_new,['test_day'=>$data['test_day']]);
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
            $data_save = array();
            $tests = array();
            $data_save = array_merge($data_save,$data_new);
            for ($i=0; $i < $n; $i++) { 
              $temp = array();
              $temp = array_merge($temp,['test_room_id'=>$test_room[$i]]);
              $temp = array_merge($temp,['subject_id'=>$subject[$i]]);
              $temp = array_merge($temp,['start_time'=>$data['start_time']]);
              $temp = array_merge($temp,['last_time'=>$data['last_time']]);
              array_push($tests,$temp);
            }
            $data_save = array_merge($data_save,['tests'=>$tests]);
            $check_test = false;
            $check_error = false;
            $test_day =  $data['test_day'];
            $start_time= $data['start_time'];
            $last_time= $data['last_time'];

            for ($i=0; $i < $n; $i++) { 
                $subject_id = $tests[$i]['subject_id'];
                $test_room_id = $tests[$i]['test_room_id'];
                $times = $this->Times->find()->contain(['Tests','Tests.Subjects','Tests.TestRooms'])->where(['Times.test_day'=>$test_day])->matching('Tests', function($q) use($test_room_id){ return $q->where(['Tests.test_room_id' => $test_room_id]);});
                $test_time = array();
                foreach ($times as $check_time) {
                    $test_time[1] = date('H:i',strtotime($check_time['start_time']));
                    $test_time[2] = date('H:i',strtotime($check_time['last_time']));
                    if (($start_time > $test_time[1] && $start_time < $test_time[2])||($last_time > $test_time[1]&& $last_time < $test_time[2]) || ($start_time == $test_time[1] && $last_time == $test_time[2]))
                    {
                        $check_error = true;
                        $check_test = true;
                    }
                }
            }
            if($check_error) $this->Flash->error(__('Thời gian ca thi của bạn đã trùng'));
            else 
            {
                if ($check_error) $this->Flash->error(__('Ca thi vừa thêm của bạn đã trùng'));
                else
                {
                    $time = $this->Times->patchEntity($time, $data_save,['contain' => ['Tests']]);
                    $time->session_id = $session_id;
                    if ($this->Times->save($time)) {
                        $this->Flash->success(__('The time has been saved.'));

                        return $this->redirect(['action' => 'index']);
                    }
                    else{debug($time->errors()); die;}
                    $this->Flash->error(__('The time could not be saved. Please, try again.'));
                }
            }
        }
        $subjects = $this->Times->Tests->Subjects->find('list',['keyField' => 'id',
        'valueField' => function ($e) {
              return $e->code . '- ' . $e->name ;
          },'limit' => 200])->where(['Subjects.session_id'=>$session_id]);
        // dd($subjects->toArray()); die;
        $testRooms = $this->Times->Tests->TestRooms->find('list', ['keyField' => 'id',
        'valueField' => function ($e) {
              return $e->name ;
          },'limit' => 200]);
        $this->set(compact('time','subjects', 'testRooms'));
    }

    public function addTest()
    {
        $time = $this->Times->newEntity();
        $session_id = $this->request->session()->read('Auth.session_id');
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            
            $test_room = '';
            foreach ($data['testRooms'] as $keys=>$testRooms) {
              $id = $keys;
              foreach ($testRooms as $key => $value) {
                $test_room = $key;
              }
            }
            $subject = '';
            foreach ($data['subjects'] as $subjects) {
              foreach ($subjects as $key => $value) {
                $subject= $key;
              }
            }
            $check_test = false;
            $check = $this->Times->get($id, ['contain' => []])->toArray();
            $test_day =  date("Y-m-d", strtotime($check['test_day']));
            $start_time= date('H:i',strtotime($check['start_time']));
            $last_time= date('H:i',strtotime($check['last_time']));
            if(empty($this->Times->Tests->find()->where(['Tests.time_id'=>$id,'Tests.subject_id'=>$subject,'Tests.test_room_id'=>$test_room])->toArray()))
            {
                $time = $this->Times->find()->contain(['Tests','Tests.Subjects','Tests.TestRooms'])->where(['Times.test_day'=>$test_day])->matching('Tests', function($q) use($test_room){ return $q->where(['Tests.test_room_id' => $test_room]);});
                $test_time = array();
                foreach ($time as $check_time) {
                    $test_time[1] = date('H:i',strtotime($check_time['start_time']));
                    $test_time[2] = date('H:i',strtotime($check_time['last_time']));
                    if (($start_time > $test_time[1] && $start_time < $test_time[2])||($last_time > $test_time[1]&& $last_time < $test_time[2]) || ($start_time == $test_time[1] && $last_time == $test_time[2]))
                    {
                        $check_test = true;
                    }
                }
            }
            else $check_test = true;
            if($check_test) $this->Flash->error(__('Ca thi vừa thêm của bạn đã trùng'));
            else
            {
               $test = $this->Times->Tests->newEntity();
               $test->time_id = $id;
               $test->subject_id = $subject;
               $test->test_room_id = $test_room;
                if ($this->Times->Tests->save($test)) {
                    $this->Flash->success(__('Bạn đã thêm thành công'));
                    return $this->redirect(['action' => 'view',$id]);
                }
                else{debug($test->errors()); die;}
                $this->Flash->error(__('The time could not be saved. Please, try again.')); 
            }
            return $this->redirect(['action' => 'view',$id]);
        }
        $subjects = $this->Times->Tests->Subjects->find('list',['keyField' => 'id',
        'valueField' => function ($e) {
              return $e->code . '- ' . $e->name ;
          },'limit' => 200])->where(['Subjects.session_id'=>$session_id]);
        // dd($subjects->toArray()); die;
        $testRooms = $this->Times->Tests->TestRooms->find('list', ['keyField' => 'id',
        'valueField' => function ($e) {
              return $e->name ;
          },'limit' => 200]);
        $this->set(compact('time','subjects', 'testRooms'));
    }
    /**
     * Edit method
     *
     * @param string|null $id Time id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $time = $this->Times->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $time = $this->Times->patchEntity($time, $this->request->getData());
            if ($this->Times->save($time)) {
                $this->Flash->success(__('The time has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The time could not be saved. Please, try again.'));
        }
        $this->set(compact('time'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Time id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $time = $this->Times->get($id);
        if ($this->Times->delete($time)) {
            $this->Flash->success(__('Xóa thành công'));
        } else {
            $this->Flash->error(__('The time could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
    public function deleteTest($id)
    {
        $this->request->allowMethod(['post', 'delete']);
        $check_test = explode(" ",$id);
        $test = $this->Times->Tests->get($check_test[0]);
        if ($this->Times->Tests->delete($test)) {
            $this->Flash->success(__('Xóa thành công'));
        } else {
            $this->Flash->error(__('The test could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'view',$check_test[1]]);
    }
    public function deleteTestByTime()
    {
      $this->layout = false;
      if ($this->request->is('ajax')) {
          $data = $this->request->getData();
          $test = $this->Times->Tests->get($data['id']);
          $this->Times->Tests->delete($test);
      }
    }
    public function searchTable()
    {
      $this->layout = false;
      $session_id = $this->request->session()->read('Auth.session_id');
      if ($this->request->is('ajax')) {
        $data = $this->request->getData();
        $this->paginate = [
            'contain' => ['Tests','Tests.Subjects','Tests.TestRooms']
        ];
        $session_id = $this->request->session()->read('Auth.session_id');
        $times = $this->paginate($this->Times->find()->where(['Times.session_id'=>$session_id,'Times.test_day'=>$data['name']])->order(['test_day'=>'ASC']));
        $this->set(compact('times'));
        }
    }
}
