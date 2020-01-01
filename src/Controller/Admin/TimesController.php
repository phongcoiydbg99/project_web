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
        $times = $this->paginate($this->Times->find()->where(['Times.session_id'=>$session_id])->order(['test_day'=>'ASC']),['limit'=>15]);

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
        //Lấy id và last-time của session
        $session_id = $this->request->session()->read('Auth.session_id');
        $session_last_time = $this->request->session()->read('Auth.last_time');
        $session_last_time = date("Y-m-d", strtotime($session_last_time));
        if ($this->request->is(['patch', 'post', 'put'])) {
            $last_time = $this->request->getData('test_day');
            $data = $this->request->getData();
            // Ngày phải lớn hơn ngày cuối cùng đang kí
            if($session_last_time < $last_time)
            {
              $check = false;
              $test_day =  $data['test_day'];
              $start_time= $data['start_time'];
              $last_time= $data['last_time'];
              //Tìm ngày đã đang kí và so sánh
              $check_times = $this->Times->find()->where(['test_day'=>$data['test_day']]);
              foreach ($check_times as $check_time) {
                if($check_time->id != $id)
                {
                  $test_time[1] = date('H:i',strtotime($check_time['start_time']));
                  $test_time[2] = date('H:i',strtotime($check_time['last_time']));
                  // dump($test_time[1].' '.$test_time[2]);
                  if (($start_time > $test_time[1] && $start_time < $test_time[2])||($last_time > $test_time[1]&& $last_time < $test_time[2]) || ($start_time == $test_time[1] && $last_time == $test_time[2]))
                  {
                      $check = true;
                  }
                }
              }
              // die;
              if (!$check)
              {
                $time = $this->Times->patchEntity($time, $this->request->getData());
                $time->test_day = $this->request->getData('test_day');
                if ($this->Times->save($time)) {
                    $this->Flash->success(__('Ca thi đã được sửa'));

                    return $this->redirect(['action' => 'view',$id]);
                }
                $this->Flash->error(__('Kiểu thời gian của bạn không đúng'));
              } else $this->Flash->error(__('Ca thi đã trùng'));
            } else  $this->Flash->error(__('Thời gian thi nhỏ hơn thời gian đăng ký'));
        }
        // Lấy danh sách môn thi và phòng thi
        $subjects = $this->Times->Tests->Subjects->find('list',['keyField' => 'id',
        'valueField' => function ($e) {
              return $e->code . '- ' . $e->name ;
          },'limit' => 200])->where(['Subjects.session_id'=>$session_id]);
        // dd($subjects->toArray()); die;
        $testRooms = $this->Times->Tests->TestRooms->find('list', ['keyField' => 'id',
        'valueField' => function ($e) {
              return $e->name ;
          },'limit' => 200]);

        $session = $this->request->session();
        $session->write('Auth.time_id', $id);

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
        $session_last_time = $this->request->session()->read('Auth.last_time');
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $session_last_time = date("Y-m-d", strtotime($session_last_time));
            // dd($data); die;
            // Điều kiện ngày thếm lớn hơn ngày cuối cùng đăng kí
            if($session_last_time < $data['test_day'])
            {
              $data_new = array();
              $data_new = array_merge($data_new,['test_day'=>$data['test_day']]);
              $data_new = array_merge($data_new,['start_time'=>$data['start_time']]);
              $data_new = array_merge($data_new,['last_time'=>$data['last_time']]);
              //Lập mảng phòng thi
              $test_room = array();
              foreach ($data['testRooms'] as $testRooms) {
                foreach ($testRooms as $key => $value) {
                  array_push($test_room,$key);
                }
              }
              //Lập bảng môn thi
              $subject = array();
              foreach ($data['subjects'] as $subjects) {
                foreach ($subjects as $key => $value) {
                  array_push($subject,$key);
                }
              }
              $n = count($subject);
              $data_save = array();
              $tests = array();
              // Tạo data import vào ca thi
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
              // So sánh trùng thời gian các ca thi
              for ($i=0; $i < $n; $i++) { 
                  $subject_id = $tests[$i]['subject_id'];
                  $test_room_id = $tests[$i]['test_room_id'];
                  // Danh sách ca thi cùng ngày thi
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
            }else  $this->Flash->error(__('Thời gian thi nhỏ hơn thời gian đăng ký'));
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
            // Xét điều kiện có ca nào trùng hay trùng phòng hay không
            if(empty($this->Times->Tests->find()->where(['Tests.time_id'=>$id,'Tests.subject_id'=>$subject,'Tests.test_room_id'=>$test_room])->toArray()) && empty($this->Times->Tests->find()->where(['Tests.time_id'=>$id,'Tests.test_room_id'=>$test_room])->toArray()))
            {
                $time = $this->Times->find()->contain(['Tests','Tests.Subjects','Tests.TestRooms'])->where(['Times.test_day'=>$test_day])->matching('Tests', function($q) use($test_room){ return $q->where(['Tests.test_room_id' => $test_room]);});
                $test_time = array();
                // Xét điều kiện thời gian xem có trùng nhau hay k
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
               //Lưu môn thi cào ca thi
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
            $data = $this->request->getData();
            $check = false;
            $test_day =  $data['test_day'];
            $start_time= $data['start_time'];
            $last_time= $data['last_time'];
            $check_times = $this->Times->find()->where(['test_day'=>$data['test_day']]);
            foreach ($check_times as $check_time) {
              if($check_time->test_day == $data['test_day'])
              {
                $test_time[1] = date('H:i',strtotime($check_time['start_time']));
                $test_time[2] = date('H:i',strtotime($check_time['last_time']));
                if (($start_time > $test_time[1] && $start_time < $test_time[2])||($last_time > $test_time[1]&& $last_time < $test_time[2]) || ($start_time == $test_time[1] && $last_time == $test_time[2]))
                {
                    $check = true;
                }
              }
            }
            if (!$check)
            {
              $time = $this->Times->patchEntity($time, $this->request->getData());
              if ($this->Times->save($time)) {
                  $this->Flash->success(__('Ca thi đã sửa thành công.'));

                  return $this->redirect(['action' => 'index']);
              }
              $this->Flash->error(__('Xảy ra lỗi yêu cầu nhập lại'));
            }
            else $this->Flash->error(__('Ca thi đã trùng'));
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
    public function export()
    {
        //dd($this->Auth->user());
        $session_id = $this->request->session()->read('Auth.session_id');
        $query = $this->Times->find()->contain(['Tests','Tests.Users','Tests.Subjects','Tests.TestRooms'])->where(['Times.session_id' => $session_id])->order((['test_day' => 'ASC','start_time' => 'ASC']));
        // dd($query->toArray());die;
        $spreadsheet = new Spreadsheet();
        $id = 0;
        foreach ($query as $time)
        {
          $spreadsheet->createSheet();
          $sheet = $spreadsheet->setActiveSheetIndex($id);
          $spreadsheet->getActiveSheet()->setTitle(date("Y-m-d", strtotime($time->test_day)));
          $spreadsheet->getDefaultStyle()
                      ->getFont()
                      ->setName('Times New Roman')
                      ->setSize(14);
          $sheet->setCellValue('A1', 'ĐẠI HỌC QUỐC GIA HÀ NỘI');            
          $sheet->setCellValue('A2', 'TRƯỜNG ĐẠI HỌC CÔNG NGHỆ');
          $sheet->setCellValue('A4', 'Ngày thi:');
          $sheet->mergeCells('A4:B4');
          $sheet->setCellValue('C4', date("Y-m-d", strtotime($time->test_day)));
          $sheet->setCellValue('D4', 'Thời gian bắt đầu:');
          $sheet->setCellValue('E4', date('H:i',strtotime($time->start_time)));
          $sheet->setCellValue('D5', 'Thời gian kết thúc:');
          $sheet->setCellValue('E5', date('H:i',strtotime($time->last_time)));
          $sheet->setCellValue('A7', 'DANH SÁCH CA THI CỦA SINH VIÊN');
          $sheet->mergeCells("A7:F7");
          $sheet->getStyle('A7')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
          $sheet->getStyle('C4')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
          $sheet->getStyle('E4')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
          $sheet->getStyle('E5')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
          $sheet->getStyle('A1')->applyFromArray(['font'=>['bold'=>true]]);
          $sheet->getStyle('A2')->applyFromArray(['font'=>['bold'=>true]]);
          $sheet->getStyle('A4')->applyFromArray(['font'=>['bold'=>true]]);
          $sheet->getStyle('D4')->applyFromArray(['font'=>['bold'=>true]]);
          $sheet->getStyle('D5')->applyFromArray(['font'=>['bold'=>true]]);
          $sheet->getStyle('A7')->applyFromArray(['font'=>['bold'=>true]]);

          $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(5);
          $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(11);
          $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(20);
          $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(18);
          $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(20);
          $spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(10);

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
          $k = 9;
          foreach ($time->tests as $tests)
          {
            $sheet->setCellValue('A'.$k, 'Môn thi');
            $sheet->getStyle('A'.$k)->applyFromArray(['font'=>['bold'=>true]]);
            $sheet->mergeCells('A'.$k.':B'.$k);
            $sheet->setCellValue('C'.$k, $tests->subject->name);
            $sheet->setCellValue('D'.$k, 'Phòng thi');
            $sheet->getStyle('D'.$k)->applyFromArray(['font'=>['bold'=>true]]);
            $sheet->setCellValue('E'.$k, $tests->test_room->name);
            $k = $k + 2;
            $sheet->setCellValue('A'.$k, 'STT');
            $sheet->setCellValue('B'.$k, 'Mã SV');
            $sheet->setCellValue('C'.$k, 'Họ và tên');
            $sheet->setCellValue('D'.$k, 'Ngày sinh');
            $sheet->setCellValue('E'.$k, 'Lớp');
            $sheet->setCellValue('F'.$k, 'Chú thích');

            
            $sheet->getStyle('A'.$k)->applyFromArray($styleArray);
            $sheet->getStyle('B'.$k)->applyFromArray($styleArray);
            $sheet->getStyle('C'.$k)->applyFromArray($styleArray);
            $sheet->getStyle('D'.$k)->applyFromArray($styleArray);
            $sheet->getStyle('E'.$k)->applyFromArray($styleArray);
            $sheet->getStyle('F'.$k)->applyFromArray($styleArray);
            $i = $k+1;
            foreach ($tests->users as $user)
            {
              $sheet->setCellValue('A'.$i, $i-5);
              $sheet->setCellValue('B'.$i, $user->username);
              $sheet->setCellValue('C'.$i, $user->first_name.' '.$user->last_name);
              $sheet->setCellValue('D'.$i, date("Y-m-d", strtotime($user->date_birth)));
              $sheet->setCellValue('E'.$i, $user->class);
              $sheet->setCellValue('F'.$i, '');
              $sheet->getStyle('A'.$i)->applyFromArray($styleArray);
              $sheet->getStyle('B'.$i)->applyFromArray($styleArray);
              $sheet->getStyle('C'.$i)->applyFromArray($styleArray1);
              $sheet->getStyle('D'.$i)->applyFromArray($styleArray);
              $sheet->getStyle('E'.$i)->applyFromArray($styleArray);
              $sheet->getStyle('F'.$i)->applyFromArray($styleArray);
              $i++;
            }
            $k = $i+3;
          }
          $id++;
        }
        $filename = 'Lich_thi-'.time().'.xls';
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
}
