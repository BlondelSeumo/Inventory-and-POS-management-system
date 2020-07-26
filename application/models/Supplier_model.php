<?php

/**
 * Author: Amirul Momenin
 * Desc:Supplier Model
 */
class Supplier_model extends CI_Model
{

    protected $supplier = 'supplier';

    function __construct()
    {
        parent::__construct();
    }

    /**
     * Get supplier by id
     *
     * @param $id -
     *            primary key to get record
     *            
     */
    function get_supplier($id)
    {
        $result = $this->db->get_where('supplier', array(
            'id' => $id
        ))->row_array();
        $db_error = $this->db->error();
        if (! empty($db_error['code'])) {
            echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
            exit();
        }
        return $result;
    }

    /**
     * Get all supplier
     */
    function get_all_supplier()
    {
        $this->db->order_by('id', 'desc');
        $result = $this->db->get('supplier')->result_array();
        $db_error = $this->db->error();
        if (! empty($db_error['code'])) {
            echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
            exit();
        }
        return $result;
    }

    /**
     * Get limit supplier
     *
     * @param $limit -
     *            limit of query , $start - start of db table index to get query
     *            
     */
    function get_limit_supplier($limit, $start)
    {
        $this->db->order_by('id', 'desc');
        $this->db->limit($limit, $start);
        $result = $this->db->get('supplier')->result_array();
        $db_error = $this->db->error();
        if (! empty($db_error['code'])) {
            echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
            exit();
        }
        return $result;
    }

    /**
     * Count supplier rows
     */
    function get_count_supplier()
    {
        $result = $this->db->from("supplier")->count_all_results();
        $db_error = $this->db->error();
        if (! empty($db_error['code'])) {
            echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
            exit();
        }
        return $result;
    }

    /**
     * function to add new supplier
     *
     * @param $params -
     *            data set to add record
     *            
     */
    function add_supplier($params)
    {
        $this->db->insert('supplier', $params);
        $id = $this->db->insert_id();
        $db_error = $this->db->error();
        if (! empty($db_error['code'])) {
            echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
            exit();
        }
        return $id;
    }

    /**
     * function to update supplier
     *
     * @param $id -
     *            primary key to update record,$params - data set to add record
     *            
     */
    function update_supplier($id, $params)
    {
        $this->db->where('id', $id);
        $status = $this->db->update('supplier', $params);
        $db_error = $this->db->error();
        if (! empty($db_error['code'])) {
            echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
            exit();
        }
        return $status;
    }

    /**
     * function to delete supplier
     *
     * @param $id -
     *            primary key to delete record
     *            
     */
    function delete_supplier($id)
    {
        $status = $this->db->delete('supplier', array(
            'id' => $id
        ));
        $db_error = $this->db->error();
        if (! empty($db_error['code'])) {
            echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
            exit();
        }
        return $status;
    }
}
