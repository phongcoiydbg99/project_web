<div class="subjects index large-9 medium-8 columns content">
    <div class="card">
        <div class="card-header"><h3><?= __('Subjects') ?></h3></div>
        <div class="card-body table-responsive p-0" style="height:250px">
            <table class="table table-head-fixed" cellpadding="0" cellspacing="0">
                <thead class="thead-light">
                <tr>
                    <th scope="col" colspan=><?= $this->Paginator->sort('code') ?></th>
                    <th scope="col"><?= $this->Paginator->sort('name') ?></th>
                    <th scope="col"><?= $this->Paginator->sort('test_day') ?></th>
                    <th scope="col" class="text-primary">Phòng thi</th>
                    <th scope="col" class="text-primary">Thời gian thi</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($subjects as $subject): ?>
                    <tr>
                        <?php 
                        foreach ($subject->tests as $tests)
                        {
                            if(!empty($tests->users))
                            {
                                foreach ($tests->users as $key)
                                {
                                    if($key->id == $id)
                                    {?>
                                        <td><?= $subject->code?></td>
                                        <td><?= $subject->name?></td>
                                        <td><?= $subject->test_day?></td>
                                        <td><?= $tests->test_room->name?></td>
                                        <td><?= date('H:i',strtotime($tests->start_time)).' - '.date('H:i',strtotime($tests->last_time))?></td>
                        <?php       }
                                }
                            }
                        }
                        ?>
                            
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>