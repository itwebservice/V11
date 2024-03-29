<?php
include "../../../model/model.php";
?>
<div class="row mg_tp_20"> <div class="col-md-12 no-pad"> <div class="table-responsive">
	<table class="table table-hover" id="upcoming_tours_id" style="margin: 20px 0 !important;">
	    <thead>
        <tr class="table-heading-row">
          <th>S_No.</th>
          <th>Offer_Title</th>
          <th>Description</th>
          <th>Valid_Till</th>
          <th>Actions</th>
        </tr> 
      </thead>
      <tbody>
        <?php
        $count = 0; 
        $sq_offer = mysqlQuery("select * from upcoming_tour_offers_master where status!='Disabled'");
        while( $row_offer = mysqli_fetch_assoc($sq_offer) ){

          $count++;
          ?>
          <tr>
            <td><?php echo $count; ?></td>
            <td><?php echo $row_offer['title']; ?></td>
            <td><?php echo $row_offer['description']; ?></td>
            <td><?php echo date("d/m/Y", strtotime($row_offer['valid_date'])); ?></td>
            <td><a class="btn btn-info btn-sm" href="#" onclick="upcoming_tours_update_modal(<?= $row_offer['offer_id'] ?>)" title="Update Details" id="update_btn-<?= $row_offer['offer_id'] ?>"><i class="fa fa-pencil-square-o"></i></a>
            <button class="btn btn-danger btn-sm" onclick="upcoming_tour_offer_disable(<?php echo $row_offer['offer_id'] ?>)" title="Disable" id="delete_btn-<?= $row_offer['offer_id'] ?>"><i class="fa fa-ban"></i></button></td>
          </tr>
          <?php
        }    
        ?>
      </tbody>
    </table>
</div> </div> </div>
<script type="text/javascript">
$('#upcoming_tours_id').dataTable({
  "pagingType": "full_numbers",
  order: [[0, 'desc']],
});
</script>