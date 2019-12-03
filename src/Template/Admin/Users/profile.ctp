<h2 style="margin-top: 20px;"><?=  $current['first_name'].' '. $current['last_name'].'<br/>'?></h2>
<div class="row">
		<div class="col-lg-3 border border-light rounded p-3 mb-5">
			<img src="https://carlisletheacarlisletheatre.org/images/person-clipart-circle-1.png" style="height="100%" width="100%">
		</div>
		<div class="col-lg-6 border border-light rounded p-3 mb-5"">
			<h4>Chi tiết người dùng</h4>
			<ul class="list-group list-group-flush">
				<li class="list-group-item">
					<dl>
						<dt>Username</dt>
						<dd style="margin-left: 25px"> <?= $current['username'] ?> </dd>
					</dl>
					<dl>
						<dt>Email</dt>
						<dd style="margin-left: 25px"> <?= $current['email'] ?> </dd>
					</dl>
					<dl>
						<dt>Ngày sinh</dt>
						<dd style="margin-left: 25px"> <?=$time = date('d/m/Y',strtotime($current['date_birth']))  ?> </dd>
					</dl>
					<dl>
						<dt>Lớp</dt>
						<dd style="margin-left: 25px"> <?= $current['class']  ?> </dd>
					</dl>
				</li>
			</ul>
		</div>
		<div class="col-lg-3 border border-light rounded p-3 mb-5">
			<h4>Action</h4>
			<ul class="list-group list-group-flush">
				<li class="list-group-item">
					<?php echo $this->Html->link('<img src="https://small.pngfans.com/20190523/s/edit-profile-icon-png-computer-icons-user-profile-034e263697f438c7.jpg" style="height="20" width="20""/> Edit profile', ['action'=>'edit'],array('escape'=>false, 'class'=>'dropdown-item'))?>

				</li>
			</ul>
		</div>

</div>
