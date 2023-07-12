<select name="" id="">
    <?php foreach($counter as $c){?>
        <option value="<?=$c->whs_code?>"><?=$c->counter_name?></option>
    <?php }?>
</select>