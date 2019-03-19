<?php

class Test_model extends CI_Model {

           public function __construct() {
                      parent::__construct();
           }

  public function getListNIK4LoginAutoComplete($nik = '') {
                      $result = $this->db->query("SELECT nik FROM employee WHERE nik LIKE '%" . $this->db->escape_like_str($nik) . "%'")->result_array();
                      $arr_nik = array();
                      foreach ($result as $row) {
                                 $arr_nik[] = trim($row['nik']);
                      }
                      return $arr_nik;
           }
}
?>