<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<div id="container">
	<h2 class="text-center">DATABASE</h2>
	<hr>
	<div id="body">
		<form method="post" class="table-responsive">
			<input type="hidden" name="act" value="step1">			
			<table class="table table-striped">
				<tr>
					<td  style="width:150px;">Database Hostname</td>
					<td>
						<input type="text" name="db_host" value="localhost" class="form-control" style="width:100%;" required/>
						<small class="text-muted">Your database host name.</small><br/>
						<small class="text-muted">Example : localhost </small>
					</td>
				</tr>
				<tr>
					<td>Database Name</td>
					<td>
						<input type="text" name="db_name" class="form-control" style="width:100%;" required/>
						<small class="text-muted">Your database name.</small><br/>
						<small class="text-muted">Example : YourDatabase </small>
					</td>
				</tr>
				<tr>
					<td>Database User</td>
					<td>
						<input type="text" name="db_user" class="form-control" style="width:100%;" required/>
						<small class="text-muted">Your database user.</small><br/>
						<small class="text-muted">Example : YourName </small>
					</td>
				</tr>
				<tr>
					<td>Database Password</td>
					<td>
						<input type="text" name="db_pass" class="form-control" style="width:100%;"/>
						<small class="text-muted">Your database password</small><br/>
						<small class="text-muted">Example : YourPassword </small>
					</td>
				</tr>
			</table>
			<br><hr>
			<div class="text-center">
				<button type="submit" class="btn btn-lg btn-success">Connect</button>
			</div>
			<br><br>
		</form>
	</div>
</div>