<?php  defined('C5_EXECUTE') or die("Access Denied."); ?>
<div class="alert alert-danger" role="alert">
	<?php 
	echo t('Error on '); 
	echo (isset($field['title'])) ? '"'.$field['title'].'"' : '';
	echo ' ' . t('entry'); 
	echo (isset($field['error'])) ? ': '.$field['error'] : ''
	?>
</div>