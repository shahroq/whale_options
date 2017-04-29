<?php  defined('C5_EXECUTE') or die("Access Denied."); ?>
<?php 
    $form = Core::make('helper/form');

    $fld_id = isset($field['id']) ? $field['id']:'';
    $fld_value = isset($field['value']) ? $field['value']:'';
    $fld_options = isset($field['options']) ? $field['options']:array();
    $fld_container_class = isset($field['container_class']) ? $field['container_class']:'';

    $fld_attr = array();
    if(isset($field['placeholder'])) $fld_attr['placeholder'] = $field['placeholder'];
    if(isset($field['style'])) $fld_attr['style'] = $field['style'];
    if(isset($field['class'])) $fld_attr['class'] = $field['class'];
    if(isset($field['maxlength'])) $fld_attr['maxlength'] = $field['maxlength'];
?>
<div class="row">
    <label class="col-xs-4 control-label">
        <?php echo (isset($field['title'])) ? $field['title'] : '' ?>
        <?php echo (isset($field['description'])) ? '<p class="text-muted">'.$field['description'].'</p>' : '' ?>
    </label>
    <div class="col-xs-8 <?php echo $fld_container_class ?>">
        <?php 
        foreach ($fld_options as $key => $value) {
            $tmp = ($key==$fld_value) ? $fld_value : "";
            echo '<div class="radio"><label>';
            echo $form->radio($field['id'], $key, $tmp, $fld_attr);
            echo $value;
            echo '</label></div>';
        }
        
        ?>
    </div>
</div>
