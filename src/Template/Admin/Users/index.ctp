<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User[]|\Cake\Collection\CollectionInterface $users
 */
?>
<div class="container pt-md-5 pt-lg-5">
    <?= $this->Flash->render()?>
    <div>
        <h3 class="float-left"><?= __('Users') ?></h3>
        <a href="#" class="btn btn-primary float-right ml-1" onclick="upload(this)" data-toggle="modal" data-target="#myModal"><i class="fas fa-plus-square"></i></a> 
        <?= $this->Form->postLink('<i class="fas fa-download"></i>', ['action' => 'export'], ['class' => 'btn btn-primary float-right ml-1', 'escape' => false]) ?>
        <?= $this->Form->control('search',['class'=>'form-control float-right w-25 ml-1','type'=> 'text','id'=>'search','label'=>false,'placeholder'=>'Search name..','onkeyup'=>'searchTable(this.value,"admin/users/searchTable")']) ?>
        <!-- The Modal -->
        <div class="modal fade" id="myModal">
            <div class="modal-dialog">
              <div class="modal-content">
              
                <!-- Modal Header -->
                <div class="modal-header">
                  <h4 class="modal-title">Import</h4>
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                
                <!-- Modal body -->
                <div class="modal-body">
                    <?= $this->Form->create($import,['type' => 'file','action' => 'import']) ?>
                        <div class="form-group">
                            <label class="sr-only" for="csv"> CSV </label>
                            <?php echo $this->Form->input('csv', ['type'=>'file','class' => 'form-control', 'label' => false, 'placeholder' => 'csv upload','accept'=>'.csv,.xls,.xlsx']); ?>
                        </div>
                        <button type="submit" name="submit" class="btn btn-default"> Upload </button>
                        <!-- <?= $this->Form->postLink('<button type="submit" name="submit" class="btn btn-default"> Upload </button>',                      ['action' => 'import',$eid],
                                                  ['escape' => false]) ?> -->
                    <?= $this->Form->end() ?>
                </div>
                
                <!--  Modal footer 
                <div class="modal-footer">
                  <button type="button" class="btn btn-danger" name="button" data-dismiss="modal">Import</button>
                </div> -->
                
              </div>
            </div>
        </div>
    </div>
    <div class="content_table">
        <table class="table table-hover mt-5" cellpadding="0" cellspacing="0">
            <thead class="thead-light"> 
                <tr>
                    <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                    <th scope="col"><?= $this->Paginator->sort('username') ?></th>
                    <th scope="col"><?= $this->Paginator->sort('role') ?></th>
                    <th scope="col"><?= $this->Paginator->sort('last_name','Họ và tên') ?></th>
                    <th scope="col"><?= $this->Paginator->sort('date_birth') ?></th>
                    <th scope="col"><?= $this->Paginator->sort('class') ?></th>
                    <th scope="col" class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                <tr>
                    <td><?= $this->Number->format($user->id) ?></td>
                    <td><?= h($user->username) ?></td>
                    <td><?= h($user->role) ?></td>
                    <td><?= h($user->first_name.' '.$user->last_name) ?></td>
                    <td><?= h($user->date_birth->i18nFormat('dd/MM/yyyy')) ?></td>
                    <td><?= h($user->class) ?></td>
                    <td class="actions">
                        <?= $this->Html->link('<i class="fas fa-pencil-alt"></i>', ['action' => 'edit', $user->id],['class' => 'btn btn-warning', 'escape' => false]) ?>
                        <?= $this->Form->postLink('<i class="far fa-trash-alt"></i>', ['action' => 'delete', $user->id], ['confirm' => __('Are you sure you want to delete # {0}?', $user->id),'class' => 'btn btn-danger', 'escape' => false]) ?>
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