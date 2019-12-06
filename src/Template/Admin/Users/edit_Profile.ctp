<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>
<?php 
    $myTemplates = [
            // 'formStart' => '<form{{attrs}}>',
            'error' => '<div class="text-danger mt-2">{{content}}</div>',
            'inputContainer' => '<div class="form-group{{required}}">{{content}}<span class="help">{{help}}</span></div>',
            'inputContainerError' => '<div class="form-group {{type}}{{required}}">{{content}}{{error}}</div>',
        ];
    $this->Form->setTemplates($myTemplates);
?>
<?= $this->Form->create($user,['action' => 'profile']) ?>
<fieldset>
        <div class="users form large-9 medium-8 columns content">
                <?php
                    // echo $this->Form->control('username');
                    // echo $this->Form->control('first_name');
                    // echo $this->Form->control('last_name');
                    // echo $this->Form->control('date_birth',['type'=> 'text','id'=>'datepicker','value'=>date("Y-m-d", strtotime($user->date_birth))]);
                    // echo $this->Form->control('class');
                    echo $this->Form->controls(
                            ['username' => ['class' => 'form-control','required' => false,'id' => 'username','label' => ['text'=>'Username']],
                                                
                             'password' => ['class' => 'form-control','required' => false,'id' => 'password','label' => ['text'=>'Password']],
                             'first_name' => ['class' => 'form-control','required' => false,'id' => 'first_name','label' => ['text'=>'First name']],
                             'last_name' => ['class' => 'form-control','required' => false,'id' => 'last_name','label' => ['text'=>'Last name']],
                             'email' => ['class' => 'form-control','required' => false,'id' => 'email','label' => ['text'=>'Email']],
                             'date_birth' => ['class' => 'form-control datepicker','required' => false,'type'=> 'text','value'=>date("Y-m-d", strtotime($user->date_birth)),'label' => ['text'=>'date_birth']],
                             'class' => ['class' => 'form-control','required' => false,'id' => 'class','label' => ['text'=>'Class']],
                            ],['legend' => '']
                        );
                ?>
            
        </div>
</fieldset>
<?= $this->Form->button('Submit',['class'=>'btn btn-primary']) ?>
<?= $this->Form->end() ?>

