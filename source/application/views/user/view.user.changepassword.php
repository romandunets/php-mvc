<?php IncludeJS('sha512'); ?>
<?php IncludeJS('form'); ?>

<script>
	$(document).ready( function() {
		var form = new Form($("#change-password-form"));
		
		form.submitFunction = function() {
			if($("#currentPassword").val() != $("#newPassword").val())
			{
				form.hashField($("#currentPassword"));
				form.hashField($("#newPassword"));
				$("#newRepeatPassword").val("");
				
				form.request();
			}
			else
			{
				$("#currentPassword").val("");
				$("#newPassword").val("");
				$("#newRepeatPassword").val("");
				
				form.result("The new password cannot be the same as current. Please try to change new password.", "unsuccessful");
			}
		};
		
		form.applyValidation(validators = [
			new Validator($("#currentPassword"), {
				name: "current password",
				required: true,
			}),
			new Validator($("#newPassword"), {
				name: "new password",
				required: true,
				minLenght: 8,
				maxLenght: 50,
				filter: /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z]{8,}$/,
				description: "Must contain capital and small latin letters and digits"
			}),
			new Validator($("#newRepeatPassword"), {
				name: "repeat new password",
				required: true,
				matchField: $("#newPassword")
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

<div id="headline" class="headline">
	<p>Change <?php echo ucfirst($model['username']) ?> Password</p>
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
		<form id="change-password-form" class="dark-form" action="<?php LinkToAction('user', 'changePassword') ?>" method="post" autocomplete="on">  
			<div id="currentPassword-input-block" class="input-block">
				<div class="label-wrapper">
					<label for="currentPassword">Current Password<span class="required_mark">*</span></label>
				</div>
				<div class="input-wrapper">
					<input id="currentPassword" name="currentPassword" type="password" maxlength="50" placeholder="&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;">
				</div>
			</div>
			<div id="newPassword-input-block" class="input-block">
				<div class="label-wrapper">
					<label for="newPassword">New Password<span class="required_mark">*</span></label>
				</div>
				<div class="input-wrapper">
					<input id="newPassword" name="newPassword" type="password" maxlength="50" placeholder="&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;">
				</div>
			</div>
			<div id="newRepeatPassword-input-block" class="input-block">
				<div class="label-wrapper">
					<label for="newRepeatPassword">Repeat New Password<span class="required_mark">*</span></label>
				</div>
				<div class="input-wrapper">
					<input id="newRepeatPassword" name="newRepeatPassword" type="password" maxlength="50" placeholder="&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;">
				</div>
			</div>
			<div id="submit-input-block" class="input-block">
				<input type="submit" value="Change Password">
			</div>
		</form>
		<div class="end-span-block"></div>
	</div>
</div>