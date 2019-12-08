<div class="content">
    <div class="row">
        <div class="col-lg-3"></div>
            <div class="col-lg-6 mt-sm-5 mt-md-5 border border-light rounded p-3 mb-5 card container">
            <div class="card-header"><h3><?php echo __('Chỉnh sửa thông tin'); ?></h3></div>
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
                         'password3' => ['type'=>'password','class' => 'form-control ','required' => false,'id' => 'password3','label' => ['Nhập lại mật khẩu:']],
                        ],['legend' => '']
                    );
                    echo $this->Form->button('submit',array('class' =>'btn btn-primary','style'=>'margin-top: 20px;'));
                    echo $this->Form->end();
                ?>
            </div>
            </div>
        <div class="col-lg-3"></div>
    </div>
</div>
