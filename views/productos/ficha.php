<?php

use yii\bootstrap4\Html;
use yii\widgets\DetailView;

$this->title = $model->titulo;
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

?>
<div class="fondo p-2">
    <div class="row">

    <h1 class="col-8"><?= Html::encode($this->title) ?></h1>
    <section class="col-8"> 
  
        <dl>
            <dt>Título Original</dt>
            <dd><?= Html::encode($model->titulo_original)?></dd>
            <dt>Año</dt>
            <dd><?= Html::encode($model->anyo)?></dd>
            <dt>Duración</dt>
            <dd><?= Html::encode($model->duracion . ' min')?></dd>
            <dt>País</dt>
            <dd><?= Html::encode($model->pais)?></dd>
            <?php if (count($model->directores) > 0): ?>
            <dt>Dirección</dt>
            <dd>
                <div>
                    <?php foreach ($model->directores as $key => $director): ?> 
                        <?= "<span>" . Html::encode($director->nombre) .
                        ($key + 1 < count($model->directores) ? "</span>," : "</span>")
                        ?>
                    <?php endforeach?>    
                </div>
            </dd>
            <?php endif ?>
            <?php if (count($model->guion) > 0): ?>
            <dt>Guion</dt>
            <dd>
                <div>
                    <?php foreach ($model->guion as $key => $guion): ?> 
                        <?= "<span>" . Html::encode($guion->nombre) .
                        ($key + 1 < count($model->guion) ? "</span>," : "</span>")
                        ?>
                    <?php endforeach?>    
                </div>
            </dd>
            <?php endif ?>
            <?php if (count($model->musica) > 0): ?>
            <dt>Música</dt>
            <dd>
                <div>
                    <?php foreach ($model->musica as $key => $musica): ?> 
                        <?= "<span>" . Html::encode($musica->nombre) .
                        ($key + 1 < count($model->musica) ? "</span>," : "</span>")
                        ?>
                    <?php endforeach?>    
                </div>
            </dd>
            <?php endif ?>
            <?php if (count($model->fotografia) > 0): ?>
            <dt>Fotografía</dt>
            <dd>
                <div>
                    <?php foreach ($model->fotografia as $key => $fotografia): ?> 
                        <?= "<span>" . Html::encode($fotografia->nombre) .
                        ($key + 1 < count($model->fotografia) ? "</span>," : "</span>")
                        ?>
                    <?php endforeach?>    
                </div>
            </dd>
            <?php endif ?>
            <?php if (count($model->interpretes) > 0): ?>
            <dt>Reparto</dt>
            <dd>
                <div>

                    <?php foreach ($model->interpretes as $key => $reparto): ?> 
                        
                        <?= "<span>". Html::encode($reparto->nombre) . 
                            ($key + 1 < count($model->interpretes) ? "</span>," : "</span>")
                        ?>
                        
                    <?php endforeach?>    
                </div>
            </dd>
            <?php endif ?>
            <?php if (count($model->productoras) > 0): ?>
            <dt>Productora</dt>
            <dd>
                <div>
                    <?php foreach ($model->productoras as $key => $productora): ?> 
                        <?= "<span>" . Html::encode($productora->nombre) .
                        ($key + 1 < count($model->productoras) ? "</span>," : "</span>")
                        ?>
                    <?php endforeach?>    
                </div>
            </dd>
            <?php endif ?>
            <?php if (count($model->generos) > 0): ?>
            <dt>Género</dt>
            <dd>
                <div>
                    <?php foreach ($model->generos as $key => $genero): ?> 
                        <?= "<span>" . Html::encode($genero->nombre) .
                        ($key + 1 < count($model->generos) ? "</span>," : "</span>")
                        ?>
                    <?php endforeach?>    
                </div>
            </dd>
            <?php endif ?>
            <dt>Sinopsis</dt>
            <dd>
                <div>
                    <?= Html::encode($model->sinopsis)?>
                </div>
            </dd>
            <?php if (count($model->premios) > 0): ?>
            <dt>Premios</dt>
            <dd>
                <div>
                    <?php foreach ($model->premios as $premio): ?> 
                        <div>
                            <?= Html::encode("(".$premio->cantidad.") ".$premio->nombre)?>
                        </div>
                    <?php endforeach?>    
                </div>
            </dd>
            <?php endif ?>
            <?php if ($criticas) :?>
            <dt>Críticas</dt>
            <dd>
                <?php foreach ($criticas as $critica): ?>
                <h5><?= Html::a(Html::encode($critica->titulo), ['criticas/view', 'id' => $critica->id]) ?></h5>
                    <p>
                        <?= Html::encode($critica->critica) ?>
                    </p>
                    <i><?= Html::encode($critica->usuario->login)?></i>
                    
                <?php endforeach?>
            </dd>
            <?php endif ?>
            <dt>Tu crítica</dt>
            <dd>
                <?php if ($miCritica !== null): ?>
                    <?= Html::a('Eliminar', ['criticas/delete', 'id' => $miCritica->id], [
                        'class' => 'btn btn-eliminar',
                                'data' => [
                                'confirm' => '¿Estás seguro de que quiere borrar la crítica?',
                                'method' => 'post',
                                ],
                    ]) ?>
                    <h5><?= $miCritica->titulo?></h5> 
                    <h6><?=$miCritica->valoracion?></h6>
                        
                    <?= $miCritica->critica?>
                <?php else: ?>
                    <div id="tu-critica">
                        <p>Escribe tu opinión sobre <?=Html::encode($model->titulo)?></p>
                        <?= Html::a('Añade tu critica', ['criticas/create', 'id' => $model->id]) ?>
                    </div>
                <?php endif ?>
        
            </dd>
        </dl>


        <p>
            
        </p>
</section>

<aside class="col-4 ">
    <div class="row">
        
        <div class="media col-6">
            <h4><?= Html::encode($model->media)?></h4>
        </div>
        <div class="total col-6">
            <h4><?= Html::encode($model->votosTotales() . ' votos')?></h4>
        </div>
    </div>
</aside>
</div>
</div>
