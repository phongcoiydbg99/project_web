<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Session $session
 */
?>
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">Quản lý kì thi</h1>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<?php 
    $myTemplates = [
            // 'formStart' => '<form{{attrs}}>',
            'error' => '<div class="text-danger mt-2">{{content}}</div>',
            'inputContainer' => '<div class="form-group{{required}}">{{content}}<span class="help">{{help}}</span></div>',
            'inputContainerError' => '<div class="form-group is-invalid {{type}}{{required}}">{{content}}{{error}}</div>',
        ];
    $this->Form->setTemplates($myTemplates);
?>
<div class="content">
    <?= $this->Form->create($session) ?>
    <fieldset>
        <div class="sessions form large-9 medium-8 columns content card container">
            <div class="card-header"><h3>Thêm kì thi</h3></div>
            <div class="card-body">
                <?php
                    echo $this->Form->controls(
                        ['name' => ['class' => 'form-control ','required' => false,'id' => 'name','label' => ['text'=>'Tên kì thi:']],
                                            
                         'year' => ['class' => 'form-control ','required' => false,'id' => 'year','label' => ['text'=>'Năm:']],
                         'start_time' => ['class' => 'form-control','required' => false,'type'=> 'text','label' => ['text'=>'Thời gian bắt đầu:']],
                         'last_time' => ['class' => 'form-control','required' => false,'type'=> 'text','label' => ['text'=>'Thời gian kết thúc:']],
                        ],['legend' => '']
                    );
                ?>
            </div>
        </div>
    </fieldset>
    <?= $this->Form->button('Xác nhận',['class'=>'btn btn-primary float-right']) ?>
    <?= $this->Form->end() ?>
</div>
<script>
        $('#start-time').datetimepicker({ uiLibrary: 'bootstrap4',
                format: 'yyyy-mm-dd HH:mm:ss',
                iconsLibrary: 'fontawesome',footer: true, modal: true });
        $('#last-time').datetimepicker({ uiLibrary: 'bootstrap4',
                format: 'yyyy-mm-dd HH:mm:ss',
                iconsLibrary: 'fontawesome',footer: true, modal: true });
</script>