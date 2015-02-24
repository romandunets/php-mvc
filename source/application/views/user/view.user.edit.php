<?php IncludeJS('form'); ?>

<script>
	$(document).ready( function() {
		var form = new Form($("#edit-user-form"));
		
		form.submitFunction = function() {
			form.request();
		};
		
		form.applyValidation(validators = [
			new Validator($("#username"), {
				name: "username",
				required: true,
				minLenght: 4,
				maxLenght: 50,
				filter: /^[a-zA-Z0-9-]+$/,
				description: "May contain only latin letters, digits and dashes"
			})
		]);
	});
</script>

<style>
	.content
	{
		text-align: center;
	}
	
	.dark-form
	{
		margin: 0px auto;
	}
	
	#submit-input-block,
	.input-block
	{
		width: 320px;
	}
</style>

<div class="headline">
	<p>Edit <?php echo ucfirst($model['username']) ?> Profile</p>
</div>
<div class="content">
	<div class="left-panel">
		<ul class="menu-list">
			<li>
				<a href="<?php LinkToAction('user') ?>">Overview</a>
			</li>
			<li>
				<a href="<?php LinkToAction('user', 'edit') ?>">Edit Profile</a>
			</li>
			<li>
				<a href="<?php LinkToAction('user', 'changePassword') ?>">Change Password</a>
			</li>
			<li>
				<a href="<?php LinkToAction('user', 'delete') ?>">Delete Account</a>
			</li>
			<li>
				<a href="<?php LinkToAction('logout') ?>">Logout</a>
			</li>
		</ul>
	</div>
	<div class="main-panel">
		<form id="edit-user-form" class="dark-form" action="<?php LinkToAction('user', 'edit') ?>" method="post" autocomplete="on">		
			<div id="username-input-block" class="input-block">
				<div class="label-wrapper">
					<label for="username">Username<span class="required_mark">*</span></label>
				</div>
				<div class="input-wrapper">
					<input id="username" name="username" type="text" maxlength="50" placeholder="username" value="<?php echo $model['username'] ?>">
				</div>
			</div>
			<div id="submit-input-block" class="input-block">
				<input type="submit" value="Save Changes">
			</div>
		</form>
		<div class="end-span-block"></div>
	</div>
</div>