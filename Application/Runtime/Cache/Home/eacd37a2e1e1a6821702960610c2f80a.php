<?php if (!defined('THINK_PATH')) exit();?><label>所属公司</label>
<div >

    <select disabled=<?=$disabled?> name="chooseBusiness" id="chooseBusiness" class="form-control">
        <option value="0">--请选择--</option>
        <?php foreach($list as $value){?>
            <option value="<?=$value['id']?>" <?php if($value['id']==$selected){echo 'selected="true"';}?>><?=$value['name']?></option>
        <?php }?>
    </select>

</div>