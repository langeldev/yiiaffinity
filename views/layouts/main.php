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
        $('#lista').empty().hide();
        $.ajax({
            type: 'GET',
            url: '$urlSearch',
            data: {
                search: search,
            }
        }).done(function(data){
            
            if(data.productos && search != '') {
                for ([index, producto] of data.productos.entries()){
                if (index < 5){
                        let a =  $('<a>').attr('href', '/ficha/' + producto.id);
                        let li = a.append($('<li>').text(producto.titulo));
                        $('#lista').append(li);
                    }else {
                        a = $('<a>').attr('href', '$urlSearch?search=' + search).addClass('ver-mas');
                        li = a.append($('<li>').text('Ver más'));
                        $('#lista').append(li);
                        break;
                    }
                }
            }
                $('#lista').show();
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

        echo '
        <div class="p-0 col-12 col-md-3 col-lg-5 mr-lg-4">
            <div id="formSearch" class="justify-content-md-center flex-grow-1 ">
                <form id="contenedor-search" class="justify-content-center col-12 row p-0 m-0" action='. $urlSearch .' method="get">
                    <label class="d-none" for="search">search</label>
                    <input id="search" class="form-control col-12" type="search"  name="search" placeholder="Buscar Título" aria-label="Search">
                    <span class="fas fa-search icono-buscador pr-sm-1"></span>
                    <ul id="lista" class="col-12"></ul>
                </form>       
            </div> 
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
                        ['label' => 'Personas', 'url' => ['/personas/index']],
                        ['label' => 'Productoras', 'url' => ['/productoras/index']],
                        ['label' => 'Géneros', 'url' => ['/generos/index']],
                    ],
                    'visible' => Yii::$app->user->identity->soyAdmin,
                ],
                [
                    'label' => Yii::$app->user->identity->login,
                    'items' => [
                        ['label' => 'Perfil', 'url' => ['/valoraciones/usuarios', 'id' => Yii::$app->user->id]],
                        ['label' => 'Mis listas', 'url' => ['/usuarios-listas/mis-listas']],
                        ['label' => 'Amigos', 'url' => ['/seguidores/mis-amigos']],
                        'items' => 
                        ['label' => 'Cerrar sesión', 'url' => ['/site/logout'], 'linkOptions' => ['data-method' => 'POST']],
                    ],
                ],
            ];
        } else {
            $items += [['label' => 'Login', 'url' => ['/site/login']]];
        }

        $items = array_merge([
            ['label' => 'Películas', 'url' => ['/productos/peliculas']],
            ['label' => 'Series', 'url' => ['/productos/series']],
            ['label' => 'Documentales', 'url' => ['/productos/documentales']]
        ], $items);

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

            <p class="text-center float-md-right">Desarrollado por M. Ángel Rodríguez</p>
        </div>
    </footer>
    <div class="modal" tabindex="-1" role="dialog">
        <div class=" modal-dialog" role="document">
            <div class="modal-content p-2">
                <div class="modal-header">
                    <h4 class="modal-title">Política de cookies</h4>
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
