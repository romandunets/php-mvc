<style>
	.content
	{
		text-align: center;
	}
</style>

<div class="headline">
	<p><?php echo ucfirst($model['username']) ?> Profile</p>
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
		<div class="key-value-block">
			<div class="text-block">
				<p>Username:</p>
			</div>
			<div class="text-block">
				<p><?php echo ucfirst($model['username']) ?></p>
			</div>
		</div>
		<div class="end-span-block"></div>
	</div>
</div>