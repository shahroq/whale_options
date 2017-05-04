<?php  defined('C5_EXECUTE') or die("Access Denied."); ?>
<?php 
    $ch = Core::make('helper/form/color');
    
    $fld_id = isset($field['id']) ? $field['id']:'';
    $fld_value = isset($field['value']) ? trim($field['value'], ''):'';
    $fld_container_class = isset($field['container_class']) ? $field['container_class']:'';
?>
<div class="row">
    <label class="col-xs-4 control-label">
        <?php echo (isset($field['title'])) ? $field['title'] : '' ?>
        <?php echo (isset($field['description'])) ? '<p class="text-muted">'.$field['description'].'</p>' : '' ?>
    </label>
    <div class="col-xs-8 <?php echo $fld_container_class ?>">
        <?php
        echo $ch->output($field['id'], $fld_value, array('preferredFormat'=>'hex'))
        ?>
    </div>
</div>
