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
$urlAceptarCookie = Url::to(['/site/aceptar-cookies']);




$js = <<<EOT
    $('#search').keyup(function(ev){
        let search = $.trim($(this).val());
        $.ajax({
            type: 'GET',
            url: '$urlSearch',
            data: {
                search: search,
            }
        }).done(function(data){
            
            $('#lista').empty().hide();
            if(data.productos && search != '') {
                for (producto of data.productos){
                    console.log(producto)
                    let a =  $('<a>').attr('href', '/ficha/' + producto.id);
                    let li = a.append($('<li>').text(producto.titulo));
                    $('#lista').append(li)
                }
                $('#lista').show();
            }
        });
    });
    
EOT;

$this->registerJs($js);
$cookies =  <<<EOT
$('.modal').modal({
    backdrop: 'static'
})
    $('.modal').modal().show();
EOT;

if (!isset($_COOKIE['aceptar_cookies'])) {
    $this->registerJs($cookies);
}


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

        echo '<div id="formSearch" class="justify-content-md-center flex-grow-1 ">
   
    <form id="contenedor-search" class="justify-content-center col-12 row p-md-0">
                <input id="search" class="form-control col-md-6" type="text" placeholder=" Buscar Título">
                <ul id="lista" class="col-md-6"></ul>
                </form>
             
        </div>  
        ';

        $items = [];

        if (!Yii::$app->user->isGuest) {
            $items += [
                [
                    'label' => 'Gestión',
                    'items' => [
                        ['label' => 'Productos', 'url' => ['/productos/index']],
                        ['label' => 'Usuarios', 'url' => ['/usuarios/index']],
                        ['label' => 'Listas', 'url' => ['/listas/index']],
                    ],
                    'visible' => Yii::$app->user->identity->soyAdmin,
                ],
                [
                    'label' => Yii::$app->user->identity->login,
                    'items' => [
                        ['label' => 'Perfil', 'url' => ['/valoraciones/usuarios', 'id' => Yii::$app->user->id]],
                        ['label' => 'Mis listas', 'url' => ['/usuarios-listas/mis-listas']],
                        ['label' => 'Amigos', 'url' => ['/seguidores/mis-amigos']],
                        ['label' => 'Cerrar sesión', 'url' => ['/site/logout'], 'linkOptions' => ['data-method' => 'POST']],
                    ],
                ],
            ];
        } else {
            $items += [['label' => 'Login', 'url' => ['/site/login']]];
        }

        echo Nav::widget([
            'options' => ['class' => 'navbar-nav'],
            'items' => $items
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
    <?= Html::button('', ['class' => 'fas fa-chevron-up', 'id' => 'al-cielo']) ?>
    <footer class="footer">
        <div class="container">
            <p class="text-center float-md-left">&copy; YiiAffinity <?= date('Y') ?></p>

            <p class="text-center float-md-right"><?= Yii::powered() ?></p>
        </div>
    </footer>
    <div class="modal" tabindex="-1" role="dialog">
        <div class=" modal-dialog" role="document">
            <div class="modal-content p-2">
                <div class="modal-header">
                    <h5 class="modal-title">Política de cookies</h5>
                </div>
                <div class="modal-body">
                    <p>Usamos cookies para mejorar la experiencia de usuario. Acepta si estas de acuerdo.</p>
                </div>
                <div class="modal-footer">
                    <a href="<?= $urlAceptarCookie ?>" class="btn btn-azul">Aceptar</a>
                    <button onclick="ventana()" class="btn btn-azul bg-secondary">Rechazar</button>
                </div>
            </div>
        </div>
    </div>

    <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>
