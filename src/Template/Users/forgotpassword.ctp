<?php $this->assign('title', 'Request Password Reset'); ?><div class="users content">
    <div class="row">
		<div class="col-lg-4"></div>
		<div class="col-lg-4 mt-sm-5 mt-md-5 border border-light rounded p-3 mb-5 card container">
		    <div class="card-header"><h3><?php echo __('Quên mật khẩu'); ?></h3></div>
		    <div class="card-body">
		    <?php
		        echo $this->Form->create();
		        echo $this->Form->input('email', ['autofocus' => true, 'label' => 'Địa chỉ email', 'required' => false,'class' => 'form-control is-invalid','placeholder' => 'Nhập Email']);
		        echo $this->Form->button('Xác nhận',array('class' =>'btn btn-primary','style'=>'margin-top: 20px;'));
		        echo $this->Form->end();
		    ?>
			</div>
		</div>
	<div class="col-lg-4"></div>
</div>
