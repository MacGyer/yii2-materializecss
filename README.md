# Icon Helper for Yii2

This package provides classes to easily render icons for your Yii2 application.

Currently the following icon libraries are supported

* Fontawesome (http://fontawesome.io) Version ```4.5```

## Installation

The preferred way of installation is through Composer.
If you don't have Composer you can get it here: https://getcomposer.org/

To install the package add the following to the ```required``` section of your composer.json:
```
"require": {
    "medienpol/yii2-icon": "~1.0"
},
```

And make Composer aware of the corresponding Github repository in the ```repositories``` section of your composer.json:
```
"repositories" : [
    {
        "type": "vcs",
        "url": "https://github.com/medienpol/yii2-icon.git"
    }
],
```

## Usage

Include the Icon asset when you need it. To enable the Icon assets in your whole application register it in your layout file.
```
// @app/views/layouts/main.php
medienpol\yii2icon\IconAsset::register($this)
```

To render a Fontawesome icon in your application call FontawesomeIconHelper::render()
```
medienpol\yii2icon\FontAwesomeIconHelper::render(medienpol\yii2icon\FontAwesomeIconHelper::FA_HEART)
```

## Miss an icon

The constant definitions will be updated in the future. If you are missing an icon or want to make us aware of a change
the provided icon library, simply raise an [issue](https://github.com/medienpol/yii2-icon/issues).
