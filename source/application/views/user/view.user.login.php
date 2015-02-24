<?php IncludeJS('sha512'); ?>
<?php IncludeJS('form'); ?>

<script>
	$(document).ready( function() {
		var form = new Form($("#login-form"));
		
		form.submitFunction = function() {
			form.hashField($("#password"));
			form.request();
		};
		
		form.applyValidation(validators = [
			new Validator($("#username"), {
				name: "username",
				required: true,
			}),
			new Validator($("#password"), {
				name: "password",
				required: true,
			})
		]);
	});
</script>

<style>
	.content
	{
		text-align: center;
	}
	
	.headline,
	{
		margin: 20px auto;
	}
	
	.input-block
	{
		width: 260px;
	}	

	.label-wrapper
	{
		width: 80px;
	}
	
	#submit-input-block
	{
		width: 260px;
	}
</style>

<div id="headline" class="headline">
	<p>Login</p>
</div>
<div class="content">
	<form id="login-form" class="dark-form" action="<?php LinkToAction('login') ?>" method="post" autocomplete="on">
		<div id="username-input-block" class="input-block">
			<div class="label-wrapper">
				<label for="username">Username</label>
			</div>
			<div class="input-wrapper">
				<input id="username" name="username" type="text" maxlength="50" placeholder="username">
			</div>
		</div>
		<div id="password-input-block" class="input-block">
			<div class="label-wrapper">
				<label for="password">Password</label>
			</div>
			<div class="input-wrapper">
				<input id="password" name="password" type="password" maxlength="50" placeholder="&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;">
			</div>
		</div>
		<div id="submit-input-block" class="input-block">
			<input type="submit" value="Login">
		</div>
	</form>
	<div class="link-block">
		<a href="<?php LinkToAction('register') ?>">Create Account</a>
	</div>
</div>