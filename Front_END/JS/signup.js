// Retrieve the form data from the signup form
const username = document.getElementById('name').value;
const surname = document.getElementById('surname').value;
const email = document.getElementById('email').value;
const password = document.getElementById('password').value;
const auth_username = 'u21543152';
const auth_password = 'Just2matt';
const authString = `${auth_username}:${auth_password}`;

// Check that all fields are filled out
if (username === '' || surname === '' || email === '' || password === '') {
  alert('Please fill out all fields.');
  return;
}

// Validate the email using regex
const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
if (!emailRegex.test(email)) {
  alert('Invalid email format.');
  return;
}

// Validate the password using regex
const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\$@\$!%*?&])[A-Za-z\d\$@\$!%*?&]{8,}$/;
if (!passwordRegex.test(password)) {
  alert('Invalid password format. Password should be longer than 8 characters, contain upper and lower case letters, at least one digit and one symbol.');
  return;
}

var xhr = new XMLHttpRequest();
var url = "https://wheatley.cs.up.ac.za/u21543152/COS221/api.php";
xhr.open("POST", url, true);
xhr.setRequestHeader('Authorization', 'Basic ' + btoa(authString));
xhr.setRequestHeader("Content-Type", "application/json");
const request_body = {
    "type": "login_signup",
    "login_signup_type": "signup",
    "email": email,
    "password": password,
    "first_name": username,
    "last_name" : surname
  };
  var json_request_body = JSON.stringify(request_body);
  xhr.send(json_request_body);
  var data = JSON.parse(xhr.responseText);
  if(data.message === "Signup successful!")
  {
    localStorage.setItem('api_key',data.api_key);
    window.location.href = '../HTML/wines.html';
  }else {
    alert(data.message);
  }