<?php
namespace App\Controller\Admin;

use App\Controller\AppController;

/**
 * TestRooms Controller
 *
 * @property \App\Model\Table\TestRoomsTable $TestRooms
 *
 * @method \App\Model\Entity\TestRoom[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class TestRoomsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    //Xem thông tin các phòng thi
    public function index()
    {
        $testRooms = $this->paginate($this->TestRooms);

        $this->set(compact('testRooms'));
    }

    /**
     * View method
     *
     * @param string|null $id Test Room id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $testRoom = $this->TestRooms->get($id, [
            'contain' => ['Tests']
        ]);

        $this->set('testRoom', $testRoom);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    //Thêm 1 phòng thi
    public function add()
    {
        $testRoom = $this->TestRooms->newEntity();
        if ($this->request->is('post')) {
            $testRoom = $this->TestRooms->patchEntity($testRoom, $this->request->getData());
            if ($this->TestRooms->save($testRoom)) {
                $this->Flash->success(__('Đã thêm phòng thi.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Thêm phòng thi bị lỗi. Xin thử lại!'));
        }
        $this->set(compact('testRoom'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Test Room id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    
    //Sửa thông tin về 1 phòng thi
    public function edit($id = null)
    {
        $testRoom = $this->TestRooms->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $testRoom = $this->TestRooms->patchEntity($testRoom, $this->request->getData());
            if ($this->TestRooms->save($testRoom)) {
                $this->Flash->success(__('Sửa phòng thi thành công.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Sửa phòng thi thất bại. Xin thử lại!'));
        }
        $this->set(compact('testRoom'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Test Room id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */

    //Xóa 1 phòng thi
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $testRoom = $this->TestRooms->get($id);
        if ($this->TestRooms->delete($testRoom)) {
            $this->Flash->success(__('Xóa thành công.'));
        } else {
            $this->Flash->error(__('Xóa thất bại. Xin thử lại!'));
        }

        return $this->redirect(['action' => 'index']);
    }
    public function searchTable()
    {
      $this->layout = false;
      if ($this->request->is('ajax')) {
          $data = $this->request->getData();
          $query = $this->TestRooms->find('all',[
              'conditions' => ['name LIKE' => '%'.$data['name'].'%']
          ]);
          $testRooms = $this->paginate($query);
          $this->set(compact('testRooms'));
      }
    }
}
