<?php

/**
 * Author: Amirul Momenin
 * Desc:Purchase Model
 */
class Purchase_model extends CI_Model
{

    protected $purchase = 'purchase';

    function __construct()
    {
        parent::__construct();
    }

    /**
     * Get purchase by id
     *
     * @param $id -
     *            primary key to get record
     *            
     */
    function get_purchase($id)
    {
        $result = $this->db->get_where('purchase', array(
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
     * Get all purchase
     */
    function get_all_purchase()
    {
        $this->db->order_by('id', 'desc');
        $result = $this->db->get('purchase')->result_array();
        $db_error = $this->db->error();
        if (! empty($db_error['code'])) {
            echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
            exit();
        }
        return $result;
    }

    /**
     * Get limit purchase
     *
     * @param $limit -
     *            limit of query , $start - start of db table index to get query
     *            
     */
    function get_limit_purchase($limit, $start)
    {
        $this->db->order_by('id', 'desc');
        $this->db->limit($limit, $start);
        $result = $this->db->get('purchase')->result_array();
        $db_error = $this->db->error();
        if (! empty($db_error['code'])) {
            echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
            exit();
        }
        return $result;
    }

    /**
     * Count purchase rows
     */
    function get_count_purchase()
    {
        $result = $this->db->from("purchase")->count_all_results();
        $db_error = $this->db->error();
        if (! empty($db_error['code'])) {
            echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
            exit();
        }
        return $result;
    }

    /**
     * function to add new purchase
     *
     * @param $params -
     *            data set to add record
     *            
     */
    function add_purchase($params)
    {
        $this->db->insert('purchase', $params);
        $id = $this->db->insert_id();
        $db_error = $this->db->error();
        if (! empty($db_error['code'])) {
            echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
            exit();
        }
        return $id;
    }

    /**
     * function to update purchase
     *
     * @param $id -
     *            primary key to update record,$params - data set to add record
     *            
     */
    function update_purchase($id, $params)
    {
        $this->db->where('id', $id);
        $status = $this->db->update('purchase', $params);
        $db_error = $this->db->error();
        if (! empty($db_error['code'])) {
            echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
            exit();
        }
        return $status;
    }

    /**
     * function to delete purchase
     *
     * @param $id -
     *            primary key to delete record
     *            
     */
    function delete_purchase($id)
    {
        $status = $this->db->delete('purchase', array(
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
