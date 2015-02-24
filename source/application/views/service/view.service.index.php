<?php IncludeJS('form'); ?>

<script>
	var form = null;
	var woodProductsCount = 0;
	var woodProductsLimit = 20;
	var woodProductSuppliersCount = 0;
	var woodProductSuppliersLimit = 20;
	
	$(document).ready( function() {
		form = new Form($("#service-form"));
		
		form.submitFunction = function() {
			form.request();
		};
		
		applyValidation();
		
		$("#standard-type").change( function() {
			switch($("#standard-type option:selected").val())
			{
				case "FSC":
					$("#certificate-input-block input[type='checkbox'][value='Group Forestry Management']").
						attr("disabled", null);
					$("#certificate-input-block input[type='checkbox'][value='Project Certification']").
						attr("disabled", null);
					$("#certificate-input-block input[type='checkbox'][value='Controlled Wood']").
						attr("disabled", null);
					$("#certificate-input-block input[type='checkbox'][value='Group Chain Of Custodies']").
						attr("disabled", null);
					break;
				case "PEFC":
					$("#certificate-input-block input[type='checkbox'][value='Group Forestry Management']").
						attr("disabled", true);
					$("#certificate-input-block input[type='checkbox'][value='Project Certification']").
						attr("disabled", true);
					$("#certificate-input-block input[type='checkbox'][value='Controlled Wood']").
						attr("disabled", true);
					$("#certificate-input-block input[type='checkbox'][value='Group Chain Of Custodies']").
						attr("disabled", true);
					break;
			}
		});
		
		$("#add-wood-product").
			click(addWoodProduct);
		addWoodProduct();
		
		$("#add-wood-product-supplier").
			click(addWoodProductSupplier);
		addWoodProductSupplier();
	});
	
	function applyValidation()
	{
		form.applyValidation( validators = [
			new Validator($("#certificate"), {
				callback: function (validator)
				{
					if($("#certificate-input-block input:checked").length > 0)
					{
						return true;
					}
					else
					{
						validator.printError($("#certificate"), "Must be choosen at least one option");
						return false;
					}
				}
			}),
			new Validator($("#organisation-information-turnover"), {
				name: "Annual Turnover of the Company",
				required: true,
				minLenght: 3,
				maxLenght: 12,
				filter: /^[0-9]+$/,
				description: "Must be number"
			}),
			new Validator($("#organisation-information-staff"), {
				name: "Number of Staff in the Company",
				required: true,
				minLenght: 1,
				maxLenght: 12,
				filter: /^[0-9]+$/,
				description: "Must be number"
			}),
			new Validator($(".wood-product"), {
				name: "Wood Product",
				required: true,
				minLenght: 2,
				maxLenght: 100,
				filter: /^[a-zA-Z0-9- ]+$/,
				description: "May contain only latin letters, digits and dashes"
			}),
			new Validator($(".annual-output"), {
				name: "Annual Output",
				required: true,
				minLenght: 1,
				maxLenght: 12,
				filter: /^[0-9]+$/,
				description: "Must be number"
			}),
			new Validator($("input.wood-product-supply"), {
				name: "Wood Product Supply",
				required: true,
				minLenght: 2,
				maxLenght: 100,
				filter: /^[a-zA-Z0-9- ]+$/,
				description: "May contain only latin letters, digits and dashes"
			}),
			new Validator($(".supply-volume"), {
				name: "Wood Product Supply Volume",
				required: true,
				minLenght: 1,
				maxLenght: 12,
				filter: /^[0-9]+$/,
				description: "Must be number"
			}),
			new Validator($("input.wood-product-supplier"), {
				name: "Wood Product Supply",
				required: true,
				minLenght: 2,
				maxLenght: 100,
				filter: /^[a-zA-Z0-9- ]+$/,
				description: "May contain only latin letters, digits and dashes"
			}),
			new Validator($("#enquiry"), {
				name: "enquiry",
				required: false,
				minLenght: 10,
				maxLenght: 5000,
				filter: /^[a-zA-Z0-9 \.,-\/#!$%\^&\*;:{}=\-_`~()''""\n]+$/,
				description: "May contain only latin letters, punctuation marks and whitespaces"
			})
		]);
	}
	
	function addWoodProduct()
	{
		woodProductsCount++;
		
		$("#add-wood-product-block")
			.before('<div class="input-wrapper wood-product-input-wrapper"><div class="input-block wood-product-title"><p>Wood Product ' + woodProductsCount +'</p></div><div class="input-block remove-wood-product"><input class="remove-wood-product" type="button" value="Remove"></div><div class="input-block wood-product-name"><div class="label-wrapper"><label for="wood-product">Product Name<span class="required_mark">*</span></label></div><div class="input-wrapper"><input type="text" class="wood-product" name="woodProductName[]"></div></div><div class="input-block wood-product-output"><div class="label-wrapper"><label for="annual-output">Annual Output<span class="required_mark">*</span></label></div><div class="input-wrapper"><select class="annual-output-type" name="woodProductOutputType[]"><option value="cubic meters">Cubic Meters</option><option value="tonnes">Tonnes</option></select></div><div class="input-wrapper"><input type="text" class="annual-output" name="woodProductOutput[]"></div></div></div>');
		
		$(".remove-wood-product")
			.unbind("click")
			.click(removeWoodProduct);
		
		$("#wood-products-input-block .remove-wood-product:first")
			.hide();
		
		applyValidation();
		
		if(woodProductsCount >= woodProductsLimit)
		{
			$("#add-wood-product-block")
				.hide();
		}
	}
	
	function removeWoodProduct()
	{
		var element = $(this).parents(".wood-product-input-wrapper");
		var elements = element.nextAll(".wood-product-input-wrapper");
		var count = elements.length;
		
		elements
			.each( function(index) {
				$(this)
					.find(".input-block .wood-product-title")
					.html("<p>Wood Product " + (woodProductsCount - count) + "</p>");
				count--;
			});
		
		element.remove();
		woodProductsCount--;
		
		if(woodProductsCount < woodProductsLimit)
		{
			$("#add-wood-product-block")
				.show();
		}
	}
	
	function addWoodProductSupplier()
	{
		woodProductSuppliersCount++;
		
		$("#add-wood-product-supplier-block")
			.before('<div class="input-wrapper wood-product-supplier-input-wrapper"><div class="input-block wood-product-supplier-title"><p>Wood Product Supplier ' + woodProductSuppliersCount +'</p></div><div class="input-block remove-wood-product-supplier"><input class="remove-wood-product-supplier" type="button" value="Remove"></div><div class="input-block wood-product-supply"><div class="label-wrapper"><label for="wood-product-supply">Product Name<span class="required_mark">*</span></label></div><div class="input-wrapper"><input type="text" class="wood-product-supply" name="woodProductSupply[]"></div></div><div class="input-block wood-product-supply-volume"><div class="label-wrapper"><label for="supply-volume">Volume<span class="required_mark">*</span></label></div><div class="input-wrapper"><select class="supply-volume-type" name="woodProductSupplyVolumeType[]"><option value="cubic meters">Cubic Meters</option><option value="tonnes">Tonnes</option></select></div><div class="input-wrapper"><input type="text" class="supply-volume" name="woodProductSupplyVolume[]"></div></div><div class="input-block wood-product-supplier"><div class="label-wrapper"><label for="wood-product-supplier">Supplier<span class="required_mark">*</span></label></div><div class="input-wrapper"><input type="text" class="wood-product-supplier" name="woodProductSupplier[]"></div></div></div>');
		
		$(".remove-wood-product-supplier")
			.unbind("click")
			.click(removeWoodProductSupplier);
		
		$("#wood-product-suppliers-input-block .remove-wood-product-supplier:first")
			.hide();
		
		applyValidation();
		
		if(woodProductSuppliersCount >= woodProductSuppliersLimit)
		{
			$("#add-wood-product-supplier-block")
				.hide();
		}
	}
	
	function removeWoodProductSupplier()
	{
		var element = $(this).parents(".wood-product-supplier-input-wrapper");
		var elements = element.nextAll(".wood-product-supplier-input-wrapper");
		var count = elements.length;
		
		elements
			.each( function(index) {
				$(this)
					.find(".wood-product-supplier-title")
					.html("<p>Wood Product Supplier " + (woodProductSuppliersCount - count) + "</p>");
				count--;
			});
		
		element.remove();
		woodProductSuppliersCount--;
		
		if(woodProductSuppliersCount < woodProductSuppliersLimit)
		{
			$("#add-wood-product-supplier-block")
				.show();
		}
	}
</script>

<style>	
	.column-1-2
	{
		width: auto;
	}
	
	.input-block
	{
		width: 400px;
	}
	
	#standard-type-input-block
	{
		margin: 20px;
	}
	
	#certificate-input-block .input-wrapper
	{
		float: none;
	}
	
	#certificate-input-block .error-wrapper
	{
		width: 370px;
	}
	
	#organisation-information-turnover-input-block .error-wrapper,
	#organisation-information-staff-input-block .error-wrapper
	{
		width: 150px;
	}
	
	#organisation-information-turnover,
	#organisation-information-staff,
	.dark-form input[type="text"].annual-output,
	.dark-form input[type="text"].supply-volume
	{
		width: 70px;
		margin: 0px 5px;
	}
	
	#organisation-information-turnover-currency-type
	{
		width: 70px;
		height: 24px;
		
		padding-right: 0px;
	}
	
	#organisation-information-staff-text-wrapper
	{
		width: 70px;
		
		line-height: 1.8;
		text-align: center;
	}
	
	.wood-product-input-wrapper,
	.wood-product-supplier-input-wrapper
	{
		padding: 5px 0px;
		border-bottom: 1px dashed #c0c0c0;
	}
	
	.dark-form input[type="text"].wood-product,
	.dark-form input[type="text"].wood-product-supply,
	.dark-form input[type="text"].wood-product-supplier
	{
		width: 200px;
	}
	
	.dark-form select.annual-output-type,
	.dark-form select.supply-volume-type
	{
		width: 125px;
		height: 24px;
		
		padding-right: 0px;
	}
	
	.input-block .wood-product .error-wrapper
	{
		width: auto;
	}
	
	.input-block .wood-product-output .error-wrapper,
	.input-block .wood-product-supply-volume .error-wrapper
	{
		width: 205px;
	}
	
	.input-block .wood-product-title,
	.input-block .wood-product-supplier-title
	{
		clear: none;
		width: auto;
	}
	
	.input-block .wood-product-name .error-wrapper,
	.input-block .wood-product-supply .error-wrapper,
	.input-block .wood-product-supplier .error-wrapper
	{
		width: 206px;
	}
	
	.input-block .remove-wood-product,
	.input-block .remove-wood-product-supplier
	{
		float: right;
		clear: none;
		
		width: 100px;
	}
	
	.dark-form input[type="button"].remove-wood-product,
	.dark-form input[type="button"].remove-wood-product-supplier
	{
		width: 100px;
	}
	
	#add-wood-product,
	#add-wood-product-supplier
	{
		width: 100px;
		margin-top: 5px;
	}
	
	.dark-form textarea
	{
		width: 378px;
		height: 195px;
	}
	
	#additional-information-input-block .label-wrapper
	{
		margin: 5px;
	}
	
	#additional-information-input-block .error-wrapper
	{
		width: auto;
	}
	
	#submit-input-block
	{
		float: right;
		width: 140px;
	}
	
	#submit-input-block input
	{
		float: right;
	}
	
	#result-input-block
	{
		clear: none;
		width: 720px;
	}
	
	#result-input-block p
	{
		margin: 15px 0px 0px 15px;
	}
</style>

<div class="headline">
	<p>Build a System</p>
</div>
<div class="content">
	<form id="service-form" class="dark-form" action="<?php LinkToAction('service') ?>" method="post" autocomplete="on"> 
		<div class="column-1-2">
			<div id="standard-type-input-block" class="input-block">
				<div class="label-wrapper">
					<label for="standard-type">Type of Standard<span class="required_mark">*</span></label>
				</div>
				<div class="input-wrapper">
					<select id="standard-type" name="standard">
						<option value="FSC">FSC</option>
						<option value="PEFC">PEFC</option>
					</select>
				</div>
			</div>
			<div id="certificate-input-block" class="input-block">
				<div class="input-wrapper">
					<fieldset id="certificate">
						<legend>Types of Certificates<span class="required_mark">*</span></legend>
						<div class="input-block">
							<div class="checkbox-wrapper">
								<input type="checkbox" name="certificate[]" value="Forestry Management">
								<label>Forestry Management</label>
							</div>
							<div class="checkbox-wrapper">
								<input type="checkbox" name="certificate[]" value="Group Forestry Management">
								<label>Group Forestry Management</label>
							</div>
							<div class="checkbox-wrapper">
								<input type="checkbox" name="certificate[]" value="Project Certification">
								<label>Project Certification</label>
							</div>
							<div class="checkbox-wrapper">
								<input type="checkbox" name="certificate[]" value="Chain Of Custodies">
								<label>Chain of Custodies</label>
							</div>
							<div class="checkbox-wrapper">
								<input type="checkbox" name="certificate[]" value="Controlled Wood">
								<label>Controlled Wood</label>
							</div>
							<div class="checkbox-wrapper">
								<input type="checkbox" name="certificate[]" value="Group Chain Of Custodies">
								<label>Group Chain of Custodies</label>
							</div>
						</div>
					</fieldset>
				</div>
			</div>
			<div id="organisation-information-input-block" class="input-block">
				<fieldset>
					<legend>Organisation Information</legend>
					<div id="organisation-information-turnover-input-block" class="input-block">
						<div class="label-wrapper">
							<label for="organisation-information-turnover">Annual Turnover of the Company<span class="required_mark">*</span></label>
						</div>
						<div class="input-wrapper">
							<select id="organisation-information-turnover-currency-type" name="turnoverCurrency">
								<option value="USD">USD</option>
								<option value="EUR">EUR</option>
								<option value="EUR">UAH</option>
							</select>
						</div>
						<div class="input-wrapper">
							<input type="text" id="organisation-information-turnover" name="turnover">
						</div>
					</div>
					<div id="organisation-information-staff-input-block" class="input-block">
						<div class="label-wrapper">
							<label for="organisation-information-staff">Number of Staff in the Company<span class="required_mark">*</span></label>
						</div>
						<div class="input-wrapper" id="organisation-information-staff-text-wrapper">
							<p>Persons</p>
						</div>
						<div class="input-wrapper" id="organisation-information-staff-wrapper">
							<input type="text" id="organisation-information-staff" name="staff">
						</div>
					</div>
				</fieldset>
			</div>
			<div id="wood-products-input-block" class="input-block">
				<fieldset>
					<legend>Wood Products</legend>
					<div id="add-wood-product-block" class="input-block">
						<input id="add-wood-product" type="button" value="Add">
					</div>
				</fieldset>
			</div>
		</div>
		<div class="column-1-2">
			<div id="wood-product-suppliers-input-block" class="input-block">
				<fieldset>
					<legend>Suppliers of Wood Product</legend>
					<div id="add-wood-product-supplier-block" class="input-block">
						<input id="add-wood-product-supplier" type="button" value="Add">
					</div>
				</fieldset>
			</div>
			<div id="additional-information-input-block" class="input-block">
				<fieldset>
					<legend>Additional Information</legend>
					<div class="input-block">
						<div class="checkbox-wrapper">
							<input type="checkbox" name="iso9001" value="certified">
							<label>The organization is certified according to ISO 9000</label>
						</div>
						<div class="checkbox-wrapper">
							<input type="checkbox" name="iso14000" value="certified">
							<label>The organization is certified according to ISO 14000 / EMAS</label>
						</div>
					</div>
					<div class="input-block">
						<div class="label-wrapper">
							<label for="enquiry">Enquiry</label>
						</div>
						<div class="input-wrapper">
							<textarea id="enquiry" name="enquiry" placeholder="Any other details..." maxlength="10000"></textarea>
						</div>
					</div>
				</fieldset>
			</div>
		</div>
		<div id="submit-input-block" class="input-block">
			<input type="submit" value="Submit Order">
		</div>
	</form>
</div>