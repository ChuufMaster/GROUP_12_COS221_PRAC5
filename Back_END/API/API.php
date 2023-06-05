<?php
// Assuming you have established a database connection
require_once 'Database.php';


const status = array(
    '400' => 'HTTP/1.1 400 Bad Request',
    '200' => 'HTTP/1.1 200 OK',
    '500' => 'HTTP/1.1 500 Internal Server Error'
);

const host = "wheatley.cs.up.ac.za";
const username = "u21543152";
const password = "YOEBF7WB6KVLTICOAB2W7YFBZN3LTDDV";
const database = "u21543152_PA5";

const db = Database::instance(host, username, password, database);

class API
{
    private $database;

    public static function instance()
    {
        static $instance = null;
        if ($instance === null)
        {
            $instance = new API();
        }
        return $instance;
    }

    public function __construct()
    {
        $this->database = db;
    }

    private function return_data($header, $data, $status)
    {
        header(status[$header]);
        header('content-Type:application/json');
        $response = array("status" => $status,
        "data" => $data
        );

        echo json_encode($response);
        exit();
    }

    private function check_set($to_check, $data)
    {
        if (!isset($to_check) || empty($to_check))
            $this->return_data('400', $data, 'error');
    }

    public function request()
    {
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);
        if ($_SERVER['REQUEST_METHOD'] !== "POST")
        {
            $this->return_data('400', 'Method must be post', 'error');

        }
        if (!isset($data) || empty($data))
        {
            $this->return_data('400', 'Request Body expected', "error");
        }

        $this->getType($data);

    }

    public function getType($data)
    {
        if (!isset($data['type']))
            $this->return_data('400', 'Type is expected', 'error');

        $type = $data['type'];

        switch ($type)
        {
            case 'login_signup':
                $this->login_signup($data);
                break;
            case 'manage':
                $this->manage($data);
                break;
            case 'sort_wines':
                $this->sort_wines($data);
                break;
            case 'CRUD':
                $this->CRUD($data);
                break;
            case 'suggest':
                $this->suggest($data);
                break;
            default:
                $this->return_data('400', 'Type is expected', 'error');
                break;
        }
    }

    public function manage($data)
    {
        $this->check_set($data['options'], 'Options not set');
        $this->check_set($data['options']['operation'], 'CRUD operation expected');
        $this->check_set($data['details'], 'Details expected');
        $this->check_set($data['details']['table'], 'Table expected');
        $this->check_set($data['details']['ID'], 'ID expected');

        $id = $data['details']['ID'];
        $table = $data['options']['table'];
        $operation = $data['options']['table'];

        $column_name = '';
        switch ($table)
        {
            case 'wines':
                $column_name = 'wine_id';
                break;
            case 'wineries':
                $column_name = 'winery_id';
                break;
            default:
                $this->return_data('400', 'Table not recognised it must either be wines or wineries', 'error');
                break;
        }

        switch ($operation)
        {
            case 'DELETE':
                $this->delete_from_table($table, $id, $column_name);
                break;
            case 'UPDATE':
                $this->update_table($table, $id, $data, $column_name);
                break;
            case 'INSERT':
                $this->insert_into_table($table, $data);
                break;
            default:
                $this->return_data('400', 'Operation not recognized', 'error');
        }
    }

    private function delete_from_table($table, $id, $column_name)
    {

        $result = db->delete($table, array($column_name => $id));

        if (gettype($result) === 'string')
            $this->return_data('500', $result, 'error');

        $this->return_data('200', $result, 'success');
    }

    private function update_table($table, $id, $data, $column_name)
    {
        $this->check_set($data['details']['data'], 'Details must be set');

        $details = $data['details']['data'];

        $result = db->update($table, $details, array($column_name => $id));

        if (gettype($result) === 'string')
            $this->return_data('500', $result, 'error');

        $this->return_data('200', 'Table successfully updated', 'success');
    }

    private function insert_into_table($table, $data)
    {
        $this->check_set($data['details']['data'], 'Details must be set');
        $details = $data['details']['data'];
        $result = db->insert($table, $details);

        if (gettype($result) === 'string')
            $this->return_data('500', $result, 'error');

        $this->return_data('200', 'Row successfully added to table', 'success');
    }

    public function sort_wines($data)
    {
        if (!isset($data['options']['order']) || !isset($data['options']['sort_type']) || !isset($data['limit']))
            $this->return_data('400', 'Sort details expected', 'error');

        $sort_type = $data['options']['sort_type'];
        $order = $data['options']['order'];
        $limit = $data['limit'];


        $results = db->select('wines', '*', '', '', $sort_type . ' ' . $order, $limit);

        $response = array();

        if ($results->num_rows <= 0)
        {
            $this->return_data('200', 'No results found', 'Success');
        }

        while ($row = mysqli_fetch_assoc($results))
        {
            $response[] = $row;
        }

        $this->return_data('200', $response, 'Success');
    }

    private function CRUD($data)
    {
        return;
    }

    private function suggest($data)
    {
        return;
    }

    private function login_signup($data)
    {
        switch ($data['login_signup_type'])
        {
            case 'signup':
                $this->handleSignupRequest($data);
                break;
            case 'login':
                $this->handleLoginRequest($data);
                break;
        }
    }
    private function handleSignupRequest($request_body)
    {
        // Validate the input
        $email = $request_body['email'];
        $password = $request_body['password'];
        $first_name = $request_body['first_name'];
        $last_name = $request_body['last_name'];

        if (empty($email) || empty($password))
        {
            return "Email and password are required.";
        }
        // Check if the user already exists
        if (db->select(array('users'), array('*'), array(), array('email' => $email))->num_rows > 0)
        {
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

    private function handleLoginRequest($request_body)
    {
        $email = $request_body['email'];
        $password = $request_body['password'];
        if (empty($email) || empty($password))
        {
            $return = array(
                'message' => "Email and password are required."
            );
            return $return;
        }
        // Check if the user already exists
        if (db->select(array('users'), array('*'), array(), array('email' => $email))->num_rows === 0)
        {
            $return = array(
                'message' => "There is no account associated with that Email. Please try again."
            );
            return $return;
        }

        $result = db->select(array('users'), array('*'), array(), array('email' => $email));
        $row = mysqli_fetch_assoc($result);
        $hashed_password = $row['password'];
        $salted_password = $row['salt'] . $password;
        if (password_verify($salted_password, $hashed_password))
        {
            $return = array(
                'message' => "Login Successful.",
                'api_key' => $row['api_key']
            );
            return $return;
        }
    }
}

$api = API::instance();
$api->request();

?>