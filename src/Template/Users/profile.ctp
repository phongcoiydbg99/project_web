<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><?= $this->Html->link(
                    ' Trang chủ ',
                    '/',
                    ['escape' => false]
                ) ?></li>
          <li class="breadcrumb-item active">Hồ sơ</li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<div class="content">
	<div class="row">
		<div class="col-lg-1"></div>
		<div class="col-lg-4 ">
			<div class="card">
				<div class="card-body">
					<?= $this->Html->image('img_avatar1.png', ['alt' => 'CakePHP','class'=>"card-img-top"]) ?>
					<h2 style="text-align: center" class="mt-3"><?=  $current['first_name'].' '. $current['last_name'].'<br/>'?></h2>	
				</div>
			</div>
		</div>
		<div class="col-lg-6 ">
			<div class="card">
				<div class="card-header">
				<h4 class="float-left">Thông tin</h4>
				<?php echo $this->Form->button('<i class="fas fa-user-edit"></i>',['escape'=>false, 'class'=>'float-right btn-primary btn','onclick'=>'editProfile()'])?>

				</div>
				<div class="card-body content_edit">
					<ul class="list-group list-group-flush">
						<li class="list-group-item">
							<dl class="row">
								<dt>Tài khoản: </dt>
								<dd style="margin-left: 25px"> <?= $current['username'] ?> </dd>
							</dl>
							<dl class="row">
								<dt>Email: </dt>
								<dd style="margin-left: 25px"> <?= $current['email'] ?> </dd>
							</dl>
							<dl class="row">
								<dt>Ngày sinh:</dt>
								<dd style="margin-left: 25px"> <?= $time = date('d/m/Y',strtotime($current['date_birth']))  ?> </dd>
							</dl>
							<dl class="row">
								<dt>Lớp:</dt>
								<dd style="margin-left: 25px"> <?= $current['class']  ?> </dd>
							</dl>
						</li>
					</ul>
				</div>
			</div>				
		</div>
		<div class="col-lg-1"></div>
	</div>
</div>
<script type="text/javascript">
	function editProfile() {
		$.ajax({
            url: baseUrl + 'users/editProfile',
            type: 'post',
            data: {
                
            },
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            dataType: 'html',
            success: function (res) {
                $('.content_edit').html(res);
            },
            error: function () {

            }
        })    
	}
</script>