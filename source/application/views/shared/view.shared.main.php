<?php
	Controller::Load('user');
	$userController = new UserController();
?>

<!DOCTYPE html>

<html>
	<head>
		<!-- TITLE -->
		<title>Forestry Management</title>
		<link rel="shortcut icon" href="<?php GetResourse('img/icons/icon.png'); ?>">
		<!-- ENDS TITLE -->
		
		<!-- META -->
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="keywords" content="Forestry Management, Forestry Control, FSC, PEFC, Forestry">
		<meta name="description" content="Forestry Management Ukraine">
		<meta name="author" content="Roman Dunets">
		<!-- ENDS META -->
		
		<!-- CSS -->
		<?php IncludeCSS('normalize'); ?>
		<?php IncludeCSS('custom-normalize'); ?>
		<?php IncludeCSS('common'); ?>
		<?php IncludeCSS('large', '(min-width: 801px)'); ?>
		<?php IncludeCSS('middle', '(min-width: 481px) and (max-width: 800px)'); ?>
		<?php IncludeCSS('small', '(max-width: 480px)'); ?>
		<!-- ENDS CSS -->	
		
		<!-- JS -->
		<?php IncludeJS('jquery-2.1.0.min'); ?>
		<?php IncludeJS('custom'); ?>
		<!-- ENDS JS -->
	</head>
	
	<body>
		<div id="page">
			<!-- HEADER -->
			<div id="header">
				<div class="wrapper">
					<div id="header-title">
						<a href="<?php LinkToAction('home') ?>">
							<div id="title-icon"></div>
							<div id="title-container">
								<div id="title">
									<p>Forestry Management</p>
								</div>
								<div id="subtitle">
									<p>FSC/PEFC Consulting Services</p>
								</div>
							</div>
						</a>
					</div>
					<div id="header-panel">
						<div id="user-panel">
							<a href="<?php LinkToAction('user') ?>">
								<?php if($userController->CheckLogin() == true): ?>
									<div id="user-account">
										<p><?php echo ucfirst(htmlentities($_SESSION['username'])); ?></p>
									</div>
									<div id="authorized-user-icon"></div>
								<?php else: ?>
									<div id="user-account">
										<p>Login</p>
									</div>
									<div id="unauthorized-user-icon"></div>
								<?php endif; ?>
							</a>
						</div>
						<div id="search-panel">
							<form id="search-form" class="white-form" action="<?php LinkToAction('search') ?>" method="get" autocomplete="on">
								<div id="search-input">
									<input name="query" type="text" placeholder="Search..." maxlength="128">
								</div>
								<div id="search-button">
									<input type="submit" value="">
								</div>
							</form>
						</div>
					</div>
				</div>					
			</div>
			<div id="separator"></div>
			<!-- ENDS HEADER -->
			
			<!-- MENU -->
			<div id="menu">
				<div class="wrapper">
					<div class="menu-item">
						<a href="<?php LinkToAction('home') ?>">
							<div class="menu-item-title">
								<p>Home</p>
							</div>
							<div class="menu-item-subtitle">
								<p>Welcome</p>
							</div>
						</a>
					</div>
					<div class="menu-item">
						<a href="<?php LinkToAction('standards') ?>">
							<div class="menu-item-title">
								<p>Standards</p>
							</div>
							<div class="menu-item-subtitle">
								<p>Basic Information</p>
							</div>
						</a>
					</div>
					<div class="menu-item">
						<a href="<?php LinkToAction('service') ?>">
							<div class="menu-item-title">
								<p>Service</p>
							</div>
							<div class="menu-item-subtitle">
								<p>Build a System</p>
							</div>
						</a>
					</div>
					<div class="menu-item">
						<a href="<?php LinkToAction('help') ?>">
							<div class="menu-item-title">
								<p>Help</p>
							</div>
							<div class="menu-item-subtitle">
								<p>Ask a Question</p>
							</div>
						</a>
					</div>
					<div class="menu-item">
						<a href="<?php LinkToAction('contact') ?>">
							<div class="menu-item-title">
								<p>Contact</p>
							</div>
							<div class="menu-item-subtitle">
								<p>Get in Touch</p>
							</div>
						</a>
					</div>
				</div>
			</div>
			<!-- ENDS MENU -->
			
			<!-- MAIN -->
			<div id="main">
				<div class="wrapper">
					<div id="main-container">
						<?php require($view); ?>
					</div>
				</div>
			</div>
			<!-- ENDS MAIN -->
			
			<!-- SUBFOOTER -->
			<div id="subfooter">
				<div class="wrapper">
					<div class="column-1-3">
						<div class="headline">
							</p>
								Pages
							</p>
						</div>
						<div class="content">
							<ul id="pages-list">
								<li>
									<a href="<?php LinkToAction('home') ?>">Home</a>
								</li>
								<li>
									<a href="<?php LinkToAction('standards') ?>">Standards</a>
								</li>
								<li>
									<a href="<?php LinkToAction('service') ?>">Service</a>
								</li>
								<li>
									<a href="<?php LinkToAction('help') ?>">Help</a>
								</li>
								<li>
									<a href="<?php LinkToAction('contact') ?>">Contact</a>
								</li>
							</ul>
						</div>
					</div>
					<div class="column-1-3">
						<div class="headline">
							<p>
								Categories
							</p>
						</div>
						<div class="content">
							<ul id="categories-list">
								<li>
									<a href="#">FSC Standards</a>
									<ul>
										<li>
											<a href="#">General</a>
										</li>
										<li>
											<a href="#">Forest Management</a>
										</li>
										<li>
											<a href="#">Chain of Custody</a>
										</li>
										<li>
											<a href="#">Controlled Wood</a>
										</li>
									</ul>
								</li>
								<li>
									<a href="#">PEFC Standards</a>
								</li>
							</ul>
						</div>
					</div>
					<div class="column-1-3">
						<div class="headline">
							<p>
								About Us
							</p>
						</div>
						<div class="content">
							<p>
								Our main task - to provide advice to both existing and potential owners, and help find solutions to all issues related to forestry. We provide You with consulting services to prepare You business for Forest Management, Chain of Custody FSC Certification. We work with national initiatives on Forest certification PEFC, Group certification FSC certificate and Controlled Wood claims.
							</p>
						</div>
					</div>
					<div id="to-top"></div>
				</div>
			</div>
			<!-- ENDS SUBFOOTER -->
			
			<!-- FOOTER -->
			<div id="footer">
				<div class="wrapper">
					<div id="copyright">
						<p>© 2014 Forestry Management Ukraine. All rights reserved.</p>
					</div>
				</div>
			</div>
			<!-- ENDS SUBFOOTER -->
		</div>
	</body>
</html>