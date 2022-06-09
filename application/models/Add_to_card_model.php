<?php
class App_to_card_model extends My_model{
    
    function __construct(){
     $this->branch_id = $this->session->userdata('id');
    }

   

}
?>