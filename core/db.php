<?php
//implement Singleton pattern
 class DB
{

    private $host = _DB_HOST;
    private $user = _DB_USER;
    private $password = _DB_PASSWORD;
    private $db = _DB;
    private $connection;
    public $query;
    public $debug = 1;
    public $errors = array();
    private static  $instance = null;
    public static function getInstance()
    {
        if (null === self::$instance)
        {
            self::$instance = new self();
        }
        return self::$instance;
    }
    private function __clone() {}
    private function __construct() {}


    /**
     * private function
     * do connection with database
     */
    public function connect()
    {
        if (!$this->connection = mysqli_connect($this->host, $this->user, $this->password, $this->db))
            die(mysqli_error());

    }

    /**
     * function return last made query
     * @return mixed
     */
    public function last_query()
    {
        return $this->query;
    }

    /**
     * function add one record in table
     * @param $table
     * @param $values
     * @return bool|int|string
     */
    public function insert($table, $values)
    {
        $query = "INSERT INTO " . $table
            . " (`" . implode("`, `", array_keys($values)) . "`) "
            . " VALUES ('" . implode("', '", $values) . "') ";

        if ($this->debug)
            $this->query = $query;

        if (!mysqli_query($this->connection, $query)) {
            $this->errors = mysqli_error($this->connection);
            print_r($this->errors);
            return false;
        }

        return mysqli_insert_id($this->connection);
    }

    /**
     * function univ_query does an universal query with given $sql parameter as a query string
     * function
     * @param $sql
     * @return array|bool|null
     */
    public function univ_query($sql)
    {
        $row = mysqli_query($this->connection, $sql);
        $res = array();
        if ($this->debug)
            $this->query = $sql;

        if (!$row) {
            $this->errors = mysqli_error($this->connection);
            return false;
        }

        if (is_object($row)) {
            if (mysqli_num_rows($row) == 1) {
                $res = mysqli_fetch_assoc($row);
            } else {
                while ($one = mysqli_fetch_assoc($row)) {
                    $res[] = $one;
                }
            }
            return $res;
        }
    }

    /** function add many records in table
     * @param $table
     * @param $array_values
     * @return bool|int
     */
    public function insert_butch($table, $array_values)
    {
        $query = "INSERT INTO " . $table
            . " (" . implode("`, `", array_keys($array_values[0])) . ") ";

        foreach ($array_values as $one)
            $oneValues[] = "(" . implode(", ", $one) . ")";


        $query .= " VALUES " . implode(',', $oneValues);

        if ($this->debug)
            $this->query = $query;

        if (!mysqli_query($this->connection, $query)) {
            $this->errors = mysqli_error($this->connection);
            return false;
        }

        return mysqli_affected_rows($this->connection);
    }

    /**
     *function delete rectords from table with conditions
     * @param string $table
     * @param associative array $conditions
     *
     * @return bool
     */
    public function delete($table, $conditions = array(), $logOper = 'AND')
    {
        $query = "DELETE FROM " . $table . " ";

        if (!empty($conditions)) {
            $query .= " WHERE ";

            foreach ($conditions as $column => $condition)
                $oneCondition[] = "`" . $column . "` " . $condition;

            $query .= implode(" " . $logOper . " ", $oneCondition);
        }

        if ($this->debug)
            $this->query = $query;

        if (!mysqli_query($this->connection, $query)) {
            $this->errors = mysqli_error($this->connection);
            return false;
        }

        return mysqli_affected_rows($this->connection);

    }

    /**
     *function update records in table with conditions
     * @param string $table
     * @param array $values
     * @param associative array $conditions
     * @return bool
     */
    public function update($table, $values, $conditions = array(), $ignore = false)
    {
        if ($ignore)
            $ignore = " IGNORE ";

        $query = "UPDATE " . $ignore . $table
            . " SET ";

        foreach ($values as $column => $newValue)
            $oneSet[] = "`" . $column . "` = '" . $newValue ."'";

        $query .= implode(", ", $oneSet);

        if (!empty($conditions)) {
            $query .= " WHERE ";

            foreach ($conditions as $column => $condition)
                $one_condition[] = $column . " ='" . $condition . "'";

            $query .= implode(" AND ", $one_condition);
        }

        if ($this->debug)
            $this->query = $query;

        if (mysqli_query($this->connection, $query) === -1) {
            $this->errors = mysqli_error($this->connection);
            return false;
        }

        return true;

    }

    /**
     * function select_one select one record from table with conditions
     * @param $table
     * @param array $conditions
     * @param string $columns
     * @param array $join
     * @return array|bool|null
     */

    public function select_one($table, $conditions = array(),$join = array(), $columns = '*')
    {
        $query = "SELECT " . $columns
            . " FROM " . $table;

        if(!empty($join)){
            foreach($join as $join_key => $cond){
                foreach($cond as $table_ => $id)
                    $query .= " " . $join_key . " " . $table_ . " ON " . $table . "." . $id . "=" . $table_. "." . $id  . " ";
            }
        }

        if (!empty($conditions)) {
            $query .= " WHERE ";

            foreach ($conditions as $column => $condition)
                $oneCondition[] = $column . "='" . $condition ."'";

            $query .= implode(" AND ", $oneCondition);
        }

        $query .= " LIMIT 1";

        if ($this->debug)
            $this->query = $query;

        $row = mysqli_query($this->connection, $query);

        if (!$row) {
            $this->errors = mysqli_error($this->connection);
            return false;
        }

        if (!mysqli_num_rows($row))
            return false;

        return mysqli_fetch_assoc($row);
    }

     /**
      * function select_many select more then one record from table with conditions
      * @param $table
      * @param array $conditions
      * @param array $join
      * @param bool|false $order
      * @param bool|false $limit
      * @param string $columns
      * @return array|bool
      */
    public function select_many($table, $conditions = array(), $join = array(), $order = array(), $limit = 10, $offset = 0, $columns = '*')
    {

        $query = "SELECT " . $columns
            . " FROM " . $table;

        if(!empty($join)){
            foreach($join as $join_key => $cond){
                foreach($cond as $table_ => $id)
                    $query .= " " . $join_key . " " . $table_ . " ON " . $table . "." . $id . "=" . $table_. "." . $id  . " ";
            }
        }

        if (!empty($conditions)) {
            $query .= " WHERE ";

            foreach ($conditions as $column => $condition)
                $oneCondition[] = $column . " = '" . $condition . "'";

            $query .= implode(" AND ", $oneCondition);
        }

        if (!empty($order)) {
            extract($order);
            $query .= " ORDER BY " . $table . "." . $order_field . " " . $order_dir . " ";
        }
        if ($offset == 0 or $offset == 1) {
            $offset = 0;
        } else {
            $offset = ($offset * $limit) - $limit;
        }

        if ($limit)
            $query .= " LIMIT " . $limit;

        if ($offset)
            $query .= ", " . $offset;

        if ($this->debug)
            $this->query = $query;

        $row = mysqli_query($this->connection, $query);

        if (!$row) {
            $this->errors = mysqli_error($this->connection);
            return false;
        }

        $rows = array();
        if (mysqli_num_rows($row)) {
            while ($one = mysqli_fetch_assoc($row))
                $rows[] = $one;
        }

        return $rows;
    }

    /**
     * function count_rows counts selected records from table
     * @param $table
     * @param array $conditions
     * @return mixed
     */

    public function count_rows($table, $conditions = array())
    {

        $query = "SELECT COUNT(*) as counter "
            . "FROM " . $table;

        if (!empty($conditions)) {
            $query .= " WHERE ";

            foreach ($conditions as $column => $condition)
                $oneCondition[] = $column . " = '" . $condition ."'";

            $query .= implode(" AND ", $oneCondition);
        }
        $query .= " LIMIT 1";

        if ($this->debug)
            $this->query = $query;
         //echo $query;
        if (!mysqli_query($this->connection, $query)) {
            $this->errors = mysqli_error($this->connection);
            return false;
        }
        $rez = mysqli_query($this->connection, $query);

            $row = mysqli_fetch_assoc($rez);
            return $row['counter'];
    }
}