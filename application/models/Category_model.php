<?php

/**
 * Author: Amirul Momenin
 * Desc:Category Model
 */
class Category_model extends CI_Model
{

    protected $category = 'category';

    function __construct()
    {
        parent::__construct();
    }

    /**
     * Get category by id
     *
     * @param $id -
     *            primary key to get record
     *            
     */
    function get_category($id)
    {
        $result = $this->db->get_where('category', array(
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
     * Get all category
     */
    function get_all_category()
    {
        $this->db->order_by('id', 'desc');
        $result = $this->db->get('category')->result_array();
        $db_error = $this->db->error();
        if (! empty($db_error['code'])) {
            echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
            exit();
        }
        return $result;
    }

    /**
     * Get limit category
     *
     * @param $limit -
     *            limit of query , $start - start of db table index to get query
     *            
     */
    function get_limit_category($limit, $start)
    {
        $this->db->order_by('id', 'desc');
        $this->db->limit($limit, $start);
        $result = $this->db->get('category')->result_array();
        $db_error = $this->db->error();
        if (! empty($db_error['code'])) {
            echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
            exit();
        }
        return $result;
    }

    /**
     * Count category rows
     */
    function get_count_category()
    {
        $result = $this->db->from("category")->count_all_results();
        $db_error = $this->db->error();
        if (! empty($db_error['code'])) {
            echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
            exit();
        }
        return $result;
    }

    /**
     * function to add new category
     *
     * @param $params -
     *            data set to add record
     *            
     */
    function add_category($params)
    {
        $this->db->insert('category', $params);
        $id = $this->db->insert_id();
        $db_error = $this->db->error();
        if (! empty($db_error['code'])) {
            echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
            exit();
        }
        return $id;
    }

    /**
     * function to update category
     *
     * @param $id -
     *            primary key to update record,$params - data set to add record
     *            
     */
    function update_category($id, $params)
    {
        $this->db->where('id', $id);
        $status = $this->db->update('category', $params);
        $db_error = $this->db->error();
        if (! empty($db_error['code'])) {
            echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
            exit();
        }
        return $status;
    }

    /**
     * function to delete category
     *
     * @param $id -
     *            primary key to delete record
     *            
     */
    function delete_category($id)
    {
        $status = $this->db->delete('category', array(
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
