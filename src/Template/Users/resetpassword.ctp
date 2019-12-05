
<?php $this->assign('title', 'Request Password Reset'); ?><div class="users content">
    <div class="row">
		<div class="col-lg-4"></div>
		<div class="col-lg-4 mt-sm-5 mt-md-5 border border-light rounded p-3 mb-5 card container">
		    <div class="card-header"><h3><?php echo __('Forgot Password'); ?></h3></div>
		    <div class="card-body">
		    <?php
		        echo $this->Form->create();
		        echo $this->Form->input('password', ['autofocus' => true, 'label' => 'New password', 'required' => true,'class' => 'form-control is-invalid','placeholder' => 'Enter password']);
			    echo $this->Form->button('reset',array('class' =>'btn btn-primary','style'=>'margin-top: 20px;'));
		        echo $this->Form->end();
		    ?>
			</div>
		</div>
	<div class="col-lg-4"></div>
</div>
