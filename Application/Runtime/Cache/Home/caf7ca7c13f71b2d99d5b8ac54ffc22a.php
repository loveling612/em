<?php if (!defined('THINK_PATH')) exit();?>    <select class="selectpicker form-inline" name="<?=$selectName?>"  id="<?=$selectName?>" class="form-control" data-live-search="true">

        <option value="0">--请选择--</option>
        <?php foreach($list as $value){?>
            <option value="<?=$value['id']?>" <?php if($value['id']==$selected){echo 'selected="true"';}?>><?=$value['name']?></option>
        <?php }?>
    </select>