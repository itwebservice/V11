<?php
include_once('../../../../model/model.php');
$quotation_id1 = $_GET['quotation'];
$to = $_GET['to'];
$quotation_id = base64_decode($quotation_id1);
global $currency;

$sq_quotation = mysqli_fetch_assoc(mysqlQuery("select * from group_tour_quotation_master where quotation_id='$quotation_id'"));
$sq_tour = mysqli_fetch_assoc(mysqlQuery("select * from tour_master where tour_id='$sq_quotation[tour_group_id]'"));
$sq_dest = mysqli_fetch_assoc(mysqlQuery("select link from video_itinerary_master where dest_id = '$sq_tour[dest_id]'"));
$basic_cost = $sq_quotation['basic_amount'];
$service_charge = $sq_quotation['service_charge'];
$tour_cost = $basic_cost + $service_charge;
$service_tax_amount = 0;
$tax_show = '';
$bsmValues = json_decode($sq_quotation['bsmValues']);

$date = $sq_quotation['created_at'];
$yr = explode("-", $date);
$year = $yr[0];

if ($sq_quotation['service_tax_subtotal'] !== 0.00 && ($sq_quotation['service_tax_subtotal']) !== '') {
    $service_tax_subtotal1 = explode(',', $sq_quotation['service_tax_subtotal']);
    for ($i = 0; $i < sizeof($service_tax_subtotal1); $i++) {
        $service_tax = explode(':', $service_tax_subtotal1[$i]);
        $service_tax_amount +=  $service_tax[2];
        $name .= $service_tax[0]  . $service_tax[1] . ', ';
    }
}
$service_tax_amount_show = currency_conversion($currency, $sq_quotation['currency_code'], $service_tax_amount);

if ($bsmValues[0]->service != '') {   //inclusive service charge
    $newBasic = $tour_cost + $service_tax_amount;
    $tax_show = '';
} else {
    // $tax_show = $service_tax_amount;
    $tax_show =  rtrim($name, ', ') . ' : ' . ($service_tax_amount);
    $newBasic = $tour_cost;
}

////////////Basic Amount Rules
if ($bsmValues[0]->basic != '') { //inclusive markup
    $newBasic = $tour_cost + $service_tax_amount;
    $tax_show = '';
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Tour Quotation</title>

    <meta property="og:title" content="Tour Operator Software - iTours" />
    <meta property="og:description"
        content="Welcome to tiTOurs leading tour operator software, CRM, Accounting, Billing, Invocing, B2B, B2C Online Software for all small scale & large scale companies" />
    <meta property="og:url" content="http://www.itouroperatorsoftware.com" />
    <meta property="og:site_name" content="iTour Operator Software" />
    <meta property="og:image"
        content="http://www.itouroperatorsoftware.com/images/iTours-Tour-Operator-Software-logo.png" />
    <meta property="og:image:width" content="215" />
    <meta property="og:image:height" content="83" />

    <link href="https://fonts.googleapis.com/css?family=Noto+Sans" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,500" rel="stylesheet">



    <link rel="stylesheet" href="<?php echo BASE_URL ?>css/font-awesome-4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="<?php echo BASE_URL ?>css/jquery-ui.min.css" type="text/css" />

    <link rel="stylesheet" href="<?php echo BASE_URL ?>css/bootstrap.min.css">

    <link rel="stylesheet" href="<?php echo BASE_URL ?>css/owl.carousel.css" type="text/css" />

    <link rel="stylesheet" href="<?php echo BASE_URL ?>css/owl.theme.css" type="text/css" />

    <link rel="stylesheet" href="<?php echo BASE_URL ?>css/app/app.php">

    <link rel="stylesheet" href="<?php echo BASE_URL ?>css/app/modules/single_quotation.php">

</head>


<body>

    <header>
        <!-- Header -->
        <nav class="navbar navbar-default">

            <!-- Header-Top -->
            <div class="Header_Top">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12">
                            <ul class="company_contact">
                                <li><a href="mailto:email@company_name.com"><i class="fa fa-envelope"></i>
                                        <?= $app_email_id; ?></a></li>
                                <li><i class="fa fa-mobile"></i> <?= $app_contact_no; ?></li>
                                <li><i class="fa fa-phone"></i> <?= $app_landline_no; ?></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header single_quotation_head">
                    <a class="navbar-brand" href="http://<?= $app_website ?>"><img
                            src="<?php echo BASE_URL ?>images/Admin-Area-Logo.png" class="img-responsive"></a>
                    <div class="logo_right_part">
                        <h1><i class="fa fa-pencil-square-o"></i> Tour Quotation</h1>
                    </div>
                </div>
                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="nav">
                    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                        <ul id="menu-center" class="nav navbar-nav">
                            <li class="active"><a href="#0">Package</a></li>
                            <li><a href="#1">Costing</a></li>
                            <!-- <li><a href="#2">Transport</a></li> -->
                            <li><a href="#3">Tour Itinerary</a></li>
                            <!-- <li><a href="#4">Accommodations</a></li> -->
                            <li><a href="#5">Train</a></li>
                            <li><a href="#6">Flight</a></li>
                            <li><a href="#11">Cruise</a></li>
                            <li><a href="#7">Incl/Excl</a></li>
                        </ul>
                    </div><!-- /.navbar-collapse -->
                </div>
            </div><!-- /.container-fluid -->
        </nav>
        <!-- Header-End -->
    </header>





    <!-- Package -->

    <section id="0" class="main_block link_page_section">

        <div class="container">

            <div class="sec_heding">

                <h2>Group Tour Details</h2>

            </div>

            <div class="row">

                <div class="col-md-6 col-xs-12">

                    <ul class="pack_info">

                        <li><span>Tour Name </span>: <?= $sq_quotation['tour_name']; ?> </li>

                        <li><span>Quotation ID </span>: <?= get_quotation_id($quotation_id, $year); ?></li>

                    </ul>

                </div>

                <div class="col-md-6 col-xs-12">

                    <ul class="pack_info">

                        <li><span>Customer Name </span>: <?= $sq_quotation['customer_name']; ?></li>

                        <li><span>E-mail ID </span>: <?= $sq_quotation['email_id']; ?></li>

                    </ul>

                </div>

            </div>

            <div class="row">

                <div class="col-md-12">

                    <div class="adolence_info mg_tp_25">

                        <ul class="main_block">
                            <li class="col-md-2 col-sm-4 col-xs-12 mg_bt_10_xs"><span>Adult :
                                </span><?= $sq_quotation['total_adult']; ?></li>
                            <li class="col-md-2 col-sm-4 col-xs-12 mg_bt_10_xs sm_r_brd_r8"><span>Infant :
                                </span><?= $sq_quotation['total_infant']; ?></li>
                            <li class="col-md-2 col-sm-4 col-xs-12 mg_bt_10_sm_xs"><span>Child With Bed :
                                </span><?= $sq_quotation['children_with_bed']; ?></li>

                            <li class="col-md-2 col-sm-4 col-xs-12"><span>Child Without Bed :
                                </span><?= $sq_quotation['children_without_bed']; ?></li>
                            <li class="col-md-2 col-sm-4 col-xs-12 mg_bt_10_sm_xs"><span>Total :
                                </span><?= $sq_quotation['total_passangers']; ?></li>

                        </ul>

                    </div>

                </div>

            </div>

        </div>

    </section>



    <!-- Costing -->

    <section id="1" class="main_block link_page_section">

        <div class="container">

            <div class="sec_heding">

                <h2>Costing</h2>

            </div>

            <div class="row">

                <div class="col-md-12">

                    <div class="adolence_info">

                        <ul class="main_block">

                            <div class="row">
                                <?php
                                $adult_cost1 = currency_conversion($currency, $sq_quotation['currency_code'], $sq_quotation['adult_cost']);
                                $infant_cost1 = currency_conversion($currency, $sq_quotation['currency_code'], $sq_quotation['infant_cost']);
                                $with_bed_cost1 = currency_conversion($currency, $sq_quotation['currency_code'], $sq_quotation['with_bed_cost']);
                                $children_cost1 = currency_conversion($currency, $sq_quotation['currency_code'], $sq_quotation['children_cost']);
                                $quotation_cost1 = currency_conversion($currency, $sq_quotation['currency_code'], $sq_quotation['quotation_cost']);
                                $service_charge = currency_conversion($currency, $sq_quotation['currency_code'], $sq_quotation['service_charge']);
                                ?>
                                <?php if ($sq_quotation['adult_cost'] != '0') { ?><li
                                    class="col-md-3 col-sm-6 col-xs-12 mg_bt_10_sm_xs"><span>Adult Cost :
                                    </span><?= $adult_cost1 ?></li> <?php } ?>

                                <?php if ($sq_quotation['infant_cost'] != '0') { ?><li
                                    class="col-md-3 col-sm-6 col-xs-12 mg_bt_10_sm_xs"><span>Infant Cost :
                                    </span><?= $infant_cost1 ?></li> <?php } ?>
                                <?php if ($sq_quotation['with_bed_cost'] != '0') { ?><li
                                    class="col-md-3 col-sm-6 col-xs-12"><span>Child with Bed Cost :
                                    </span><?= $with_bed_cost1 ?></li> <?php } ?>
                                <?php if ($sq_quotation['children_cost'] != '0') { ?><li
                                    class="col-md-3 col-sm-6 col-xs-12 mg_bt_10_sm_xs"><span>Child w/o Bed Cost :
                                    </span><?= $children_cost1 ?></li> <?php } ?>
                                <li class="col-md-3 col-sm-6 col-xs-12 mg_bt_10_sm_xs"><span>Other Charges :
                                    </span><?= $service_charge ?></li>
                                <li class="col-md-3 col-sm-6 col-xs-12 mg_bt_10 sm_r_brd_r8"><span>Tax :
                                    </span><?= $service_tax_amount_show ?></li>
                                <li class="col-md-3 col-sm-6 col-xs-12 mg_bt_10_xs sm_r_brd_r8 highlight"
                                    style="font-weight: 600; color: #016d01;"><span class="highlight">Quotation Cost :
                                    </span><?= $quotation_cost1 ?></li>
                            </div>

                        </ul>

                    </div>

                </div>

            </div>
            <!-- bank -->
            <?php
            global $currency, $bank_name_setting, $bank_branch_name, $acc_name, $bank_acc_no, $bank_ifsc_code, $bank_swift_code;

            $bank_name_setting1 = ($bank_name_setting != '') ? $bank_name_setting : 'NA';
            $bank_branch_name1 = ($bank_branch_name != '') ? $bank_branch_name : 'NA';
            $acc_name1 = ($acc_name != '') ? $acc_name : 'NA';
            $bank_acc_no1 = ($bank_acc_no != '') ? $bank_acc_no : 'NA';
            $bank_ifsc_code1 = ($bank_ifsc_code != '') ? $bank_ifsc_code : 'NA';
            $bank_swift_code1 = ($bank_swift_code != '') ? $bank_swift_code : 'NA';
            $bank_account_name1 = ($bank_account_name != '') ? $bank_account_name : 'NA';

            ?>
            <div class="sec_heding">
                <div class="sec_heding mg_tp_30">

                    <h2>Bank Details</h2>

                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="adolence_info">
                            <div class="row mg_bt_10">
                                <ul class="main_block">
                                    <li class="col-md-4 col-sm-6 col-xs-12 mg_bt_10"><span>Bank Name :
                                        </span><u><?= $bank_name_setting1 ?></u></li>
                                    <li class="col-md-4 col-sm-6 col-xs-12 mg_bt_10"><span>Bank Branch :
                                        </span><u><?= $bank_branch_name1 ?>(<?= $bank_ifsc_code1 ?>)</u></li>
                                    <li class="col-md-4 col-sm-6 col-xs-12 mg_bt_10"><span>Account Type:
                                        </span><u><?= $acc_name1 ?></u></li>
                                    <li class="col-md-4 col-sm-6 col-xs-12 mg_bt_10"><span>Account Number:
                                        </span><u><?= $bank_acc_no1 ?></u></li>
                                    <li class="col-md-4 col-sm-6 col-xs-12 mg_bt_10"><span>Swift Code:
                                        </span><u><?= $bank_swift_code1 ?></u></li>
                                    <li class="col-md-4 col-sm-6 col-xs-12 mg_bt_10"><span>Bank Account Name:
                                        </span><u><?= $bank_account_name1 ?></u></li>

                                </ul>
                            </div>

                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-md-12">
                        <div class="adolence_info">
                            <?php
                            if (check_qr()) {

                            ?>
                            <ul class="main_block">

                                <li class="col-md-12 text-center mg_bt_10"> <?= get_qr('general') ?>
                                    <br>
                                    <p class="text-center">Scan & Pay</p>
                                </li>

                            </ul>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <!-- bank -->


        </div>

    </section>

    <!-- Tour Itinenary -->

    <section id="3" class="main_block link_page_section">

        <div class="container">
            <div class="sec_heding">
                <h2>Tour Itinerary</h2>
            </div>
            <div class="row mg_bt_30">
                <div class="col-md-12">
                    <div class="adolence_info mg_tp_15">
                        <ul class="main_block">
                            <li class="col-md-12 col-sm-4 col-xs-12 mg_bt_10_xs"><img
                                    src="<?php echo BASE_URL . 'images/quotation/youtube-icon.png'; ?>"
                                    class="itinerary-img img-responsive">
                                &nbsp;Destination Guide Video :&nbsp;<a href="<?= $sq_dest['link'] ?>"
                                    class="no-marg itinerary-link" target="_blank"><?= $sq_dest['link'] ?> </a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 Itinenary_detail app_accordion">
                    <div class="panel-group main_block" id="pkg_accordion" role="tablist" aria-multiselectable="true">
                        <?php
                        $count = 0;
                        $i = 0;
                        $sq_package_program = mysqlQuery("select * from group_tour_program where tour_id ='$sq_quotation[tour_group_id]'");
                        $dates = (array) get_dates_for_tour_itineary($sq_quotation['quotation_id']);
                        while ($row_itinarary = mysqli_fetch_assoc($sq_package_program)) {

                            if ($row_itinarary['daywise_images'] != "") {
                                $daywise_image = $row_itinarary['daywise_images'];
                            } else {
                                $daywise_image = 'http://itourscloud.com/quotation_format_images/dummy-image.jpg';
                            }

                            $count++; ?>
                        <div class="panel panel-default main_block">
                            <div class="panel-heading main_block" role="tab" id="heading<?= $count; ?>">
                                <div class="Normal collapsed main_block" role="button" data-toggle="collapse"
                                    data-parent="#pkg_accordion" href="#collapse<?= $count; ?>" aria-expanded="false"
                                    aria-controls="collapse<?= $count; ?>">
                                    <div class="col-md-2"><span><em>Day :</em>
                                            <?= $count; ?><?= '(' . $dates[$i++] . ')' ?></span></div>
                                    <div class="col-md-5" style="line-height: 26px; padding:7px 15px 7px 15px;">
                                        <span><em>Attraction :</em> <?= $row_itinarary['attraction']; ?></span></div>
                                    <div class="col-md-4"><span><em>Overnight stay :</em>
                                            <?= $row_itinarary['stay']; ?></span></div>
                                    <div class="col-md-12" style="line-height: 26px; padding:7px 15px 7px 15px;">
                                        <span><em>Meal Plan :</em> <?= $row_itinarary['meal_plan']; ?></span></div>
                                </div>
                            </div>
                            <div id="collapse<?= $count; ?>" class="panel-collapse <?= $in; ?> collapse main_block"
                                role="tabpanel" aria-labelledby="heading<?= $count; ?>">

                                <div class="panel-body">
                                    <div class="col-md-4 col-sm-6 col-xs-12">
                                        <div class="Sightseeing_img_block main_block"
                                            onclick="display_destination('<?php echo $daywise_image; ?>');">
                                            <img src="<?php echo $daywise_image; ?>" class="img-responsive">
                                        </div>
                                    </div>
                                    <pre class="real_text"><?= $row_itinarary['day_wise_program']; ?></pre>
                                </div>
                            </div>
                        </div>
                        <?php $in = '';
                        } ?>
                    </div>
                </div>
            </div>

            <div id="div_quotation_form1"></div>

            <!-- Accomodations -->

            <?php
            $sq_hotel_count = mysqli_num_rows(mysqlQuery("select * from package_tour_quotation_hotel_entries where quotation_id='$quotation_id'"));
            if ($sq_hotel_count > 0) { ?>

            <!-- <section id="4" class="main_block link_page_section">

    <div class="container">

      <div class="sec_heding">

        <h2>accommodations</h2>

      </div>

      <div class="row">

        <div class="col-md-10 col-md-offset-1 col-sm-12">

        <?php
                $sq_hotel = mysqlQuery("select * from package_tour_quotation_hotel_entries where quotation_id='$quotation_id'");
                while ($row_hotel = mysqli_fetch_assoc($sq_hotel)) {

                    $hotel_name = mysqli_fetch_assoc(mysqlQuery("select * from hotel_master where hotel_id='$row_hotel[hotel_name]'"));
                    $city_name = mysqli_fetch_assoc(mysqlQuery("select * from city_master where city_id='$row_hotel[city_name]'"));
                    $sq_hotel_count = mysqli_num_rows(mysqlQuery("select * from hotel_vendor_images_entries where hotel_id = '$row_hotel[hotel_name]'"));
                    if ($sq_hotel_count == '0') {
                        $newUrl = BASE_URL . 'images/dummy-image.jpg';
                    } else {
                        $sq_hotel_image1 = mysqli_fetch_assoc(mysqlQuery("select * from hotel_vendor_images_entries where hotel_id = '$row_hotel[hotel_name]'"));
                        $image = $sq_hotel_image1['hotel_pic_url'];
                        $newUrl = preg_replace('/(\/+)/', '/', $image);
                        $newUrl = explode('uploads', $newUrl);
                        $newUrl = BASE_URL . 'uploads' . $newUrl[1];
                    }
        ?>

          <div class="col-md-4 col-sm-6 col-xs-12 mg_bt_20">

            <div class="single_accomodation_hotel mg_bt_10_xs">

              <div class="acco_hotel_image" style="display: block;cursor: pointer;" onclick="display_gallery('<?php echo $row_hotel['hotel_name']; ?>')">

                <img src="<?php echo $newUrl; ?>" style="width: 100%;height: 135px;" class="img-responsive">

              </div>

              <div class="acco_hotel_detail">

                <ul class="text-center">

                  <li class="acco-_hotel_name"><?= $hotel_name['hotel_name'] . $similar_text; ?></li>

                  <li class="acco-_hotel_star"><?= $row_hotel['hotel_type']; ?></li>

                  <li class="acco-_hotel_city"><span>City : </span><?= $city_name['city_name']; ?></li>

                  <li class="acco-_hotel_days"><span>Total Nights : </span><?= $row_hotel['total_days']; ?></li>

                </ul>

              </div>

              <div class="acco_hotel_btn text-center mg_tp_20">

                <button type="button" data-toggle="modal" onclick="display_gallery('<?php echo $row_hotel['hotel_name']; ?>')" title="View Gallery">Hotel Gallery</button>

              </div>

            </div>

          </div>

          <?php } ?>

        </div>

      </div>

    </div>

  </section> -->

            <?php }

            ?>

            <div id="div_quotation_form"></div>

            <!-- Train -->

            <?php

            $sq_train_count = mysqli_num_rows(mysqlQuery("select * from group_tour_quotation_train_entries where quotation_id ='$quotation_id'"));



            if ($sq_train_count > 0) {

            ?>

            <section id="5" class="main_block link_page_section">

                <div class="container">

                    <div class="sec_heding">

                        <h2>Train</h2>

                    </div>

                    <div class="row">

                        <div class="col-md-12">

                            <div class="table-responsive">

                                <table class="table table-bordered no-marg" id="tbl_emp_list">

                                    <thead>

                                        <tr class="table-heading-row">

                                            <th>From</th>

                                            <th>To</th>

                                            <th>Class</th>

                                            <th>Departure_Datetime</th>

                                            <th>Arrival_DateTime</th>

                                        </tr>

                                    </thead>

                                    <tbody>

                                        <?php
                                            $sq_train = mysqlQuery("select * from group_tour_quotation_train_entries where quotation_id='$quotation_id'");
                                            while ($row_train = mysqli_fetch_assoc($sq_train)) { ?>

                                        <tr>

                                            <td><?= $row_train['from_location']; ?></td>

                                            <td><?= $row_train['to_location']; ?></td>

                                            <td><?= $row_train['class']; ?></td>

                                            <td><?= date('d-m-Y H:i', strtotime($row_train['departure_date'])); ?></td>

                                            <td><?= date('d-m-Y H:i', strtotime($row_train['arrival_date'])); ?></td>

                                        </tr>

                                        <?php } ?>

                                    </tbody>

                                </table>

                            </div>

                        </div>

                    </div>

                </div>

            </section>

            <?php } ?>



            <!-- Flight -->

            <?php

            $sq_plane_count = mysqli_num_rows(mysqlQuery("select * from group_tour_quotation_plane_entries where quotation_id='$quotation_id'"));



            if ($sq_plane_count > 0) { ?>

            <section id="6" class="main_block link_page_section">

                <div class="container">

                    <div class="sec_heding">

                        <h2>Flight</h2>

                    </div>

                    <div class="row">

                        <div class="col-md-12">

                            <div class="table-responsive">

                                <table class="table table-bordered no-marg" id="tbl_emp_list">

                                    <thead>

                                        <tr class="table-heading-row">

                                            <th>From</th>

                                            <th>To</th>

                                            <th>Airline</th>

                                            <th>Class</th>

                                            <th>Departure_DateTime</th>

                                            <th>Arrival_DateTime</th>

                                        </tr>

                                    </thead>

                                    <tbody>

                                        <?php
                                            $sq_plane = mysqlQuery("select * from group_tour_quotation_plane_entries where quotation_id='$quotation_id'");
                                            while ($row_plane = mysqli_fetch_assoc($sq_plane)) {
                                                $sq_airline = mysqli_fetch_assoc(mysqlQuery("select * from airline_master where airline_id='$row_plane[airline_name]'"));
                                            ?>
                                        <tr>

                                            <td><?= $row_plane['from_location']; ?></td>

                                            <td><?= $row_plane['to_location']; ?></td>

                                            <td><?= $sq_airline['airline_name'] . ' (' . $sq_airline['airline_code'] . ')'; ?>
                                            </td>

                                            <td><?= $row_plane['class']; ?></td>

                                            <td><?= date('d-m-Y H:i', strtotime($row_plane['dapart_time'])); ?></td>

                                            <td><?= date('d-m-Y H:i', strtotime($row_plane['arraval_time'])); ?></td>

                                        </tr>

                                        <?php } ?>

                                    </tbody>

                                </table>

                            </div>

                        </div>

                    </div>

                </div>

            </section>

            <?php } ?>


            <!-- Flight -->

            <?php

            $sq_cruise_count = mysqli_num_rows(mysqlQuery("select * from group_tour_quotation_cruise_entries where quotation_id='$quotation_id'"));



            if ($sq_cruise_count > 0) { ?>

            <section id="11" class="main_block link_page_section">

                <div class="container">

                    <div class="sec_heding">

                        <h2>Cruise</h2>

                    </div>

                    <div class="row">

                        <div class="col-md-12">

                            <div class="table-responsive">

                                <table class="table table-bordered no-marg" id="tbl_emp_list">

                                    <thead>

                                        <tr class="table-heading-row">

                                            <th>Departure_Datetime</th>
                                            <th>Arrival_Datetime</th>
                                            <th>Route</th>
                                            <th>Cabin</th>
                                            <th>Sharing</th>

                                        </tr>

                                    </thead>

                                    <tbody>

                                        <?php
                                            $sq_cruise = mysqlQuery("select * from group_tour_quotation_cruise_entries where quotation_id='$quotation_id'");
                                            while ($row_train = mysqli_fetch_assoc($sq_cruise)) {
                                            ?>
                                        <tr>
                                            <td><?= get_datetime_user($row_train['dept_datetime']) ?></td>
                                            <td><?= get_datetime_user($row_train['arrival_datetime']) ?></td>
                                            <td><?= $row_train['route'] ?></td>
                                            <td><?= ($row_train['cabin']) ?></td>
                                            <td><?= ($row_train['sharing']) ?></td>
                                        </tr>
                                        <?php
                                            } ?>

                                    </tbody>

                                </table>

                            </div>

                        </div>

                    </div>

                </div>

            </section>

            <?php } ?>


            <!-- Excursion -->

            <?php

            $sq_ex_count = mysqli_num_rows(mysqlQuery("select * from package_tour_quotation_excursion_entries where quotation_id='$quotation_id'"));



            if ($sq_ex_count > 0) { ?>

            <!-- <section id="10" class="main_block link_page_section">

    <div class="container">

      <div class="sec_heding">

        <h2>Excursion</h2>

      </div>

      <div class="row">

        <div class="col-md-12">

         <div class="table-responsive">

          <table class="table table-bordered no-marg" id="tbl_emp_list">

            <thead>

              <tr class="table-heading-row">
                <th>Sr.No</th>

                <th>City Name</th>

                <th>Excursion Name</th>

              </tr>

            </thead>

            <tbody>

            <?php
                // $sq_ex = mysqlQuery("select * from package_tour_quotation_excursion_entries where quotation_id='$quotation_id'");
                // $count =0;
                // while($row_ex = mysqli_fetch_assoc($sq_ex))
                // {
                //   $count++;
                //   $sq_city = mysqli_fetch_assoc(mysqlQuery("select * from city_master where city_id='$row_ex[city_name]'"));
                //   $sq_ex_name = mysqli_fetch_assoc(mysqlQuery("select * from itinerary_paid_services where service_id='$row_ex[excursion_name]'"));
            ?>   

              <tr>

                <td><?= $count; ?></td>

                <td><?= $sq_city['city_name']; ?></td>

                <td><?= $sq_ex_name['service_name']; ?></td>

              </tr>

              <?php //} 
                ?>

            </tbody>

          </table>

         </div>

       </div>

      </div>

    </div>
  </section>  -->


            <?php } ?>




            <!-- Inclusion -->
            <!-- Exclusion -->

            <section id="7" class="main_block link_page_section">

                <div class="container">

                    <div class="row">

                        <div class="col-md-12 in_ex_tab">

                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs responsive" role="tablist">
                                <li role="presentation"><a href="#home" aria-controls="home" role="tab"
                                        data-toggle="tab">Inclusions</a></li>
                                <li role="presentation"><a href="#profile" aria-controls="profile" role="tab"
                                        data-toggle="tab">Exclusions</a></li>
                                <li role="presentation" class="active"><a href="#terms" aria-controls="terms" role="tab"
                                        data-toggle="tab">Terms & conditions</a></li>
                            </ul>

                            <!-- Tab panes -->

                            <div class="tab-content responsive">

                                <div role="tabpanel" class="tab-pane" id="home">
                                    <pre><?php echo $sq_quotation['incl']; ?></pre>
                                </div>

                                <div role="tabpanel" class="tab-pane" id="profile">
                                    <pre><?php echo $sq_quotation['excl']; ?></pre>
                                </div>

                                <div role="tabpanel" class="tab-pane active" id="terms">
                                    <pre><?php
                                            $sq_query = mysqli_fetch_assoc(mysqlQuery("select * from terms_and_conditions where type='Group Quotation' and active_flag='Active'"));
                                            echo $sq_query['terms_and_conditions'] ?></pre>
                                </div>

                            </div>



                        </div>

                    </div>

                </div>

            </section>



            <!-- Feedback -->
            <?php
            $quotation_id = base64_encode($quotation_id);
            ?>
            <section id="8" class="main_block link_page_section">

                <div class="container">

                    <div class="feedback_action text-center">

                        <div class="row">

                            <div class="col-sm-4 col-xs-12">

                                <div class="feedback_btn succes mg_bt_20">

                                    <button value="Interested in Booking"><a
                                            href="quotation_email_interested.php?quotation_id=<?php echo $quotation_id; ?>"
                                            style="color:#ffffff;text-decoration:none">I'm Interested</a>

                                </div>

                            </div>

                            <div class="col-sm-4 col-xs-12">

                                <div class="feedback_btn danger mg_bt_20">

                                    <button value="Interested in Booking"><a
                                            href="quotation_email_not_interested.php?quotation_id=<?php echo $quotation_id; ?>"
                                            style="color:#ffffff;text-decoration:none">Not Interested</a>

                                </div>

                            </div>

                            <div class="col-sm-4 col-xs-12">

                                <div class="feedback_btn info mg_bt_20">

                                    <button type="button" data-toggle="modal" data-target="#feedback_suggestion"
                                        title="Write Suggestion">Give Suggestion</button>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </section>



            <!-- Footer -->



            <footer class="main_block">

                <div class="footer_part">

                    <div class="container">

                        <div class="row">

                            <div class="col-md-8 col-sm-6 col-xs-12 mg_bt_10_sm_xs">

                                <div class="footer_company_cont">

                                    <p><i class="fa fa-map-marker"></i> <?php echo $app_address; ?></p>

                                </div>

                            </div>

                            <div class="col-md-4 col-sm-6 col-xs-12">

                                <div class="footer_company_cont text-center text_left_sm_xs">

                                    <p><i class="fa fa-phone"></i> <?php echo $app_contact_no; ?></p>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </footer>





            <div class="modal fade" id="feedback_suggestion" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">

                <div class="modal-dialog modal-md" role="document">

                    <div class="modal-content">

                        <div class="modal-header">

                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>

                            <h4 class="modal-title" id="myModalLabel">Suggestion</h4>

                        </div>

                        <div class="modal-body">

                            <textarea class="form-control" placeholder="*Write Suggestion" id="suggestion"
                                rows="5"></textarea>

                            <div class="row mg_tp_20 text-center">

                                <button class="btn btn-success" id="btn_quotation_send"
                                    onclick="multiple_suggestion_mail('<?php echo $quotation_id; ?>');"><i
                                        class="fa fa-paper-plane-o"></i>&nbsp;&nbsp;Send</a></button>

                            </div>

                        </div>

                    </div>

                </div>

            </div>





            <!-- Footer-End-->




            <script src="<?php echo BASE_URL ?>js/jquery-3.1.0.min.js"></script>

            <script src="<?php echo BASE_URL ?>js/jquery-ui.min.js"></script>
            <script src="<?php echo BASE_URL ?>js/bootstrap.min.js"></script>
            <script src="<?php echo BASE_URL ?>js/owl.carousel.min.js"></script>
            <script src="<?php echo BASE_URL ?>js/responsive-tabs.js"></script>

            <script type="text/javascript">
            (function($) {
                fakewaffle.responsiveTabs(['xs', 'sm']);
            })(jQuery);
            </script>



            <script type="text/javascript">
            function multiple_suggestion_mail(quotation_id) {

                var base_url = $('#base_url').val();

                var suggestion = $('#suggestion').val();

                if (suggestion == '') {
                    alert('Enter suggestion');
                    return false;
                }

                $('#btn_quotation_send').button('loading');

                $.ajax({

                    type: 'post',

                    url: 'suggestion_email_send.php',

                    data: {
                        quotation_id: quotation_id,
                        suggestion: suggestion
                    },

                    success: function(message) {

                        alert(message);

                        $('#feedback_suggestion').modal('hide');

                        $('#btn_quotation_send').button('reset');

                    }

                });

            }
            </script>





            <!-- sticky-header -->

            <script type="text/javascript">
            $(document).ready(function() {



                $(window).bind('scroll', function() {



                    var navHeight = 159; // custom nav height



                    ($(window).scrollTop() > navHeight) ? $('div.nav').addClass('goToTop'): $('div.nav')
                        .removeClass('goToTop');



                });



            });



            // Smooth-scroll -->

            $(document).on('click', '#menu-center a', function(event) {

                event.preventDefault();



                $('html, body').animate({

                    scrollTop: $($.attr(this, 'href')).offset().top

                }, 500);

            });



            //Active-menu -->

            $("#menu-center a").click(function() {

                $(this).parent().siblings().removeClass('active');

                $(this).parent().addClass('active');

            });



            // Accordion -->

            $('#myCollapsible').collapse({

                toggle: false

            })



            function display_destination(newurl)

            {

                $.post('../display_destination_image.php', {
                    newurl: newurl
                }, function(data) {

                    $('#div_quotation_form1').html(data);

                });



            }

            function display_gallery(hotel_name)

            {

                $.post('display_hotel_gallery.php', {
                    hotel_name: hotel_name
                }, function(data) {

                    $('#div_quotation_form').html(data);

                });



            }
            </script>



</body>

</html>
<?php
$date = date('d-m-Y H:i');

$content = '

<tr>
            <table width="85%" cellspacing="0" cellpadding="5" style="color: #888888;border: 1px solid #888888;margin: 0px auto;margin-top:20px; min-width: 100%;" role="presentation">
              <tr><td style="text-align:left;border: 1px solid #888888;">Name</td>   <td style="text-align:left;border: 1px solid #888888;">' . $sq_quotation['customer_name'] . '</td></tr>
              <tr><td style="text-align:left;border: 1px solid #888888;">Quotation Id</td>   <td style="text-align:left;border: 1px solid #888888;" >' . get_quotation_id(base64_decode($quotation_id1), $year) . '</td></tr>
              <tr><td style="text-align:left;border: 1px solid #888888;">On Datetime</td>   <td style="text-align:left;border: 1px solid #888888;">' . $date . '</td></tr>
            </table>
          </tr>';


$subject = 'Customer viewed quotation! (ID : ' . get_quotation_id(base64_decode($quotation_id1), $year) . ' , ' . $sq_quotation['customer_name'] . ' )';
$model->app_email_send('9', 'Admin', $app_email_id, $content, $subject);


?>