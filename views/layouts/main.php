<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap4\Nav;
use yii\bootstrap4\NavBar;
use yii\bootstrap4\Breadcrumbs;
use app\assets\AppAsset;
use yii\bootstrap\Modal;
use yii\helpers\Url;

AppAsset::register($this);

$urlSearch = Url::to(['productos/search']);

$js = <<<EOT
 comprobarCookie();
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
                    let a =  $('<a>').attr('href', 'index.php?r=productos/ficha&id=' + producto.id);
                    let li = a.append($('<li>').text(producto.titulo));
                    $('#lista').append(li)
                }
                $('#lista').show();
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

        echo '<div id="formSearch" class="justify-content-md-center flex-grow-1 ">
   
    <form id="contenedor-search" class="justify-content-center col-12 row p-md-0">
                <input id="search" class="form-control col-md-6" type="text" placeholder=" Buscar Título">
                <ul id="lista" class="col-md-6"></ul>
                </form>
             
        </div>  
        ';

        echo Nav::widget([
            'options' => ['class' => 'navbar-nav'],
            'items' => [
                ['label' => 'Productos', 'url' => ['/productos/index']],
                ['label' => 'Usuarios', 'url' => ['/usuarios/index']],
                Yii::$app->user->isGuest ? ''
                    : ['label' => 'Editar Perfil', 'options' => ['class' => 'd-md-none'], 'url' => ['/usuarios/editar-perfil']],
                Yii::$app->user->isGuest ? (['label' => 'Login', 'url' => ['/site/login']]) : ('<li class="nav-item">'
                    . Html::beginForm(['/site/logout'], 'post')
                    . Html::submitButton(
                        'Logout (' . Yii::$app->user->identity->login . ')',
                        ['class' => 'btn btn-warning nav-link logout']
                    )
                    . Html::endForm()
                    . '</li>')
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
    <?= Html::button('', ['class' => 'fas fa-chevron-up', 'id' => 'al-cielo']) ?>
    <footer class="footer">
        <div class="container">
            <p class="text-center float-md-left">&copy; YiiAffinity <?= date('Y') ?></p>

            <p class="text-center float-md-right"><?= Yii::powered() ?></p>
        </div>
    </footer>

    <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>

<?php Modal::begin([
    'id' => 'modal',
    'size' => 'modal-xl',
]); ?>
<section class="p-3">
    <h3 class="text-center mb-3">POLÍTICA DE COOKIES</h3>
    <p>
        El acceso a este Sitio Web puede implicar la utilización de cookies. Las cookies son pequeñas cantidades de información que se almacenan en el navegador utilizado por cada Usuario —en los distintos dispositivos que pueda utilizar para navegar— para que el servidor recuerde cierta información que posteriormente y únicamente el servidor que la implementó leerá. Las cookies facilitan la navegación, la hacen más amigable, y no dañan el dispositivo de navegación.
    </p>
    <p>
        Las cookies son procedimientos automáticos de recogida de información relativa a las preferencias determinadas por el Usuario durante su visita al Sitio Web con el fin de reconocerlo como Usuario, y personalizar su experiencia y el uso del Sitio Web, y pueden también, por ejemplo, ayudar a identificar y resolver errores.
    </p>
    <p>
        La información recabada a través de las cookies puede incluir la fecha y hora de visitas al Sitio Web, las páginas visionadas, el tiempo que ha estado en el Sitio Web y los sitios visitados justo antes y después del mismo. Sin embargo, ninguna cookie permite que esta misma pueda contactarse con el número de teléfono del Usuario o con cualquier otro medio de contacto personal. Ninguna cookie puede extraer información del disco duro del Usuario o robar información personal. La única manera de que la información privada del Usuario forme parte del archivo Cookie es que el usuario dé personalmente esa información al servidor.
    </p>
    <p>
        Las cookies que permiten identificar a una persona se consideran datos personales. Por tanto, a las mismas les será de aplicación la Política de Privacidad anteriormente descrita. En este sentido, para la utilización de las mismas será necesario el consentimiento del Usuario. Este consentimiento será comunicado, en base a una elección auténtica, ofrecido mediante una decisión afirmativa y positiva, antes del tratamiento inicial, removible y documentado.
    </p>

    <h4>
        Cookies propias
    </h4>
    <p>
        Son aquellas cookies que son enviadas al ordenador o dispositivo del Usuario y gestionadas exclusivamente por <a href="https://yii-affinity.herokuapp.com">YiiAffinity</a> para el mejor funcionamiento del Sitio Web. La información que se recaba se emplea para mejorar la calidad del Sitio Web y su Contenido y su experiencia como Usuario. Estas cookies permiten reconocer al Usuario como visitante recurrente del Sitio Web y adaptar el contenido para ofrecerle contenidos que se ajusten a sus preferencias.
    </p>

    <h4>
        Deshabilitar, rechazar y eliminar cookies
    </h4>
    <p>
        El Usuario puede deshabilitar, rechazar y eliminar las cookies —total o parcialmente— instaladas en su dispositivo mediante la configuración de su navegador (entre los que se encuentran, por ejemplo, Chrome, Firefox, Safari, Explorer). En este sentido, los procedimientos para rechazar y eliminar las cookies pueden diferir de un navegador de Internet a otro. En consecuencia, el Usuario debe acudir a las instrucciones facilitadas por el propio navegador de Internet que esté utilizando. En el supuesto de que rechace el uso de cookies —total o parcialmente— podrá seguir usando el Sitio Web, si bien podrá tener limitada la utilización de algunas de las prestaciones del mismo.

        Este documento de Política de Cookies ha sido creado mediante el generador de plantilla de política de cookies online el día 13/05/2021.
    </p>
    <div class='modal-footer'>
        <button id='aceptar-cookie' type='button' class='btn btn-votar' data-dismiss='modal'>Aceptar</button>
        <button id='rechazar-cookie' type='button' class='btn btn-secondary rounded-0' data-dismiss='modal'>Rechazar</button>
    </div>

</section>
<?php Modal::end() ?>
