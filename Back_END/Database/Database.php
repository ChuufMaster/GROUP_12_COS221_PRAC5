<?php

class Database
{
    private $connection; // Database connection

    public static function instance($host, $username, $password, $database)
    {
        static $instance = null;
        if ($instance === null)
        {
            $instance = new Database($host, $username, $password, $database);
        }
        return $instance;
    }

    // Constructor
    public function __construct($host, $username, $password, $database)
    {
        $this->connection = $this->connect($host, $username, $password, $database);
    }

    // Connect to the database
    private function connect($host, $username, $password, $database)
    {
        $connection = mysqli_connect($host, $username, $password, $database);

        // Check connection
        if (mysqli_connect_errno())
        {
            die('Failed to connect to MySQL: ' . mysqli_connect_error());
        }

        return $connection;
    }

    // Execute an SQL query
    public function executeQuery($query)
    {
        $result = mysqli_query($this->connection, $query);

        // Check for errors
        if (!$result)
        {
            return mysqli_error($this->connection);
        }

        return $result;
    }

    // Perform a SELECT query with JOIN operations. Tables and Columns have to be arrays even if it is just one.
    public function select($tables, $columns = '*', $joins = '', $conditions = array(), $order = '', $limit = '', $or_and = "AND", $gt_lt = '=', $fuzzy = false)
    {
        if (!is_array($columns))
            $columns = array($columns);
        if (!is_array($tables))
            $tables = array($tables);
        if (!is_array($joins))
            $joins = array($joins);
        
        $query = "SELECT " . implode(', ', $columns);
        $query .= " FROM " . implode(', ', $tables);

        if (!empty($joins))
        {
            $query .= " " . implode(' ', $joins);
        }


        $condition = empty($gt_lt) ? '=' : $gt_lt;
        $wildcard = '';
        if ($fuzzy)
        {
            $condition = 'LIKE';
            $wildcard = '%';
        }


        if (!empty($conditions))
        {
            $whereConditions = array();
            foreach ($conditions as $column => $value)
            {
                $escaped_value = mysqli_real_escape_string($this->connection, $value);
                $whereConditions[] = "$column $condition '$wildcard$escaped_value$wildcard'";
            }
            $query .= " WHERE " . implode(" $or_and ", $whereConditions);
        }

        if (!empty($order))
        {
            $query .= " ORDER BY " . $order;
        }

        if (!empty($limit))
        {
            $query .= " LIMIT " . $limit;
        }

        return $this->executeQuery($query);
        //return $query;
    }

    // Perform an INSERT query. Columns has to be an array in the format (column => value)
    public function insert($table, $data)
    {
        $columns = implode(', ', array_keys($data));
        $values = implode("', '", array_values($data));
        $query = "INSERT INTO $table ($columns) VALUES ('$values')";

        $this->executeQuery($query);

        return mysqli_insert_id($this->connection);
    }

    // Perform an UPDATE query
    public function update($table, $columns, $conditions)
    {
        if (!is_array($conditions))
        {
            $conditions = array($conditions);
        }

        $wheres = array();

        foreach($conditions as $where => $value){
            $value = mysqli_real_escape_string($this->connection, $value);
            array_push($wheres, "$where = '$value'");
        }

        $set = '';
        foreach ($columns as $column => $value)
        {  
            $value = mysqli_real_escape_string($this->connection, $value);
            $set .= "$column = '$value', ";
        }
        $set = rtrim($set, ', ');

        $conditions = implode(' AND ', $conditions);
        $wheres = implode(' AND ', $wheres);

        $query = "UPDATE $table SET $set WHERE $wheres";

        return $this->executeQuery($query);
        //return $query;
    }

    // Perform a DELETE query
    public function delete($table, $conditions)
    {
        if (!is_array($conditions))
        {
            $conditions = array($conditions);
        }

        $query = "DELETE FROM $table";

        $where_conditions = array();
        foreach ($conditions as $column => $value)
        {
            $escaped_value = mysqli_real_escape_string($this->connection, $value);
            $where_conditions[] = "$column = '$escaped_value'";
        }
        $query .= " WHERE " . implode(' AND ', $where_conditions);


        return $this->executeQuery($query);
    }

    // Close the database connection
    public function close()
    {
        mysqli_close($this->connection);
    }
}

?>