<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><?= $this->Html->link(
                    ' Trang chủ ',
                    '/',
                    ['escape' => false]
                ) ?></li>
          <li class="breadcrumb-item active">Hồ sơ</li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<div class="content">
    <div class="row">
        <div class="col-lg-3"></div>
            <div class="col-lg-6 border border-light rounded p-3 mb-5 card container">

            <div class="card-header"><h3><?php echo __('Đổi mật khẩu'); ?></h3></div>
            <div class="card-body">
                <?php
                $myTemplates = [
                    'error' => '<div class="text-danger mt-2">{{content}}</div>',
                    'inputContainer' => '<div class="form-group{{required}}">{{content}}<span class="help">{{help}}</span></div>',
                    'inputContainerError' => '<div class="form-group {{type}}{{required}}">{{content}}{{error}}</div>',
                ];

                $this->Form->setTemplates($myTemplates);
              
                    echo $this->Form->create($user);
                    
                    echo $this->Form->controls(
                        [                             
                         'password1' => ['type'=>'password','class' => 'form-control ','required' => false,'id' => 'password1','label' => ['text'=>'Mật khẩu cũ:']],
                         'password2' => ['type'=>'password','class' => 'form-control ','required' => false,'id' => 'password2','label' => ['text'=>'Mật khẩu mới:']],
                         'password3' => ['type'=>'password','class' => 'form-control ','required' => false,'id' => 'password3','label' => ['text'=>'Nhập lại mật khẩu:']],
                        ],['legend' => '']
                    );
                    echo $this->Form->button('Xác nhận',array('class' =>'btn btn-primary','style'=>'margin-top: 20px;'));
                    echo $this->Form->end();
                ?>
            </div>
            </div>
        <div class="col-lg-3"></div>
    </div>
</div>
