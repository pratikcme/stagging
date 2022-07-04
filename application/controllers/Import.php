<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Import extends Vendor_Controller
{
    public $vendorId;

    function __construct(){
        parent::__construct();
        $this->branch_id = $this->session->userdata['id'];
        $this->load->model('import_model','this_model');
    //     ini_set("display_errors", "1");
             // error_reporting(E_ALL);
       
    }

    public function index(){

        $data['catgeory'] = $this->this_model->getCatgory();
        $this->load->view('import',$data);
    }

    public function generate(){
        $type = $this->input->post('type');

        if($type == 1){
            $this->genrate_excel();
        }else{
            $this->genrate_excel_for_update();
        }

    }

    public function importExcelFile(){
        if($this->input->post()){            
            $type = $this->input->post('type');
            if($type == 1){
                $this->import_excel();
            }else{

                $this->update_productQuantity();
            }   
        }
        $this->utility->setFlashMessage('danger',"Somthing went Wrong");
        redirect(base_url().'import/import_excel');
    }


    public function genrate_excel(){
        // print_r($this->input->post());die;
        $subCatgeoryList = $this->this_model->subcategory_list($this->input->post('catgeory'));
        if(empty($subCatgeoryList)){
            $this->utility->setFlashMessage('danger',"Subcategory Not available for this category");
            redirect(base_url().'import/');
            die;
        }
        $brandList = $this->this_model->brand_list($this->input->post('catgeory'));
        if(empty($brandList)){
            $this->utility->setFlashMessage('danger',"Brand Not available for this category");
            redirect(base_url().'import/');
            die;
        }
        // echo $this->db->last_query();
        // print_r($brandList);die;
        $unitList = $this->this_model->unit_list();
        $supplierList = $this->this_model->supplier_list();
        $packageList = $this->this_model->package_list();
        // print_r($packageList);die;
        // $categoryList = $this->this_model->category_list();
        // print_r($categoryList);die;

        $this->load->library('excel');

        $this->excel->setActiveSheetIndex(0);
        $this->excel->getActiveSheet()->setTitle('PHPExcel');
        $this->excel->getActiveSheet()->setCellValue('A1', 'No');
        // $this->excel->getActiveSheet()->setCellValue('B1', 'catgeory');
        $this->excel->getActiveSheet()->setCellValue('B1', 'Type');
        $this->excel->getActiveSheet()->setCellValue('C1', 'Subcategory');
        $this->excel->getActiveSheet()->setCellValue('D1', 'Brand');
        $this->excel->getActiveSheet()->setCellValue('E1', 'Product name');
        $this->excel->getActiveSheet()->setCellValue('F1', 'Product Content');
        $this->excel->getActiveSheet()->setCellValue('G1', 'About');
        // $this->excel->getActiveSheet()->setCellValue('H1', 'Supplier');
        $this->excel->getActiveSheet()->setCellValue('H1', 'Varient');
        $this->excel->getActiveSheet()->setCellValue('I1', 'Varient Unit');
        $this->excel->getActiveSheet()->setCellValue('J1', 'Package');
        $this->excel->getActiveSheet()->setCellValue('K1', 'Quantity');
        $this->excel->getActiveSheet()->setCellValue('L1', 'Purchase Price');
        $this->excel->getActiveSheet()->setCellValue('M1', 'Maximum Retail Price');
        $this->excel->getActiveSheet()->setCellValue('N1', 'Discount');
        $this->excel->getActiveSheet()->setCellValue('O1', 'Image');
        $this->excel->getActiveSheet()->setCellValue('P1', 'GST');
        $this->excel->getActiveSheet()->setCellValue('Q1', 'Max Order Qty');


        $this->excel->getActiveSheet()->getStyle('A1:Q1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->getStyle('A1:Q1')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle('A1:Q1')->getFont()->setSize(12);
        $this->excel->getActiveSheet()->getStyle('A1:Q1')->getFill()->getStartColor()->setARGB('#333');

        $default_border = array(
            'style' => PHPExcel_Style_Border::BORDER_THIN,
            'color' => array('rgb' => '1006A3')
        );
        $style_header = array(
            'borders' => array(
                'bottom' => $default_border,
                'left' => $default_border,
                'top' => $default_border,
                'right' => $default_border
            ),
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array(
                    'rgb' => 'E1E0F7'
                )
            ),
            'font' => array(
                'bold' => true
            )
        );

        //   for ($i = 2; $i <= 150; $i++) {

        //     $objValidation5 = $this->excel->getActiveSheet()->getCell('B'.$i.'')->getDataValidation();
        //     $objValidation5->setType( PHPExcel_Cell_DataValidation::TYPE_LIST );
        //     $objValidation5->setErrorStyle( PHPExcel_Cell_DataValidation::STYLE_INFORMATION );
        //     $objValidation5->setAllowBlank(false);
        //     $objValidation5->setShowInputMessage(true);
        //     $objValidation5->setShowErrorMessage(true);
        //     $objValidation5->setShowDropDown(true);
        //     $objValidation5->setErrorTitle('Input error');
        //     $objValidation5->setError('Value is not in list.');
        //     $objValidation5->setPromptTitle('Pick from list');
        //     $objValidation5->setPrompt('Please pick a value from the drop-down list.');
        //     $objValidation5->setFormula1('"'. implode(',',$categoryList).'"');

        // }

//        $this->excel->getActiveSheet()->getProtection()->setSheet(true);
        for ($i = 2; $i <= 150; $i++) {

            $objValidation = $this->excel->getActiveSheet()->getCell('B'.$i.'')->getDataValidation();
            $objValidation->setType( PHPExcel_Cell_DataValidation::TYPE_LIST );
            $objValidation->setErrorStyle( PHPExcel_Cell_DataValidation::STYLE_INFORMATION );
            $objValidation->setAllowBlank(false);
            $objValidation->setShowInputMessage(true);
            $objValidation->setShowErrorMessage(true);
            $objValidation->setShowDropDown(true);
            $objValidation->setErrorTitle('Input error');
            $objValidation->setError('Value is not in list.');
            $objValidation->setPromptTitle('Pick from list');
            $objValidation->setPrompt('Please pick a value from the drop-down list.');
            $objValidation->setFormula1('"New,Old"');

        }

        for ($i = 2; $i <= 150; $i++) {

            $objValidation1 = $this->excel->getActiveSheet()->getCell('C'.$i.'')->getDataValidation();
            $objValidation1->setType( PHPExcel_Cell_DataValidation::TYPE_LIST );
            $objValidation1->setErrorStyle( PHPExcel_Cell_DataValidation::STYLE_INFORMATION );
            $objValidation1->setAllowBlank(false);
            $objValidation1->setShowInputMessage(true);
            $objValidation1->setShowErrorMessage(true);
            $objValidation1->setShowDropDown(true);
            $objValidation1->setErrorTitle('Input error');
            $objValidation1->setError('Value is not in list.');
            $objValidation1->setPromptTitle('Pick from list');
            $objValidation1->setPrompt('Please pick a value from the drop-down list.');
            $objValidation1->setFormula1('"'. implode(',',$subCatgeoryList).'"');

        }

        for ($i = 2; $i <= 150; $i++) {

            $objValidation2 = $this->excel->getActiveSheet()->getCell('D'.$i.'')->getDataValidation();
            $objValidation2->setType( PHPExcel_Cell_DataValidation::TYPE_LIST );
            $objValidation2->setErrorStyle( PHPExcel_Cell_DataValidation::STYLE_INFORMATION );
            $objValidation2->setAllowBlank(false);
            $objValidation2->setShowInputMessage(true);
            $objValidation2->setShowErrorMessage(true);
            $objValidation2->setShowDropDown(true);
            $objValidation2->setErrorTitle('Input error');
            $objValidation2->setError('Value is not in list.');
            $objValidation2->setPromptTitle('Pick from list');
            $objValidation2->setPrompt('Please pick a value from the drop-down list.');
            $objValidation2->setFormula1('"'. implode(',',$brandList).'"');

        }

        // for ($i = 2; $i <= 150; $i++) {

        //     $objValidation3 = $this->excel->getActiveSheet()->getCell('H'.$i.'')->getDataValidation();
        //     $objValidation3->setType( PHPExcel_Cell_DataValidation::TYPE_LIST );
        //     $objValidation3->setErrorStyle( PHPExcel_Cell_DataValidation::STYLE_INFORMATION );
        //     $objValidation3->setAllowBlank(false);
        //     $objValidation3->setShowInputMessage(true);
        //     $objValidation3->setShowErrorMessage(true);
        //     $objValidation3->setShowDropDown(true);
        //     $objValidation3->setErrorTitle('Input error');
        //     $objValidation3->setError('Value is not in list.');
        //     $objValidation3->setPromptTitle('Pick from list');
        //     $objValidation3->setPrompt('Please pick a value from the drop-down list.');
        //     $objValidation3->setFormula1('"'. implode(',',$supplierList).'"');


        // }

        for ($i = 2; $i <= 150; $i++) {

            $objValidation4 = $this->excel->getActiveSheet()->getCell('I'.$i.'')->getDataValidation();
            $objValidation4->setType( PHPExcel_Cell_DataValidation::TYPE_LIST );
            $objValidation4->setErrorStyle( PHPExcel_Cell_DataValidation::STYLE_INFORMATION );
            $objValidation4->setAllowBlank(false);
            $objValidation4->setShowInputMessage(true);
            $objValidation4->setShowErrorMessage(true);
            $objValidation4->setShowDropDown(true);
            $objValidation4->setErrorTitle('Input error');
            $objValidation4->setError('Value is not in list.');
            $objValidation4->setPromptTitle('Pick from list');
            $objValidation4->setPrompt('Please pick a value from the drop-down list.');
            $objValidation4->setFormula1('"'. implode(',',$unitList).'"');

        }

        for ($i = 2; $i <= 150; $i++) {

            $objValidation5 = $this->excel->getActiveSheet()->getCell('J'.$i.'')->getDataValidation();
            $objValidation5->setType( PHPExcel_Cell_DataValidation::TYPE_LIST );
            $objValidation5->setErrorStyle( PHPExcel_Cell_DataValidation::STYLE_INFORMATION );
            $objValidation5->setAllowBlank(false);
            $objValidation5->setShowInputMessage(true);
            $objValidation5->setShowErrorMessage(true);
            $objValidation5->setShowDropDown(true);
            $objValidation5->setErrorTitle('Input error');
            $objValidation5->setError('Value is not in list.');
            $objValidation5->setPromptTitle('Pick from list');
            $objValidation5->setPrompt('Please pick a value from the drop-down list.');
            $objValidation5->setFormula1('"'. implode(',',$packageList).'"');

        }

        

        //ob_start();
        $filename = $this->input->post('catgory_name').'.xlsx';
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        ob_end_clean();
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');
        

        $objWriter->save('php://output');

        redirect(base_url().'import');
    }

    public function import_excel(){
        $productResult = $this->display_records();
        $data['tempRecord'] = $productResult;
        if($this->input->post()){
            $this->db->query('TRUNCATE TABLE temp_product');
            $this->db->query('TRUNCATE TABLE temp_product_weight');
            $this->db->query('TRUNCATE TABLE temp_product_image');
            $result = $this->this_model->importExcel($this->input->post());
            if($result){
                // $this->utility->setFlashMessage('success',"Product uploaded successfully");
                $number = rand(10,100);
                redirect(base_url().'import/import_excel/'.$this->utility->safe_b64encode($number));
            }else{

                $this->utility->setFlashMessage('danger',"Somthing went Wrong");
            }
            redirect(base_url().'import/import_excel');
        }
        $data['category'] = $this->this_model->getCategorys(); 
        $this->load->view('import_excel',$data);
    }

    public function genrate_excel_for_update(){
    	 $category_name = $this->input->post('catgory_name');
        // print_r($category_name);die;
    	 // $category_name = ['category_name'=>"Grocery"];
    	 $product = $this->this_model->getProductOfCategory($this->input->post());

         foreach ($product as $key => $value) {
             $res = $this->this_model->getVarientOfProduct($value->id,$this->branch_id);
             $product[$key]->productVarient = $res;
         }


    	 // echo "<pre>" ;
    	 // print_r($product);die;


    	$this->load->library('excel');

        $this->excel->setActiveSheetIndex(0);
        $this->excel->getActiveSheet()->setTitle('PHPExcel');
        $this->excel->getActiveSheet()->setCellValue('A1', 'No');
        // $this->excel->getActiveSheet()->setCellValue('B1', 'catgeory');
        $this->excel->getActiveSheet()->setCellValue('B1', 'Type');
        $this->excel->getActiveSheet()->setCellValue('C1', 'Product name');
        $this->excel->getActiveSheet()->setCellValue('D1', 'Varient');
        $this->excel->getActiveSheet()->setCellValue('E1', 'Varient Unit');
        $this->excel->getActiveSheet()->setCellValue('F1', 'Package');
        $this->excel->getActiveSheet()->setCellValue('G1', 'Quantity');
        $this->excel->getActiveSheet()->setCellValue('H1', 'Product_price');
        $this->excel->getActiveSheet()->setCellValue('I1', 'Discount(%)');
        $this->excel->getActiveSheet()->setCellValue('J1', 'Maximum order quantity');


        $this->excel->getActiveSheet()->getStyle('A1:J1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->getStyle('A1:J1')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle('A1:J1')->getFont()->setSize(12);
        $this->excel->getActiveSheet()->getStyle('A1:J1')->getFill()->getStartColor()->setARGB('#333');

        $default_border = array(
            'style' => PHPExcel_Style_Border::BORDER_THIN,
            'color' => array('rgb' => '1006A3')
        );
        $style_header = array(
            'borders' => array(
                'bottom' => $default_border,
                'left' => $default_border,
                'top' => $default_border,
                'right' => $default_border
            ),
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array(
                    'rgb' => 'E1E0F7'
                )
            ),
            'font' => array(
                'bold' => true
            )
        );
       //  $count = count($product) + 2;
      	// for ($i = 2; $i < $count ; $i++) {
      		
       //      $objValidation = $this->excel->getActiveSheet()->getCell('B'.$i.'')->getDataValidation();
       //      $objValidation->setType( PHPExcel_Cell_DataValidation::TYPE_LIST );
       //      $objValidation->setErrorStyle( PHPExcel_Cell_DataValidation::STYLE_INFORMATION );
       //      $objValidation->setAllowBlank(false);
       //      $objValidation->setShowInputMessage(true);
       //      $objValidation->setShowErrorMessage(true);
       //      $objValidation->setShowDropDown(true);
       //      $objValidation->setErrorTitle('Input error');
       //      $objValidation->setError('Value is not in list.');
       //      $objValidation->setPromptTitle('Pick from list');
       //      $objValidation->setPrompt('Please pick a value from the drop-down list.');
       //      $objValidation->setFormula1('"New,Old"');
       //      $objValidation->setFormula1('=\'autofill\'!New:Old');

       //  }
        $k = 2;
        $x = 1;
        foreach ($product as $i => $value){
            foreach ($value->productVarient as $key => $v) {
        	   $type = 'Old';
               if($key == 0){
                $type = 'New';
               }
                $objPHPExcel = $this->excel->getActiveSheet()->SetCellValue('A'.$k.'', ''.$x.'');
                $objPHPExcel = $this->excel->getActiveSheet()->SetCellValue('B'.$k.'', ''.$type.'');
                $objPHPExcel = $this->excel->getActiveSheet()->SetCellValue('C'.$k.'', ''.$value->product_name.'');
                $objPHPExcel = $this->excel->getActiveSheet()->SetCellValue('D'.$k.'', ''.$v->weight_no.'');
                $objPHPExcel = $this->excel->getActiveSheet()->SetCellValue('E'.$k.'', ''.$v->name.'');
                $objPHPExcel = $this->excel->getActiveSheet()->SetCellValue('F'.$k.'', ''.$v->package.'');
                $objPHPExcel = $this->excel->getActiveSheet()->SetCellValue('G'.$k.'', ''.$v->quantity.'');
                $objPHPExcel = $this->excel->getActiveSheet()->SetCellValue('H'.$k.'', ''.$v->price.'');
                $objPHPExcel = $this->excel->getActiveSheet()->SetCellValue('I'.$k.'', ''.$v->discount_per.'');
                $objPHPExcel = $this->excel->getActiveSheet()->SetCellValue('J'.$k.'', ''.$v->max_order_qty.'');
            $k++;
            $x++;
            }

        }



        //ob_start();
        $filename = $this->input->post('catgory_name').'.xlsx';
        // $filename = 'grocery.xlsx';
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        ob_end_clean();
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');
        

        $objWriter->save('php://output'); 
    }

    public function update_productQuantity(){
        $this->load->library('excel');
        if($this->input->post()){
            $result = $this->this_model->UpdateProductQuantity($this->input->post());
                $this->utility->setFlashMessage('success',"Product quantity updated successfully");
            if($result){
            }else{
                $this->utility->setFlashMessage('danger',"Somthing went Wrong");
            }
            redirect(base_url().'import/import_excel');
        }
        $data['category'] = $this->this_model->getCategorys(); 
        $this->load->view('import_excel',$data);
    }

    public function display_records(){
        $tempRecord = $this->this_model->getTemopRecord();
        return $tempRecord;
    }

    public function insertExcelRecordParmanent(){
        $result = $this->this_model->insertExcelRecordParmanent();
        // lq();
        if($result >= 3){
            $this->db->query('TRUNCATE TABLE temp_product');
            $this->db->query('TRUNCATE TABLE temp_product_weight');
            $this->db->query('TRUNCATE TABLE temp_product_image');
            $this->utility->setFlashMessage('success',"Product uploaded successfully");
             redirect(base_url().'import/import_excel');
        }else{
            $this->utility->setFlashMessage('danger',"Somthing went wrong");
             redirect(base_url().'import/import_excel');
        }

    }
}

?>
