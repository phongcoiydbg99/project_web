<?php
namespace App\Controller\Admin;

use App\Controller\AppController;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 *
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UsersController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $users = $this->paginate($this->Users);
        $import = $this->Users->newEntity();
        
        $this->set('import',$import);
        $this->set(compact('users'));
    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => ['Subjects', 'TestTimes']
        ]);

        $this->set('user', $user);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $subjects = $this->Users->Subjects->find('list', ['limit' => 200]);
        $testTimes = $this->Users->TestTimes->find('list', ['limit' => 200]);
        $this->set(compact('user', 'subjects', 'testTimes'));
    }

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => ['Subjects', 'TestTimes']
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $subjects = $this->Users->Subjects->find('list', ['limit' => 200]);
        $testTimes = $this->Users->TestTimes->find('list', ['limit' => 200]);
        $this->set(compact('user', 'subjects', 'testTimes'));
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);
        if ($this->Users->delete($user)) {
            $this->Flash->success(__('The user has been deleted.'));
        } else {
            $this->Flash->error(__('The user could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
    public function import()
    {
        if (isset($_POST['submit'])) 
        {
            $check_import = $this->request->getData();
            $filename = $check_import['csv']['tmp_name'];
            // // Import uploaded file to Database
            // $handle = fopen($filename, "r");
            // while(($data = fgetcsv($handle)) !== FALSE)
            // {
            //     $user = $this->Users->newEntity();
            //     $user->id = $data[0];
            //     $user->username = $data[1];
            //     $user->password = $data[2];
            //     $user->role = $data[3];
            //     $user->first_name = $data[4];
            //     $user->last_name = $data[5];
            //     $user->date_birth = $data[6];
            //     $user->class = $data[7];
            // if ($this->Users->save($user)) {
            //     $this->Flash->success(__('The user has been saved.'));}
            // else  $this->Flash->error(__('The user could not be saved. Please, try again.'));

            // }
            // 
            if (!isset($filename) || !in_array($check_import['csv']['type'], [
              'text/x-comma-separated-values', 
              'text/comma-separated-values', 
              'text/x-csv', 
              'text/csv', 
              'text/plain',
              'application/octet-stream', 
              'application/vnd.ms-excel', 
              'application/x-csv', 
              'application/csv', 
              'application/excel', 
              'application/vnd.msexcel', 
              'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
            ])) {
              die("Invalid file type");
            }
            require '../vendor/autoload.php';
            
            if (pathinfo($check_import['csv']['name'], PATHINFO_EXTENSION) == 'csv') {
              $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
            } else if (pathinfo($check_import['csv']['name'], PATHINFO_EXTENSION) == 'xlsx'){
              $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
            } else {$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();}
            $spreadsheet = $reader->load($filename);
            $worksheet = $spreadsheet->getActiveSheet();
            $i = 0;
            $dem = 0;
            foreach ($worksheet->getRowIterator() as $row) {
            // Fetch data
              $i++;
              $cellIterator = $row->getCellIterator();
              $cellIterator->setIterateOnlyExistingCells(false);
              $data = [];
              foreach ($cellIterator as $cell) {
                $data[] = $cell->getValue();
              }

              // Insert database
              $user = $this->Users->newEntity();
              $user->id = $data[0];
              $user->username = $data[1];
              $user->password = $data[2];
              $user->role = $data[3];
              $user->first_name = $data[4];
              $user->last_name = $data[5];
              $user->date_birth = $data[6];
              $user->class = $data[7];
              if ($this->Users->save($user)) $dem++;
            }
            if($i === $dem ){
              $this->Flash->set('The user has been saved.',['element' =>'success',]);
            } else  $this->Flash->set('The user could not be saved. Please, try again.',['element' =>'error',]);

        }
        return $this->redirect(['controller' => 'users', 'action' => 'index']);
        
    }
}
