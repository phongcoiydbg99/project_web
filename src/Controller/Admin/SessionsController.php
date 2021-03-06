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
        $last_time = $session->last_time;
        $session = $this->request->session();
        $session->write('Auth.session_id', $id); 
        $session->write('Auth.last_time', $last_time); 
        $this->set('session', $session);
        return $this->redirect(['controller'=>'users','action' => 'index']);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    //Thêm 1 kỳ học
    public function add()
    {
        $this->viewBuilder()->setLayout('admin');
        $session = $this->Sessions->newEntity();
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            
            if ($data['start_time'] < $data['last_time'])
            {
                $session = $this->Sessions->patchEntity($session, $this->request->getData());
                $session->year = $data['year']['year'];
                
                if ($this->Sessions->save($session)) {
                    $this->Flash->success(__('Bạn đã lưu thành công.'));

                    return $this->redirect(['action' => 'index']);
                } 
                // else {debug($session->errors()); die;}
                $this->Flash->error(__('Có lỗi xảy ra xin thử lại.'));
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
    //Sửa 1 kỳ học
    public function edit($id = null)
    {
        $this->viewBuilder()->setLayout('admin');
        $session = $this->Sessions->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();
            if ($data['start_time'] < $data['last_time'])
            {
                $session = $this->Sessions->patchEntity($session, $this->request->getData());
                $session->year = $data['year']['year'];
                if ($this->Sessions->save($session)) {
                    $this->Flash->success(__('Bạn đã lưu thành công.'));

                    return $this->redirect(['action' => 'index']);
                } else {debug($session->errors()); die;}
                $this->Flash->error(__('Có lỗi xảy ra xin thử lại.'));
            }
            else $this->Flash->error(__('Thời gian bắt đầu phải nhỏ hơn thời gian kết thúc'));
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
    //Xóa 1 kỳ học
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $session = $this->Sessions->get($id,['contain'=>'Subjects']);
        if ($this->Sessions->delete($session)) {
            $this->Flash->success(__('Xóa thành công'));
        } else {
            $this->Flash->error(__('Xóa thất bại.'));
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
