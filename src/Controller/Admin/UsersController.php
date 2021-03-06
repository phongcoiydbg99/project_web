<?php
namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use Cake\I18n;

require '../vendor/autoload.php';
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

    // hiển thị thông tin sinh viên
    public function index()
    {
        $users = $this->paginate($this->Users->find()->where(['Users.role' => 'user'])->order(['Users.username' => 'ASC']),['limit'=>15]);
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
            'contain' => ['Subjects', 'Tests']
        ]);

        $this->set('user', $user);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */

    // thêm sinh viên
    public function add()
    {
        $user = $this->Users->newEntity();
        $check_edit = false; 
        $session_id = $this->request->session()->read('Auth.session_id');
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            // Xét xem có đăng kí môn nào k
            if(!empty($data['subjects']))
            {
              $key = $data['subjects'];
              unset($data['subjects']);
              $data['subjects']['_ids'] = array();
              // tại data để lưu
              foreach ($key as $index => $value) {
                      if($index == 0) $check_edit = true;
                      array_push($data['subjects']['_ids'],(string)$index);
                  }
              if (!$check_edit)
              {
                $user = $this->Users->patchEntity($user, $data,['validate' => 'add']);
                $user->role = 'user';
                if ($this->Users->save($user)) {
                    $this->Flash->success(__('The user has been saved.'));

                    return $this->redirect(['action' => 'index']);
                }else{
                  $this->Flash->error(__('The user could not be saved. Please, try again.'));
                  // debug($user->errors()); die;
                }
              }
              else $this->Flash->error(__('Môn thi của bạn bị trống'));
            }
            else $this->Flash->error(__('Môn thi của bạn bị trống'));
        }
        $subjects = $this->Users->Subjects->find('list',['keyField' => 'id',
        'valueField' => function ($e) {
              return $e->code . '- ' . $e->name ;
          },'limit' => 200])->where(['Subjects.session_id'=>$session_id]);
        $tests = $this->Users->Tests->find('list', ['limit' => 200]);
        // dd($subjects->toArray());
        $this->set(compact('user', 'subjects', 'tests'));
    }

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */

    // chỉnh sửa thông tin sinh viên
    public function edit($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => ['Subjects']
        ]);
        $session_id = $this->request->session()->read('Auth.session_id');
        $check_edit = false; 
        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();
            if(!empty($data['subjects']))
            {
              // Tạo data
              $key = $data['subjects'];
              unset($data['subjects']);
              $data['subjects']['_ids'] = array();
              foreach ($key as $index => $value) {
                    if($index == 0) $check_edit = true;
                    array_push($data['subjects']['_ids'],(string)$index);
                  }
            }
            // dd($data); die;
            if (!$check_edit)
            {
              $user = $this->Users->patchEntity($user, $data,['validate' => 'add']);
              // dd($user); die;
              if ($this->Users->save($user)) {
                  $this->Flash->success(__('Lưu sinh viên thành công'));

                  return $this->redirect(['action' => 'index']);
              }else{
                $this->Flash->error(__('Có lỗi xảy ra xin thử lại'));
                // debug($user->errors()); die;
              }
            }
            else $this->Flash->error(__('Môn thi của bạn bị trống'));
            
        }
        $subjects = $this->Users->Subjects->find('list',['keyField' => 'id',
        'valueField' => function ($e) {
              return $e->code . '- ' . $e->name ;
          },'limit' => 200])->where(['Subjects.session_id'=>$session_id]);
        $tests = $this->Users->Tests->find('list', ['limit' => 200]);
        $this->set(compact('user', 'subjects', 'tests','session_id'));
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */

    // xóa sinh viên
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);
        if ($this->Users->delete($user)) {
            $this->Flash->success(__('Xóa sinh viên thành công.'));
        } else {
            $this->Flash->error(__('Có lỗi xảy ra xin thử lại.'));
        }

        return $this->redirect(['action' => 'index']);
    }


    public function deleteTest($user_test)
    {
      // Xóa đăng kí môn
        $this->request->allowMethod(['post', 'delete']);
        $user_test = explode(" ",$user_test);
        $time_id = $user_test[1];
        $users_tests = TableRegistry::getTableLocator()->get('users_tests');
        $check = $users_tests->find()->where(['user_id'=> $user_test[0],'test_id'=> $user_test[1]])->first();
        if ($users_tests->delete($check)) {
            $test = $this->Users->Tests->get($user_test[1]);
            if ($test->computer_registered != 0) $test->computer_registered--;
            $this->Users->Tests->save($test);
            $this->Flash->success(__('Bạn đã xóa thành công'));
        } else {
            $this->Flash->error(__('Có lỗi xảy ra, xin thử lại'));
        }
        return $this->redirect(['controller'=>'tests','action' => 'view',$time_id]);
    }
    public function import()
    {
      $users_subjects = TableRegistry::getTableLocator()->get('users_subjects');
      $subjects = TableRegistry::getTableLocator()->get('subjects');
        if (isset($_POST['submit'])) 
        {
            $check_import = $this->request->getData();
            $filename = $check_import['csv']['tmp_name'];
            //xét loại cải file nhận vào
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
            // tạo file excel 
            if (pathinfo($check_import['csv']['name'], PATHINFO_EXTENSION) == 'csv') {
              $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
            } else if (pathinfo($check_import['csv']['name'], PATHINFO_EXTENSION) == 'xlsx'){
              $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
            } else {$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();}
            // ĐỌc file 
            $spreadsheet = $reader->load($filename);
            $worksheet = $spreadsheet->getActiveSheet();
            $i = 0;
            $dem = 0;
            $code = $worksheet->getCellByColumnAndRow(2, 6)->getValue();
            $name = $worksheet->getCellByColumnAndRow(2, 7)->getValue();
            $test_day = $worksheet->getCellByColumnAndRow(6, 7)->getFormattedValue();
            // dd(empty($this->Users->Subjects->find()->where(['code' => $code,'session_id'=>$this->request->session()->read('Auth.session_id')])->toArray()));
            // die;
            $subject = $subjects->newEntity();
            $subject->code = $code;
            $subject->name = $name;
            $subject->test_day = date("Y-m-d", strtotime($test_day));
            $subject->session_id = $this->request->session()->read('Auth.session_id');
            // lưu môn thi
            if($subjects->save($subject))
            {
              foreach ($worksheet->getRowIterator(10) as $row) {
            // Fetch data
                $i++;
                $cellIterator = $row->getCellIterator();
                $cellIterator->setIterateOnlyExistingCells(false);
                $data = [];
                foreach ($cellIterator as $cell) {
                  $data[] = $cell->getFormattedValue();
                }
                // Insert database
                // Lưu sinh viên cùng môn thi
                $user = $this->Users->newEntity();
                $user->username = $data[1];
                $user->password = $data[1];
                $user->role = 'user';
                $vt = strrpos($data[2]," ");
                $user->first_name = substr($data[2],0,$vt);
                $user->last_name = substr($data[2],$vt+1,strlen($data[2]));
                $date = str_replace('/','-',$data[3]);
                $user->date_birth = date("Y-m-d", strtotime($date));
                $user->class = $data[4];
                if ($this->Users->save($user)) 
                {
                  $user_id = $user->id;
                }
                else 
                {
                  $check_user = $this->Users->find()->where(['Users.username' => $user->username])->toArray();
                  $user_id = $check_user[0]['id'];
                }
                if (isset($user_id))
                {
                  $dem++;
                  $users_subject = $users_subjects->newEntity();
                  $users_subject->user_id = $user_id;
                  $users_subject->subject_id = $subject->id;
                  if($data[5] != '') $users_subject->status = 1;

                  $users_subjects->save($users_subject);
                }
              }
              if($i === $dem ){
                $this->Flash->set('Thêm sinh viên và môn học thành công.',['element' =>'success',]);
              } else  $this->Flash->set('Có lỗi xảy ra xin thử lại.',['element' =>'error',]);
            }
            else $this->Flash->set('Môn của bạn bị trùng',['element' =>'error',]);
            
        }
        return $this->redirect(['controller' => 'users', 'action' => 'index']);
    }
    public function export()
    {
        //dd($this->Auth->user());
        
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $spreadsheet->getDefaultStyle()
                    ->getFont()
                    ->setName('Times New Roman')
                    ->setSize(14);
        $sheet->setCellValue('A1', 'ĐẠI HỌC QUỐC GIA HÀ NỘI');            
        $sheet->setCellValue('A2', 'TRƯỜNG ĐẠI HỌC CÔNG NGHỆ');
        $sheet->setCellValue('A4', 'DANH SÁCH TÀI KHOẢN CỦA SINH VIÊN');
        $sheet->mergeCells("A4:G4");
        $sheet->getStyle('A4')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A1')->applyFromArray(['font'=>['bold'=>true]]);
        $sheet->getStyle('A2')->applyFromArray(['font'=>['bold'=>true]]);
        $sheet->getStyle('A4')->applyFromArray(['font'=>['bold'=>true]]);

        $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(5);
        $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(11);
        $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(20);
        $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(15);
        $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(12);
        $spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(20);
        $spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(10);

        $sheet->setCellValue('A5', 'STT');
        $sheet->setCellValue('B5', 'Mã SV');
        $sheet->setCellValue('C5', 'Họ và tên');
        $sheet->setCellValue('D5', 'Mật khẩu');
        $sheet->setCellValue('E5', 'Ngày sinh');
        $sheet->setCellValue('F5', 'Lớp');
        $sheet->setCellValue('G5', 'Chú thích');

        $styleArray = [
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ],
            'borders' => [
                'top' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
                'left' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
                'right' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
                'bottom' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ]
        ];$styleArray1 = [
            'borders' => [
                'top' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
                'left' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
                'right' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
                'bottom' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ]
        ];
        $sheet->getStyle('A5')->applyFromArray($styleArray);
        $sheet->getStyle('B5')->applyFromArray($styleArray);
        $sheet->getStyle('C5')->applyFromArray($styleArray);
        $sheet->getStyle('D5')->applyFromArray($styleArray);
        $sheet->getStyle('E5')->applyFromArray($styleArray);
        $sheet->getStyle('F5')->applyFromArray($styleArray);
        $sheet->getStyle('G5')->applyFromArray($styleArray);
        
        $query = $this->Users->find()->where(['Users.role' => 'user']);
        $i =6;
        foreach ($query as $user)
        {
          $sheet->setCellValue('A'.$i, $i-5);
          $sheet->setCellValue('B'.$i, $user->username);
          $sheet->setCellValue('C'.$i, $user->first_name.' '.$user->last_name);
          $sheet->setCellValue('D'.$i, $user->username);
          $sheet->setCellValue('E'.$i, date("Y-m-d", strtotime($user->date_birth)));
          $sheet->setCellValue('F'.$i, $user->class);
          $sheet->setCellValue('G'.$i, '');
          $sheet->getStyle('A'.$i)->applyFromArray($styleArray);
          $sheet->getStyle('B'.$i)->applyFromArray($styleArray);
          $sheet->getStyle('C'.$i)->applyFromArray($styleArray1);
          $sheet->getStyle('D'.$i)->applyFromArray($styleArray);
          $sheet->getStyle('E'.$i)->applyFromArray($styleArray);
          $sheet->getStyle('F'.$i)->applyFromArray($styleArray);
          $sheet->getStyle('G'.$i)->applyFromArray($styleArray);
          $i++;
        }
        $filename = 'DS_tai_khoan_SV-'.time().'.xls';
        // Redirect output to a client's web browser (Xlsx)
        $writer = new Xls($spreadsheet);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: max-age=0');
        header('Expires: Fri, 11 Nov 2011 11:11:11 GMT');
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
        header('Cache-Control: cache, must-revalidate');
        header('Pragma: public');
        $writer->save('php://output');
   
        // $writer->save(ROOT_UPLOAD_PATH.$fileName); 
        // //redirect(HTTP_UPLOAD_PATH.$fileName); 
        // $filepath = file_get_contents(ROOT_UPLOAD_PATH.$fileName);
        // force_download($fileName, $filepath);
        exit;
        return $this->redirect(['controller' => 'users', 'action' => 'index']);
    }

    public function searchTable()
    {
      $this->layout = false;
      $session_id = $this->request->session()->read('Auth.session_id');
      if ($this->request->is('ajax')) {
          $data = $this->request->getData();
          // Tìm kiểm xem chứa kí tự giống
          $query = $this->Users->find('all',[
              'conditions' => ['or'=>['first_name LIKE' => '%'.$data['name'].'%','last_name LIKE' => '%'.$data['name'].'%','username LIKE' => '%'.$data['name'].'%']]
          ])->where(['Users.role' => 'user']);
          $users = $this->paginate($query,['limit'=>15]);
          $this->set(compact('users'));
      }
    }
    public function autoComplete()
    {
      $this->layout = false;
      $session_id = $this->request->session()->read('Auth.session_id');
      if ($this->request->is('ajax')) {
          $data = $this->request->getData();
          $i = $data['id'];
          $subjects = $this->Users->Subjects->find('list',['keyField' => 'id',
          'valueField' => function ($e) {
                return $e->code . '- ' . $e->name ;
            },'limit' => 200,'conditions' => ['or'=>['code LIKE' => '%'.$data['name'].'%','name LIKE' => '%'.$data['name'].'%']]])->where(['Subjects.session_id'=>$session_id]);
          $this->set(compact('subjects','i'));
      }
    }
    public function addSubjects()
    {
      $session_id = $this->request->session()->read('Auth.session_id');
      $this->layout = false;
      if ($this->request->is('ajax')) {
        $data = $this->request->getData();
        $i = $data['id'];
        $subjects = $this->Users->Subjects->find('list',['keyField' => 'id',
          'valueField' => function ($e) {
                return $e->code . '- ' . $e->name ;
            },'limit' => 200])->where(['Subjects.session_id'=>$session_id]);
        $this->set(compact('subjects','i'));
      }
    }
    public function deleteTests()
    {
      $this->layout = false;
      if ($this->request->is('ajax')) {
          $data = $this->request->getData();
          // Xóa môn học cửa sv
          $users_subjects = TableRegistry::getTableLocator()->get('users_subjects');
          $test = $users_subjects->get($data['id']);
          $users_subjects->delete($test);
      }
    }

    // hiển thị thông tin của admin 
    public function profile()
    {
      $this->viewBuilder()->setLayout('admin');
        $users = $this->paginate($this->Users);
        $user = $this->Users->get($this->Auth->user('id'), [
            'contain' => ['Subjects', 'Tests']
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Auth->setUser($user);
                $this->Flash->success(__('Lưu thông tin thành công.'));

                return $this->redirect(['controller'=>'users','action' => 'profile']);
            }
            $this->Flash->error(__('Có lỗi xảy ra, xin thử lại.'));
        }
        $subjects = $this->Users->Subjects->find('list', ['limit' => 200]);
        $tests = $this->Users->Tests->find('list', ['limit' => 200]);
        $this->set(compact('user', 'subjects', 'tests'));
        $this->set(compact('users'));
    }

    // sửa thông tin admin
    public function editProfile($id = null)
    {
        $this->layout = false;

        if ($this->request->is('ajax')) {
            $data = $this->request->getData();
            $user = $this->Users->get($this->Auth->user('id'), [
                'contain' => ['Subjects', 'Tests']
            ]);
            $this->set(compact('user'));
        }
        
    }
}
