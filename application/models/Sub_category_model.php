<?php

/**
 * Author: Amirul Momenin
 * Desc:Sub_category Model
 */
class Sub_category_model extends CI_Model
{

    protected $sub_category = 'sub_category';

    function __construct()
    {
        parent::__construct();
    }

    /**
     * Get sub_category by id
     *
     * @param $id -
     *            primary key to get record
     *            
     */
    function get_sub_category($id)
    {
        $result = $this->db->get_where('sub_category', array(
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
     * Get all sub_category
     */
    function get_all_sub_category()
    {
        $this->db->order_by('id', 'desc');
        $result = $this->db->get('sub_category')->result_array();
        $db_error = $this->db->error();
        if (! empty($db_error['code'])) {
            echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
            exit();
        }
        return $result;
    }

    /**
     * Get limit sub_category
     *
     * @param $limit -
     *            limit of query , $start - start of db table index to get query
     *            
     */
    function get_limit_sub_category($limit, $start)
    {
        $this->db->order_by('id', 'desc');
        $this->db->limit($limit, $start);
        $result = $this->db->get('sub_category')->result_array();
        $db_error = $this->db->error();
        if (! empty($db_error['code'])) {
            echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
            exit();
        }
        return $result;
    }

    /**
     * Count sub_category rows
     */
    function get_count_sub_category()
    {
        $result = $this->db->from("sub_category")->count_all_results();
        $db_error = $this->db->error();
        if (! empty($db_error['code'])) {
            echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
            exit();
        }
        return $result;
    }

    /**
     * function to add new sub_category
     *
     * @param $params -
     *            data set to add record
     *            
     */
    function add_sub_category($params)
    {
        $this->db->insert('sub_category', $params);
        $id = $this->db->insert_id();
        $db_error = $this->db->error();
        if (! empty($db_error['code'])) {
            echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
            exit();
        }
        return $id;
    }

    /**
     * function to update sub_category
     *
     * @param $id -
     *            primary key to update record,$params - data set to add record
     *            
     */
    function update_sub_category($id, $params)
    {
        $this->db->where('id', $id);
        $status = $this->db->update('sub_category', $params);
        $db_error = $this->db->error();
        if (! empty($db_error['code'])) {
            echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
            exit();
        }
        return $status;
    }

    /**
     * function to delete sub_category
     *
     * @param $id -
     *            primary key to delete record
     *            
     */
    function delete_sub_category($id)
    {
        $status = $this->db->delete('sub_category', array(
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
