<div id="paynl_payment"></div>
<div class="buttons">

    <div class="right">
        <?php
        if(!empty($optionSubList)){
        ?>
        <select id="optionsub">
            <option value=''>Kies uw bank</option>
            <?php 
            foreach($optionSubList as $optionSub){
                echo "<option value='".$optionSub['id']."'>".$optionSub['name']."</option>";
            }
            ?>
        </select>
        <?php } ?>

        <input onclick="startTransaction();" type="button" value="<?php echo $button_confirm; ?>" id="button-confirm" class="button" /></div>
</div>
<script type="text/javascript">
    function startTransaction() {
        var data = {};
        if (jQuery('#optionsub') != undefined) {
            data.optionSubId = jQuery('#optionsub').val();
        }
        jQuery.ajax({
        url: 'index.php?route=payment/<?php echo $paymentMethodName;?>/startTransaction',
                dataType: 'json',
                data: data,
                type: 'POST',
                beforeSend: function() {
                    $('#button-confirm').attr('disabled', true);
                            <?php if (substr(VERSION, 0, 3) == '1.4') { ?>
                            $('#paynl_payment').before('<div class="wait"><img src="catalog/view/theme/default/image/loading_1.gif" alt="" />Betaling wordt gestart</div>');
                            <?php } else { ?>
                            $('#paynl_payment').before('<div class="attention"><img src="catalog/view/theme/default/image/loading.gif" alt="" />Betaling wordt gestart</div>');
                            <?php } ?>
                },
                success: function(json) {
                    if (json['error']) {
                    <?php if (substr(VERSION, 0, 3) == '1.4') { ?>
                            $('.wait').remove();
                            <?php } else { ?>
                            $('.attention').remove();
                            <?php } ?>
                            alert(json['error']);
                    $('#button-confirm').attr('disabled', false);
                    }
                    if (json['success']) {
                        location = json['success'];
                        }
                    }
        });
    }
</script>