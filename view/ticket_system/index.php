<?php
include "../../model/model.php";
/*======******Header******=======*/
require_once('../layouts/admin_header.php');
require_once('../../classes/tour_booked_seats.php');

$role = $_SESSION['role'];
$role_id = $_SESSION['role_id'];
$login_id = $_SESSION['login_id'];
$reminder_status = (isset($_SESSION['reminder_status'])) ? "true" : "false";
$getClient =  mysqli_fetch_array(mysqlQuery("select client_id from app_settings"))['client_id'];
$modules = json_decode(file_get_contents("modules.json"),true);

if(empty($modules))
{
    $modules = [];
}
?>
<!-- tickets -->

<style>
    .center-body {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 100%;
        height: 100vh;
        /****** center box
	width: 300px;
	height: 300px;
	border: solid 1px #aaa;
	******/
    }

    .loader-circle-2 {
        position: relative;
        width: 70px;
        height: 70px;
        display: inline-block;
    }

    .loader-circle-2:before,
    .loader-circle-2:after {
        content: "";
        display: block;
        position: absolute;
        border-width: 5px;
        border-style: solid;
        border-radius: 50%;
    }

    .loader-circle-2:before {
        width: 70px;
        height: 70px;
        border-bottom-color: #009688;
        border-right-color: #009688;
        border-top-color: transparent;
        border-left-color: transparent;
        animation: loader-circle-2-animation-2 1s linear infinite;
    }

    .loader-circle-2:after {
        width: 40px;
        height: 40px;
        border-bottom-color: #e91e63;
        border-right-color: #e91e63;
        border-top-color: transparent;
        border-left-color: transparent;
        top: 22%;
        left: 22%;
        animation: loader-circle-2-animation 0.85s linear infinite;
    }

    @keyframes loader-circle-2-animation {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(-360deg);
        }
    }

    @keyframes loader-circle-2-animation-2 {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }
</style>
<div class="dashboard_table dashboard_table_panel main_block mg_bt_25" style="padding: 40px;">

    <div class="row text-left">

        <div class="col-md-12">
            <div class="dashboard_table_heading main_block">

                <div class="col-md-6 no-pad">

                    <h3>Tickets</h3>


                </div>
                <div class="col-md-6 ">
                    <!-- Button trigger modal -->
                    <div class="text-right">

                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addmodal">
                            Add New +
                        </button>
                    </div>

                    <!-- Modal -->

                    <div class="modal fade bd-example-modal-lg" data-backdrop="static" id="addmodal" tabindex="-1" role="dialog" aria-labelledby="addmodal" aria-hidden="true">
                        <div class="modal-dialog modal-lg" style="width: 1200px;" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Add New Ticket</h5>
                                    <button type="button" class="close" id="closeThisAdd" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form id="addticketform">
                                    <div class="modal-body">
                                        <!-- new -->
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="row">
                                                    <input type="hidden" name="client" id="client" value="<?php echo $getClient; ?>">
                                                    <div class="col-md-6 mg_tp_10">
                                                        <label for="" class="form-label">Main Module</label>

                                                        <select name="main_module" id="main_module" data-toggle="tooltip" title="Select Type" class="form-control">
                                                            <option value="CRM">CRM</option>
                                                            <option value="B2B">B2B</option>
                                                            <option value="Website">Website</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6 mg_tp_10">
                                                        <label for="" class="form-label">Module</label>
                                                        <input type="text" name="" id="module" title="Module" class=" form-control" list="module_list" placeholder="*Module" onchange="getSubmodules()"><datalist id="module_list">
                                                                <?php
                                                            foreach($modules as $module)
                                                            {
                                                                ?>
                                                                    <option value="<?= $module['name'] ?>" data-moduleid="<?= $module['id'] ?>">
                                                            <?php }
                                                        ?>  
                                                        </datalist>
                                                    </div>
                                                    <div class="col-md-6 mg_tp_10">
                                                        <label for="" class="form-label">Sub Module</label>
                                                        <input type="text" name="" id="submodule" title="Sub Module" class=" form-control" placeholder="*Sub Module" list="sub_module_list">
                                                        <datalist id="sub_module_list">
                                                                    <option value="Sub Module">
                                                        </datalist>
                                                    </div>
                                                    <div class="col-md-6 mg_tp_10">
                                                        <label for="" class="form-label">Issue Type</label>

                                                        <select name="type" id="type" data-toggle="tooltip" title="Select Issue Type" class="form-control">
                                                            <option value="Issue">Issue</option>
                                                            <option value="Suggestion">Suggestion</option>
                                                            <option value="Customization">Customization</option>

                                                        </select>
                                                    </div>
                                                    <div class="col-md-12 mg_tp_10">
                                                        <label for="" class="form-label">Description</label>
                                                        <textarea name="" class=" form-control" id="description" cols="30" rows="10" placeholder="*Description"></textarea>
                                                    </div>

                                                    <div class="col-md-6 mg_tp_10">
                                                        <label for="" class="form-label">Snapshot Link</label>
                                                        <input type="text" name="" id="sslink" title="Snapshot Link" class=" form-control" placeholder="Snapshot Link">
                                                    </div>
                                                    <div class="col-md-6 mg_tp_10">
                                                        <label for="" class="form-label">Video Link</label>
                                                        <input type="text" name="" id="videolink" title="Video Link" class=" form-control" placeholder="Video Link">
                                                    </div>


                                                </div>
                                            </div>
                                        </div>








                                        <!-- row script -->

                                    </div>
                                    <div class="modal-footer">
                                        <div class="row">
                                            <!-- <div class="col-md-6 text-left">
                                                <label for="" class="form-label">Raise Another Ticket</label>
                                                <input type="checkbox" name="" id="" title="Add More Ticket" class="form-check" placeholder="*Add More Ticket">
                                            </div> -->
                                            <div class="col-md-12">
                                                <button name="add_ticket" type="button" onclick="addTicket()" id="ticketsubmit" class="btn btn-primary">Add Ticket</button>

                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>



            </div>

            <div class="get_tickets_report" id="get_tickets_report">

                <?php
                // $dataAll = file_get_contents('https://support.itourscloud.com/model/get-ticket-api.php?cid=' . $getClient);
                // echo $dataAll;
                ?>
            </div>

        </div>



    </div>

</div>
<!-- tickets end -->
<?php
/*======******Footer******=======*/
require_once('../layouts/admin_footer.php');
?>



<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script> -->
<script>
    function addTicket() {
        $("#ticketsubmit").html('Loading...');
        $("#ticketsubmit").prop('disabled', true);

        var client = $('#client').val();
        var main_module = $('#main_module').val();
        var module = $('#module').val();
        var submodule = $('#submodule').val();
        var description = $('#description').val();
        var type = $('#type').val();
        var sslink = $('#sslink').val();
        var videolink = $('#videolink').val();


        if (main_module == "") {
            error_msg_alert("Main Module Is Required");
            $("#ticketsubmit").html('Add Ticket');
            $("#ticketsubmit").prop('disabled', false);
            return false;
        }
        if (module == "") {
            error_msg_alert("Module Is Required");
            $("#ticketsubmit").html('Add Ticket');
            $("#ticketsubmit").prop('disabled', false);
            return false;

        }
        if (submodule == "") {
            error_msg_alert("Sub Module Is Required");
            $("#ticketsubmit").html('Add Ticket');
            $("#ticketsubmit").prop('disabled', false);
            return false;

        }
        if (description == "") {
            error_msg_alert("Description Is Required");
            $("#ticketsubmit").html('Add Ticket');
            $("#ticketsubmit").prop('disabled', false);
            return false;

        }
        if (type == "") {
            error_msg_alert("Type Is Required");
            $("#ticketsubmit").html('Add Ticket');
            $("#ticketsubmit").prop('disabled', false);
            return false;

        }

        $.ajax({
            type: 'POST',
            url: 'https://support.itourscloud.com/model/add-ticket-api.php',
            data: {
                client: client,
                main_module: main_module,
                module: module,
                submodule: submodule,
                description: description,
                type: type,
                sslink: sslink,
                videolink: videolink
                // other data
            },
            success: function() {
                success_msg_alert('added successfully');
                document.getElementById('addticketform').reset();
                $("#ticketsubmit").html('Add Ticket');
                $("#ticketsubmit").prop('disabled', false);
                // $('#closeThisAdd').click();
                clearForm();
                getData();
                // setTimeout(() => {
                //     location.reload();

                // }, 2000);

            },
            error: function(jqXHR, textStatus, errorThrown) {
                if (jqXHR.status == 500) {
                    $("#ticketsubmit").html('Add Ticket');
                    $("#ticketsubmit").prop('disabled', false);
                    error_msg_alert('Internal error: ' + jqXHR.responseText);
                } else {
                    $("#ticketsubmit").html('Add Ticket');
                    $("#ticketsubmit").prop('disabled', false);
                    error_msg_alert('Unexpected error.' + jqXHR.responseText);
                }
            }
        });

    }

    // $(document).ready(function() {
    getData();

    // });

    function clearForm() {
        $('#module').val('');
        $('#submodule').val('');
        $('#description').val('');
        $('#sslink').val('');
        $('#videolink').val('');
    }

    function getData() {
        $("#get_tickets_report").html(`<div class="center-body"><div class="loader-circle-2"></div></div>`);
        var clientId = $('#client').val();
        $.get('get_data.php', {
            clientId: clientId
        }, function(data) {
           
            $('#get_tickets_report').html(data);
        });
    }
    getSubmodules();
    function getSubmodules() {
        // var test = $('#module');
        var module_name = $('#module').val();
        $.post('get_submodules.php',{module_name:module_name},function(data)
        {   
            $('#sub_module_list').html(data);
        });
    }
</script>