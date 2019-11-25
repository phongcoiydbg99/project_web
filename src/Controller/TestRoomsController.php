<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * TestRooms Controller
 *
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
            'contain' => []
        ]);

        $this->set('testRoom', $testRoom);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $testRoom = $this->TestRooms->newEntity();
        if ($this->request->is('post')) {
            $testRoom = $this->TestRooms->patchEntity($testRoom, $this->request->getData());
            if ($this->TestRooms->save($testRoom)) {
                $this->Flash->success(__('The test room has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The test room could not be saved. Please, try again.'));
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
    public function edit($id = null)
    {
        $testRoom = $this->TestRooms->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $testRoom = $this->TestRooms->patchEntity($testRoom, $this->request->getData());
            if ($this->TestRooms->save($testRoom)) {
                $this->Flash->success(__('The test room has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The test room could not be saved. Please, try again.'));
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
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $testRoom = $this->TestRooms->get($id);
        if ($this->TestRooms->delete($testRoom)) {
            $this->Flash->success(__('The test room has been deleted.'));
        } else {
            $this->Flash->error(__('The test room could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
