<?php 

include "../../../model/model.php";

 

$transport_agency_id = $_POST['transport_agency_id'];

$sq_transport_agency = mysqli_fetch_assoc(mysqlQuery("select * from transport_agency_master where transport_agency_id='$transport_agency_id'"));
$mobile_no = $encrypt_decrypt->fnDecrypt($sq_transport_agency['mobile_no'], $secret_key);
$email_id = $encrypt_decrypt->fnDecrypt($sq_transport_agency['email_id'], $secret_key);

 

?>

<div class="modal fade profile_box_modal" id="transport_view_modal" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" data-keyboard="false">

  	<div class="modal-dialog modal-lg" role="document">

    	<div class="modal-content">

      		<div class="modal-body profile_box_padding">

      	

	      		<div>

				  <!-- Nav tabs -->

				  	<ul class="nav nav-tabs" role="tablist">

				    	<li role="presentation" class="active"><a href="#basic_information" aria-controls="home" role="tab" data-toggle="tab" class="tab_name">Transporter Information</a></li>

				    	<li class="pull-right"><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></li>

				  	</ul>



		            <div class="panel panel-default panel-body fieldset profile_background">

						<!-- Tab panes1 -->

						<div class="tab-content">

						    <!-- *****TAb1 start -->

						    <div role="tabpanel" class="tab-pane active" id="basic_information">

						     	<div class="row">

									<div class="col-md-12">

										<div class="profile_box main_block">

							        	<?php $sq_city = mysqli_fetch_assoc(mysqlQuery("select city_name from city_master where city_id='$sq_transport_agency[city_id]'")); ?>

							        		<div class="row">

           										<div class="col-md-6 right_border_none_sm" style="border-right: 1px solid #ddd">
           											<span class="main_block"> 

							        					<i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>

							        				    <?php echo "<label>City Name <em>:</em></label> " .$sq_city['city_name']; ?>

							        				</span>
							        				<span class="main_block"> 

							        					<i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>

							        				    <?php echo "<label>Transporter Name <em>:</em></label> " .$sq_transport_agency['transport_agency_name']; ?>

							        				</span>

							        				<span class="main_block">

							        					<i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>

							        				    <?php echo "<label>Mobile No <em>:</em></label> " .$mobile_no; ?> 

							        				</span>
							        				<span class="main_block">

							        					<i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>

							        				    <?php echo "<label>Landline No <em>:</em></label> " .$sq_transport_agency['landline_no']; ?> 

							        				</span>
							        				<span class="main_block">

							        					<i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>

							        				    <?php echo "<label>Email ID <em>:</em></label> " .$email_id ; ?>

							        				</span>

							        				<span class="main_block">

							        					<i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>

							        				    <?php echo "<label>Contact Person  <em>:</em></label> " .$sq_transport_agency['contact_person_name']; ?>

							        				</span>

							        				<span class="main_block"> 

							        					<i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>

							        				    <?php echo "<label>Emergency Contact <em>:</em></label> " .$sq_transport_agency['immergency_contact_no']; ?>

							        				</span>
							        				<?php $sq_state = mysqli_fetch_assoc(mysqlQuery("select * from state_master where id='$sq_transport_agency[state_id]'"));
                   									 ?> 
							        				 <span class="main_block">

										                  <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>

										                  <?php echo "<label>State/Country <em>:</em></label>".$sq_state['state_name'] ?>

										            </span>
							        				<!-- <span class="main_block">

							        					<i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>

							        				    <?php echo "<label>Country <em>:</em></label> " .$sq_transport_agency['country']; ?>

							        				</span> -->

							        				<span class="main_block">

							        					<i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>

							        				    <?php echo "<label>Website <em>:</em></label> " .$sq_transport_agency['website']; ?>

							        				</span>
							        				<span class="main_block">
														<i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
														<?php echo "<label>Address <em>:</em></label> " .$sq_transport_agency['transport_agency_address']; ?> 
													</span>

							        			</div>


							        			<div class="col-md-6">

							        				<span class="main_block">

							        					<i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>

							        				    <?php echo "<label>Bank Name <em>:</em></label> " .$sq_transport_agency['bank_name']; ?>

							        				</span>
							        				<span class="main_block"> 

							        					<i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>

							        				    <?php echo "<label>Account Type <em>:</em></label> " .$sq_transport_agency['account_name']; ?>

							        				</span>
							        				<span class="main_block"> 

							        					<i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>

							        				    <?php echo "<label>Account No <em>:</em></label> " .$sq_transport_agency['account_no']; ?>

							        				</span>

							        				<span class="main_block">

							        					<i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>

							        				    <?php echo "<label>Branch <em>:</em></label> " .$sq_transport_agency['branch']; ?> 

							        				</span>

							        				<span class="main_block">

							        					<i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>

							        				    <?php echo "<label>IFSC/SWIFT CODE <em>:</em></label> " .strtoupper($sq_transport_agency['ifsc_code']); ?>

							        				</span>
							        				<span class="main_block">

							        					<i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>

							        				    <?php echo "<label>Personal Identification No(PIN) <em>:</em></label> " .$sq_transport_agency['pan_no']; ?>

							        				</span>
							        				 
							        				<span class="main_block">

							        					<i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>

							        				    <?php echo "<label>Tax No <em>:</em></label> " .strtoupper($sq_transport_agency['service_tax_no']); ?>

							        				</span>
													<span class="main_block">

														<i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>

														<?php echo "<label> Opening Balance <em>:</em></label> " .$sq_transport_agency['opening_balance']; ?>

													</span>
													<span class="main_block">

														<i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>

														<?php echo "<label> Balance Side <em>:</em></label> " .$sq_transport_agency['side']; ?>

													</span>
										            <span class="main_block">

							        				<i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i> 

							        				    <?php echo "<label>Status <em>:</em></label> " .$sq_transport_agency['active_flag']; ?>

							        				</span>	

								    			</div>

								    		</div>
											<div class="row">
												<div class="col-md-12">										
													
												</div>
											</div>
								    	</div>

								    </div>



								</div>  

						    </div>

						    <!-- ********Tab1 End******** --> 

						</div>

					</div>

		        </div>

    		</div>

    	</div>

	</div>

</div>



<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>

<script>

$('#transport_view_modal').modal('show');

</script>  

 

