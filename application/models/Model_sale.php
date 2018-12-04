<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class model_sale extends CI_Model
{



    public function readSiogesSales($file_name){
        $row = 1;
        $index = 0;
        $rows = array();
        $dateTime=date('Y-m-d H:m:s');

        //load the excel library
        $this->load->library('excel');

        //read file from path
        $objPHPExcel = PHPExcel_IOFactory::load($file_name);

        //get only the Cell Collection
        $cell_collection = $objPHPExcel->getActiveSheet()->getCellCollection();

        //extract to a PHP readable array format
        foreach ($cell_collection as $cell) {
            $rows_count=$objPHPExcel->setActiveSheetIndex(0)->getHighestRow();
            $column = $objPHPExcel->getActiveSheet()->getCell($cell)->getColumn();
            $row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
            $data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();

            //The header will/should be in row 1 only. of course, this can be modified to suit your need.

            switch ($column) {
                case "A":
                    $column='externalCode';
                    break;
                case "B":
                    $column='meal';
                    break;
                case "C":
                    $column='group';
                    break;
                case "D":
                    $column='quantity';
                    break;
                case "E":
                    $column='amount';
                    break;
            }
            if ($row == 1) {
                $header[$row][$column] = $data_value;
            } else if($row!==$rows_count) {
                $arr_data[$row][$column] = $data_value;
            }
        }


        //$destination= FCPATH . 'uploads/ftp/old/rapport-' . date("Y-m-d-H-i-s") . '.xls';
        //rename($file_name, $destination);


        //send the data in an array format
        $data['header'] = $header;



        $data['rows'] = $arr_data;
        $data['dateTime'] = $dateTime;
        return $data;
    }

    public function getSiogesMeals($data){
        $mealsList=array();
        foreach ($data['sales']['rows'] as $key => $sale) {
            $externalCode=str_pad($sale['externalCode'], 18, '0', STR_PAD_LEFT);
            $meal = $this->model_meal->getByExternalCode($externalCode);
            $quantity = $sale["quantity"];
            $date=explode(' ', $data['sales']['dateTime']);
            $mealItem=array(
                'id'=>$meal['id'],
                'externalCode'=>$externalCode,
                'meal'=>$meal['name'],
                'quantity'=> floatval($quantity),
                'amount'=>floatval($sale["amount"]),
                'date'=> $date
            );
            if($meal['name']=== $sale['meal'] /*and $priceCSV == $meal['sellPrice']*/){
                $data['sales']['rows'][$key]['status']='valid';
                if(!is_null($sale['externalCode'])){
                    $mealsList[] = $mealItem;
                }
            }else if (!$meal){
                $undefinedMeal = $this->model_meal->createUndefined($externalCode, $sale['meal']);
                $meal_id=$this->model_meal->addSimpleMeal($undefinedMeal);
                $mealItem["id"]= $meal_id;
                $data['sales']['rows'][$key]['status'] = 'valid';
                if($sale['externalCode']!==""){
                    $mealsList[] = $mealItem;
                }
            }
        }

        return $mealsList;
    }

    public function readUniwellSales($file_name){
        $this->log_begin();
        $row = 1;
        $index = 0;
        $rows = array();
        $dateTime='';
        if (($handle = fopen($file_name, "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                $num = count($data);
                //echo "<p> $num fields in line $row: <br /></p>\n";
                $row++;
                for ($c = 0; $c < $num; $c++) {
                    $data[$c] . "<br />\n";
                }
                if (isset($data[1]) and $data[1] !== "ALL TOTAL" and $row > 7) {

                    //delete 0000 from left
                    $id = ltrim($data[0], '0');
                    $product = $this->model_meal->getByExternalCode($data[0]);

                    if (!isset($product['name'])) {
                        $product = $this->model_product->nullProduct();
                    }

                    $data['product'] = $product;
                    $rows[] = $data;
                }
                if (isset($data[1]) and $data[1] === "ALL TOTAL" and $row > 7) {
                    break;
                }
                if($row===5){
                    if(isset($data[2])){
                        $dateTime = $data[2];
                    }else{
                        $dateTime=date('Y-m-d').'T10';
                    }
                }
                $index++;
            }
            fclose($handle);
        }
        $data['rows'] = $rows;
        $data['dateTime'] = $dateTime;
        $this->log_end($data);
        return $data;
    }

}