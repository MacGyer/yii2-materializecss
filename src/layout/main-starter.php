<?php
/* @var $this \yii\web\View */
/* @var $content string */

use macgyer\yii2materializecss\lib\Html;
use macgyer\yii2materializecss\widgets\navigation\Nav;
use macgyer\yii2materializecss\widgets\navigation\NavBar;
use macgyer\yii2materializecss\widgets\navigation\Breadcrumbs;
use macgyer\yii2materializecss\widgets\Alert;
use app\asset\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">

    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <!--Let browser know website is optimized for mobile-->
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>

    <body>
        <?php $this->beginBody() ?>

        <?php
        $nav = NavBar::begin([
                    'brandLabel' => 'HUMANON',
                    'brandUrl' => Yii::$app->homeUrl,
                    'options' => ['class' => '',],
                    'fixed' => true,
                    'wrapperOptions' => [
                        'class' => 'container'
                    ],
        ]);

        $menuItems = [
            ['label' => 'Home', 'url' => ['/site/index'], 'linkOptions' => ['class' => '']],
            ['label' => 'About', 'url' => ['/site/about']],
            ['label' => 'Contact', 'url' => ['/site/contact']],
        ];
        if (Yii::$app->user->isGuest) {
            //$menuItems[] = ['label' => 'Signup', 'url' => ['/site/signup']];
            $menuItems[] = ['label' => 'Login', 'url' => ['/site/login']];
        } else {
            $menuItems[] = '<li>'
                    . Html::beginForm(['/site/logout'], 'post')
                    . Html::submitButton(
                            'Logout (' . Yii::$app->user->identity->username . ')', ['class' => 'btn btn-flat']
                    )
                    . Html::endForm()
                    . '</li>';
        }

        echo Nav::widget([
            'options' => ['class' => 'right hide-on-med-and-down '],
            'items' => $menuItems,
        ]);

        $nav->sidenavItems = $menuItems;

        NavBar::end();
        ?>

        <div class="row"></div>

        <div class="container">

            
                <?=
                Breadcrumbs::widget([
                    'options' => ['class' => 'row'],
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                ])
                ?>
            

            <?= Alert::widget() ?>

            <?= $content ?>
        </div>


        <footer class="page-footer ">
            <div class="container">
                <div class="row">
                    <div class="col l6 s12">
                        <h5 class="white-text">Footer Content</h5>
                        <p class="grey-text text-lighten-4">You can use rows and columns here to organize your footer content.</p>
                    </div>
                    <div class="col l4 offset-l2 s12">
                        <h5 class="white-text">Links</h5>
                        <ul>
                            <li><a class="grey-text text-lighten-3" href="#!">Link 1</a></li>
                            <li><a class="grey-text text-lighten-3" href="#!">Link 2</a></li>
                            <li><a class="grey-text text-lighten-3" href="#!">Link 3</a></li>
                            <li><a class="grey-text text-lighten-3" href="#!">Link 4</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="footer-copyright">
                <div class="container">
                    &copy; My Company <?= date('Y') ?>
                    <?= Yii::powered() ?>
                </div>
            </div>
        </footer>

        <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>
