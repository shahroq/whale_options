[concrete5](https://www.concrete5.org) Theme Options
=====================================================

Description
-----------
The Theme Options makes it easy to include a dashboard options page in your Concrete5 theme. It was built so developers can concentrate on making the actual theme rather than spending time creating an options panel from scratch.


Supported field types:
----------------------
* text: Textbox
* textarea: Textarea
* checkbox: Checkbox
* radio: Radio Button
* select: Select Box
* color: Color Picker
* image: Image Selector
* page: Page Selector
* divider: divide entries with hr
* header: header

Define Options:
---------------
options.php file can be place in any of these paths:
1. /application/config/options/options.php
2. <active theme>/options/options.php
3. /packages/whale_options/options/options.php

Read Options:
-------------
Every option saved as a separate entry on c5 Config table. You can read each entry via [core config api](http://documentation.concrete5.org/developers/packages/storing-configuration-values). 

$logo = \Core::make('config/database')->get('options.logo');

for more details check this [integration tutorial](https://www.concrete5.org/marketplace/addons/theme-options/integration-with-your-theme). 

Option File arguments:
----------------------
* id: element unique id
* type: field type 
* title: dashboard title
* description: dashboard description
* placeholder: entry placeholder (types: text & textarea)
* style: entry inline style
* class: entry class
* container_class: entry container class (e.g: col-xs-4)
* value: initial value
* options: array of key/values (types: select, radio) 
* method: name of method in package controller which run on save (it receives the field value)

Changelog
---------
* 1.1.0 : 2018-12-30
	- Minor changes
* 1.0.0 
	Initial Release	


