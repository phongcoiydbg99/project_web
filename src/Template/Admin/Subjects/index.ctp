<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Subject[]|\Cake\Collection\CollectionInterface $subjects
 */
?>
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">Quản lý môn thi</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item active">Môn thi</li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<div class="content">
    <div class="card">
        <div class="card-header">
            <h3 class="float-left"><?= __('Môn thi') ?></h3>
            <?= $this->Html->link('<i class="fas fa-plus-square"></i>',['action' => 'add'],['class' => "btn btn-primary float-right ml-1",'escape' => false]) ?>
            <?= $this->Form->control('search',['class'=>'form-control float-right w-25 ml-1','type'=> 'text','id'=>'search','label'=>false,'placeholder'=>'Tìm kiếm tên môn học..','onkeyup'=>'searchTable(this.value,"admin/subjects/searchTable")']) ?>
        </div>
        <div class="card-body">
            <div class="content_table">
                <table class="table table-hover border"cellpadding="0" cellspacing="0">
                    <thead class="thead-light">
                        <tr>
                            <th scope="col"><?= $this->Paginator->sort('code','Mã môn') ?></th>
                            <th scope="col"><?= $this->Paginator->sort('name','Tên môn') ?></th>
                            <th scope="col"><?= $this->Paginator->sort('test_day','Ngày thi') ?></th>
                            <th scope="col" class="actions"><?= __('Hành vi') ?></th>
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
                                <?= $this->Form->postLink('<i class="far fa-trash-alt"></i>', ['action' => 'delete', $subject->id], ['confirm' => __('Bạn chắc chắn muốn xóa # {0}?', $subject->id),'class' => 'btn btn-danger', 'escape' => false]) ?>
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
                        'nextDisabled' => '<li class="page-item disabled"><a class="page-link" href="{{url}}">{{text}}</a></li>',
                        'first' => '<li class="page-item "><a class="page-link" href="{{url}}">{{text}}</a></li>',
                        'last' => '<li class="page-item "><a class="page-link" href="{{url}}">{{text}}</a></li>'
                    ]); ?>
                    <?= $this->Paginator->first('<< ' . __('First')) ?>
                    <?= $this->Paginator->prev('< ' . __('Previous')) ?>
                    <?= $this->Paginator->numbers() ?>
                    <?= $this->Paginator->next(__('Next') . ' >') ?>
                    <?= $this->Paginator->last(__('Last') . ' >>') ?>
                </ul>
                <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    
</script>