<?php  defined('C5_EXECUTE') or die("Access Denied."); ?>
<?php 
    $form = Core::make('helper/form');

    $fld_id = isset($field['id']) ? $field['id']:'';
    $fld_value = isset($field['value']) ? (boolean)$field['value']:FALSE;
    $fld_container_class = isset($field['container_class']) ? $field['container_class']:'';

    $fld_attr = array();
    if(isset($field['style'])) $fld_attr['style'] = $field['style'];
    if(isset($field['class'])) $fld_attr['class'] = $field['class'];
?>
<div class="row">
    <label class="col-xs-4 control-label">
        <?php echo (isset($field['title'])) ? $field['title'] : '' ?>
        <?php echo (isset($field['description'])) ? '<p class="text-muted">'.$field['description'].'</p>' : '' ?>
    </label>
    <div class="col-xs-8 <?php echo $fld_container_class ?>">
        <?php
        echo $form->checkbox($field['id'], 1, $fld_value, $fld_attr);
        ?>
    </div>
</div>
