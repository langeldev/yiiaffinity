<?php

/* @var $this yii\web\View */

use yii\bootstrap4\Html;

$this->title = 'YiiAffinity';
?>
<div class="fondo">
    <div class="col-12 row">
        <aside class="d-none d-md-block col-md-2 nav-lateral p-0">
         <?php if (!Yii::$app->user->isGuest): ?>
            <ul>
                <li>
                    <?= Html::a('Editar Perfil', ['usuarios/editar-perfil']) ?>
                </li>
            </ul> 
        <?php endif ?>
        </aside>
        <section class="body-content col-12 col-md-10 my-0">
            <h2>Cartelera</h2>

            <div class="card-deck">
                <div class="row col-12">
                    <?php foreach ($productos as $producto) : ?>
                        <div class="col-6 col-lg-4 my-4">
                            <div class="card">
                                <img class="card-img-top cartel" src="#" alt="">
                                <div class="card-body">
                                    <h5 class="card-title titulo">
                                        <?= Html::a($producto->titulo, ['productos/view', 'id' => $producto->id]) ?>
                                    </h5>
                                </div>
                            </div>

                        </div>

                    <?php endforeach ?>
        </section>
    </div>
</div>
</div>
</div>
