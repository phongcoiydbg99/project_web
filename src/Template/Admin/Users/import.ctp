<div class="col-md-8">
        <?= $this->Form->create($import,['type' => 'file']) ?>
        <div class="form-group">
            <label class="sr-only" for="csv"> CSV </label>
            <?php echo $this->Form->input('csv', ['type'=>'file','class' => 'form-control', 'label' => false, 'placeholder' => 'csv upload',]); ?>
        </div>
        <button type="submit" name="submit" class="btn btn-default"> Upload </button>
    <?= $this->Form->end() ?>
</div>