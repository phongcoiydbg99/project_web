<?php foreach ($subjects as $subject): ?>
	<tr>
		<td style="width: 44px"></td>
	    <td><input type="text" class="border-0" name="subject[<?= $subject['_matchingData']['Tests']['id']?>][code]" value="<?= $subject->code?>" style="width:50px" readonly></td>
	    <td><input type="text" class="border-0" name="subject[<?= $subject['_matchingData']['Tests']['id']?>][name]" value="<?= $subject->name?>" style="width:50px"readonly></td>
	    <td><input type="text" class="border-0" name="subject[<?= $subject['_matchingData']['Tests']['id']?>][test_day]" value="<?= $subject->test_day?>" style="width:80px"readonly></td>
	    <td><input type="text" class="border-0" name="subject[<?= $subject['_matchingData']['Tests']['id']?>][room]" value="<?= $subject['_matchingData']['TestRooms']['name']?>" style="width:50px"readonly></td>
	    <td><input type="text" class="border-0" name="subject[<?= $subject['_matchingData']['Tests']['id']?>][time]" value="<?= date('H:i',strtotime($subject['_matchingData']['Tests']['start_time'])).' - '.date('H:i',strtotime($subject['_matchingData']['Tests']['last_time'])) ?>" style="width:100px"readonly></td>
	    
	    <td class="actions">
	    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $subject->id], ['confirm' => __('Are you sure you want to delete # {0}?', $subject->id)]) ?>
	    </td>
	</tr>
<?php endforeach; ?>