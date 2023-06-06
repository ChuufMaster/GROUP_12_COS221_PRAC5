document.getElementById('signInBtn').addEventListener('click', function(event) {
  event.preventDefault();

  // Retrieve the form data from the login form
  const email = document.getElementById('email').value;
  const password = document.getElementById('password').value;


  // Check that all fields are filled out
  if (email === '' || password === '') {
    alert('Please fill out all fields.');
    return;
  }

  // Validate the email using regex
  const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
  if (!emailRegex.test(email)) {
    alert('Invalid email format.');
    return;
  }

  var xhr = new XMLHttpRequest();
  var url = "http://localhost/GROUP_12_COS221_PRAC5/Back_END/API/API.php";
  xhr.open("POST", url, true);
  const request_body = {
    "type": "login_signup",
    "login_signup_type": "login",
    "email": email,
    "password": password
  };
  var json_request_body = JSON.stringify(request_body);
  xhr.send(json_request_body);
  xhr.onload = function() {
    
    var data = JSON.parse(xhr.responseText).data;
    console.log(data.message);
    if (data.message === "Login Successful!") {
      localStorage.setItem('api_key', data.api_key);
      localStorage.setItem('isManager',data.is_manager);
      window.location.href = '../HTML/wines.html';
    } else {
      alert(data.message);
    }
  }
});
