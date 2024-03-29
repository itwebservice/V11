<?php
include "../../../model/model.php";

$emp_id = $_POST['emp_id'];
$from_date = $_POST['from_date'];
$to_date = $_POST['to_date'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$login_emp_id = $_SESSION['emp_id'];
$role = $_SESSION['role'];
$role_id = $_SESSION['role_id'];
$branch_status = $_POST['branch_status'];

$query = "select * from leave_request where 1 ";
if($from_date!='' && $to_date!=''){
	$from_date = get_date_db($from_date);
	$to_date = get_date_db($to_date);
	$query .=" and created_date between '$from_date' and '$to_date'";
}
if($emp_id != ''){
	$query .= " and emp_id='$emp_id'";
}
if($branch_status=='yes'){
	if($role=='Branch Admin' || $role=='Accountant' || $role=='Hr' || $role_id>'7'){
		$query .= " and emp_id in (select emp_id from emp_master where branch_id = '$branch_admin_id')";
	}
	elseif($role!='Admin' && $role!='Branch Admin' && $role!='Hr' && $role_id!='7' && $role_id<'7'){
		$query .= " and emp_id='$emp_id' ";
	}
}
elseif($role!='Admin' && $role!='Branch Admin' && $role!='Hr' && $role!='Accountant' && $role_id!='7' && $role_id<'7'){
	$query .= " and emp_id='$emp_id'";
}
// $query .=" order by request_id desc";
?>
<div class="row mg_tp_20"> <div class="col-md-12 no-pad mg_tp_20"> <div class="table-responsive">

<table class="table table-hover" id="tbl_customer_list" style="margin: 20px 0 !important;">
	<thead>
		<tr class="table-heading-row">
			<th>S_No.</th>
			<th>User_Name</th>
			<th>Request_date</th>
			<th>Status</th>
			<th>Total_days</th>
			<th>Reason</th>
			<?php if($role == "Admin" || $role == "Branch Admin" || $role == "Hr"){ ?>
			<th>Remark</th> <?php } ?>
		</tr>
	</thead>
	<tbody>
		<?php 
		$count = 0;
		$sq_req = mysqlQuery($query);
		while($row_req = mysqli_fetch_assoc($sq_req)){
			
			$sq_emp = mysqli_fetch_assoc(mysqlQuery("select * from emp_master where emp_id='$row_req[emp_id]'"));
			if($row_req['status'] == 'Reject'){ $bg = 'danger'; }
			else if($row_req['status'] == 'Approved'){ $bg = 'success'; }
			else { $bg = ''; }
			?>
			<tr class="<?= $bg ?>">
				<td><?= ++$count ?></td>
				<td><?= $sq_emp['first_name'].' '.$sq_emp['last_name']  ?></td>
				<td><?= date('d/m/Y', strtotime($row_req['created_date'])) ?></td>
				<td><?= ($row_req['status']=='')?'Not Processed': $row_req['status'] ?></td>
				<td><?=  $row_req['no_of_days'] ?></td>
				<td><?= $row_req['reason_for_leave'] ?></td>
				<?php if($role == "Admin" || $role == "Branch Admin" || $role == "Hr"){ ?>
				<td>
					<button class="btn btn-info btn-sm" onclick="display_modal(<?= $row_req['emp_id'] ?>,<?= $row_req['request_id'] ?>)" title="Edit Remark"><i class="fa fa-pencil-square-o"></i></button>
				</td>		<?php } ?>		
			</tr>
			<?php
		}
		?>
	</tbody>
</table>	

</div> </div> </div>
<script>
$('#tbl_customer_list').dataTable({
		"pagingType": "full_numbers",
		order: [[0, 'desc']],
});
</script>