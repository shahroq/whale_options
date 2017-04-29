<?php  defined('C5_EXECUTE') or die("Access Denied."); ?>
<div class="row">
    <h4 class="col-xs-12">
        <?php echo (isset($field['title'])) ? $field['title'] : '' ?>
	    <?php echo (isset($field['description'])) ? '<p class="text-muted">'.$field['description'].'</p>' : '' ?>
    </h4>
</div>
