<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<div id="container">
	<h2 class="text-center">CONFIGURATIONS</h2>
	<div id="body">
	<br>
		<form method="post" class="table-responsive" autocomplete="on">
			<input type="hidden" name="act" value="step2"/>
			<input type="hidden" name="db_host" value="<?php echo DB_HOST;?>"/>
			<input type="hidden" name="db_name" value="<?php echo DB_NAME;?>"/>
			<input type="hidden" name="db_user" value="<?php echo DB_USER;?>"/>
			<input type="hidden" name="db_pass" value="<?php echo DB_PASS;?>"/>
			<div class="text-center"><p><small><b>Website Informations</b></small></p></div>

			<table class="table table-striped">
				<tr>
					<td>Website Url</td>
					<td>
						<input type="text" name="site_url" class="form-control" style="width:100%;" value="<?php echo site_url();?>" required/>
						<small class="text-muted">Your website url.</small><br/>
						<small class="text-muted">Example : http://www.mydomain.com/</small>
					</td>
				</tr>
				<tr>
					<td>Website Name</td>
					<td>
						<input type="text" name="site_name" class="form-control" style="width:100%;" required/>
						<small class="text-muted">Your website name.</small><br/>
						<small class="text-muted">Example : Great Community</small>
					</td>
				</tr>
				<tr>
					<td>Website Description</td>
					<td>
						<input type="text" name="site_desc" class="form-control" style="width:100%;" required/>
						<small class="text-muted">Your site description.</small><br/>
						<small class="text-muted">Example : Indonesian free CMS and great Community support.</small>
					</td>
				</tr>
				<tr>
					<td>Website Email</td>
					<td>
						<input type="email" name="site_email" class="form-control" style="width:100%;" required/>
						<small class="text-muted">Your site email.</small><br/>
						<small class="text-muted">Example : site@email.here</small>
					</td>
				</tr>

				<tr>
					<td colspan="2" class="text-cetner">
						<br>
						<div class="text-center"><small><b>Administrator User</b></small></div>
					</td>
				</tr>
				<tr>
					<td>Admin Username</td>
					<td>
						<input type="text" name="adm_user" class="form-control" style="width:100%;" maxlength="15" minlength="5" required/>
						<small class="text-muted">Username for login to administrator page, please just write letters and numbers (lowercase).</small><br/>
						<small class="text-muted">Example : admin123</small>
					</td>
				</tr>
				<tr>
					<td>Admin Email</td>
					<td>
						<input type="email" name="adm_email" class="form-control" style="width:100%;" required/>
						<small class="text-muted">Your admin email.</small><br/>
						<small class="text-muted">Example : your@email.here</small>
					</td>
				</tr>
				<tr>
					<td>Admin Password</td>
					<td>
						<input type="text" name="adm_pass" class="form-control" style="width:100%;" maxlength="20" minlength="6" required/>
						<small class="text-muted">Password for login to administrator page, please enter character more than 6 characters.</small><br/>
						<small class="text-muted">Example : admin123</small>
					</td>
				</tr>
				<tr>
					<td colspan="2" class="text-cetner">
						<br>
						<div class="text-center"><small><b>Local</b></small></div>
					</td>
				</tr>
				<tr>
					<td>Default Timezone</td>
					<td>
						<div class="row col-sm-6">
                        <select class="form-control col-sm-5" name="timezone" required>
                            <option value="Asia/Jakarta">Asia/Jakarta</option>
                            <?php
                            	$arr_timez_id_lst3 = DateTimeZone::listIdentifiers();
                            	foreach ($arr_timez_id_lst3 as $timez) {
                            ?>
                            <option value="<?php echo $timez;?>" style="font-size:13px;padding:3px;"><?php echo $timez;?></option>
                            <?php } ?>
                        </select>
						</div>
					</td>
				</tr>
			</table>
			<br><hr>
			<div class="text-center">
				<button type="submit" class="btn btn-lg btn-success">Install Now</button>
			</div>
			<br><br>
		</form>
	</div>
</div>