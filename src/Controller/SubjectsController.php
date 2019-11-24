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
        $query = $this->Subjects->find()->contain(['TestRooms','Tests','Tests.Users'])->matching('Users', function($q){ return $q->where(['Users.id' => $this->Auth->user('id')]);
        });
        $subjects = $this->paginate($query);
        $id = $this->Auth->user('id');
        // $query = TableRegistry::getTableLocator()->get('users_tests');
        // dd($users_tests);
        foreach ( $subjects as $subject)
        {
            $i = 0;
            foreach ($subject->tests as $tests)
            {
                
                // dump($tests['users'][0]['_joinData']['id']);
                // dd($this->paginate($this->Subjects->find()->contain(['TestRooms','Tests'])->join([
                //     'u' => [
                //         'table' => 'users_tests',
                //         'type' => 'LEFT',
                //         'conditions' => 'u.test_id = Tests.id',
                //     ]
                // ])->matching('Users', function($q){ return $q->where(['Users.id' => $this->Auth->user('id')]);})->matching('Tests')
                // ));
                $i++;
            }
        }
        $users_tests = TableRegistry::getTableLocator()->get('users_tests');
        $tests = TableRegistry::getTableLocator()->get('tests');
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            foreach ($data['subject'] as $index => $value) {
                $q = $users_tests->find()->where(['user_id'=> $this->Auth->user('id'),'test_id' => $index]);
                if (empty($q->toArray())){
                    $users_test = $users_tests->newEntity();
                    $users_test->user_id = $this->Auth->user('id');
                    $users_test->test_id = $index;
                    if ($users_tests->save($users_test)) {
                    $this->Flash->success(__('The subject has been saved.'));
                    }
                    else $this->Flash->error(__('The subject could not be saved. Please, try again.'));
                } 
            }
            return $this->redirect(['action' => 'index']);
        }
        $this->set(compact(['subjects','id']));
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
}
