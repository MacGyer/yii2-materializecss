# Materialize for Yii2

This package integrates the Materialize CSS framework into [Yii2](http://www.yiiframework.com/).
[Materialize](http://materializecss.com/) is a modern responsive front-end framework based on Material Design.

## Installation

The preferred way of installation is through Composer.
If you don't have Composer you can get it here: https://getcomposer.org/

To install the package add the following to the ```required``` section of your composer.json:
```
"require": {
    "macgyer/yii2-materializecss": "@dev"
},
```

And make Composer aware of the corresponding Github repository in the ```repositories``` section of your composer.json:
```
"repositories" : [
    {
        "type": "vcs",
        "url": "https://github.com/macgyer/yii2-materializecss.git"
    }
]
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

These widgets are planned for development:

* GridView with ActionColumn and DataColumn
* Collection
* Pagination
* Modal
* Toast
* Collapsible
