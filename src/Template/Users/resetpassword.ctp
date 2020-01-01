
<?php 
    $myTemplates = [
            // 'formStart' => '<form{{attrs}}>',
            'error' => '<div class="text-danger mt-2">{{content}}</div>',
            'inputContainer' => '<div class="form-group{{required}}">{{content}}<span class="help">{{help}}</span></div>',
            'inputContainerError' => '<div class="form-group is-invalid {{type}}{{required}}">{{content}}{{error}}</div>',
        ];
    $this->Form->setTemplates($myTemplates);
?>
<?php $this->assign('title', 'Request Password Reset'); ?><div class="users content">
    <div class="row">
		<div class="col-lg-4"></div>
		<div class="col-lg-4 mt-sm-5 mt-md-5 border border-light rounded p-3 mb-5 card container">
		    <div class="card-header"><h3><?php echo __('Đặt lại mật khẩu'); ?></h3></div>
		    <div class="card-body">
		    <?php
		        echo $this->Form->create($users);
		        echo $this->Form->control('password', ['autofocus' => true, 'label' => 'Mật khẩu mới', 'required' => true,'class' => 'form-control','placeholder' => 'Nhập password']);
			    echo $this->Form->button('Xác nhận',array('class' =>'btn btn-primary','style'=>'margin-top: 20px;'));
		        echo $this->Form->end();
		    ?>
			</div>
		</div>
	<div class="col-lg-4"></div>
</div>
