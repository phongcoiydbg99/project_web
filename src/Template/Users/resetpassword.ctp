<?php $this->assign('title', 'Request Password Reset'); ?><div class="users content">
    <h3><?php echo __('Reset Password'); ?></h3>
    <?php echo $this->flash->render() ?>
    <?php
        echo $this->Form->create();
        echo $this->Form->input('password', ['autofocus' => true, 'label' => 'New password', 'required' => true]);
        echo $this->Form->button('reset password');
        echo $this->Form->end();
    ?>
</div>