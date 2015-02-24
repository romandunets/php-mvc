$(document).ready( function() {
	$("#to-top").click( function() {
		$("html, body").animate({scrollTop: 0}, 500);
	});
});

function ucfirst(string)
{
	return string.substr(0, 1).toUpperCase() + string.substr(1);
}

function formhash(form, password)
{
    // Create a new element input, hashed password field. 
    var p = document.createElement("input");
 
    // Add the new element to the form. 
    form.appendChild(p);
    p.name = "hashedPassword";
    p.type = "hidden";
    p.value = hex_sha512(password.value);
 
    // Make sure the plaintext password doesn't get sent. 
    password.value = "";
	
    // Finally submit the form. 
    //form.submit();
}

function changePassword(form, oldPassword, newPassword, newRepeatPassword)
{
	if(newPassword.value == newRepeatPassword.value)
	{
		var oldHashedPassword = document.createElement("input");
		
		form.appendChild(oldHashedPassword);
		oldHashedPassword.name = "oldHashedPassword";
		oldHashedPassword.type = "hidden";
		oldHashedPassword.value = hex_sha512(oldPassword.value);
		
		var newHashedPassword = document.createElement("input");
		
		form.appendChild(newHashedPassword);
		newHashedPassword.name = "newHashedPassword";
		newHashedPassword.type = "hidden";
		newHashedPassword.value = hex_sha512(newPassword.value);
 
		oldPassword.value = "";
		newPassword.value = "";
		newRepeatPassword.value = "";
	
		form.submit();
	}
	else
	{
		alert("New passwords do not match!");
	}
}

function deleteAccount(form, password, repeatPassword)
{
	if(password.value == repeatPassword.value)
	{
		// Create a new element input, hashed password field. 
		var p = document.createElement("input");
	 
		// Add the new element to the form. 
		form.appendChild(p);
		p.name = "hashedPassword";
		p.type = "hidden";
		p.value = hex_sha512(password.value);
	 
		// Make sure the plaintext password doesn't get sent. 
		password.value = "";
		repeatPassword.value = "";
	 
		// Finally submit the form. 
		form.submit();
	}
	else
	{
		alert("New passwords do not match!");
	}
}

function regformhash(form, username, password, conf)
{
    if(username.value == '' || password.value == '' || conf.value == '')
	{
        alert('You must provide all the requested details. Please try again');
        return false;
    }
 
    // Check the username
    re = /^\w+$/; 
    if(!re.test(form.username.value))
	{ 
        alert("Username must contain only letters, numbers and underscores. Please try again"); 
        form.username.focus();
        return false;
    }
 
    // Check that the password is sufficiently long (min 6 chars)
    if (password.value.length < 6)
	{
        alert('Passwords must be at least 6 characters long.  Please try again');
        form.password.focus();
        return false;
    }
 
    // At least one number, one lowercase and one uppercase letter 
    // At least six characters 
    var re = /(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}/; 
    if (!re.test(password.value))
	{
        alert('Passwords must contain at least one number, one lowercase and one uppercase letter. Please try again');
        return false;
    }
 
    // Check password and confirmation are the same
    if (password.value != conf.value)
	{
        alert('Your password and confirmation do not match. Please try again');
        form.password.focus();
        return false;
    }
 
    // Create a new element input, this will be our hashed password field. 
    var p = document.createElement("input");
 
    // Add the new element to our form. 
    form.appendChild(p);
    p.name = "p";
    p.type = "hidden";
    p.value = hex_sha512(password.value);
 
    // Make sure the plaintext password doesn't get sent. 
    password.value = "";
    conf.value = "";
 
    // Finally submit the form. 
    form.submit();
    return true;
}