
    <div class="row">
		<div class="col-lg-4"></div>
			<div class="col-lg-4 mt-sm-5 mt-md-5 border border-light rounded p-3 mb-5 card container">
		    <div class="card-header"><h3><?php echo __('First login'); ?></h3></div>
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
			  
			        echo $this->Form->create($users);
			        echo $this->Form->controls(
					['email' => ['class' => 'form-control is-invalid','required' => false,'placeholder' => 'Enter email', 'id' => 'email','label' => ['text'=>'Email']],
										
					 'password' => ['class' => 'form-control is-invalid','required' => false,'placeholder' => 'Enter password', 'id' => 'password','label' => ['text'=>'New password']]
					],['legend' => '']
				);
			        echo $this->Form->button('submit',array('class' =>'btn btn-primary','style'=>'margin-top: 20px;'));
			        echo $this->Form->end();
			    ?>
	</div>
	</div>
	<div class="col-lg-4"></div>
</div>
