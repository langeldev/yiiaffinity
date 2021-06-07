<?php

use yii\bootstrap4\Html;
?>
<div class="card-deck m-auto">
    <div class="col-12 align-center m-0 p-0 row">
        <?php if ($productos) : ?>
            <?php foreach ($productos as $producto) : ?>
                <div class="col-6 col-md-4 col-lg-3 my-4">
                    <div class="card">
                        <?= Html::img($producto->getImagen(), ['class' => 'card-img-top']) ?>
                        <div class="card-body">
                            <h3 class="card-title titulo">
                                <?= Html::a($producto->titulo, ['productos/ficha', 'id' => $producto->id]) ?>
                            </h3>
                        </div>
                    </div>
                </div>
            <?php endforeach ?>
        <?php else : ?>
            <div class="justify-content-center mt-5 col-12">
                <h3 class="text-center mt-4">No se encontraron resultados</h3>
            </div>
        <?php endif ?>
    </div>
</div>
