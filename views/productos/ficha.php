<?php

use yii\bootstrap4\Html;
use yii\helpers\Url;

$this->title = $model->titulo;
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

$urlAgregarValoracion = Url::to(['valoraciones/agregar']);
$urlNoVista = Url::to(['valoraciones/no-vista']);

$js = <<<EOT

$('#valoraciones-valoracion').on('change',function(ev){
    let valoracion = $(this).val();
    let producto = $model->id;
    if (valoracion != '') {
        $.ajax({
            type: 'POST',
            url: '$urlAgregarValoracion',
            data: {
                producto_id: producto,
                valoracion: valoracion
            }
        }).done(function(data){
            $('#media').text(formateo(data.media));
            $('#total').html(data.total + "</br>votos");
        });
    } else {
        $.ajax({
            type: 'POST',
            url: '$urlNoVista',
            data: {
                producto_id: producto
            }
        }).done(function(data){
            $('#media').text(formateo(data.media));
            $('#total').html(data.total + "</br>votos");
        });
    }
 
});
EOT;
$this->registerJs($js);
?>
<div class="fondo p-2">
    <div class="col-12">
        <h1 id="titulo" class="text-center text-md-left h1 border-0" itemprop="name"><?= Html::encode($this->title) ?></h1>
        <ul class="nav-ficha col-12">
            <li>
                <?= Html::a('Ficha', '', ['class' => 'ficha-selected']) ?>
            </li>
            <li>
                <?= Html::a('Críticas [' . count($model->criticas) . ']', ['/criticas/ver-criticas', 'id' => $model->id]) ?>
            </li>

        </ul>

        <div class="row py-3 d-flex flex-column-reverse flex-md-row">
            <section class="col-12 col-md-9 row" itemscope itemtype="https://schema.org/Movie" itemref="titulo cartel">
                    <dt class="izquierda col-3 text-right">Título original</dt>
                    <dd class="derecha col-9"><?= Html::encode($model->titulo_original) ?></dd>
                    <dt class="izquierda col-3 text-right">Año</dt>
                    <dd class="derecha col-9" itemprop="dateCreated"><?= Html::encode($model->anyo) ?></dd>
                    <dt class="izquierda col-3 text-right" itemprop="duration">Duración</dt>
                    <dd class="derecha col-9"><?= Html::encode($model->duracion . ' min') ?></dd>
                    <dt class="izquierda col-3 text-right">País</dt>
                    <dd class="derecha col-9"><?= Html::encode($model->pais) ?></dd>
                    <?php if (count($model->directores) > 0) : ?>
                        <dt class="izquierda col-3 text-right">Dirección</dt>
                        <dd class="derecha col-9">
                            <?php foreach ($model->directores as $key => $director) : ?>
                                <?= '<span itemprop="director">'. Html::encode($director->nombre) .
                                    ($key + 1 < count($model->directores) ? "</span>," : "</span>")
                                ?>
                            <?php endforeach ?>
                        </dd>
                    <?php endif ?>
                    <?php if (count($model->guion) > 0) : ?>
                        <dt class="izquierda col-3 text-right">Guion</dt>
                        <dd class="derecha col-9">
                            <?php foreach ($model->guion as $key => $guion) : ?>
                                <?= "<span>" . Html::encode($guion->nombre) .
                                    ($key + 1 < count($model->guion) ? "</span>," : "</span>")
                                ?>
                            <?php endforeach ?>
                        </dd>
                    <?php endif ?>
                    <?php if (count($model->musica) > 0) : ?>
                        <dt class="izquierda col-3 text-right">Música</dt>
                        <dd class="derecha col-9">
                            <?php foreach ($model->musica as $key => $musica) : ?>
                                <?= "<span>" . Html::encode($musica->nombre) .
                                    ($key + 1 < count($model->musica) ? "</span>," : "</span>")
                                ?>
                            <?php endforeach ?>
                        </dd>
                    <?php endif ?>
                    <?php if (count($model->fotografia) > 0) : ?>
                        <dt class="izquierda col-3 text-right">Fotografía</dt>
                        <dd class="derecha col-9">
                            <?php foreach ($model->fotografia as $key => $fotografia) : ?>
                                <?= "<span>" . Html::encode($fotografia->nombre) .
                                    ($key + 1 < count($model->fotografia) ? "</span>," : "</span>")
                                ?>
                            <?php endforeach ?>
                        </dd>
                    <?php endif ?>
                    <?php if (count($model->interpretes) > 0) : ?>
                        <dt class="izquierda col-3 text-right">Reparto</dt>
                        <dd class="derecha col-9">
                            <?php foreach ($model->interpretes as $key => $reparto) : ?>
                                <?= "<span>" . Html::encode($reparto->nombre) .
                                    ($key + 1 < count($model->interpretes) ? "</span>," : "</span>")
                                ?>
                            <?php endforeach ?>
                        </dd>
                    <?php endif ?>
                    <?php if (count($model->productoras) > 0) : ?>
                        <dt class="izquierda col-3 text-right">Productora</dt>
                        <dd class="derecha col-9">
                            <?php foreach ($model->productoras as $key => $productora) : ?>
                                <?= "<span>" . Html::encode($productora->nombre) .
                                    ($key + 1 < count($model->productoras) ? "</span>," : "</span>")
                                ?>
                            <?php endforeach ?>
                        </dd>
                    <?php endif ?>
                    <?php if (count($model->generos) > 0) : ?>
                        <dt class="izquierda col-3 text-right">Género</dt>
                        <dd class="derecha col-9">
                            <?php foreach ($model->generos as $key => $genero) : ?>
                                <?= '<span itemprop="genre">' . Html::encode($genero->nombre) .
                                    ($key + 1 < count($model->generos) ? "</span>," : "</span>")
                                ?>
                            <?php endforeach ?>
                        </dd>
                    <?php endif ?>
                    <dt class="izquierda col-3 text-right">Sinopsis</dt>
                    <dd class="derecha col-9">
                        <?= Html::encode($model->sinopsis) ?>
                    </dd>
                    <?php if (count($model->premios) > 0) : ?>
                        <dt class="izquierda col-3 text-right">Premios</dt>
                        <dd class="derecha col-9">
                                <?php foreach ($model->premios as $premio) : ?>
                                    <div>
                                        <?= Html::encode("(" . $premio->cantidad . ") " . $premio->nombre) ?>
                                    </div>
                                <?php endforeach ?>
                        </dd>
                    <?php endif ?>
                    <dt class="izquierda col-3 text-right">Tu crítica</dt>
                    <dd class="derecha col-9">

                        <div class="criticas-container">
                            <?php if ($miCritica !== null) : ?>
                                <article class="p-2 p-md-5 critica-container">
                                    <header class="cabecera-critica">
                                        <div class="datos-usuarios-criticas col-11">
                                            <i class="fa fa-user"></i>
                                            <h4 class="usuario-critica"><?= Html::encode($miCritica->usuario->login) ?></h4>
                                            <span class="localidad">
                                                <?php
                                                if ($miCritica->usuario->ciudad || $miCritica->usuario->pais) {
                                                    echo $miCritica->usuario->ciudad
                                                        ? Html::encode($miCritica->usuario->ciudad)
                                                        : '';
                                                    echo $miCritica->usuario->pais
                                                        ? ' (' . Html::encode($miCritica->usuario->pais) . ')'
                                                        : '';
                                                }
                                                ?>
                                            </span>

                                        </div>
                                        <div class="valor-critica">
                                            <?= Html::encode($miCritica->valoracion) ?>
                                        </div>
                                    </header>

                                    <h5 class="titulo-critica"><?= Html::a(Html::encode($miCritica->titulo), ['criticas/view', 'id' => $miCritica->id]) ?></h5>
                                    <h6 class="fecha"><?= Yii::$app->formatter->asDate($miCritica->created_at, 'long') ?></h6>
                                    <p class="critica ">
                                        <?= Html::encode($miCritica->critica) ?>
                                    </p>

                                    <div>
                                        <?= Html::a('Eliminar', ['criticas/delete', 'id' => $miCritica->id], [
                                            'class' => 'btn btn-eliminar',
                                            'data' => [
                                                'confirm' => '¿Estás seguro de que quiere borrar la crítica?',
                                                'method' => 'post',
                                            ],
                                        ]) ?>

                                    <?= Html::a('Modificar', ['criticas/update', 'id' => $model->id], [
                                            'class' => 'btn btn-azul',
                                            'data' => [
                                                'method' => 'post',
                                            ],
                                        ]) ?>
                                    </div>
                                </article>
                            <?php else : ?>
                                <div id="tu-critica">
                                    <p>Escribe tu opinión sobre <?= Html::encode($model->titulo) ?></p>
                                    <?= Html::a('Añade tu critica', ['criticas/create', 'id' => $model->id]) ?>
                                </div>
                            <?php endif ?>
                    </dd>
                </dl>

            </section>

            <aside class="col-12 col-md-3 mb-3">
                <div class="p-0 text-center">
                <?= Html::img($model->getImagen(), ['class' => 'img-fluid', 'id' => 'cartel', 'itemprop' => 'image'])?>
                </div>
                <div class="d-flex flex-md-column flex-wrap">
                    <div class="valoraciones col-6 col-md-12">
                        <div class="media">
                            <h5 id="media"><?= Html::encode(number_format($model->media, 1, ",", "")) ?></h5>
                        </div>
                        <div class="total">
                            <h5 id="total"><?= Html::encode($model->votosTotales) . ' <br> votos' ?></h5>
                        </div>

                    </div>

                    <div class="valoracion-accion col-5 col-md-12 text-center ml-auto">
                        <?php if (!Yii::$app->user->isGuest) : ?>
                            <h5>
                                Tu voto
                            </h5>
                            <?= $this->render('/valoraciones/_form', [
                                'miValoracion' => $miValoracion,
                                'lista' => $lista
                            ]) ?>
                        <?php else : ?>
                            <h5 class="d-flex h-100 aling-items-center">
                                <?= Html::a('Votar',  ['/site/login'], ['class' => 'btn btn-azul w-100 p-2 align-self-center']) ?>
                            </h5>
                        <?php endif ?>
                    </div>

                    <div class="valoracion-accion col-6 col-md-12 text-center mr-auto">
                        <?php if (!Yii::$app->user->isGuest) : ?>
                            <h5>
                                Añadir a lista
                            </h5>
                            <?= $this->render('/listas-productos/_form', [
                                'productoLista' => $productoLista,
                                'misListas' => $misListas,
                                'producto' => $model->id,
                            ]) ?>
                        <?php else : ?>
                            <?= Html::a('Añadir a listas',  ['/site/login'], ['class' => 'btn btn-azul w-100 p-2']) ?>
                        <?php endif ?>
                    </div>
                </div>
            </aside>

        </div>
    </div>
</div>
