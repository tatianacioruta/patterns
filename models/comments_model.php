<?php

class Comments_model extends Model
{
    private $_table = 'comments';
    private $_id = 'id_comment';


    public function get_one($id)
    {
        $conditions = array(
            $this->_id =>  $id
        );
        $join = array('LEFT JOIN' => array('users' => 'id_user', 'posts' => 'id_post'));

        return $this->db->select_one($this->_table, $conditions, $join);

    }

    public function get_all($conditions = array(), $join = array(), $order = array(), $limit = 10, $offset = 0, $columns = '*')
    {
        return $this->db->select_many($this->_table, $conditions, $join, $order, $limit, $offset, $columns);

    }

    public function delete_by_cond($conditions)
    {
        return $this->db->delete($this->_table, $conditions);
    }

    public function delete_by_id($id)
    {
        $conditions = array(
            $this->_id => "=" . $id
        );
        return $this->db->delete($this->_table, $conditions);
    }


    function change_one($id, $values)
    {
        $conditions = array(
            $this->_id => $id
        );
        return $this->db->update($this->_table, $values, $conditions);
    }

    function add_one($values)
    {
        return $this->db->insert($this->_table, $values);
    }

    public function add_many($array_values)
    {
        return $this->db->insert_butch($this->_table, $array_values);
    }

    public function count_results($conditions)
    {
        return $this->db->count_rows($this->_table, $conditions);
    }

    public function check_id($id)
    {

        $conditions = array(
            $this->_id => ' = ' . $id
        );
        return $this->db->count_rows($conditions);
    }

    public function check_by_cond($conditions)
    {
        return $this->db->count_rows($conditions);
    }
}