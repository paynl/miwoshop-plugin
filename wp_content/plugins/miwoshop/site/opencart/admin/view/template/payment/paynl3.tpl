<?php echo $header; ?>
<div id="content">
    <div class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
        <?php } ?>
    </div>
    <?php if ($error_warning) { ?>
    <div class="warning"><?php echo $error_warning; ?></div>
    <?php } ?>
    <div class="box"> 
        <div class="left"></div> 
        <div class="right"></div> 

        <div class="heading">
            <h1><img src="view/image/payment.png" alt="" /> <?php echo $heading_title; ?></h1>
            <div class="buttons"><a onclick="$('#form').submit();" class="button"><span><?php echo $button_save; ?></span></a><a onclick="location = '<?php echo $cancel; ?>';" class="button"><span><?php echo $button_cancel; ?></span></a></div>
        </div>

        <div class="content">
            <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
                <table class="form">
                    <tr>
                        <td>Actief</td>
                        <td colspan="2"><select name="<?php echo $payment_method_name; ?>_status">
                                <?php if ($status) { ?>
                                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                                <option value="0"><?php echo $text_disabled; ?></option>
                                <?php } else { ?>
                                <option value="1"><?php echo $text_enabled; ?></option>
                                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                                <?php } ?>
                            </select></td>
                    </tr>
                    <tr>
                        <td width="25%"><span class="required">*</span> Label<br /></td>
                        <td colspan="2">
                            <input type="text" name="<?php echo $payment_method_name; ?>_label" value="<?php echo $label; ?>" />
                        </td>
                    </tr>
                    <tr>
                        <td width="25%"><span class="required">*</span> Apitoken<br /></td>
                        <td colspan="2">
                            <input type="text" name="<?php echo $payment_method_name; ?>_apitoken" value="<?php echo $apitoken; ?>" />
                            <span class="error"><?php echo $error_apitoken;?></span>
                        </td>
                    </tr>
                    <tr>
                        <td width="25%"><span class="required">*</span> ServiceId<br /></td>
                        <td colspan="2"><input type="text" name="<?php echo $payment_method_name; ?>_serviceid" value="<?php echo $serviceid; ?>" />
                        <span class="error"><?php echo $error_serviceid;?></span>
                        </td>
                    </tr>
					<tr>
                        <td>Bevestiginsmail versturen</td>
                        <td colspan="2">
                            <select name="<?php echo $payment_method_name; ?>_send_confirm_email">             
                                <?php 
                                $selectedStart = '';
                                $selectedComplete = '';
                                if($send_confirm_email == 'start'){
                                    $selectedStart = 'selected="selected"';
                                } else {
                                    $selectedComplete = 'selected="selected"';
                                }
                                ?>
                                <option <?php echo $selectedStart; ?> value="start">Bij starten betaling</option>
                                <option <?php echo $selectedComplete; ?> value="complete">Na afronden betaling</option>                          
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Statusupdates sturen</td>
                        <td colspan="2">
                            <select name="<?php echo $payment_method_name; ?>_send_status_updates">
                                <?php if ($send_status_updates == 1) { ?>
                                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                                <option value="0"><?php echo $text_disabled; ?></option>
                                <?php } else { ?>
                                <option value="1"><?php echo $text_enabled; ?></option>
                                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                                <?php } ?>
                            </select>
                            <span>Alleen van toepassing als bevestigingsmail wordt verstuurd bij starten betaling</span>
                        </td>
                    </tr>
                    <tr>
                        <td>Order status pending</td>
                        <td colspan="2"><select name="<?php echo $payment_method_name; ?>_pending_status">
                                <?php foreach ($order_statuses as $order_status) { ?>
                                <?php if ($order_status['order_status_id'] == $pending_status) { ?>
                                <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                                <?php } else { ?>
                                <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                                <?php } ?>
                                <?php } ?>
                            </select></td>
                    </tr>      
                    <tr>
                        <td>Order status complete</td>
                        <td colspan="2"><select name="<?php echo $payment_method_name; ?>_completed_status">
                                <?php foreach ($order_statuses as $order_status) { ?>
                                <?php if ($order_status['order_status_id'] == $completed_status) { ?>
                                <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                                <?php } else { ?>
                                <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                                <?php } ?>
                                <?php } ?>
                            </select></td>
                    </tr>      
                    <tr>
                        <td>Order status canceled</td>
                        <td colspan="2"><select name="<?php echo $payment_method_name; ?>_canceled_status">
                                <?php foreach ($order_statuses as $order_status) { ?>
                                <?php if ($order_status['order_status_id'] == $canceled_status) { ?>
                                <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                                <?php } else { ?>
                                <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                                <?php } ?>
                                <?php } ?>
                            </select></td>
                    </tr>      
                    <tr>
                        <td>Minimum bedrag</td>
                        <td colspan="2"><input type="text" name="<?php echo $payment_method_name; ?>_total" value="<?php echo $total; ?>" /></td>
                    </tr>
                    <tr>
                        <td>Maximum bedrag</td>
                        <td colspan="2"><input type="text" name="<?php echo $payment_method_name; ?>_totalmax" value="<?php echo $totalmax; ?>" /></td>
                    </tr>


                    <tr>
                        <td>Sortering</td>
                        <td colspan="2"><input type="text" name="<?php echo $payment_method_name; ?>_sortorder" value="<?php echo $sortorder; ?>" size="1" /></td>
                    </tr>
          
                   
                </table>
            </form>
        </div>
       
    </div>
</div>
<?php echo $footer; ?>
