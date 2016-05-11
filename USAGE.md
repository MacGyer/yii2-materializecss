Usage Materialize for Yii2
==========================

Alert box message
-----------------

To generate a Alert box message, please add the following snippet source code into your project:


```php
use macgyer\yii2materializecss\widgets\Alert;

#TODO Added a Alert widget example.
```

More details information at Materialize Reference, please see the following URL: http://materializecss.com/

Dialog boxes and confirmation messages
--------------------------------------

To generate a Dialog box message and confirmation message, please add the following snippet source code into your project:


```php
use macgyer\yii2materializecss\widgets\Modal;

#TODO Added a alert message example.
#TODO Added a confirmation message example.
```

More details information at Materialize Reference, please see the following URL: http://materializecss.com/modals.html

Breadcrumbs
-----------

To generate the Breadcrumbs, please add the following snippet source code into your project:

```php
use Yii;
use macgyer\yii2materializecss\widgets\Breadcrumbs;

echo Breadcrumbs::widget([
    // the wrapper for the breadcrumbs list
    'tag' => 'div',
    // the HTML options for the wrapper tag
    // to render <div class="nav-wrapper">
    'options' => ['class' => 'nav-wrapper'],
    // the HTML options for the surrounding "nav" tag
    // to render <nav class="breadcrumbs"> 
    'containerOptions' => ['class' => 'breadcrumbs'],
    // the first hyperlink in the breadcrumbs (called home link).
    // The default value is [[\yii\web\Application::homeUrl]]
    'homeLink' => Yii::$app->homeUrl,
    // List of links to appear in the breadcrumbs
    'links' => [
        'label' => 'Demo',
        'url' => 'http://example.com/',
        'class' => 'external',
    ], 
    [
        'label' => 'Person',
        'url' => '/person/person/index',
        'class' => 'breadcrumb',
    ], 
    [
        'label' => 'Jane Doe',
        'url' => ['/person/person/view', 'id' => '1']],
        'class' => 'breadcrumb',
    ]
);
```

The above described source code render the HTML source code like this:

```html
<nav class="breadcrumbs">
    <div class="nav-wrapper">
        <a class="breadcrumb" href="/">Home</a>
        <a class="breadcrumb external" href="http://example.com/">Demo</a>
        <a class="breadcrumb" href="/person/person/index">Person</a>
        <a class="breadcrumb" href="/person/person/view?id=1">Jane Doe</a>
        <span class="breadcrumb active">Update</span>
    </div>
</nav>
```

More details information at Materialize Reference, please see the following URL: http://materializecss.com/breadcrumbs.html

Navbar Widget
-------------

NavBar renders a navbar HTML component. To generate the NavBar, please add the following snippet source code into your project:

```php
use macgyer\yii2materializecss\widgets\Nav;
use macgyer\yii2materializecss\widgets\NavBar;

NavBar::begin([
    'brandLabel' => '&nbsp;&nbsp;NavBar Test',
    'brandUrl' => Yii::$app->homeUrl,
    'brandOptions' => [
        'title' => 'This a NavBar Test',
    ],
    'options' => [
        'class' => 'navbar navbar-default navbar-fixed-top',
        'id' => 'my-background-brand-logo',
    ],
]);

echo Nav::widget([
    'items' => [
        [
            'label' => 'Home',
            'url' => ['/site/index']
        ],
        ['label' => 'About', 'url' => ['/site/about']],
    ],
    'options' => [
        'class' => 'navbar-nav right'
    ],
]);

NavBar::end();
```

The above described source code render the HTML source code like this:

```html
<nav id="my-background-brand-logo" class="navbar navbar-default navbar-fixed-top"
     role="navigation">
    <div class="nav-wrapper">
        <a class="brand-logo" href="/" title="This a NavBar Test">&nbsp;&nbsp;NavBar Test</a>
        <a class="button-collapse" href="#" 
           data-activates="sidenav_d272bad5e644c83c6862f0a7156765d7">
            <i class="material-icons">menu</i></a>
        <div id="w0-collapse">
            <ul id="w1" class="navbar-nav right">
                <li class="active"><a href="/site/index">Home</a></li>
                <li><a href="/site/about">About</a></li>
            </ul>
        </div>
    </div>
</nav>
```

More details information at Materialize Reference, please see the following URL: http://materializecss.com/navbar.html#right

Navbar Widget with dropdown elemets
-----------------------------------

To generate the NavBar with dropdown elemets, please add the following snippet source code into your project:

```php

use macgyer\yii2materializecss\widgets\NavBar;
use macgyer\yii2materializecss\widgets\Nav;

NavBar::begin([
    'brandLabel' => '&nbsp;&nbsp;NavBar Test',
    'brandUrl' => Yii::$app->homeUrl,
    'brandOptions' => [
        'title' => 'This a NavBar Test',
    ],
    'options' => [
        'class' => 'navbar navbar-default navbar-fixed-top',
        'id' => 'my-background-brand-logo',
    ],
]);

echo Nav::widget([
    'items' => [
        [
            'label' => 'Home',
            'url' => ['site/index'],
            'linkOptions' => ['class' =>'dropdown-button my-dropdown-button']
        ],
        [
            'label' => 'Dropdown',
            'items' => [
                 ['label' => 'Level 1 - Dropdown A', 'url' => '/module/controller/action'],
                 '<li class="divider"></li>',
                 '<li class="dropdown-header">Dropdown Header</li>',
                 ['label' => 'Level 1 - Dropdown B', 'url' => '#'],
            ],
        ],
    ],
    'options' => [
        // set this to nav-tab to get tab-styled navigation
        'class' =>'nav-pills right'
    ],
]);

NavBar::end();
```

The above described source code render the HTML source code like this:

```html
<nav id="my-background-brand-logo" class="navbar navbar-default navbar-fixed-top"
     role="navigation">
    <div class="nav-wrapper">
        <a class="brand-logo" href="/" title="This a NavBar Test">&nbsp;&nbsp;NavBar Test</a>
        <a class="button-collapse" href="#" data-activates="sidenav_c47b8cbc2c04b504f937ecd5872e1b4e">
            <i class="material-icons">menu</i>
        </a>
        <div id="w0-collapse">
            <ul id="w1" class="nav-pills right">
                <li class="active">
                    <a class="dropdown-button my-dropdown-button" href="/site/index">Home</a>
                </li>
                <li class="dropdown">
                    <a class="dropdown-button" href="#" data-activates="dropdown_f633099c7f4544ccf301ffed2e483d42">Dropdown <i class="material-icons right">arrow_drop_down</i>
                    </a>
                    <ul id="dropdown_f633099c7f4544ccf301ffed2e483d42" class="dropdown-content">
                        <li><a href="/module/controller/action" tabindex="-1">Level 1 - Dropdown A</a></li>
                        <li class="divider"></li>
                        <li class="dropdown-header">Dropdown Header</li>
                        <li><a href="#" tabindex="-1">Level 1 - Dropdown B</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
```

More details information at Materialize Reference, please see the following URL: http://materializecss.com/navbar.html#navbar-dropdown

Buttons
-------

To generate the Button, please add the following snippet source code into your project:

```php
use macgyer\yii2materializecss\widgets\Button;

echo Button::widget([
    'tagName' => 'button',
    'label' => 'Action',
    'icon' => [
        // name of the icon, required
        'name' => 'add',
        // position of the icon, optional, 'left' or 'right', defaults to 'left'
        'position' => 'left',
        // the HTML attributes for the img, optional
        'options' => ['class' => 'material-icons small '],
    ],
    'options' => ['class' => 'btn waves-effect waves-light '],
]);
```

The above described source code render the HTML source code like this:

```html
<button class="btn waves-effect waves-light"><i class="material-icons small left">add</i>Action</button>
```

More details information at Materialize Reference, please see the following URL: http://materializecss.com/buttons.html#raised

Fixed action buttons
--------------------

To generate a Fixed action button, please add the following snippet source code into your project:

```php
use macgyer\yii2materializecss\widgets\FixedActionButton;

echo FixedActionButton::widget([
    // the HTML attributes for the visible button.
    'buttonOptions' => [
        'title' => 'Clic here to see Options for Edit',
        'class' => 'btn btn-floating btn-large red ',
    ],
    // the tag used to render the button.
    'buttonTagName' => 'a',
    // the label on the button.
    'buttonLabel' => 'Edit',
    // the options for the optional icon.
    'buttonIcon' => [
        // name of the icon, required
        'name' => 'mode_edit',
        // position of the icon, optional, 'left' or 'right', defaults to 'left'
        'position' => 'left',
        // the HTML attributes for the img, optional
        'options' => ['class' => 'material-icons large '],
    ],
    // list of button items in the fixed action button.
    'items' => [
        [
            'label' => \yii\helpers\Html::tag('i', 'insert_chart', ['class' => 'material-icons',]),
            'url' => '#',
            'visible' => true,
            'linkOptions' => [
                'title' => 'Chart View',
                'class' =>'btn-floating red'
            ],
            // 'options' => ['class' => 'my-li-item-fixed-action-btn'],
        ],
        [
            'label' => \yii\helpers\Html::tag('i', 'format_quote', ['class' => 'material-icons',]),
            'url' => '#',
            'visible' => true,
            'linkOptions' => [
                'title' => 'Original View',
                'class' =>'btn-floating yellow darken-1'
            ],
            // 'options' => ['class' => 'my-li-item-fixed-action-btn'],
        ],
        [
            'label' => \yii\helpers\Html::tag('i', 'publish', ['class' => 'material-icons',]),
            'url' => '#',
            'visible' => true,
            'linkOptions' => [
                'title' => 'Publish this article',
                'class' =>'btn-floating green'
            ],
            // 'options' => ['class' => 'my-li-item-fixed-action-btn'],
        ],
        [
            'label' => \yii\helpers\Html::tag('i', 'attach_file', ['class' => 'material-icons',]),
            'url' => '#',
            'visible' => true,
            'linkOptions' => [
                'title' => 'Attach file',
                'class' =>'btn-floating blue'
            ],
            // 'options' => ['class' => 'my-li-item-fixed-action-btn'],
        ],
    ],
    // whether the labels for header items should be HTML-encoded.
    'encodeLabels' => false,
    // the HTML attributes for the widget container tag.
    'options' => ['class' => 'fixed-action-btn '],
    // the HTML attributes for the container around the button items.
    // 'itemsContainerOptions' => ['class' => 'my-ul-item-fixed-action-btn'],
    // whether the button items are only visible after click
    'clickToToggle' => true,
    // whether to display a horizontal FAB.
    'horizontal' => true,
]);
```

The above described source code render the HTML source code like this:

```html
<div class="fixed-action-btn click-to-toggle horizontal" style="bottom: 45px; right: 24px;">
    <a class="btn btn-floating btn-large red ">
        <i class="material-icons large left">mode_edit</i>
    </a>
    <ul>
        <li><a class="btn-floating red"><i class="material-icons">insert_chart</i></a></li>
        <li><a class="btn-floating yellow darken-1"><i class="material-icons">format_quote</i></a></li>
        <li><a class="btn-floating green"><i class="material-icons">publish</i></a></li>
        <li><a class="btn-floating blue"><i class="material-icons">attach_file</i></a></li>
    </ul>
</div>
```

More details information at Materialize Reference, please see the following URL: http://materializecss.com/buttons.html#floating

Icons
-----

To generate a Icon, please add the following snippet source code into your project:

```php
use macgyer\yii2materializecss\widgets\Icon;

echo Icon::widget([
    // name of the icon, required
    'name' => 'add',
    // position of the icon, optional, 'left' or 'right', defaults to 'left'
    'position' => 'left',
    // the HTML attributes for the img, optional
    'options' => ['class' => 'material-icons small '],
]) . "&nbsp;Add a article.";
```

The above described source code render the HTML source code like this:

```html
<i class="material-icons small left">add</i>&nbsp;Add a article.
```

More details information at Materialize Reference, please see the following URL: http://materializecss.com/icons.html

Chip renders with a image
-------------------------

To generate a Chip with image, please add the following snippet source code into your project:

```php
use macgyer\yii2materializecss\widgets\Chip;

echo Chip::widget([
    // the HTML attributes for the widget container tag.
    'options' => ['class' => 'chip'],
    // the content of the chip besides the optional image and/or icon.
    'content' => 'Jane Doe',
    // the HTML attributes for the img tag.
    'imageOptions' => [
        'src' => '@web/images/yuna.jpg',
        'alt' => 'Contact Person'
    ],
]);
```

The above described source code render the HTML source code like this:

```html
<div class="chip"><img src="/images/yuna.jpg" alt="Contact Person">Jane Doe</div>
```

More details information at Materialize Reference, please see the following URL: http://materializecss.com/chips.html

Chip renders with a icon
------------------------

To generate a Chip with icon, please add the following snippet source code into your project:

```php
use macgyer\yii2materializecss\widgets\Chip;

echo Chip::widget([
    // the HTML attributes for the widget container tag.
    'options' => ['class' => 'chip'],
    // the content of the chip besides the optional image and/or icon.
    'content' => 'Jane Doe',
    // the options for the optional icon.
    'icon' => [
        // name of the icon, required
        'name' => 'close',
        // position of the icon, optional, 'left' or 'right', defaults to 'left'
        'position' => 'left',
        // the HTML attributes for the img, optional
        'options' => ['class' => 'material-icons small '],

    ],
    // whether to render the icon inside the chip
    'renderIcon' => true
]);
```

The above described source code render the HTML source code like this:

```html
<div class="chip">Jane Doe<i class="material-icons small left">close</i></div>
```

More details information at Materialize Reference, please see the following URL: http://materializecss.com/chips.html#tag

Indeterminate Lineal Preloader
------------------------------

To generate a Indeterminate Lineal Preloader (formally called "Indeterminate Lineal Spinner"), please add the following snippet source code into your project:

```php
use macgyer\yii2materializecss\widgets\Progress;

echo Progress::widget([
    // the HTML attributes for the widget container tag.
    'options' => ['class' => 'progress my-progress'],
    //  HTML attributes for the progress tag.
    'progressOptions' => [],
]);
```

The above described source code render the HTML source code like this:

```html
<div class="progress my-progress">
    <div class="indeterminate"></div>
</div>
```

More details information at Materialize Reference, please see the following URL: http://materializecss.com/preloader.html#linear

Determinate Lineal Preloader
----------------------------

To generate a Determinate Lineal Preloader (formally called "Determinate Lineal Spinner"), please add the following snippet source code into your project:

```php
use macgyer\yii2materializecss\widgets\Progress;

echo Progress::widget([
    // the HTML attributes for the widget container tag.
    'options' => ['class' => 'progress'],
    //  HTML attributes for the progress tag.
    'progressOptions' => [
        'type' => 'determinate',
        'width' => 55,
    ],
]);
```

More details information at Materialize Reference, please see the following URL: http://materializecss.com/preloader.html#linear

Circular Preloader renders with materialize
------------------------------------------

To generate a Circular Preloader (formally called "Circular Spinner"), please add the following snippet source code into your project:

```php
use macgyer\yii2materializecss\widgets\Spinner;

echo Spinner::widget([
    // the HTML attributes for the widget container tag.
    'options' => ['class' => 'preloader-wrapper big active'],
    // the HTML attributes for the spinner.
    'spinnerOptions' => ['class' => 'spinner-layer spinner-red-only'],
    // whether to show alternating colors in spinner.
    'flashColors' => false,
]);
```

The above described source code render the HTML source code like this:

```html
<div class="spinner-layer spinner-red-only">
    <div class="circle-clipper left">
        <div class="circle"></div>
    </div>
    <div class="gap-patch">
        <div class="circle"></div>
    </div>
    <div class="circle-clipper right">
        <div class="circle"></div>
    </div>
</div>
```

More details information at Materialize Reference, please see the following URL: http://materializecss.com/preloader.html#circular

Circular Preloader with Flashing Colors
-------------------------------------

To generate a Circular Preloader with Flashing Colors (formally called "Circular Spinner"), please add the following snippet source code into your project:

```php
use macgyer\yii2materializecss\widgets\Spinner;

echo Spinner::widget([
    // the HTML attributes for the widget container tag.
    'options' => ['class' => 'preloader-wrapper big active'],
    // the HTML attributes for the spinner.
    'spinnerOptions' => ['class' => 'spinner-layer'],
    // whether to show alternating colors in spinner.
    'flashColors' => true,
]);
```

The above described source code render the HTML source code like this:

```html
<div class="preloader-wrapper big active preloader-wrapper active">
    <div class="spinner-layer spinner-blue">
        <div class="circle-clipper left">
            <div class="circle"></div>
        </div>
        <div class="gap-patch">
            <div class="circle"></div>
        </div>
        <div class="circle-clipper right">
            <div class="circle"></div>
        </div>
    </div>
    <div class="spinner-layer spinner-red">
        <div class="circle-clipper left">
                <div class="circle"></div>
        </div>
        <div class="gap-patch">
            <div class="circle"></div>
        </div>
        <div class="circle-clipper right">
            <div class="circle"></div>
        </div>
    </div>
    <div class="spinner-layer spinner-yellow">
        <div class="circle-clipper left">
            <div class="circle"></div>
        </div>
        <div class="gap-patch">
            <div class="circle"></div>
        </div>
        <div class="circle-clipper right">
            <div class="circle"></div>
        </div>
    </div>
    <div class="spinner-layer spinner-green">
        <div class="circle-clipper left">
            <div class="circle"></div>
        </div>
        <div class="gap-patch">
            <div class="circle"></div>
        </div>
        <div class="circle-clipper right">
            <div class="circle"></div>
        </div>
    </div>
</div>
```

More details information at Materialize Reference, please see the following URL: http://materializecss.com/preloader.html#circular-color
