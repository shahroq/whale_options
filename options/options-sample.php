<?php
/**
 * @author 		shahroq <shahroq \at\ yahoo.com>
 * @copyright  	Copyright (c) 2018 shahroq
 * http://concrete5.killerwhalesoft.com/addons/
 * To start using this add-on you should have an "options.php" file inside one of these folders:
 * 1- /application/config/options/options.php
 * 2- <active theme>/options/options.php
 * 3- /packages/whale_options/options/options.php
 * There is a sample "options-sample.php" file inside the package /options/ folder. Copy and rename this file to on of those locations and start tweaking it. 
 * It contains a 3-dimensional array each of which presents Tabs > Panels > Fields consecutively. The sample file holds every possible field & attribute, so compare this file with result at your concrete5 "theme options" page in the dashboard should give an overall understanding of what every option stands for.
 */
defined('C5_EXECUTE') or die('Access denied.');

	$options = array(
		'tabs' => array(
			//Tab A
			array(
				'id'  => 'taba',
				'title'  => t('Tab A'),
				'selected'  => TRUE,
				'panels' => array(
					//Tab A > Panel 1
					array(
						'id'  => 'panel-a1',
						'title'  => t('Panel A1'),
						'subtitle'  => t(''),
						'fields' => array(
							array(
								'id'   => 'text_1',
								'type' => 'text',
								'title' => t('Text 1'),
								'description' => t('Textfield Description'),
								'placeholder' => t('Textfield Placeholder'),
								'style' => '',
								'class' => '',
								'container_class' => '', //'col-md-3',
								'required' => TRUE,
								'value' => '',
								//'method' => 'my_method', //add a method with this name to package controller 
							),
							array(
								'id'   => 'textarea_1',
								'type' => 'textarea',
								'title' => t('Textarea 1'),
								'description' => t('Textarea Description'),
								'placeholder' => t('Textarea Placeholder'),
								'style' => 'min-height:100px;',
								'class' => '',
								'container_class' => '',
								'required' => FALSE,
								'value' => '',
							),
							array(
								'id'   => 'checkbox_1',
								'type' => 'checkbox',
								'title' => t('Checkbox 1'),
								'description' => t('Checkbox Description'),
								'value' => FALSE,
							),
							array(
								'id'   => 'radio_1',
								'type' => 'radio',
								'title' => t('Radio 1'),
								'description' => t('Radio Description'),
								'value' => '2',
								'options' => array('1' => t('Option 1'), '2' => t('Option 2'))
							),
							array(
								'id'   => 'select_1',
								'type' => 'select',
								'title' => t('Select 1'),
								'description' => t('Select Description'),
								'value' => '0',
								'options' => array('0' => t('[ Select ]'), '1' => t('Option 1'), '2' => t('Option 2'))
							),
							array(
								'type' => 'divider',
							),
							array(
								'id'   => 'color_1',
								'type' => 'color',
								'title' => t('Color 1'),
								'description' => t('Color Description'),
								'value' => 'cccccc',
							),
							array(
								'id'   => 'image_1',
								'type' => 'image',
								'title' => t('Image 1'),
								'description' => t('Image Description'),
								'value' => 0,
							),
							array(
								'id'   => 'page_1',
								'type' => 'page',
								'title' => t('Page 1'),
								'description' => t('Page Description'),
								'value' => 0,
							),
							array(
								'id'   => 'date_1',
								'type' => 'date',
								'title' => t('Date 1'),
								'description' => t('Date Description'),
								'value' => 0,
							),
						),
					),
					//Tab A: Panel 2
					array(
						'id'  => 'panel-a2',
						'title'  => t('Panel A2'),
						'closed'  => TRUE,
						'fields' => array(
							array(
								'id'   => 'text_2',
								'type' => 'text',
								'title' => t('Text 2'),
								'description' => t('Text Description'),
								'placeholder' => t('Text Placeholder'),
								'style' => '',
								'class' => '',
								'container_class' => '',
								'required' => FALSE,
								'value' => '',
							),
						),
					),
				),		
			),
			//Tab B
			array(
				'id'  => 'tabb',
				'title'  => t('Tab B'),
				'panels' => array(
					//Tab B > Panel 1
					array(
						'id'  => 'panel-b1',
						'title'  => t('Panel B1'),
						'closed'  => FALSE,
						'fields' => array(
							array(
								'id'   => 'text_3',
								'type' => 'text',
								'title' => t('Text 3'),
								'description' => t('Text Description'),
								'placeholder' => t('Text Placeholder'),
								'style' => '',
								'class' => '',
								'container_class' => '',
								'required' => FALSE,
								'value' => '',
							),
						),
					),
				),		

			),
		),	
	);
