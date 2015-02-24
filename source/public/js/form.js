function Form(form)
{
	this.form = form;
	this.validation = false;
	this.validators = [];
	
	this.form.submit(this, function(event) {
		if(event.data.validation && event.data.isValid())
		{
			event.data.submitFunction();
		}
			
		return false;
	});
	
	this.submitFunction = function()
	{
		this.form.submit();
	}
	
	this.hashField = function(field)
	{
		// Add a new hidden input element (hashed field) to the form 
		form
			.append("<input>")
			.find("input:last")
			.attr({
				type : "hidden",
				name : "hashed" + ucfirst(field.attr("name"))
			})
			.val(hex_sha512(field.val()));
		
		// Make sure the plain text field data doesn't get sent 
		field.val("");
	}
	
	this.applyValidation = function (validators)
	{
		this.validators = validators;
		var form = this.form;
		
		this.validators.forEach( function (element, index, array) {
				element.object.each( function(index) {
					$(this)
						.on('input', function() {
							element.validate(index);
						});
					//$(this)
					//	.unbind("change");
					$(this)
						.change(function() {
							if(element.validate(index))
							{
								element.validateOnServer(index, form);
							}
						});
				});
			});
		
		this.validation = true;
	}
	
	this.isValid = function()
	{
		var valid = true;
		
		this.validators.forEach( function (element, index, array) {
			valid = (element.validate()) ? valid : false;
		});
		
		return valid;
	}
	
	this.request = function()
	{
		var request = $.ajax({
			url: this.form.attr("action"),
			data: this.form.serialize(),
			type: "POST"
		});

		var form = this;
		request.done(function(data) {
			$("#result-input-block")
				.remove();
			alert(data);
			response = $.parseJSON(data);
			switch(response.action)
			{
				case "redirect":
					window.location.href = response.data;
					break;
				
				case "update":
					location.reload();
					break;
				
				case "success":
					form.result(response.data, "successful");
					form.reset();
					break;
				
				case "error":
					form.result(response.data, "unsuccessful");
					break;
			}
		});
	}
	
	this.result = function(message, type)
	{
		$("#result-input-block")
			.remove();
				
		form
			.append("<div></div>");
		form
			.find("div:last")
			.attr("id", "result-input-block")
			.addClass("input-block")
			.append("<p></p>");		
		
		$("#result-input-block p:first")
			.addClass(type)
			.text(message);
	}
	
	this.reset = function()
	{
		this.form
			.find("input[type=text], textarea")
				.val("");
		this.form
			.find("input[type=checkbox]").removeAttr('checked');
		
		this.form
			.find('select')
				.find('option:first')
					.attr('selected', true);  
	}
}

function Validator(object, options)
{
	this.object = object;
	
	this.name = (options.name) ? options.name : object.attr("id");
	this.required = ((options.required !== undefined) && (options.required !== null)) ? options.required : false;
	this.minLenght = (options.minLenght) ? options.minLenght : 0;
	this.maxLenght = (options.maxLenght) ? options.maxLenght : -1;
	this.filter = (options.filter) ? options.filter : null;
	this.description = (options.description) ? options.description : "Please enter a valid " + this.name;
	this.matchField = (options.matchField) ? options.matchField : null;
	this.callback = (options.callback) ? options.callback : null;
	this.remote = (options.remote) ? options.remote : null;
	
	this.isValid = null;
	
	if(this.matchField)
	{
		var validator = this;
		this.matchField
			.on('input', function() {
				validator.validate();
			});
	}
	
	this.validate = function(index)
	{
		this.isValid = true;
		
		var validator = this;
		var object = null;
		
		if((index != null) && (index != undefined))
		{
			object = this.object.slice(index, index + 1);
		}
		else
		{
			object = this.object;
		}
		
		object.each( function() {
			var value = $(this).val();
			
			$(this)
				.removeClass("input-error");
			$(this)
				.parent()
					.siblings(".error-wrapper")
						.remove();
						
			validator.isValid = true;
			
			if((validator.required) && (value.length == 0))
			{
				validator.printError($(this), "Cannot be empty");
				validator.isValid = false;
			}
			else if((value.length > 0) && (value.length < validator.minLenght))
			{
				validator.printError($(this), "Is too short");
				validator.isValid = false;
			}
			else if((validator.maxLenght > 0) && (value.length > validator.maxLenght))
			{
				validator.printError($(this), "Is too long");
				validator.isValid = false;
			}
			else if((validator.filter != null) && (value.length > 0) && (!validator.filter.test(value)))
			{
				validator.printError($(this), validator.description);
				validator.isValid = false;
			}
			else if((validator.matchField != null) && (value != validator.matchField.val()))
			{
				validator.printError($(this), "The " + validator.name + " does not match");
				validator.isValid = false;
			}
			else if((validator.callback != null) && (!validator.callback(validator)))
			{
				validator.isValid = false;
			}
		});
		
		return validator.isValid;
	}
	
	this.validateOnServer = function(index, form)
	{
		var validator = this;
		var object = null;
		
		if((index != null) && (index != undefined))
		{
			object = this.object.slice(index, index + 1);
		}
		else
		{
			object = this.object;
		}
		
		object.each( function() {
			$(this)
				.removeClass("input-error");
			$(this)
				.parent()
					.siblings(".error-wrapper")
						.remove();
			
			var request = $.ajax({
				url: form.attr("action") + "/validate",
				data: object.serialize(),
				type: "POST"
			});
			
			object = $(this);
			request.done(function(data) {
				if(data)
				{
					response = $.parseJSON(data);
					
					switch(response.action)
					{
						/*case "success":
							alert();
							validator.printError(object, response.data);
							break;*/
						
						case "error":
							validator.printError(object, response.data);
							break;
					}
				}
			});
		});
	}
	
	this.printError = function(object, text)
	{
		object
			.addClass("input-error");
		
		objectContainer = object
			.parent()
			.parent();
		objectContainer.append("<div></div>");
		objectContainer
			.find("div")
				.last()
				.addClass("error-wrapper");
		
		errorWrapper = objectContainer.find(".error-wrapper");
		errorWrapper
			.append("<p></p>");
		errorWrapper
			.find("p")
				.text(text);

		return false;
	}
}