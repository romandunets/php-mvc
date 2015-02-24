<?php IncludeJS('form'); ?>
<script src="https://maps.googleapis.com/maps/api/js?sensor=false"></script>

<script>
	$(document).ready( function() {
		var form = new Form($("#email-form"));
		
		form.submitFunction = function() {
			form.request();
		};
		
		form.applyValidation(validators = [
			new Validator($("#name"), {
				name: "name",
				required: true,
				minLenght: 3,
				maxLenght: 50,
				filter: /^[a-zA-Z- ]+$/,
				description: "May contain only latin letters, dashes and whitespaces"
			}),
			new Validator($("#email"), {
				name: "email address",
				required: false,
				minLenght: 8,
				maxLenght: 50,
				filter: /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/
			}),
			new Validator($("#subject"), {
				name: "message subject",
				required: false,
				minLenght: 5,
				maxLenght: 100,
				filter: /^[a-zA-Z0-9 \.,-\/#!$%\^&\*;:{}=\-_`~()''""]+$/,
				description: "May contain only latin letters, punctuation marks and whitespaces"
			}),
			new Validator($("#message"), {
				name: "message text",
				required: true,
				minLenght: 10,
				maxLenght: 5000,
				filter: /^[a-zA-Z0-9 \.,-\/#!$%\^&\*;:{}=\-_`~()''""\n]+$/,
				description: "May contain only latin letters, punctuation marks and whitespaces"
			})
		]);
		
		var center = new google.maps.LatLng(49.841799, 24.031655);
		
		var mapCanvas = document.getElementById('map-canvas');
        var mapOptions = {
			center: center,
			zoom: 17,
			mapTypeId: google.maps.MapTypeId.ROADMAP
        }
		
        var map = new google.maps.Map(mapCanvas, mapOptions);
		
		var marker = new google.maps.Marker({
			position: center
		});

		marker.setMap(map);
		
		var infowindow = new google.maps.InfoWindow({
			content: "We are here!"
		});

		infowindow.open(map, marker);
		
		google.maps.event.addListener(marker, 'click', function() {
			infowindow.open(map,marker);
		});
	});
	/*$(document).ready( function() {
		validators = [
			new Validator("name", "name", true, 3, 50, /^[a-zA-Z- ]+$/, "latin letters, dashes and whitespaces"),
			new Validator("email", "email address", false, 8, 50, /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/, null),
			new Validator("subject", "message subject", false, 5, 100, /^[a-zA-Z0-9 \.,-\/#!$%\^&\*;:{}=\-_`~()''""]+$/, "latin letters, punctuation marks and whitespaces"),
			new Validator("message", "message text", true, 10, 5000, /^[a-zA-Z0-9 \.,-\/#!$%\^&\*;:{}=\-_`~()''""\n]+$/, "latin letters, punctuation marks and whitespaces")
		];

		applyValidation("email-form", validators, function() {		
			$.post(
				$("#email-form").attr("action"),
				$("#email-form").serialize(),
				function(data)
				{
					var result = parseInt(data);
					printResult(result);
				});
			
			return false;
		});
		
        var mapCanvas = document.getElementById('map-canvas');
        var mapOptions = {
			center: new google.maps.LatLng(49.841799, 24.031655),
			zoom: 17,
			mapTypeId: google.maps.MapTypeId.ROADMAP
        }
        var map = new google.maps.Map(mapCanvas, mapOptions);
	});
	
	function printResult(result, exceed)
	{
		if(result < 0)
		{
			$("#result-input-block")
				.append("<p></p>");
				
			$("#result-input-block p:first")
				.attr({
					id : "subresult-input-block-text",
				})
				.addClass("unsuccessful")
				.text("An error occurred while sending the Message. Please try to send the Message again.");
		}
		else
		{
			$("#email-form").hide();
				
			$("#result-input-block")
				.append("<p></p>")
				.append("<p></p>");
			
			if(result > 0)
			{
				$("#result-input-block")
					.append("<input></input>");
			}
			
			$("#result-input-block p:first")
				.attr({
					id : "result-input-block-text",
				});
				
			if(!exceed)
			{
				$("#result-input-block p:first")
					.addClass("successful")
					.text("Your Message has been sent successfully.");
			}
			else
			{
				$("#result-input-block p:first")
					.text("Sorry.");
			}
			
			$("#result-input-block p:last")
				.attr({
						id : "result-input-block-hint",
				})
				.text((result > 0) ? "Would You like to send one more Email?" : "You have exceeded your daily Message sending limit.");
			
			if(result > 0)
			{
				$("#result-input-block input")
					.attr({
						id : "send-another-message-button",
						class : "dark-form-button",
						type : "button",
						value : "Send another Email"
					});
					
				$("#send-another-message-button").click( function() {
					$("#email-form")
						.find("input[type=text], textarea")
							.val("");
							
					$("#result-input-block")
						.empty();
					
					$("#email-form")
						.show();
				});
			}
		}
	}
	*/
</script>

<style>
	.column-1-2
	{
		width: 480px;
		margin: 0px 10px 10px 10px;
	}
	
	.dark-form
	{
		margin: 0px auto;
	}
	
	.input-block
	{
		clear: none;
		width: 230px;
		margin: 5px;
	}
	
	.label-wrapper
	{
		clear: both;
		
		margin: 0px;
		padding: 0px 0px 2px 10px;
	}
	
	.input-wrapper
	{
		margin: 0px;
	}
	
	.error-wrapper
	{
		width: auto;
	}
	
	#name,
	#email
	{
		width: 208px;
	}
	
	#subject-input-block,
	#message-input-block
	{
		width: 470px;
	}
	
	#subject
	{
		width: 448px;
	}
	
	#hint-input-block
	{
		width: 440px;
		margin: 0px 20px;
	}
	
	#hint-input-block p
	{
		margin: 0px;
	}
	
	#submit-input-block
	{
		float: right;
		
		width: 140px;
		margin-top: 15px;
	}
	
	#result-input-block
	{
		width: 470px;
		text-align: center;
	}
	
	#result-input-block-text
	{
		margin: 20px;
		
		font-size: 11pt;
		font-weight: bold;
	}
	
	#subresult-input-block-text
	{
		margin: 0px;
		text-align: left;
	}
	
	#message
	{
		height: 130px;
	}
	
	#result-input-block-hint
	{}
	
	#send-another-message-button
	{
		width: auto;
		margin: 5px auto;
	}
	
	#map-canvas
	{
		width: 480px;
		height: 300px;
	}
	
	#follow-us-info
	{
		margin: 10px;
	}
</style>

<div class="column-1-2">
	<div class="headline">
		<p>Email Us</p>
	</div>
	<div class="content">
		<form id="email-form" class="dark-form" action="<?php LinkToAction('contact') ?>" method="post" autocomplete="on">
			<div id="name-input-block" class="input-block">
				<div class="label-wrapper">
					<label for="name">Name<span class="required_mark">*</span></label>
				</div>
				<div class="input-wrapper">
					<input id="name" name="name" type="text" placeholder="Your Name..." maxlength="50">
				</div>
			</div>
			<div id="email-input-block" class="input-block">
				<div class="label-wrapper">
					<label for="email">Email</label>
				</div>
				<div class="input-wrapper">
					<input id="email" name="email" type="text" placeholder="Your Email..." maxlength="50">
				</div>
			</div>
			<div id="subject-input-block" class="input-block">
				<div class="label-wrapper">
					<label for="subject">Subject</label>
				</div>
				<div class="input-wrapper">
					<input id="subject" name="subject" type="text" placeholder="Message Subject..." maxlength="100">
				</div>
			</div>
			<div id="message-input-block" class="input-block">
				<div class="label-wrapper">
					<label for="message">Message<span class="required_mark">*</span></label>
				</div>
				<div class="input-wrapper">
					<textarea id="message" name="message" placeholder="How can We help You..?" maxlength="5000"></textarea>
				</div>
			</div>
			<div id="hint-input-block" class="input-block">
				<p><span class="required_mark">*</span> - required</p>
			</div>
			<div id="submit-input-block" class="input-block">
				<input type="submit" value="Send">
			</div>
		</form>
		<div id="result-input-block" class="input-block"></div>
	</div>
</div>
<div class="column-1-2">
	<div class="headline">
		<p>Follow Us</p>
	</div>
	<div class="content">
		<div id="map-canvas"></div>
		<div id="follow-us-info">
			<ul class="list-0">
				<li>Address: Chambers Street 12, Lviv, Ukraine (44511)</li>
				<li>Phone: (33) 1234 5677, (33) 1245 9876</li>
				<li>Email: info@forestryukraine.ua</li>
			</ul>
		</div>
	</div>
</div>