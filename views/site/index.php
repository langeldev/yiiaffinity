<?php

/* @var $this yii\web\View */

use yii\bootstrap4\Html;

$this->title = 'YiiAffinity';
$userId = Yii::$app->user->id ?? -1;
$urlRecomendacion =  Url::to(['/productos/recomendar']);
$js = <<<EOT
$(document).ready(function() {
    let userId = $userId;
    if (getCookie('genero' + userId) !== ""){
        pedirRecomendacion(userId, '$urlRecomendacion');
    }
});
EOT;

$this->registerJs($js);

?>
<div class="fondo">
    <div class="col-12 row p-0 m-0">

        <section class="body-content col-12 col-md-10 my-0">

            <h2 class="text-center text-md-left ml-md-4 h2">Cartelera</h2>
            <div class="card-deck col-12 m-auto">
                <div class="row align-center">
                    <?php foreach ($productos as $producto) : ?>
                        <div class="col-6 col-lg-4 my-4">
                            <div class="card">
                            <?= Html::img($producto->getImagen(), ['class' => 'card-img-top cartel'])?>
                                
                                <div class="card-body">
                                    <h5 class="card-title titulo">
                                        <?= Html::a($producto->titulo, ['productos/ficha', 'id' => $producto->id]) ?>
                                    </h5>
                                </div>
                            </div>
                        </div>
                    <?php endforeach ?>
                </div>
            </div>
        </section>
    </div>
</div>
