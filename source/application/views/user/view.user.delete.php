<?php IncludeJS('sha512'); ?>
<?php IncludeJS('form'); ?>

<script>
	$(document).ready( function() {
		var form = new Form($("#delete-account-form"));
		
		form.submitFunction = function() {
			form.hashField($("#password"));
			$("#repeatPassword").val("");

			form.request();
		};
		
		form.applyValidation(validators = [
			new Validator($("#password"), {
				name: "password",
				required: true,
			}),
			new Validator($("#repeatPassword"), {
				name: "repeat password",
				required: true,
				matchField: $("#password")
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
	<p>Delete <?php echo ucfirst($model['username']) ?> Account</p>
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
		<form id="delete-account-form" class="dark-form" action="<?php LinkToAction('user', 'delete') ?>" method="post" autocomplete="on">
			<div id="password-input-block" class="input-block">
				<div class="label-wrapper">
					<label for="password">Password<span class="required_mark">*</span></label>
				</div>
				<div class="input-wrapper">
					<input id="password" name="password" type="password" maxlength="50" placeholder="&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;">
				</div>
			</div>
			<div id="repeatPassword-input-block" class="input-block">
				<div class="label-wrapper">
					<label for="repeatPassword">Repeat Password<span class="required_mark">*</span></label>
				</div>
				<div class="input-wrapper">
					<input id="repeatPassword" name="repeatPassword" type="password" maxlength="50" placeholder="&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;">
				</div>
			</div>
			<div id="submit-input-block" class="input-block">
				<input type="submit" value="Delete Account">
			</div>
		</form>
		<div class="end-span-block"></div>
	</div>
</div>