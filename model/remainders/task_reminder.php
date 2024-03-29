<?php
include_once('../model.php'); 
$cur_time = date('Y-m-d H:i');
$cur_time1 = date('Y-m-d H:i');
$last_time = strtotime($cur_time);
$sq_task = mysqlQuery("select * from tasks_master where remind_due_date >= '$cur_time' and task_status!='Disabled'");
while($row_tasks = mysqli_fetch_assoc($sq_task)){

    $task = $row_tasks['task_name'];
    $due_date = date('d-m-Y H:i', strtotime($row_tasks['due_date']));
    $remind_due_date = date('Y-m-d H:i', strtotime($row_tasks['remind_due_date']));
    $remind_by = $row_tasks['remind_by'];
    $task_type = $row_tasks['task_type'];

    $sq_emp_info = mysqli_fetch_assoc(mysqlQuery("select * from emp_master where emp_id='$row_tasks[emp_id]'"));
    $emp_name = $sq_emp_info['first_name'].' '.$sq_emp_info['last_name'];
    $email_id = $sq_emp_info['email_id'];
    $mobile_no = $sq_emp_info['mobile_no'];
    
    if($row_tasks['remind'] != 'None'){
        if($cur_time1 == $remind_due_date) task_mail($emp_name,$email_id,$task,$due_date,$mobile_no,$remind_by,$task_type);
    }
}

function task_mail($emp_name,$email_id,$task,$due_date,$mobile_no,$remind_by,$task_type)
{
    $email_content = '
    <tr>
        <table width="85%" cellspacing="0" cellpadding="5" style="color: #888888;border: 1px solid #888888;margin: 0px auto;margin-top:20px; min-width: 100%;" role="presentation">
        <tr><td style="text-align:left;border: 1px solid #888888;">Task Name</td>   <td style="text-align:left;border: 1px solid #888888;">'.$task.'</td></tr>
        <tr><td style="text-align:left;border: 1px solid #888888;"> Due Date</td>   <td style="text-align:left;border: 1px solid #888888;" >'.date('d-m-Y H:i', strtotime($due_date)).'</td></tr>
        <tr><td style="text-align:left;border: 1px solid #888888;"> Task Type </td>   <td style="text-align:left;border: 1px solid #888888;" >'.$task_type.'</td></tr>
        </table>
    </tr>';

    $sms_content = "Hello ".$emp_name.". Your task reminder."." 
Tasks : ".$task." , Due Datetime:".date('d-m-Y H:i', strtotime($due_date));

    $subject = 'Task Reminder';
    global $model;

    if($remind_by=="Email And SMS"){
        $model->app_email_send('71',$emp_name,$email_id, $email_content,$subject,'1');
        $model->send_message($mobile_no, $sms_content);

    }
    else if($remind_by=="Email"){
        $model->app_email_send('71',$emp_name,$email_id, $email_content,$subject,'1');
    }
    else if($remind_by=="SMS"){
        $model->send_message($mobile_no, $sms_content);
    }
}