<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\TestRoom $testRoom
 */
?>
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><?= $this->Html->link(
                ' Phòng thi ',
                '/admin/phong-thi',
                ['escape' => false]
            ) ?></li>
          <li class="breadcrumb-item active">Sửa phòng thi</li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<?php 
    $myTemplates = [
            // 'formStart' => '<form{{attrs}}>',
            'error' => '<div class="text-danger mt-2">{{content}}</div>',
            'inputContainer' => '<div class="form-group{{required}}">{{content}}<span class="help">{{help}}</span></div>',
            'inputContainerError' => '<div class="form-group {{type}}{{required}}">{{content}}{{error}}</div>',
        ];
    $this->Form->setTemplates($myTemplates);
?>
<div class="content">
<div class="testRooms form large-9 medium-8 columns content">
    <?= $this->Form->create($testRoom) ?>
    <fieldset>
        <div class="card">
            <div class="card-header"><h3>Thêm phòng thi</h3></div>
            <div class="card-body">
                <?php
                    echo $this->Form->control('name',['class'=>"form-control ", 'label'=>'Phòng']);
                    echo $this->Form->control('total_computer',['class'=>"form-control ", 'label'=>'Tổng số máy tính']);
                ?> 
            </div>
        </div>
    </fieldset>
    <?= $this->Form->button('Xác nhận',['class'=>'btn btn-primary float-right']) ?>
    <?= $this->Form->end() ?>
</div>
</div>
