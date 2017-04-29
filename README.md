[Concrete 5](https://www.concrete5.org) Theme Options
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

Define Options:
---------------
There is an "option.php" inside package root that as default is loaded. It is recommended not change this file, instead you can copy this file into your active theme root and change options.

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

Changelog
---------
= 1.0.1 =
* First Release


