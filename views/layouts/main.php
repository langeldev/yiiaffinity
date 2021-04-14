<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap4\Nav;
use yii\bootstrap4\NavBar;
use yii\bootstrap4\Breadcrumbs;
use app\assets\AppAsset;
use yii\helpers\Url;

AppAsset::register($this);

$urlSearch = Url::to(['productos/search']);

$js = <<<EOT
    $('#search').keyup(function(ev){
        let search = $(this).val();
        $.ajax({
            type: 'GET',
            url: '$urlSearch',
            data: {
                search: search,
            }
        }).done(function(data){
            
            $('#lista').empty()
            if(data.productos && search != '') {
                for (producto of data.productos){
                    console.log(producto)
                    let a =  $('<a>').attr('href', 'index.php?r=productos/ficha&id=' + producto.id);
                    let li = a.append($('<li>').text(producto.titulo));
                    $('#lista').append(li);
                }
            }
        });
    });
EOT;

$this->registerJs($js);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap mt-5">
    <?php
    NavBar::begin([
        'brandLabel' => Html::img('@web/img/logo.png', ['class' => 'd-inline-block aling-top logo', 'alt' => 'YIIAFFINITY']),
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-light bg-warning navbar-expand-md fixed-top',
        ],
   
        'collapseOptions' => [
            'class' => 'justify-content-end',
        ],
    ]);
 
    echo '<div id="formSearch" class="justify-content-md-center">
            <form class="form-inline my-2 my-lg-0">
                <input id="search" class="form-control mr-sm-2" type="search" placeholder="Título">
                </form>
                <ul id="lista"><ul>
                </div>';

    echo Nav::widget([
        'options' => ['class' => 'navbar-nav'],
        'items' => [
            ['label' => 'Productos', 'url' => ['/productos/index']],
            ['label' => 'Usuarios', 'url' => ['/usuarios/index']],
            Yii::$app->user->isGuest ? '' 
            :['label' => 'Editar Perfil', 'options' => ['class' => 'd-md-none'],'url' => ['/usuarios/editar-perfil']],
            Yii::$app->user->isGuest ? (
                ['label' => 'Login', 'url' => ['/site/login']]
            ) : (
                '<li class="nav-item">'
                . Html::beginForm(['/site/logout'], 'post')
                . Html::submitButton(
                    'Logout (' . Yii::$app->user->identity->login . ')',
                    ['class' => 'btn btn-warning nav-link logout']
                )
                . Html::endForm()
                . '</li>'
            ) 
        ],
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
                <?= $content ?>   
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="float-left">&copy; YiiAffinity <?= date('Y') ?></p>

        <p class="float-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
