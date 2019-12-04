<div class="row">
	<div class="col-lg-4"></div>
	<div class="col-lg-4 mt-sm-5 mt-md-5 rounded p-3 mb-5 card container">
		<div class="card-header"><h2>Login</h2></div>
		<div class="card-body">
			<?php 

				$myTemplates = [
					// 'formStart' => '<form{{attrs}}>',
					'error' => '<div class="text-danger mt-2">{{content}}</div>',
				    'inputContainer' => '<div class="form-group{{required}}">{{content}}<span class="help">{{help}}</span></div>',
				    'input' => '<input type="{{type}}" name="{{name}}" class="form-control " {{attrs}}/>',
				    'inputContainerError' => '<div class="form-group {{type}}{{required}}">{{content}}{{error}}</div>',
				];

				$this->Form->setTemplates($myTemplates);

				echo $this->Form->create($user);
				// if ($this->Form->isFieldError('username')){
	   //          echo $this->Form->error('username', $validator['username']['_empty']);}
				echo $this->Form->controls(
					['username' => ['class' => 'form-control is-invalid','required' => false,'placeholder' => 'Enter username', 'id' => 'username','label' => ['text'=>'Username']],
										
					 'password' => ['class' => 'form-control is-invalid','required' => false,'placeholder' => 'Enter password', 'id' => 'password','label' => ['text'=>'Password']]
					],['legend' => '']
				);

				echo $this->Form->button('Login',['class' =>'btn btn-primary']);
				echo $this->Html->link('Forgot password',array('controller'=>'Users','action'=>'forgotpassword'),array('style'=>'float: right; margin-top:10px;'));
				echo $this->Form->end();
			?>
		</div>
	</div>
	<div class="col-lg-4"></div>
</div>

