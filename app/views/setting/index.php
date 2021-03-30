<div class="row">
	<div class="col-xs-12 col-sm-12">
		<?php
			Flasher::msgInfo();
		?>
		<div class="widget">
			<form action="<?= BASEURL; ?>/setting/savesetting" method="POST" enctype="multipart/form-data">
				<div class="col-md-6">
					<input type="hidden" name="id" value="<?= $data['setting']['id']; ?>">
					<div class="form-group">
						<label for="company">Company Name</label>
						<input type="text" name="company" id="company" class="form-control" placeholder="Company Name" required="true" value="<?= $data['setting']['company']; ?>">
					</div>

                    <div class="form-group">
						<label for="address">Address</label>
						<input type="text" name="address" id="address" class="form-control" placeholder="Address" value="<?= $data['setting']['address']; ?>">
					</div>					

					<div class="form-group">
						<button type="submit" class="btn btn-primary">Save</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>