<?php

/* @var $this yii\web\View */

use yii\bootstrap4\Html;

$this->title = 'YiiAffinity';

?>
<div class="fondo p-2">
    <div class="row p-0 m-0">
       
        <section class="body-content col-12 my-0">

            <h1 class="text-center text-md-left h1">Cartelera</h1>
            <div class="card-deck col-12 m-auto">
                <div class="row align-center">
                    <?php foreach ($productos as $producto) : ?>
                        <div class="col-6 col-lg-3 my-4">
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
