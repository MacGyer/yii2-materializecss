# Materialize for Yii2

This package integrates the Materialize CSS framework into [Yii2](http://www.yiiframework.com/).
[Materialize](http://materializecss.com/) is a modern responsive front-end framework based on Material Design.

## Installation

The preferred way of installation is through Composer.
If you don't have Composer you can get it here: https://getcomposer.org/

To install the package add the following to the ```required``` section of your composer.json:
```
"require": {
    "macgyer/yii2-materializecss": "*"
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

* Alert
* Breadcrumbs
* Button
* Chip
* Dropdown
* Icon
* Nav
* NavBar
* ActiveForm
* ActiveField
* SwitchButton
* GridView with ActionColumn
* DetailView
* Fixed Action Button
* DatePicker
* Modal
* Spinner
* Progress

These widgets are planned for development:

* Collection
* Toast
* Collapsible

## Gii Support

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

Currently there is an issue with jQuery version 2.2.x and the datepicker pickadate.js.
Please check out the issues at https://github.com/Dogfalo/materialize/issues/2808#issuecomment-191642171.

To circumvent problems with the datepicker, use jQuery version 2.1.4 until further notice.
You can implement this in your asset bundle config:

```php
// @app/config/main.php

'components' => [
    // more components
    'assetManager' => [
        'bundles' => [
            'yii\web\JqueryAsset' => [
                'sourcePath' => null,
                'js' => [
                    '//ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js',
                ]
            ],
        ],
    ],
    // more components
],
```