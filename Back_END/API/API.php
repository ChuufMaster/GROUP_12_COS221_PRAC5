<?php
// Assuming you have established a database connection
require_once 'Database.php';
function handleSignupRequest($request_body)
{
    // Validate the input
    $email = $request_body['email'];
    $password = $request_body['password'];
    $first_name = $request_body['first_name'];
    $last_name = $request_body['last_name'];

    if (empty($email) || empty($password)) {
        return "Email and password are required.";
    }
    // Check if the user already exists
    if (db->select(array('users'), array('*'), array(), array('email' => $email))->num_rows > 0) {
        return "Email is already taken.";
    }
    // Generate a random salt
    $salt = bin2hex(random_bytes(16));

    // Combine the salt with the password
    $salted_password = $salt . $password;

    // Hash the salted password
    $hashed_password = password_hash($salted_password, PASSWORD_DEFAULT);

    $api_key = bin2hex(random_bytes(32));

    $signup_info = array('email' => $email, 'password' => $hashed_password, 'first_name' => $first_name, 'last_name' => $last_name, 'salt' => $salt, 'api_key' => $api_key);

    db->insert('all_users', $signup_info);

    return "Signup successful!";
}

function handleLoginRequest($request_body)
{
    $email = $request_body['email'];
    $password = $request_body['password'];
    if (empty($email) || empty($password)) {
        $return = array(
            'message' => "Email and password are required."
        );
        return $return;
    }
    // Check if the user already exists
    if (db->select(array('users'), array('*'), array(), array('email' => $email))->num_rows === 0) {
        $return = array(
            'message' => "There is no account associated with that Email. Please try again."
        );
        return $return;
    }

    $result = db->select(array('users'), array('*'), array(), array('email' => $email));
    $row = mysqli_fetch_assoc($result);
    $hashed_password = $row['password'];
    $salted_password = $row['salt'] . $password;
    if (password_verify($salted_password,$hashed_password))
    {
        $return = array(
            'message' => "Login Successful.",
            'api_key' => $row['api_key']
        );
        return $return;
    }
}

const db = new Database('wheatley.cs.up.ac.za', 'u21543152', 'YOEBF7WB6KVLTICOAB2W7YFBZN3LTDDV', 'u21543152_PA5');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $request_body = json_decode(file_get_contents('php://input'), true);
    switch($request_body['type']) {
        case 'SignUp':
            handleSignupRequest($request_body);
            break;
        case 'LogIn':
            handleLoginRequest($request_body);
            break;
    }

}

?>