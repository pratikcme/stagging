<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Stock_control extends Vendor_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function view_stock_control_list() 
    {
        $this->load->view('stock_control_list');
    }
    public function order_stock_add()
    {
    	$this->load->view('order_stock_add');
    }
    public function order_stock()
    {
        $this->load->view('order_stock');
    }
    public function add_order()
    {
        $ordername = $this->input->post('txtOrderName');
        $supplier_id = $this->input->post('supplier');
        $deliver_outlet_id = $this->input->post('deliver_to');

        $formatted_date = $this->input->post('txtDeliveryDueDate');
        $ordernumber = $this->input->post('txtOrderNumber');
        $supplierinvoice = $this->input->post('txtSupplierInvoice');
        $vendor_id = $this->session->userdata('id');
        
        if($parent_id == '0')
        {
            $parent_insert_id = '1';
        }
        else
        {
            $parent_insert_id = $this->session->userdata('parent_id');
        }

        $data = array(

            'order_name' => $ordername,
            'supplier_id' => $supplier_id,
            'deliver_outlet_id' => $deliver_outlet_id,
            'deliver_date' => $formatted_date,
            'order_no' => $ordernumber,
            'supplier_invoice' => $supplierinvoice,
            'vendor_id' => $vendor_id,            
            'current_date' => date('Y-m-d')
        );

        $insert_data = $this->db->insert('new_stock',$data);
        if($insert_data)
        {
            $this->session->set_flashdata('msg', 'Order has been added successfully.');
            redirect(base_url().'stock_control/view_stock_control_list');
        }
        else
        {
            $this->session->set_flashdata('msg', 'Error in order');
            redirect(base_url().'stock_control/view_stock_control_list');
        }

    }
    public function add_stock_order()
    {
            
             $product_id = $_GET['product_id'];
             $product_name = $_GET['product_name'];
             $retail_price = $_GET['retail_price'];
             $userid = $this->session->userdata('id');
             $orderid = $_GET['order_id'];
             $vendor_id = $this->session->userdata('id');
           
             $data = array(

            'product_id' => $product_id,
            'product_name' => $product_name,
            'product_supply_price' => $retail_price,
            'order_id' => $orderid,
            'vendor_id' => $vendor_id,
        );
            $insert_data = $this->db->insert('add_stock_order',$data);
            if($insert_data)
            {
                $this->session->set_flashdata('msg', 'Product has been added successfully');
            }
            else
            {
                $this->session->set_flashdata('msg', 'Error in added');
            }   


    }
    public function edit_total_price()
    {
        $id = $_GET['id'];
        $product_id = $_GET['product_id'];
        $quantity = $_GET['quantity'];
        $cost = $_GET['price'];
        $order_id = $_GET['order_id'];
        $total_price = $_GET['total_price'];

        $this->db->query("UPDATE add_stock_order SET product_quantity = '$quantity', cost = '$cost' WHERE order_id = '$order_id' AND product_id = '$product_id' AND id = '$id'");
        $this->db->query("UPDATE new_stock SET total_price = '$total_price' WHERE order_id = '$order_id'");

        return;
        exit();
    }
    public function ajax_search_product()
    {
    	$search = $this->input->post('search');
    	$vendor_id = $this->session->userdata('id');
        $parent_vendor_id = $this->session->userdata('parent_id');
    	$res = $this->db->query("SELECT * FROM `product` WHERE status != '9' AND  vendor_id = '$vendor_id'  AND name LIKE '%$search%'");

    	$row_search = $res->result();
         $output  = '';
        
         $i = '1';
         foreach ($row_search as $product)
         { 
                    echo '<tr class="gradeX odd ajax_search">';
                    echo '<td class=""><input type="hidden" id="productId'.$i.'" value="' .$product->id. '">' .$i. '</td>';
                    echo '<td class=""><input type="hidden" id="productName'.$i.'" value="' .$product->name. '">' .$product->name. '</td>';
                    echo '<td class=""><input type="hidden" id="retailPrice'.$i.'" value="' .$product->final_price. '">' .$product->final_price. '</td>';
                    	
                    echo '<td class=""><button type="button" class="current_click btn btn-success btn-s-xs" onclick="clickme('."'$product->id'".','."'$product->name'".','."'$product->final_price'".')" >ADD </button></td>';
             

                    echo '</tr>';
            $i++;
            
         } 
         // echo '<tbody>';
         // $output .= '</tbody>';             

        // print_r($output);
        // exit();       
   
    }

    public function single_delete_stock_order()
    {
        $ids = $_GET['ids'];
        $data = array(
            'status' => '9'
        );
        $this->db->where('order_id', $ids);
        $this->db->update('new_stock', $data);
        ob_get_clean();
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');
        echo json_encode(['status'=>1]);
        exit();
    }
}

?>