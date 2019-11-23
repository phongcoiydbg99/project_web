<?php foreach ($test_rooms as $test_room): ?>
    <?php foreach ($test_room->test_rooms as $key)
        echo '<option>'. $key->name .'</option>';
    ?>
<?php endforeach; ?>

<div class="card">
    <div class="card-header"><h3><?= __('Subjects') ?></h3></div>
    <div class="ajax card-body table-responsive p-0" style="height:200px">
        <?= $this->Form->create() ?>
        <table class="table table-head-fixed table-hover" cellpadding="0" cellspacing="0">
            <thead class="thead-light">
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('code') ?></th>
                <th scope="col"><?= $this->Paginator->sort('name') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            </thead>

            <tbody id="checked-subject">

            </tbody>
            <?= $this->Form->button('Login', ['class' => 'btn btn-primary']) ?>

        </table>
        <?= $this->Form->end() ?>
    </div>
</div>
