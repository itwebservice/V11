<?php
include "../../../model/model.php";

/** Error reporting */
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
date_default_timezone_set('Europe/London');

if (PHP_SAPI == 'cli')
	die('This example should only be run from a Web Browser');

/** Include PHPExcel */
require_once '../../../classes/PHPExcel-1.8/Classes/PHPExcel.php';

//This function generates the background color
function cellColor($cells,$color){
    global $objPHPExcel;

    $objPHPExcel->getActiveSheet()->getStyle($cells)->getFill()->applyFromArray(array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'startcolor' => array(
             'rgb' => $color
        )
    ));
}

//This array sets the font atrributes
$header_style_Array = array(
    'font'  => array(
        'bold'  => true,
        'color' => array('rgb' => '000000'),
        'size'  => 12,
        'name'  => 'Verdana'
    ));
$table_header_style_Array = array(
    'font'  => array(
        'bold'  => false,
        'color' => array('rgb' => '000000'),
        'size'  => 11,
        'name'  => 'Verdana'
    ));
$content_style_Array = array(
    'font'  => array(
        'bold'  => false,
        'color' => array('rgb' => '000000'),
        'size'  => 9,
        'name'  => 'Verdana'
    ));

//This is border array
$borderArray = array(
          'borders' => array(
              'allborders' => array(
                  'style' => PHPExcel_Style_Border::BORDER_THIN
              )
          )
      );

// Create new PHPExcel object
$objPHPExcel = new PHPExcel();

// Set document properties
$objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
                             ->setLastModifiedBy("Maarten Balliauw")
                             ->setTitle("Office 2007 XLSX Test Document")
                             ->setSubject("Office 2007 XLSX Test Document")
                             ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
                             ->setKeywords("office 2007 openxml php")
                             ->setCategory("Test result file");


//////////////////////////****************Content start**************////////////////////////////////
$emp_id = $_SESSION['emp_id'];
$role = $_SESSION['role'];
$role_id = $_SESSION['role_id'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$branch_status = $_GET['branch_status'];
$customer_id = $_GET['customer_id'];
$exc_id = $_GET['exc_id'];
$from_date = $_GET['from_date'];
$to_date = $_GET['to_date'];
$cust_type = $_GET['cust_type'];
$company_name = $_GET['company_name'];
$financial_year_id = $_SESSION['financial_year_id'];

$row_count = 9;

if($customer_id!=""){
	$sq_customer_info = mysqli_fetch_assoc(mysqlQuery("select * from customer_master where customer_id='$customer_id'"));
    if($sq_customer_info['type']=='Corporate'||$sq_customer_info['type'] == 'B2B'){
        $cust_name = $sq_customer_info['company_name'];
    }else{
        $cust_name = $sq_customer_info['first_name'].' '.$sq_customer_info['last_name'];
    }
}
else{
	$cust_name = "";
}

if($from_date!="" && $to_date!=""){
    $date_str = $from_date.' to '.$to_date;
}
else{
    $date_str = "";
}

if($exc_id != ''){
    $query = mysqli_fetch_assoc(mysqlQuery("select * from excursion_master where exc_id='$exc_id' and delete_status='0'"));
    $date = $query['created_at'];
    $yr = explode("-", $date);
    $year =$yr[0];
    $invoice_id = get_exc_booking_id($exc_id,$year);
}

if($company_name == 'undefined') { $company_name = ''; }

// Add some data
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('B2', 'Report Name')
            ->setCellValue('C2', 'Activity Report')
            ->setCellValue('B3', 'Booking ID')
            ->setCellValue('C3', $invoice_id)
            ->setCellValue('B4', 'Customer')
            ->setCellValue('C4', $cust_name)
            ->setCellValue('B5', 'From-To Date')
            ->setCellValue('C5', $date_str)
            ->setCellValue('B6', 'Customer Type')
            ->setCellValue('C6', $cust_type)
            ->setCellValue('B7', 'Company Name')
            ->setCellValue('C7', $company_name);

$objPHPExcel->getActiveSheet()->getStyle('B2:C2')->applyFromArray($header_style_Array);
$objPHPExcel->getActiveSheet()->getStyle('B2:C2')->applyFromArray($borderArray);    

$objPHPExcel->getActiveSheet()->getStyle('B3:C3')->applyFromArray($header_style_Array);
$objPHPExcel->getActiveSheet()->getStyle('B3:C3')->applyFromArray($borderArray);    

$objPHPExcel->getActiveSheet()->getStyle('B4:C4')->applyFromArray($header_style_Array);
$objPHPExcel->getActiveSheet()->getStyle('B4:C4')->applyFromArray($borderArray); 

$objPHPExcel->getActiveSheet()->getStyle('B5:C5')->applyFromArray($header_style_Array);
$objPHPExcel->getActiveSheet()->getStyle('B5:C5')->applyFromArray($borderArray);    

$objPHPExcel->getActiveSheet()->getStyle('B6:C6')->applyFromArray($header_style_Array);
$objPHPExcel->getActiveSheet()->getStyle('B6:C6')->applyFromArray($borderArray);

$objPHPExcel->getActiveSheet()->getStyle('B7:C7')->applyFromArray($header_style_Array);
$objPHPExcel->getActiveSheet()->getStyle('B7:C7')->applyFromArray($borderArray);
 

$query = "select * from excursion_master where financial_year_id='$financial_year_id' and delete_status='0' ";
if($customer_id!=""){
    $query .=" and customer_id='$customer_id'";
}
if($exc_id!=""){
    $query .=" and exc_id='$exc_id'";
}
if($from_date!="" && $to_date!=""){
    $from_date = date('Y-m-d', strtotime($from_date));
    $to_date = date('Y-m-d', strtotime($to_date));
    $query .= " and created_at between '$from_date' and '$to_date'";
}
if($company_name != ""){
    $query .= " and customer_id in (select customer_id from customer_master where company_name = '$company_name')";
}
if($cust_type != ""){
    $query .= " and customer_id in (select customer_id from customer_master where type = '$cust_type')";
}
if($branch_status=='yes'){
    if($role=='Branch Admin' || $role=='Accountant' || $role_id>'7'){
        $query .= " and branch_admin_id = '$branch_admin_id'";
    }
    elseif($role!='Admin' && $role!='Branch Admin' && $role_id!='7' && $role_id<'7'){
        $query .= " and emp_id='$emp_id' and branch_admin_id = '$branch_admin_id'";
    }
}
elseif($role!='Admin' && $role!='Branch Admin' && $role_id!='7' && $role_id<'7'){
    $query .= " and emp_id='$emp_id'";
}
// $query .= " order by exc_id desc";

$objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('B'.$row_count, "Sr. No")
        ->setCellValue('C'.$row_count, "Booking ID")
        ->setCellValue('D'.$row_count, "Customer Name")
        ->setCellValue('E'.$row_count, "Activity_DateTime")
        ->setCellValue('F'.$row_count, "City Name")
        ->setCellValue('G'.$row_count, "Activity Name")
        ->setCellValue('H'.$row_count, "Transfer Option")
        ->setCellValue('I'.$row_count, "Total Guest")
        ->setCellValue('J'.$row_count, "Amount");

$objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':J'.$row_count)->applyFromArray($header_style_Array);
$objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':J'.$row_count)->applyFromArray($borderArray); 
$row_count++;
        $count = 1;
        $sq_exc = mysqlQuery($query);
        while($row_exc =mysqli_fetch_assoc($sq_exc))
        {

            $date = $row_exc['created_at'];
            $yr = explode("-", $date);
            $year =$yr[0];
            $sq_customer_info = mysqli_fetch_assoc(mysqlQuery("select * from customer_master where customer_id='$row_exc[customer_id]'"));
			if($sq_customer_info['type'] == 'Corporate'||$sq_customer_info['type'] == 'B2B'){
				$customer_name = $sq_customer_info['company_name'];
			}else{
				$customer_name = $sq_customer_info['first_name'].' '.$sq_customer_info['last_name'];
			}

            $sq_entry = mysqlQuery("select * from excursion_master_entries where exc_id='$row_exc[exc_id]'");
            while($row_entry = mysqli_fetch_assoc($sq_entry))
            {
                $sq_city = mysqli_fetch_assoc(mysqlQuery("select * from city_master where city_id='$row_entry[city_id]'"));
                $sq_exc1 = mysqli_fetch_assoc(mysqlQuery("select * from excursion_master_tariff where entry_id='$row_entry[exc_name]'"));
                $total = $row_entry['total_adult']+$row_entry['total_child'] + $row_entry['total_infant'];

                $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('B'.$row_count, $count++)
                ->setCellValue('C'.$row_count, get_exc_booking_id($row_entry['exc_id'],$year))
                ->setCellValue('D'.$row_count, $customer_name)
                ->setCellValue('E'.$row_count, get_datetime_user($row_entry['exc_date']))
                ->setCellValue('F'.$row_count, $sq_city['city_name'])
                ->setCellValue('G'.$row_count, $sq_exc1['excursion_name'] )
                ->setCellValue('H'.$row_count, $row_entry['transfer_option'] )
                ->setCellValue('I'.$row_count, $total)
                ->setCellValue('J'.$row_count, number_format($row_entry['total_cost'],2));


                $objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':J'.$row_count)->applyFromArray($content_style_Array);
                $objPHPExcel->getActiveSheet()->getStyle('B'.$row_count.':J'.$row_count)->applyFromArray($borderArray);    
                    $row_count++;
            }
        }
//////////////////////////****************Content End**************////////////////////////////////
	

// Rename worksheet
$objPHPExcel->getActiveSheet()->setTitle('Simple');


for($col = 'A'; $col !== 'N'; $col++) {
    $objPHPExcel->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
}


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);


// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Activity Report('.date('d-m-Y H:i').').xls"');
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header ('Last-Modified: '.gmdate('D, d M Y H:i').' GMT'); // always modified
header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header ('Pragma: public'); // HTTP/1.0

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
exit;
