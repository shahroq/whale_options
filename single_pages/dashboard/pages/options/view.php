<?php
/**
 * @author      shahroq <shahroq \at\ yahoo.com>
 * @copyright   Copyright (c) 2018 shahroq
 * http://concrete5.killerwhalesoft.com/addons/
 */
defined('C5_EXECUTE') or die('Access denied.');

$task = 'update';
$buttonText = t('Update Options');
//print_r($options);
?>

<?php if ($options['tabs']) { ?>

    <!--begin:form:-->
    <form method="post" action="<?php  echo $this->action($task)?>" id="form" class="">
	<div class="ccm-pane-body" id="whale-form">

    <!-- Begin: Tabs -->
    <?php
        print Core::make('helper/concrete/ui')->tabs($tabs);
    ?>
    <!-- End: Tabs -->

    <?php foreach ((array)$options['tabs'] as $tab) { ?>
    <!-- Begin: Tab -->    
    <DIV class="ccm-tab-content" id="ccm-tab-content-<?php echo $tab['id'] ?>" >
        
        <?php foreach ((array)$tab['panels'] as $panel) { //print_r($panel)?>
        <!-- Begin: Panel -->    
        <div class="well <?php echo $panel['id'] ?>">
            <h2>
                <?php echo $panel['title'] ?>&nbsp;
                <?php echo isset($panel['subtitle']) ? '<small>'.$panel['subtitle'] . '</small>':'' ?>
                
                <a href="#<?php echo 'form_'.$panel['id'] ?>" class="show-hide pull-right" title="<?php echo t('Click to Show/Hide')?>"><i class="fa <?php echo ($panel['closed']) ? 'fa-chevron-down': 'fa-chevron-up'; ?>"></i></a>
            </h2>   
            <div id="<?php echo 'form_'.$panel['id'] ?>" style="display:<?php echo ($panel['closed']) ? 'none': ''; ?>;">
                <hr>
                <?php 
                foreach ((array)$panel['fields'] as $field) { 
                    $fld_type = isset($field['type']) ? $field['type']:'';
                    $f = $fieldTypeViews . $fld_type;
                    View::element($f, array('field'=>$field), 'whale_options');
                }    
                ?>
            </div>         
        </div>
        <!-- End: Panel -->    
        <?php } ?>

    </DIV>
    <!-- End: Tab -->    
    <?php } ?>

    <!-- Begin: Buttons -->
    <div class="ccm-dashboard-form-actions-wrapper">
    <div class="ccm-dashboard-form-actions">
        <button type="submit" class="btn btn-primary pull-right"><?php echo $buttonText ?></button>
    </div>
    </div>
    <!-- END: Buttons -->

    </div>
	</form>

<?php }else{ ?>
    <!-- Begin: Welcome -->
    <?php 
    View::element($welcomeView, array(), 'whale_options');
    ?>
    <!-- End: Welcome -->
<?php } ?>
