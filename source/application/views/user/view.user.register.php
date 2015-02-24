<?php IncludeJS('sha512'); ?>
<?php IncludeJS('form'); ?>

<script>
	var form;
	
	$(document).ready( function() {
		form = new Form($("#register-form"));
		
		form.submitFunction = function() {
			form.hashField($("#password"));
			$("#repeat-password").val("");
			form.request();
		};
		
		applyValidation();
		
		$("#category").change( function() {
			changeCategory();
		});
		changeCategory();
		
		$("#specialist-input-block input[type='checkbox'][value='other']").change( function() {
			changeSpecialist();
		});
		changeSpecialist();
	});
	
	function applyValidation()
	{
		form.applyValidation(validators = [
			new Validator($("#username"), {
				name: "username",
				required: true,
				minLenght: 4,
				maxLenght: 20,
				filter: /^[\w]{4,20}$/,
				description: "May contain only english letters, digits and underscores"
			}),
			new Validator($("#password"), {
				name: "password",
				required: true,
				minLenght: 8,
				maxLenght: 30,
				filter: /^.*(?=.{8,})(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!#$%&? "]).*$/,
				description: "Must contain capital and small english letters, special characters and digits"
			}),
			new Validator($("#repeat-password"), {
				name: "repeat password",
				required: true,
				matchField: $("#password")
			}),
			new Validator($("#email"), {
				name: "email address",
				required: true,
				minLenght: 5,
				maxLenght: 50,
				filter: /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/
			}),
			new Validator($("#repeat-email"), {
				name: "repeat email",
				required: true,
				matchField: $("#email")
			}),
			new Validator($("#company"), {
				name: "company name",
				required: true,
				minLenght: 2,
				maxLenght: 50,
				filter: /^[a-zA-Z- ]+$/,
				description: "May contain only english letters and dashes"
			}),
			new Validator($("#specialist-other-input"), {
				name: "other interested person",
				required: false,
				minLenght: 2,
				maxLenght: 50,
				filter: /^[a-zA-Z-, ]+$/,
				description: "May contain only english letters and dashes"
			}),
			new Validator($("#first-name"), {
				name: "First Name",
				required: true,
				minLenght: 2,
				maxLenght: 50,
				filter: /^[a-zA-Z-]+$/,
				description: "May contain only english letters and dashes"
			}),
			new Validator($("#second-name"), {
				name: "Second Name",
				required: true,
				minLenght: 2,
				maxLenght: 50,
				filter: /^[a-zA-Z-]+$/,
				description: "May contain only english letters and dashes"
			}),
			new Validator($("#website"), {
				name: "Website URL",
				required: false,
				minLenght: 3,
				maxLenght: 150,
				filter: /^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-~#%?=*&^]*)*\/?$/,
			}),
			new Validator($("#phone"), {
				name: "Phone Number",
				required: false,
				minLenght: 3,
				maxLenght: 20,
				filter: /^((\+\d{1,3}(-| )?\(?\d\)?(-| )?\d{1,5})|(\(?\d{2,6}\)?))(-| )?(\d{3,4})(-| )?(\d{4})(( x| ext)\d{1,5}){0,1}$/,
			}),
			new Validator($("#fax"), {
				name: "Fax Number",
				required: false,
				minLenght: 3,
				maxLenght: 20,
				filter: /^((\+\d{1,3}(-| )?\(?\d\)?(-| )?\d{1,5})|(\(?\d{2,6}\)?))(-| )?(\d{3,4})(-| )?(\d{4})(( x| ext)\d{1,5}){0,1}$/,
			}),
			new Validator($("#address"), {
				name: "Street Address",
				required: false,
				minLenght: 3,
				maxLenght: 60,
				filter: /(\b\w*\b)(\s{1,2}\w)*\s\d{1,5}[\s\w.]*/,
			}),
			new Validator($("#city"), {
				name: "City Name",
				required: false,
				minLenght: 3,
				maxLenght: 30,
				filter: /^[a-zA-Z]+(?:[\s-][a-zA-Z]+)*$/,
			}),
			new Validator($("#state"), {
				name: "State Name",
				required: false,
				minLenght: 3,
				maxLenght: 30,
				filter: /^[a-zA-Z]+(?:[\s-][a-zA-Z]+)*$/,
			}),
			new Validator($("#zip"), {
				name: "ZIP Code",
				required: false,
				minLenght: 4,
				maxLenght: 5,
				filter: /^\d{5}$/,
			})
		]);
	}
	
	function changeCategory()
	{
		switch($("#category option:selected").val())
		{
			case "Individual":
			case "Entrepreneur":
				$("#company-input-block").remove();
				break;
			case "Organization or Company":
				$("#category-input-block")
					.after('<div id="company-input-block" class="input-block"><div class="label-wrapper"><label for="company">Company Name<span class="required_mark">*</span></label></div><div class="input-wrapper"><input id="company" name="company" type="text" maxlength="50" placeholder="Company"></div></div>');
				applyValidation();
				break;
		}
	}
	
	function changeSpecialist()
	{
		if($("#specialist-input-block input[type='checkbox'][value='other']").prop('checked'))
		{
			$("#specialist-other-label")
				.after('<div id="specialist-other-input-block"><input id="specialist-other-input" name="specialist[]" type="text" maxlength="50" placeholder="Specialist"></div>');
				applyValidation();
		}
		else
		{
			$("#specialist-other-input-block").remove();
		}
	}
</script>

<style>
	.content
	{
		text-align: center;
	}
	
	.headline
	{
		margin: 20px auto;
	}
	
	.input-block
	{
		width: 400px;
	}
	
	.checkbox-wrapper
	{
		margin: 2px 0px 2px 10px;
	}
	
	.error-wrapper
	{
		float: none;
		width: auto;
	}
	
	#register-form input[type="text"],
	#register-form input[type="password"]
	{
		width: 178px;
	}
	
	#register-form select
	{
		width: 200px;
	}
	
	#password-input-block,
	#email-input-block,
	#first-name-input-block,
	#website-input-block,
	#address-input-block,
	#category-input-block
	{
		margin-top: 20px;
	}
	
	#honorific,
	#country,
	#category
	{
		width: 160px;
		height: 24px;
	}
	
	#specialist-other-label
	{
		float: left;
	}
	
	#specialist-other-input
	{
		margin-top: -2px;
		margin-left: 120px;
	}
	
	#specialist-other-input-block
	{
		float: left;
	}
	
	#submit-input-block
	{
		width: 430px;
	}
</style>

<div class="headline">
	<p>Create Account</p>
</div>
<div class="content">
	<form id="register-form" class="dark-form" action="<?php LinkToAction('register') ?>" method="post" autocomplete="on">        
		<div class="set-block">
			<fieldset>
				<legend>Account Information</legend>
				<div id="username-input-block" class="input-block">
					<div class="label-wrapper">
						<label for="username">Username<span class="required_mark">*</span></label>
					</div>
					<div class="input-wrapper">
						<input id="username" name="username" type="text" maxlength="50" placeholder="username">
					</div>
				</div>
				<div id="password-input-block" class="input-block">
					<div class="label-wrapper">
						<label for="password">Password<span class="required_mark">*</span></label>
					</div>
					<div class="input-wrapper">
						<input id="password" name="password" type="password" maxlength="50" placeholder="&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;">
					</div>
				</div>
				<div id="repeat-password-input-block" class="input-block">
					<div class="label-wrapper">
						<label for="repeat-password">Repeat Password<span class="required_mark">*</span></label>
					</div>
					<div class="input-wrapper">
						<input id="repeat-password" name="repeat-password" type="password" maxlength="50" placeholder="&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;">
					</div>
				</div>
				<div id="email-input-block" class="input-block">
					<div class="label-wrapper">
						<label for="email">Email<span class="required_mark">*</span></label>
					</div>
					<div class="input-wrapper">
						<input id="email" name="email" type="text" maxlength="50" placeholder="your@email.com">
					</div>
				</div>
				<div id="repeat-email-input-block" class="input-block">
					<div class="label-wrapper">
						<label for="repeat-email">Repeat Email<span class="required_mark">*</span></label>
					</div>
					<div class="input-wrapper">
						<input id="repeat-email" name="repeat-email" type="text" maxlength="50" placeholder="your@email.com">
					</div>
				</div>
			</fieldset>
		</div>
		<div class="set-block">
			<fieldset>
				<legend>Business Information</legend>
				<div id="category-input-block" class="input-block">
					<div class="label-wrapper">
						<label for="category">Your Category<span class="required_mark">*</span></label>
					</div>
					<div class="input-wrapper">
						<select id="category" name="category">
							<option value="Individual">Individual</option>
							<option value="Entrepreneur">Entrepreneur</option>
							<option value="Organization or Company">Organization or Company</option>
						</select>
					</div>
				</div>
				<div id="specialist-input-block" class="input-block">
					<div class="label-wrapper">
						<label for="specialist[]">You are Interested in Certification as:</label>
					</div>
					<div class="checkbox-wrapper">
						<input type="checkbox" name="specialist[]" value="researcher">
						<label>Researcher</label>
					</div>
					<div class="checkbox-wrapper">
						<input type="checkbox" name="specialist[]" value="consultant">
						<label>Consultant</label>
					</div>
					<div class="checkbox-wrapper">
						<input type="checkbox" name="specialist[]" value="consumer">
						<label>Consumer</label>
					</div>
					<div class="checkbox-wrapper">
						<input type="checkbox" value="other">
						<label id="specialist-other-label" name="specialist[]">Other</label>
					</div>
				</div>
			</fieldset>
		</div>
		<div class="set-block">
			<fieldset>
				<legend>Contact Information</legend>
				<div id="first-name-input-block" class="input-block">
					<div class="label-wrapper">
						<label for="first-name">First Name<span class="required_mark">*</span></label>
					</div>
					<div class="input-wrapper">
						<input id="first-name" name="firstName" type="text" maxlength="50" placeholder="First name">
					</div>
				</div>
				<div id="second-name-input-block" class="input-block">
					<div class="label-wrapper">
						<label for="second-name">Second Name<span class="required_mark">*</span></label>
					</div>
					<div class="input-wrapper">
						<input id="second-name" name="secondName" type="text" maxlength="50" placeholder="Second name">
					</div>
				</div>
				<div id="honorific-input-block" class="input-block">
					<div class="label-wrapper">
						<label for="honorific">Honorific<span class="required_mark">*</span></label>
					</div>
					<div class="input-wrapper">
						<select id="honorific" name="honorific">
							<option value="Mr.">Mr.</option>
							<option value="Ms.">Ms.</option>
							<option value="Miss">Miss</option>
							<option value="Mrs.">Mrs.</option>
						</select>
					</div>
				</div>
				<div id="website-input-block" class="input-block">
					<div class="label-wrapper">
						<label for="website">Website</label>
					</div>
					<div class="input-wrapper">
						<input id="website" name="website" type="text" maxlength="150" placeholder="www.yourwebsite.com">
					</div>
				</div>
				<div id="phone-input-block" class="input-block">
					<div class="label-wrapper">
						<label for="phone">Phone Number</label>
					</div>
					<div class="input-wrapper">
						<input id="phone" name="phone" type="text" maxlength="15" placeholder="###########">
					</div>
				</div>
				<div id="fax-input-block" class="input-block">
					<div class="label-wrapper">
						<label for="fax">Fax Number</label>
					</div>
					<div class="input-wrapper">
						<input id="fax" name="fax" type="text" maxlength="15" placeholder="###########">
					</div>
				</div>
				<div id="address-input-block" class="input-block">
					<div class="label-wrapper">
						<label for="address">Address</label>
					</div>
					<div class="input-wrapper">
						<input id="address" name="address" type="text" maxlength="100" placeholder="Some street 123">
					</div>
				</div>
				<div id="city-input-block" class="input-block">
					<div class="label-wrapper">
						<label for="city">City</label>
					</div>
					<div class="input-wrapper">
						<input id="city" name="city" type="text" maxlength="50" placeholder="Some city">
					</div>
				</div>
				<div id="state-input-block" class="input-block">
					<div class="label-wrapper">
						<label for="state">State</label>
					</div>
					<div class="input-wrapper">
						<input id="state" name="state" type="text" maxlength="50" placeholder="Some state">
					</div>
				</div>
				<div id="zip-input-block" class="input-block">
					<div class="label-wrapper">
						<label for="zip">ZIP</label>
					</div>
					<div class="input-wrapper">
						<input id="zip" name="zip" type="text" maxlength="5" placeholder="#####">
					</div>
				</div>
				<div id="country-input-block" class="input-block">
					<div class="label-wrapper">
						<label for="country">Country</label>
					</div>
					<div class="input-wrapper">
						<select id="country" name="country">
							<option value="" selected="selected">Select Country</option>
							<option value="Afganistan">Afghanistan</option>
							<option value="Albania">Albania</option>
							<option value="Algeria">Algeria</option>
							<option value="American Samoa">American Samoa</option>
							<option value="Andorra">Andorra</option>
							<option value="Angola">Angola</option>
							<option value="Anguilla">Anguilla</option>
							<option value="Antigua &amp; Barbuda">Antigua &amp; Barbuda</option>
							<option value="Argentina">Argentina</option>
							<option value="Armenia">Armenia</option>
							<option value="Aruba">Aruba</option>
							<option value="Australia">Australia</option>
							<option value="Austria">Austria</option>
							<option value="Azerbaijan">Azerbaijan</option>
							<option value="Bahamas">Bahamas</option>
							<option value="Bahrain">Bahrain</option>
							<option value="Bangladesh">Bangladesh</option>
							<option value="Barbados">Barbados</option>
							<option value="Belarus">Belarus</option>
							<option value="Belgium">Belgium</option>
							<option value="Belize">Belize</option>
							<option value="Benin">Benin</option>
							<option value="Bermuda">Bermuda</option>
							<option value="Bhutan">Bhutan</option>
							<option value="Bolivia">Bolivia</option>
							<option value="Bonaire">Bonaire</option>
							<option value="Bosnia &amp; Herzegovina">Bosnia &amp; Herzegovina</option>
							<option value="Botswana">Botswana</option>
							<option value="Brazil">Brazil</option>
							<option value="British Indian Ocean Ter">British Indian Ocean Ter</option>
							<option value="Brunei">Brunei</option>
							<option value="Bulgaria">Bulgaria</option>
							<option value="Burkina Faso">Burkina Faso</option>
							<option value="Burundi">Burundi</option>
							<option value="Cambodia">Cambodia</option>
							<option value="Cameroon">Cameroon</option>
							<option value="Canada">Canada</option>
							<option value="Canary Islands">Canary Islands</option>
							<option value="Cape Verde">Cape Verde</option>
							<option value="Cayman Islands">Cayman Islands</option>
							<option value="Central African Republic">Central African Republic</option>
							<option value="Chad">Chad</option>
							<option value="Channel Islands">Channel Islands</option>
							<option value="Chile">Chile</option>
							<option value="China">China</option>
							<option value="Christmas Island">Christmas Island</option>
							<option value="Cocos Island">Cocos Island</option>
							<option value="Colombia">Colombia</option>
							<option value="Comoros">Comoros</option>
							<option value="Congo">Congo</option>
							<option value="Cook Islands">Cook Islands</option>
							<option value="Costa Rica">Costa Rica</option>
							<option value="Cote DIvoire">Cote D'Ivoire</option>
							<option value="Croatia">Croatia</option>
							<option value="Cuba">Cuba</option>
							<option value="Curaco">Curacao</option>
							<option value="Cyprus">Cyprus</option>
							<option value="Czech Republic">Czech Republic</option>
							<option value="Denmark">Denmark</option>
							<option value="Djibouti">Djibouti</option>
							<option value="Dominica">Dominica</option>
							<option value="Dominican Republic">Dominican Republic</option>
							<option value="East Timor">East Timor</option>
							<option value="Ecuador">Ecuador</option>
							<option value="Egypt">Egypt</option>
							<option value="El Salvador">El Salvador</option>
							<option value="Equatorial Guinea">Equatorial Guinea</option>
							<option value="Eritrea">Eritrea</option>
							<option value="Estonia">Estonia</option>
							<option value="Ethiopia">Ethiopia</option>
							<option value="Falkland Islands">Falkland Islands</option>
							<option value="Faroe Islands">Faroe Islands</option>
							<option value="Fiji">Fiji</option>
							<option value="Finland">Finland</option>
							<option value="France">France</option>
							<option value="French Guiana">French Guiana</option>
							<option value="French Polynesia">French Polynesia</option>
							<option value="French Southern Ter">French Southern Ter</option>
							<option value="Gabon">Gabon</option>
							<option value="Gambia">Gambia</option>
							<option value="Georgia">Georgia</option>
							<option value="Germany">Germany</option>
							<option value="Ghana">Ghana</option>
							<option value="Gibraltar">Gibraltar</option>
							<option value="Great Britain">Great Britain</option>
							<option value="Greece">Greece</option>
							<option value="Greenland">Greenland</option>
							<option value="Grenada">Grenada</option>
							<option value="Guadeloupe">Guadeloupe</option>
							<option value="Guam">Guam</option>
							<option value="Guatemala">Guatemala</option>
							<option value="Guinea">Guinea</option>
							<option value="Guyana">Guyana</option>
							<option value="Haiti">Haiti</option>
							<option value="Hawaii">Hawaii</option>
							<option value="Honduras">Honduras</option>
							<option value="Hong Kong">Hong Kong</option>
							<option value="Hungary">Hungary</option>
							<option value="Iceland">Iceland</option>
							<option value="India">India</option>
							<option value="Indonesia">Indonesia</option>
							<option value="Iran">Iran</option>
							<option value="Iraq">Iraq</option>
							<option value="Ireland">Ireland</option>
							<option value="Isle of Man">Isle of Man</option>
							<option value="Israel">Israel</option>
							<option value="Italy">Italy</option>
							<option value="Jamaica">Jamaica</option>
							<option value="Japan">Japan</option>
							<option value="Jordan">Jordan</option>
							<option value="Kazakhstan">Kazakhstan</option>
							<option value="Kenya">Kenya</option>
							<option value="Kiribati">Kiribati</option>
							<option value="Korea North">Korea North</option>
							<option value="Korea Sout">Korea South</option>
							<option value="Kuwait">Kuwait</option>
							<option value="Kyrgyzstan">Kyrgyzstan</option>
							<option value="Laos">Laos</option>
							<option value="Latvia">Latvia</option>
							<option value="Lebanon">Lebanon</option>
							<option value="Lesotho">Lesotho</option>
							<option value="Liberia">Liberia</option>
							<option value="Libya">Libya</option>
							<option value="Liechtenstein">Liechtenstein</option>
							<option value="Lithuania">Lithuania</option>
							<option value="Luxembourg">Luxembourg</option>
							<option value="Macau">Macau</option>
							<option value="Macedonia">Macedonia</option>
							<option value="Madagascar">Madagascar</option>
							<option value="Malaysia">Malaysia</option>
							<option value="Malawi">Malawi</option>
							<option value="Maldives">Maldives</option>
							<option value="Mali">Mali</option>
							<option value="Malta">Malta</option>
							<option value="Marshall Islands">Marshall Islands</option>
							<option value="Martinique">Martinique</option>
							<option value="Mauritania">Mauritania</option>
							<option value="Mauritius">Mauritius</option>
							<option value="Mayotte">Mayotte</option>
							<option value="Mexico">Mexico</option>
							<option value="Midway Islands">Midway Islands</option>
							<option value="Moldova">Moldova</option>
							<option value="Monaco">Monaco</option>
							<option value="Mongolia">Mongolia</option>
							<option value="Montserrat">Montserrat</option>
							<option value="Morocco">Morocco</option>
							<option value="Mozambique">Mozambique</option>
							<option value="Myanmar">Myanmar</option>
							<option value="Nambia">Nambia</option>
							<option value="Nauru">Nauru</option>
							<option value="Nepal">Nepal</option>
							<option value="Netherland Antilles">Netherland Antilles</option>
							<option value="Netherlands">Netherlands (Holland, Europe)</option>
							<option value="Nevis">Nevis</option>
							<option value="New Caledonia">New Caledonia</option>
							<option value="New Zealand">New Zealand</option>
							<option value="Nicaragua">Nicaragua</option>
							<option value="Niger">Niger</option>
							<option value="Nigeria">Nigeria</option>
							<option value="Niue">Niue</option>
							<option value="Norfolk Island">Norfolk Island</option>
							<option value="Norway">Norway</option>
							<option value="Oman">Oman</option>
							<option value="Pakistan">Pakistan</option>
							<option value="Palau Island">Palau Island</option>
							<option value="Palestine">Palestine</option>
							<option value="Panama">Panama</option>
							<option value="Papua New Guinea">Papua New Guinea</option>
							<option value="Paraguay">Paraguay</option>
							<option value="Peru">Peru</option>
							<option value="Phillipines">Philippines</option>
							<option value="Pitcairn Island">Pitcairn Island</option>
							<option value="Poland">Poland</option>
							<option value="Portugal">Portugal</option>
							<option value="Puerto Rico">Puerto Rico</option>
							<option value="Qatar">Qatar</option>
							<option value="Republic of Montenegro">Republic of Montenegro</option>
							<option value="Republic of Serbia">Republic of Serbia</option>
							<option value="Reunion">Reunion</option>
							<option value="Romania">Romania</option>
							<option value="Russia">Russia</option>
							<option value="Rwanda">Rwanda</option>
							<option value="St Barthelemy">St Barthelemy</option>
							<option value="St Eustatius">St Eustatius</option>
							<option value="St Helena">St Helena</option>
							<option value="St Kitts-Nevis">St Kitts-Nevis</option>
							<option value="St Lucia">St Lucia</option>
							<option value="St Maarten">St Maarten</option>
							<option value="St Pierre &amp; Miquelon">St Pierre &amp; Miquelon</option>
							<option value="St Vincent &amp; Grenadines">St Vincent &amp; Grenadines</option>
							<option value="Saipan">Saipan</option>
							<option value="Samoa">Samoa</option>
							<option value="Samoa American">Samoa American</option>
							<option value="San Marino">San Marino</option>
							<option value="Sao Tome &amp; Principe">Sao Tome &amp; Principe</option>
							<option value="Saudi Arabia">Saudi Arabia</option>
							<option value="Senegal">Senegal</option>
							<option value="Serbia">Serbia</option>
							<option value="Seychelles">Seychelles</option>
							<option value="Sierra Leone">Sierra Leone</option>
							<option value="Singapore">Singapore</option>
							<option value="Slovakia">Slovakia</option>
							<option value="Slovenia">Slovenia</option>
							<option value="Solomon Islands">Solomon Islands</option>
							<option value="Somalia">Somalia</option>
							<option value="South Africa">South Africa</option>
							<option value="Spain">Spain</option>
							<option value="Sri Lanka">Sri Lanka</option>
							<option value="Sudan">Sudan</option>
							<option value="Suriname">Suriname</option>
							<option value="Swaziland">Swaziland</option>
							<option value="Sweden">Sweden</option>
							<option value="Switzerland">Switzerland</option>
							<option value="Syria">Syria</option>
							<option value="Tahiti">Tahiti</option>
							<option value="Taiwan">Taiwan</option>
							<option value="Tajikistan">Tajikistan</option>
							<option value="Tanzania">Tanzania</option>
							<option value="Thailand">Thailand</option>
							<option value="Togo">Togo</option>
							<option value="Tokelau">Tokelau</option>
							<option value="Tonga">Tonga</option>
							<option value="Trinidad &amp; Tobago">Trinidad &amp; Tobago</option>
							<option value="Tunisia">Tunisia</option>
							<option value="Turkey">Turkey</option>
							<option value="Turkmenistan">Turkmenistan</option>
							<option value="Turks &amp; Caicos Is">Turks &amp; Caicos Is</option>
							<option value="Tuvalu">Tuvalu</option>
							<option value="Uganda">Uganda</option>
							<option value="Ukraine">Ukraine</option>
							<option value="United Arab Erimates">United Arab Emirates</option>
							<option value="United Kingdom">United Kingdom</option>
							<option value="United States of America">United States of America</option>
							<option value="Uraguay">Uruguay</option>
							<option value="Uzbekistan">Uzbekistan</option>
							<option value="Vanuatu">Vanuatu</option>
							<option value="Vatican City State">Vatican City State</option>
							<option value="Venezuela">Venezuela</option>
							<option value="Vietnam">Vietnam</option>
							<option value="Virgin Islands (Brit)">Virgin Islands (Brit)</option>
							<option value="Virgin Islands (USA)">Virgin Islands (USA)</option>
							<option value="Wake Island">Wake Island</option>
							<option value="Wallis &amp; Futana Is">Wallis &amp; Futana Is</option>
							<option value="Yemen">Yemen</option>
							<option value="Zaire">Zaire</option>
							<option value="Zambia">Zambia</option>
							<option value="Zimbabwe">Zimbabwe</option>
						</select>
					</div>
				</div>
			</fieldset>
		</div>
		<div id="submit-input-block" class="input-block">
			<input type="submit" value="Create Account">
		</div>
	</form>
	<div class="link-block">
		<a href="<?php LinkToAction('login') ?>">To Login</a>
	</div>
</div>