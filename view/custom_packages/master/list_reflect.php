<?php

include "../../../model/model.php";

$dest_id = $_POST['dest_id'];
$status = $_POST['status'];

?>

<div class="row mg_tp_20">
    <div class="col-md-12 no-pad">
        <div class="table-responsive">

            <table class="table" id="tbl_tour_list" style="margin: 20px 0 !important;">

                <thead>

                    <tr class="table-heading-row">

                        <th>S_No.</th>

                        <th>Package_Name</th>

                        <th>Days/Nights</th>
                        <th>Actions</th>


                    </tr>

                </thead>

                <tbody>

                    <?php

					$count = 0;

					if ($status != '') {
						$query = "select * from custom_package_master where 1 and status='$status'";
					} else {

						$query = "select * from custom_package_master where 1 and status='Active'";
					}

					if ($dest_id != '') {

						$query .= " and dest_id = '$dest_id'";
					}

					$sq_tours = mysqlQuery($query);
					while ($row_tour = mysqli_fetch_assoc($sq_tours)) {

						if ($app_quot_format == 2) {
							$url1 = BASE_URL . "model/app_settings/print_html/quotation_html/quotation_html_2/b2b_package_html.php?package_id=$row_tour[package_id]";
						} else if ($app_quot_format == 3) {
							$url1 = BASE_URL . "model/app_settings/print_html/quotation_html/quotation_html_3/b2b_package_html.php?package_id=$row_tour[package_id]";
						} else if ($app_quot_format == 4) {
							$url1 = BASE_URL . "model/app_settings/print_html/quotation_html/quotation_html_4/b2b_package_html.php?package_id=$row_tour[package_id]";
						} else if ($app_quot_format == 5) {
							$url1 = BASE_URL . "model/app_settings/print_html/quotation_html/quotation_html_5/b2b_package_html.php?package_id=$row_tour[package_id]";
						} else if ($app_quot_format == 6) {
							$url1 = BASE_URL . "model/app_settings/print_html/quotation_html/quotation_html_6/b2b_package_html.php?package_id=$row_tour[package_id]";
						} else {
							$url1 = BASE_URL . "model/app_settings/print_html/quotation_html/quotation_html_1/b2b_package_html.php?package_id=$row_tour[package_id]";
						}

						$bg = ($row_tour['clone'] == 'yes') ? 'warning' : '';
						$status = $row_tour['status'];
						if ($status == 'Inactive') {
							$bg = 'danger';
							$copy_btn = '';
							$pdf_btn = '';
						} else {
							$pdf_btn = '<a onclick="loadOtherPage(\'' . $url1 . '\')" class="btn btn-info btn-sm" title="Print"><i class="fa fa-print"></i></a>';
							$copy_btn = '<button class="btn btn-warning btn-sm" onclick="package_clone(' . $row_tour['package_id'] . ')" title="Copy Package Tour"><i class="fa fa-files-o"></i></button>';
						}

					?>
                    <tr class="<?php echo $bg; ?>">
                        <td><?= ++$count ?></td>
                        <td><?= $row_tour['package_name'] . '(' . $row_tour['package_code'] . ')' ?></td>
                        <td><?= $row_tour['total_days'] . 'D/' . $row_tour['total_nights'] . 'N' ?></td>
                        <td><?php
							echo  $pdf_btn.'
							<form style="display:inline-block" action="update_modal.php" class="no-marg" method="POST">
								<input type="hidden" id="package_id" style="display:inline-block" name="package_id" value="' . $row_tour['package_id'] . '">
								<button class="btn btn-info btn-sm form-control" id="update_btn' . $row_tour['package_id'] . '" title="Update Details"><i class="fa fa-pencil-square-o"></i></button>
							</form>' .$copy_btn . '<button class="btn btn-info btn-sm" onclick="view_modal(' . $row_tour['package_id'] . ')" id="view_btn-' . $row_tour['package_id'] . '" title="View Details"><i class="fa fa-eye"></i></button>'; ?>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
$('#tbl_tour_list').dataTable({
    "pagingType": "full_numbers"
});
</script>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>