<?php
// Assuming you have established a database connection
require_once '../Database/Database.php';

class API
{
    private $host;
    private $username;
    private $password;
    private $database_name;
    private $db;
    public $status_codes = array(
    '400' => 'HTTP/1.1 400 Bad Request',
    '200' => 'HTTP/1.1 200 OK',
    '500' => 'HTTP/1.1 500 Internal Server Error'
    );

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
        $this->host = "wheatley.cs.up.ac.za";
        $this->username = "u21543152";
        $this->password = "YOEBF7WB6KVLTICOAB2W7YFBZN3LTDDV";
        $this->database_name = "u21543152_PA5";
        $this->db = Database::instance($this->host, $this->username, $this->password, $this->database_name);
    }

    private function return_data($header, $data, $status)
    {
        header($this->status_codes[$header]);
        header('content-Type:application/json');
        $response = array("status" => $status,
        "data" => $data
        );

        echo json_encode($response);
        exit();
    }

    private function check_set($to_check, $message, $data)
    {
        try
        {
            if (!isset($data[$to_check]) || empty($to_check))
                $this->return_data('400', $message, 'error');
        }
        catch (error)
        {
            $this->return_data('500', $message, 'error');
        }
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
            case 'get_random':
                $this->get_random($data);
                break;
            case 'get_by_conditions':
                $this->get_by_conditions($data);
                break;
            case 'get_by_winery':
                $this->get_by_winery_or_location($data);
                break;
            case 'add_images':
                $this->add_images($data);
                break;
            default:
                $this->return_data('400', 'Type is expected or is incorrect', 'error');
                break;
        }
    }

    public function manage($data)
    {
        $this->check_set('options', 'Options not set', $data);
        $this->check_set('operation', 'CRUD operation expected', $data['options']);
        $this->check_set('details', 'Details expected', $data);
        $this->check_set('table', 'Table expected', $data['details']);
        $this->check_set('ID', 'ID expected', $data['details']);

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

        $result = $this->db->delete($table, array($column_name => $id));

        if (gettype($result) === 'string')
            $this->return_data('500', $result, 'error');

        $this->return_data('200', $result, 'success');
    }

    private function update_table($table, $id, $data, $column_name)
    {
        $this->check_set('data', 'Details must be set', $data['details']);

        $details = $data['details']['data'];

        $result = $this->db->update($table, $details, array($column_name => $id));

        if (gettype($result) === 'string')
            $this->return_data('500', $result, 'error');

        $this->return_data('200', 'Table successfully updated', 'success');
    }

    private function insert_into_table($table, $data)
    {
        $this->check_set('data', 'Details must be set', $data['details']);
        $details = $data['details']['data'];
        $result = $this->db->insert($table, $details);

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


        $results = $this->db->select('wines', '*', '', '', $sort_type . ' ' . $order, $limit);

        if (gettype($results) === 'string')
            $this->return_data('500', $results, 'error');

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
        if ($this->db->select(array('users'), array('*'), array(), array('email' => $email))->num_rows > 0)
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

        $this->db->insert('all_users', $signup_info);

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
        if ($this->db->select(array('users'), array('*'), array(), array('email' => $email))->num_rows === 0)
        {
            $return = array(
                'message' => "There is no account associated with that Email. Please try again."
            );
            return $return;
        }

        $result = $this->db->select(array('users'), array('*'), array(), array('email' => $email));
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

    private function get_random($data)
    {
        $this->check_set('limit', 'Limit must be set', $data);
        $this->check_set('table', 'Table must be set', $data);
        $this->check_set('details', 'Field must be set', $data);

        $limit = $data['limit'];
        $table = $data['table'];
        $details = $data['details'];

        $results = $this->db->select($table, $details, '', '', 'RAND()', $limit);

        if (gettype($results) === 'string')
            $this->return_data('500', $results, 'error');


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

    private function get_by_conditions($data)
    {
        $this->check_set('limit', 'Limit must be set', $data);
        $this->check_set('table', 'Table must be set', $data);
        $this->check_set('details', 'Field must be set', $data);
        $this->check_set('conditions', 'Conditions must be set', $data);

        $limit = $data['limit'];
        $table = $data['table'];
        $details = $data['details'];
        $conditions = $data['conditions'];

        $results = $this->db->select($table, $details, '', $conditions, 'RAND()', $limit);

        if (gettype($results) === 'string')
            $this->return_data('500', $results, 'error');


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

    private function get_by_winery_or_location($data)
    {
        $this->check_set('limit', 'Limit must be set', $data);
        $this->check_set('winery_name', 'Winery name must be set', $data);

        $winery_name = $data['winery_name'];
        $limit = $data['limit'];

        $results = $this->db->select('wines AS w', 'w.*', 'INNER JOIN wineries AS win ON w.winery_id = win.winery_id', array('win.winery_name' => $winery_name), '', $limit);
        if (gettype($results) === 'string')
            $this->return_data('500', $results, 'error');

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

    private function add_images($data)
    {
        $this->check_set('images', 'Images must be set', $data);
        $images = $data['images'];

        foreach ($images as $id => $image_url)
        {
            $table = 'wines';
            $column_name = 'wine_id';

            $result = $this->db->update($table, array('image' => $image_url), array($column_name => $id));

            if (gettype($result) === 'string')
                $this->return_data('500', $result, 'error');
            }
            $this->return_data('200', 'Images successfully added', 'success');
    }
}

$api = API::instance();
$api->request();

?>