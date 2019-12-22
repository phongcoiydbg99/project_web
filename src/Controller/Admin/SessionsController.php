<?php
namespace App\Controller\Admin;

use App\Controller\AppController;

/**
 * Sessions Controller
 *
 * @property \App\Model\Table\SessionsTable $Sessions
 *
 * @method \App\Model\Entity\Session[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class SessionsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $this->viewBuilder()->setLayout('admin');
        $sessions = $this->paginate($this->Sessions->find()->order(['year'=>'DESC']),['limit'=>15]);

        $this->set(compact('sessions'));
    }

    /**
     * View method
     *
     * @param string|null $id Session id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $session = $this->Sessions->get($id, [
            'contain' => ['Subjects']
        ]);
        $session = $this->request->session();
        $session->write('Auth.session_id', $id); 
        $this->set('session', $session);
        return $this->redirect(['controller'=>'times','action' => 'index']);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $this->viewBuilder()->setLayout('admin');
        $session = $this->Sessions->newEntity();
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            if ($data['start_time'] < $data['last_time'])
            {
                $session = $this->Sessions->patchEntity($session, $this->request->getData());
                if ($this->Sessions->save($session)) {
                    $this->Flash->success(__('The session has been saved.'));

                    return $this->redirect(['action' => 'index']);
                } else {debug($session->errors()); die;}
                $this->Flash->error(__('The session could not be saved. Please, try again.'));
            }
            else $this->Flash->error(__('Thời gian bắt đầu phải nhỏ hơn thời gian kết thúc'));
        }
        $this->set(compact('session'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Session id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $this->viewBuilder()->setLayout('admin');
        $session = $this->Sessions->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $session = $this->Sessions->patchEntity($session, $this->request->getData());
            if ($this->Sessions->save($session)) {
                $this->Flash->success(__('The session has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The session could not be saved. Please, try again.'));
        }
        $this->set(compact('session'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Session id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $session = $this->Sessions->get($id,['contain'=>'Subjects']);
        if ($this->Sessions->delete($session)) {
            $this->Flash->success(__('The session has been deleted.'));
        } else {
            $this->Flash->error(__('The session could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function radioSession()
    {
        if ($this->request->is('ajax')) {
            $data = $this->request->getData();
            $session = $this->Sessions->find()->where(['choose'=> 1])->first();
            $session->choose = 0;
            $this->Sessions->save($session);
            $session = $this->Sessions->find()->where(['id'=> $data['id']])->first();
            $session->choose = 1;
            $this->Sessions->save($session);
            return $this->redirect(['action' => 'index']);
        }
    }
}
