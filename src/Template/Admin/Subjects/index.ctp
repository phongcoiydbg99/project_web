<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Subject[]|\Cake\Collection\CollectionInterface $subjects
 */
?>

<div class="container pt-md-5 pt-lg-5">
    <div class='container'>
        <h3 class="float-left"><?= __('Subjects') ?></h3>
        <?= $this->Html->link('<i class="fas fa-plus-square"></i>',['action' => 'add'],['class' => "btn btn-primary float-right ml-1",'escape' => false]) ?>
        <?= $this->Form->control('search',['class'=>'form-control float-right w-25 ml-1','type'=> 'text','id'=>'search','label'=>false,'placeholder'=>'Search subject name..','onkeyup'=>'searchTable(this.value,"admin/subjects/searchTable")']) ?>
    </div>
    <div class="content_table">
        <table class="table table-hover mt-5"cellpadding="0" cellspacing="0">
            <thead class="thead-light">
                <tr>
                    <th scope="col"><?= $this->Paginator->sort('code') ?></th>
                    <th scope="col"><?= $this->Paginator->sort('name') ?></th>
                    <th scope="col"><?= $this->Paginator->sort('test_day') ?></th>
                    <th scope="col" class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($subjects as $subject): ?>
                <tr>
                    <td><?= h($subject->code) ?></td>
                    <td><?= h($subject->name) ?></td>
                    <td><?= h($subject->test_day->i18nFormat('dd/MM/yyyy')) ?></td>
                    <td class="actions">
                        <?= $this->Html->link('<i class="fas fa-pencil-alt"></i>', ['action' => 'edit', $subject->id],['class' => 'btn btn-warning', 'escape' => false])?>
                        <?= $this->Form->postLink('<i class="far fa-trash-alt"></i>', ['action' => 'delete', $subject->id], ['confirm' => __('Are you sure you want to delete # {0}?', $subject->id),'class' => 'btn btn-danger', 'escape' => false]) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="paginator">
        <ul class="pagination">
            <?php
            $this->Paginator->templates([
                'prevActive' => '<li class="page-item"><a class="page-link" href="{{url}}">{{text}}</a></li>',
                'prevDisabled' => '<li class="page-item disabled"><a class="page-link" href="{{url}}">{{text}}</a></li>',
                'number' => '<li class="page-item"><a class="page-link" href="{{url}}">{{text}}</a></li>',
                'current' => '<li class="page-item"><a class="page-link" href="{{url}}">{{text}}</a></li>',
                'nextActive' => '<li class="page-item"><a class="page-link" href="{{url}}">{{text}}</a></li>',
                'nextDisabled' => '<li class="page-item disabled"><a class="page-link" href="{{url}}">{{text}}</a></li>'
            ]); ?>
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
    </div>
</div>
<script type="text/javascript">
    
</script>