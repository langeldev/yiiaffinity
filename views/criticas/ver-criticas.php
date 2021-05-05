<?php

use yii\bootstrap4\Html;
use yii\bootstrap4\LinkPager;

$this->title = $producto->titulo;
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);


?>
<div class="fondo p-2">


    <h1 class="col-12 pt-3"><?= Html::encode($this->title) ?></h1>

    <section class="col-12">
        <ul class="nav-ficha col-12">
            <li>
                <?= Html::a('Ficha', ['/productos/ficha', 'id' => $producto->id]) ?>
            </li>
            <li>

                <?= Html::a('Críticas [' . count($producto->criticas) . ']', '', ['class' => 'ficha-selected']) ?>
            </li>
        </ul>

        <div class="row py-3">
            <div class="offset-2 offset-md-0 col-8 col-md-2 mb-4">
                <img class="img-fluid" src="#" alt="">
            </div>
            <dl class="col-10 col-md-8">
                <div class="row">
                    <dt class="izquierda col-12 col-md-2 text-md-right">Año</dt>
                    <dd class="derecha col-12 col-md-10"><?= Html::encode($producto->anyo) ?></dd>
                    <dt class="izquierda col-12 col-md-2 text-md-right">País</dt>
                    <dd class="derecha col-12 col-md-10"><?= Html::encode($producto->pais) ?></dd>
                    <?php if (count($producto->directores) > 0) : ?>
                        <dt class="izquierda col-12 col-md-2 text-md-right">Dirección</dt>
                        <dd class="derecha col-12 col-md-10">
                            <div>
                                <?php foreach ($producto->directores as $key => $director) : ?>
                                    <?= "<span>" . Html::encode($director->nombre) .
                                        ($key + 1 < count($producto->directores) ? "</span>," : "</span>")
                                    ?>
                                <?php endforeach ?>
                            </div>
                        </dd>
                    <?php endif ?>

                    <?php if (count($producto->interpretes) > 0) : ?>
                        <dt class="izquierda col-12 col-md-2 text-md-right">Reparto</dt>
                        <dd class="derecha col-12 col-md-10">
                            <div>
                                <?php foreach ($producto->interpretes as $key => $reparto) : ?>
                                    <?= "<span>" . Html::encode($reparto->nombre) .
                                        ($key + 1 < count($producto->interpretes) ? "</span>," : "</span>")
                                    ?>
                                <?php endforeach ?>
                            </div>
                        </dd>
                    <?php endif ?>

                    <?php if (count($producto->generos) > 0) : ?>
                        <dt class="izquierda col-12 col-md-2 text-md-right">Género</dt>
                        <dd class="derecha col-12 col-md-10">
                            <div>
                                <?php foreach ($producto->generos as $key => $genero) : ?>
                                    <?= "<span>" . Html::encode($genero->nombre) .
                                        ($key + 1 < count($producto->generos) ? "</span>," : "</span>")
                                    ?>
                                <?php endforeach ?>
                            </div>
                        </dd>
                    <?php endif ?>
                </div>
            </dl>

                <div class="puntos-criticas">
                    <div class="media">
                        <h3 id="media"><?= Html::encode(number_format($producto->mediaCriticas, 1, ",", "")) ?></h3>
                    </div>
                    <div class="total">
                        <h4 id="total"><?= Html::encode($producto->criticasTotales()) ?> <br>votos</h4>
                    </div>
                </div>
            <div class="derecha col-12 col-md-10">
                
                <p>
                    <span class="izquierda">Sinopsis</span>
                    <?= Html::encode($producto->sinopsis) ?>
                </p>
            </div>
    </section>
    <div class="my-4 row col-12 justify-content-center">
        <?= LinkPager::widget([
            'pagination' => $pagination
        ]) ?>
    </div>
    
    <div class="col-12">
        <section class="criticas-container">
            
        <?php if ($criticas) : ?>
            <?php foreach ($criticas as $critica) : ?>
                <article class="p-3 p-md-5 critica-container">
                    <header class="cabecera-critica">
                        <div class="datos-usuarios-criticas col-11">
                            <i class="fa fa-user"></i>
                            <h4 class="usuario-critica"><?= Html::encode($critica->usuario->login) ?></h4>
                            <span class="localidad">
                                <?php
                                if ($critica->usuario->ciudad || $critica->usuario->pais) {
                                    echo $critica->usuario->ciudad
                                    ? Html::encode($critica->usuario->ciudad)
                                        : '';
                                        echo $critica->usuario->pais
                                        ? ' (' . Html::encode($critica->usuario->pais) . ')'
                                        : '';
                                    }
                                ?>
                            </span>

                        </div>
                        <div class="valor-critica">
                            <?= Html::encode($critica->valoracion) ?>
                        </div>
                    </header>

                    <h5 class="titulo-critica"><?= Html::a(Html::encode($critica->titulo), ['criticas/view', 'id' => $critica->id]) ?></h5>
                    <h6 class="fecha"><?= Yii::$app->formatter->asDate($critica->created_at, 'long') ?></h6>
                    <p class="critica ">
                        <?= Html::encode($critica->critica) ?>
                    </p>
                    <?php if (!Yii::$app->user->isGuest) : ?>
                        <?php if ($critica->usuario_id === Yii::$app->user->id) : ?>
                            <div>
                                <?= Html::a('Eliminar', ['criticas/delete', 'id' => $critica->id], [
                                    'class' => 'btn btn-eliminar',
                                    'data' => [
                                        'confirm' => '¿Estás seguro de que quiere borrar la crítica?',
                                        'method' => 'post',
                                    ],
                                ]) ?>
                                <?= Html::a('Modificar', ['criticas/update', 'id' => $critica->producto_id], [
                                            'class' => 'btn btn-votar',
                                            'data' => [
                                                'method' => 'post',
                                            ],
                                ]) ?>
                            </div>
                        <?php endif ?> 
                    <?php endif ?>
                </article>
                
                <?php endforeach ?>
                
        <?php else : ?>
            <article class="p-5 critica-container text-center">
                <h2>No hay críticas de <i class="izquierda"><?= Html::encode($producto->titulo) ?></i></h2>
            </article>
            <?php endif ?>

        </section>
    </div>
        <div class="my-4 row col-12 justify-content-center">
        <?= LinkPager::widget([
            'pagination' => $pagination
            ]) ?>
    </div>
</div>
