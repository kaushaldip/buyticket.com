<?php
if (!defined('BASEPATH'))
           exit('No direct script access allowed');

class Test extends CI_Controller {

    public function __construct() {
            parent::__construct();
           $this->load->helper(array('form', 'url'));
            $this->load->model('Test_model');
    }
     public function index() {
        $this->load->view('test_view');
    }

    function getListNIK4LoginAutoComplete() {
        if (isset($_POST['nik'])) {
            echo   json_encode($this->Test_model->getListNIK4LoginAutoComplete(trim($_POST['nik'])));
                      } else {
                                 echo json_encode(array());
                      }
           }
}
?>