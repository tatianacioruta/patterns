<?php

class Map_model extends Model
{
    private $_table = 'markers';
    private $_id = 'id_marker';


    public function get_one($id)
    {
        $conditions = array(
            $this->_id => ' = ' . $id
        );
        $join = array();

        return $this->db->select_one($this->_table, $conditions, $join);

    }
    public function get_one_by_cond($cond = array())
    {
        $join = array();

        return $this->db->select_one($this->_table, $cond, $join);
    }
    public function get_all($conditions = array(), $join = array(), $order = "", $limit = false, $columns = '*')
    {
        return $this->db->select_many($this->_table, $conditions, $join, $order, $limit, $columns);

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
            $this->_id => "=" . $id
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
            $this->_id . ' = '  =>  $id
        );
        return $this->db->count_rows($this->_table,$conditions);
    }
    public function check_social_id($id)
    {

        $conditions = array(
            'social_id  = ' => $id
        );
        return $this->db->count_rows($this->_table,$conditions);
    }

    public function check_by_cond($conditions)
    {
        return $this->db->count_rows($conditions);
    }
}