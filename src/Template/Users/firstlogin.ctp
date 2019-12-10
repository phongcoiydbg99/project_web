<div class="content">
    <div class="row">
		<div class="col-lg-4"></div>
			<div class="col-lg-4 mt-sm-5 mt-md-5 border border-light rounded p-3 mb-5 card container">
		    <div class="card-header"><h3><?php echo __('Chỉnh sửa thông tin'); ?></h3></div>
		    <div class="card-body">
		    	<?php
				$myTemplates = [
					// 'formStart' => '<form{{attrs}}>',
					'error' => '<div class="text-danger mt-2">{{content}}</div>',
				    'inputContainer' => '<div class="form-group{{required}}">{{content}}<span class="help">{{help}}</span></div>',
				    'inputContainerError' => '<div class="form-group {{type}}{{required}}">{{content}}{{error}}</div>',
				];

				$this->Form->setTemplates($myTemplates);
			  
			        echo $this->Form->create($user);
			        echo $this->Form->controls(
					['email' => ['class' => 'form-control','required' => false,'placeholder' => 'Nhập email', 'id' => 'email','label' => ['text'=>'Email']],
										
					 'password' => ['class' => 'form-control','required' => false,'placeholder' => 'Nhập password', 'id' => 'password','label' => ['text'=>'Mật khẩu mới']]
					],['legend' => '']
				);
			        echo $this->Form->button('Xác nhận',array('class' =>'btn btn-primary','style'=>'margin-top: 20px;'));
			        echo $this->Form->end();
			    ?>
			</div>
			</div>
		<div class="col-lg-4"></div>
	</div>
</div>
