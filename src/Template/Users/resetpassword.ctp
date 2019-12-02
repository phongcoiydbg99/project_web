<?php $this->assign('title', 'Request Password Reset'); ?><div class="users content">
   <?= $this->Flash->render() ?>
    <div class="row">
		<div class="col-lg-4"></div>
			<div class="col-lg-4 mt-sm-5 mt-md-5 border border-light rounded p-3 mb-5">
			    <h3><?php echo __('Forgot Password'); ?></h3>
			    <?php echo $this->flash->render() ?>
			    <?php
			        echo $this->Form->create();
			        echo $this->Form->input('password', ['autofocus' => true, 'label' => 'New password', 'required' => true,'class' => 'form-control is-invalid','placeholder' => 'Enter password']);
			        echo $this->Form->button('reset',array('class' =>'btn btn-primary','style'=>'margin-top: 20px;'));
			        echo $this->Form->end();
			    ?>
	</div>
	<div class="col-lg-4"></div>
</div>
