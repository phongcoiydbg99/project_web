<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Subject $subject
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
                ' Môn thi ',
                '/admin/subjects',
                ['escape' => false]
            ) ?></li>
          <li class="breadcrumb-item active">Sửa môn thi</li>
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
<?= $this->Form->create($subject) ?>
<fieldset>
    <div class="row">
        <div class="col-md-12 col-lg-12">
            <div class="subjects form large-9 medium-8 columns content card">
                <div class="card-header "><h3>Thêm môn thi</h3></div>
                <div class="card-body">
		        <?php
		            echo $this->Form->controls(
                            ['code' => ['class' => 'form-control','required' => false,'id' => 'code','label' => ['text'=>'Mã môn học:']],
                                                
                             'name' => ['class' => 'form-control','required' => false,'id' => 'name','label' => ['text'=>'Tên môn học']],
                            ],['legend' => '']
                        );

		        ?>
		        </div>
		        <div class="card-footer">
		        	<?= $this->Form->button('Xác nhận',['class'=>'btn btn-primary float-right']) ?>
		        </div>
            </div> 
        </div>
    </div>
    </fieldset>
    <?= $this->Form->end() ?>
</div>
