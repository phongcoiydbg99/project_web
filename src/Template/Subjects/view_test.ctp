

<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item active">Lịch thi</li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<div class="content">
    <div class="card">
        <div class="card-body">
            <?= $this->Form->control('<i class="fas fa-print"></i> In kết quả',['class'=>'btn btn-primary','type'=> 'button','id'=>'search','label'=>false,'onclick'=>'printTest()']) ?>
            <div class="print_area mt-5" id = 'print_area'>
                <table style="width: 100%; border: none; border-collapse: collapse;">
                    <tr>
                        <td style="width: 40%; text-align: center; vertical-align: top;">
                            <p style="text-transform: uppercase; font-weight: normal; margin: 0; padding: 0; font-size: 12pt;">ĐẠI HỌC QUỐC GIA HÀ NỘI</p>
                            <p style="text-transform:uppercase; margin: 0; padding: 0; font-size:12pt; font-weight:bold;">TRƯỜNG ĐẠI HỌC C&#212;NG NGHỆ</p>
                        </td>
                        <td style="width: 60%; text-align: center; vertical-align: top;">
                            <p style="text-transform: uppercase; font-weight: bold; margin: 0; padding: 0; font-size: 12pt;">CỘNG HÒA XÃ HỘI CHỦ NGHĨA VIỆT NAM</p>
                            <p style="margin: 0; padding: 0; font-weight: bold;">Độc lập - Tự do - Hạnh phúc</p>
                        </td>
                    </tr>
                </table>
                <h1 style="text-align: center; text-transform: uppercase; font-weight: bold; font-size: 14pt; margin: 30px 0 0 0; padding: 0;">KẾT QUẢ ĐĂNG KÝ MÔN HỌC - HỌC KỲ 1 NĂM HỌC 2019-2020</h1>
                <p style="text-align: center; font-weight: bold; margin: 0; padding: 0; font-size: 14pt;">
                    Ngày 1 tháng 12 năm 2019
                </p>
                <table style="width: 100%; border: none; border-collapse: collapse; margin-top: 30px;">
                    <tr>
                        <td>Họ và tên</td>
                        <td><b><?= $this->getRequest()->getSession()->read('Auth.User.first_name') . ' ' . $this->getRequest()->getSession()->read('Auth.User.last_name') ?></b></td>
                        <td>Ngày sinh</td>
                        <td><b><?= date("Y-m-d", strtotime($this->getRequest()->getSession()->read('Auth.User.date_birth')))?></b></td>
                        <td>Mã sinh viên</td>
                        <td><b><?= $this->getRequest()->getSession()->read('Auth.User.username')?></b></td>
                        <td>Lớp</td>
                        <td><b><?= $this->getRequest()->getSession()->read('Auth.User.class')?></b></td>
                    </tr>
                </table>
                <br />
                    <?php 
                        if(empty($subjects->toArray())) {?>
                            <div class=" col-lg-4 container mt-5">
                               <h2>Bạn chưa đăng kí thi</h2>
                                
                            </div>
                    <?php
                        }
                        else {
                    ?>
                    <table class="table  table-bordered table-sm" cellpadding="0" cellspacing="0">
                        <thead class="thead-light">
                        <tr>
                            <th scope="col" colspan=><?= $this->Paginator->sort('code') ?></th>
                            <th scope="col"><?= $this->Paginator->sort('name') ?></th>
                            <th scope="col"><?= $this->Paginator->sort('test_day') ?></th>
                            <th scope="col" class="text-primary">Phòng thi</th>
                            <th scope="col" class="text-primary">Thời gian thi</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($subjects as $subject): ?>
                            <tr>
                                <?php 
                                foreach ($subject->tests as $tests)
                                {
                                    if(!empty($tests->users))
                                    {
                                        foreach ($tests->users as $key)
                                        {
                                            if($key->id == $id)
                                            {?>
                                                <td><?= $subject->code?></td>
                                                <td><?= $subject->name?></td>
                                                <td><?= $subject->test_day->i18nFormat('dd/MM/yyyy')?></td>
                                                <td><?= $tests->test_room->name?></td>
                                                <td><?= date('H:i',strtotime($tests->start_time)).' - '.date('H:i',strtotime($tests->last_time))?></td>
                                <?php       }
                                        }
                                    }
                                }
                                ?>
                                    
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php } ?> 
        </div>
    </div>
    <div class="mb-5 mr-4">
        <?= $this->Html->link('Đăng kí', ['action' => 'index'],['class' => 'btn btn-primary float-right', 'escape' => false]);?> 
    </div>
    </div>
</div>
<br>
<script>
    function printTest()
    {
        var restorepage = document.body.innerHTML;
        var printcontent = document.getElementById('print_area').innerHTML;
        document.body.innerHTML = printcontent;
        window.print();
        document.body.innerHTML = restorepage;
    }
</script>