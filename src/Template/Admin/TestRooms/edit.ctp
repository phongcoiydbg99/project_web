<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\TestRoom $testRoom
 */
?>
<?php 
    $myTemplates = [
            // 'formStart' => '<form{{attrs}}>',
            'error' => '<div class="text-danger mt-2">{{content}}</div>',
            'inputContainer' => '<div class="form-group{{required}}">{{content}}<span class="help">{{help}}</span></div>',
            'input' => '<input type="{{type}}" name="{{name}}" class="form-control " {{attrs}}/>',
            'inputContainerError' => '<div class="form-group {{type}}{{required}}">{{content}}{{error}}</div>',
        ];
    $this->Form->setTemplates($myTemplates);
?>
<?= $this->Form->create($testRoom) ?>
    <fieldset>
        <legend><?= __('Edit Test Room') ?></legend>
            <div class="testRooms form large-9 medium-8 columns content">

                    <?php
                        echo $this->Form->control('name');
                        echo $this->Form->control('total_computer');
                    ?>
                
            </div>
    </fieldset>
<?= $this->Form->button('Submit',['class'=>'btn btn-primary']) ?>
<?= $this->Form->end() ?>
