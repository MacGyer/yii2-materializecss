[![license](https://img.shields.io/badge/LICENCE-BSD--3--Clause-blue.svg)](https://packagist.org/packages/macgyer/yii2-materializecss)
[![Github Release](https://img.shields.io/github/release/macgyer/yii2-materializecss.svg)](https://packagist.org/packages/macgyer/yii2-materializecss)
[![Packagist](https://img.shields.io/packagist/dt/macgyer/yii2-materializecss.svg)](https://packagist.org/packages/macgyer/yii2-materializecss)

# Materialize for Yii2

----

This is the current, actively developed 3.x branch which is implementing Materialize version 1.0 and thus breaking backwards compatibility.

[Go to 1.x version](https://github.com/MacGyer/yii2-materializecss/tree/1.x)

[Go to 2.x version](https://github.com/MacGyer/yii2-materializecss/tree/2.x)

----

This package integrates the Materialize CSS framework into [Yii2](http://www.yiiframework.com/).
[Materialize](http://materializecss.com/) is a modern responsive front-end framework based on Material Design.

See [official documentation](http://macgyer.github.io/yii2-materializecss/) for detailed information.

Have a look at the [official demo page](https://yii2-materializecss.pluspunkt-coding.de) to see the repo in action (needs adaption to v3)

Current Materialize version implemented: 1.0.0.

## Installation

The preferred way of installation is through Composer.
If you don't have Composer you can get it here: https://getcomposer.org/

You also should install the Composer Asset Plugin to handle NPM and Bower assets:
```
$ composer global require "fxp/composer-asset-plugin:~1.4"
```

Or you can make use of Asset Packagist: <https://asset-packagist.org/>

To install the package add the following to the ```require``` section of your composer.json:
```
"require": {
    "macgyer/yii2-materializecss": "~3.0.0"
},
```

## Usage

To load the Materialize CSS files integrate the MaterializeAsset into your app.
Two ways to achieve this is to register the asset in the main layout:

```php
// @app/views/layouts/main.php

\macgyer\yii2materializecss\assets\MaterializeAsset::register($this);
// further code
```

or as a dependency in your app wide AppAsset.php

```php
// @app/assets/AppAsset.php

public $depends = [
    'macgyer\yii2materializecss\assets\MaterializeAsset',
    // more dependencies
];
```

## Widgets

The following widgets are currently available:

* ActiveField
* ActiveForm
* Alert
* Breadcrumbs
* Button
* Carousel
* ChipInput
* Collapsible
* DatePicker
* DetailView
* Dropdown
* FloatingActionButton
* GridView with ActionColumn
* Icon
* LinkPager
* MaterialBox
* Modal
* Nav
* NavBar
* Parallax
* Progress
* RangeInput
* Select
* SideNav
* Slider
* Spinner
* StaticChip
* SubmitButton
* SwitchButton
* TimePicker

## Gii support

If you are creating your CRUD controller and view files using Gii you can get materialized view files by integrating the adapted Gii templates.

```php
// @app/config/main-local.php

$config['modules']['gii'] = [
    'class' => 'yii\gii\Module',      
    'allowedIPs' => ['127.0.0.1', '::1', '192.168.0.*', '192.168.178.20'],  
    'generators' => [
        'crud' => [
            'class' => 'yii\gii\generators\crud\Generator',
            'templates' => [ // setting materializecss templates
                'materializecss' => '@vendor/macgyer/yii2-materializecss/src/gii-templates/generators/crud/materializecss', 
            ]
        ]
    ],
];
```

You can copy those templates to any location you wish for further customization. Make sure you adapt the path accordingly in your config.

## Known issues

Systems operating on normal parameters :)


## Sample layout

There is a sample layout file included in the package. You can use this file to get inspiration for
your own layout or replace the respective ```views/layouts/main.php``` with the file provided.

You can find the sample layout file in ```src/layout/main.php```.

## Change log

### 3.0.0 - 2018-11-16
* implement Materialize v1.0.0
* **Breaking changes included**

### 2.0.0 - 2017-07-30
* **Please note: this release contains breaking changes**
* moved [Breadcrumbs](https://github.com/MacGyer/yii2-materializecss/blob/master/src/widgets/navigation/Breadcrumbs.php), [Dropdown](https://github.com/MacGyer/yii2-materializecss/blob/master/src/widgets/navigation/Dropdown.php), [FixedActionButton](https://github.com/MacGyer/yii2-materializecss/blob/master/src/widgets/navigation/FixedActionButton.php), [Nav](https://github.com/MacGyer/yii2-materializecss/blob/master/src/widgets/navigation/Nav.php), [NavBar](https://github.com/MacGyer/yii2-materializecss/blob/master/src/widgets/navigation/NavBar.php) and [SideNav](https://github.com/MacGyer/yii2-materializecss/blob/master/src/widgets/navigation/SideNav.php) to dedicated namespace (**breaking**)
* dropped chingyawhao/materialize-clockpicker in favor of Materialize native time picker implementation (**breaking**)
* added [Collapsible](https://github.com/MacGyer/yii2-materializecss/blob/master/src/widgets/Collapsible.php)
* updated Materialize to v0.100.1

### 1.5.0 - 2017-07-03
* added [Carousel](https://github.com/MacGyer/yii2-materializecss/blob/master/src/widgets/media/Carousel.php)
* added [MaterialBox](https://github.com/MacGyer/yii2-materializecss/blob/master/src/widgets/media/MaterialBox.php)
* added [Parallax](https://github.com/MacGyer/yii2-materializecss/blob/master/src/widgets/media/Parallax.php)
* added [Slider](https://github.com/MacGyer/yii2-materializecss/blob/master/src/widgets/media/Slider.php)
* improved sample layout

### 1.4.0 - 2017-06-05
* added [RangeInput](https://github.com/MacGyer/yii2-materializecss/blob/master/src/widgets/form/RangeInput.php)
* updated Materialize to v0.98.2
* added some missing PHPDoc annotations

### 1.3.0 - 2017-03-02
* added [LinkPager](https://github.com/MacGyer/yii2-materializecss/blob/master/src/widgets/grid/LinkPager.php)
* [GridView](https://github.com/MacGyer/yii2-materializecss/blob/master/src/widgets/grid/GridView.php): set [LinkPager](https://github.com/MacGyer/yii2-materializecss/blob/master/src/widgets/grid/LinkPager.php) as default pager class

### 1.2.1 - 2017-02-05
* [Select](https://github.com/MacGyer/yii2-materializecss/blob/master/src/widgets/form/Select.php): added multiple property
* Composer dependency for Yii restricted to ~2.0.0
* Composer dependency for PHP set to >= 5.6.0

### 1.2.0 - 2017-02-01
* updated Materialize to v0.98.0
* added [Select](https://github.com/MacGyer/yii2-materializecss/blob/master/src/widgets/form/Select.php)
* [ActiveField](https://github.com/MacGyer/yii2-materializecss/blob/master/src/widgets/form/ActiveField.php): added dropDownList()
* [ActiveField](https://github.com/MacGyer/yii2-materializecss/blob/master/src/widgets/form/ActiveField.php): changed characterCounter() to work with Materialize v0.98.0
* [Modal](https://github.com/MacGyer/yii2-materializecss/blob/master/src/widgets/Modal.php): fixed modal plugin call
* [FixedActionButton](https://github.com/MacGyer/yii2-materializecss/blob/master/src/widgets/FixedActionButton.php): added toolbar support

### 1.1.0 - 2017-01-05
* added [SideNav](https://github.com/MacGyer/yii2-materializecss/blob/master/src/widgets/Button.php)
* [Nav](https://github.com/MacGyer/yii2-materializecss/blob/master/src/widgets/Nav.php): added [SideNav](https://github.com/MacGyer/yii2-materializecss/blob/master/src/widgets/Button.php) support
* [NavBar](https://github.com/MacGyer/yii2-materializecss/blob/master/src/widgets/NavBar.php): moved mobile toggle button to [Nav](https://github.com/MacGyer/yii2-materializecss/blob/master/src/widgets/Nav.php)
* [ActiveField](https://github.com/MacGyer/yii2-materializecss/blob/master/src/widgets/form/ActiveField.php): added Materialize autocomplete support
* [ActiveField](https://github.com/MacGyer/yii2-materializecss/blob/master/src/widgets/form/ActiveField.php): added Materialize character count support
* [ActiveField](https://github.com/MacGyer/yii2-materializecss/blob/master/src/widgets/form/ActiveField.php): checkbox and radio are not enclosed by label as default
 
### 1.0.9 - 2016-09-01
* added [TimePicker](https://github.com/MacGyer/yii2-materializecss/blob/master/src/widgets/form/TimePicker.php)

### 1.0.8 - 2016-08-08
* [Button](https://github.com/MacGyer/yii2-materializecss/blob/master/src/widgets/Button.php): fixed tag rendering
* [SwitchButton](https://github.com/MacGyer/yii2-materializecss/blob/master/src/widgets/form/SwitchButton.php): fixed uncheck property
* [Alert](https://github.com/MacGyer/yii2-materializecss/blob/master/src/widgets/Alert.php): added ```default``` context class
* [Button](https://github.com/MacGyer/yii2-materializecss/blob/master/src/widgets/Button.php): added property ```type```
* [Button](https://github.com/MacGyer/yii2-materializecss/blob/master/src/widgets/Button.php): added property ```large```
* [Button](https://github.com/MacGyer/yii2-materializecss/blob/master/src/widgets/Button.php): added property ```disabled```
* [Spinner](https://github.com/MacGyer/yii2-materializecss/blob/master/src/widgets/Spinner.php): added property ```size```
* [Spinner](https://github.com/MacGyer/yii2-materializecss/blob/master/src/widgets/Spinner.php): added property ```color```
* [SwitchButton](https://github.com/MacGyer/yii2-materializecss/blob/master/src/widgets/form/SwitchButton.php): added support for Icon/HTML labels
* added [SubmitButton](https://github.com/MacGyer/yii2-materializecss/blob/master/src/widgets/form/SubmitButton.php)

### 1.0.7 - 2016-07-27
* full source documentation
* fixed Materialize version to 0.97.6 to monitor 0.97.7 release before integration

### 1.0.6 - 2016-05-16
* added sample layout
* fixed line separators
* removed Datepicker issue from section "Known issues"

### 1.0.5 - 2016-04-24
* updated README with fixed Datepicker issue
* refactored [Breadcrumbs](https://github.com/MacGyer/yii2-materializecss/blob/master/src/widgets/Breadcrumbs.php)

### 1.0.3 - 2016-03-10
* fixed multiple usage of [MaterializeWidgetTrait](https://github.com/MacGyer/yii2-materializecss/blob/master/src/lib/MaterializeWidgetTrait.php) producing bugs
* updated PHPDoc in [NavBar](https://github.com/MacGyer/yii2-materializecss/blob/master/src/widgets/NavBar.php)

### 1.0.2 - 2016-03-09
* added [Spinner](https://github.com/MacGyer/yii2-materializecss/blob/master/src/widgets/Spinner.php)
* added [Progress](https://github.com/MacGyer/yii2-materializecss/blob/master/src/widgets/Progress.php)

### 1.0.1 - 2016-03-09
* updated README
* added Packagist support

### 1.0.0 - 2016-03-09
* Initial release
