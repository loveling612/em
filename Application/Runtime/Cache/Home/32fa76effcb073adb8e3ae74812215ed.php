<?php if (!defined('THINK_PATH')) exit();?><div >
    <select class="selectpicker form-inline" <?php if($disabled){ echo 'disabled="disabled"';}?>name="message_category" id="message_category" class="form-control" data-live-search="true">>
        <option value="0">--请选择--</option>
        <?php foreach($list as $key=>$value){?>
            <option value="<?=$key?>" <?php if($key==$selected){echo 'selected="true"';}?>><?=$value?></option>
        <?php }?>
    </select>

</div>