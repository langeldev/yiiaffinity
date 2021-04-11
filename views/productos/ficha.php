<?php

use yii\bootstrap4\Html;
use yii\widgets\DetailView;

$this->title = $model->titulo;
$this->params['breadcrumbs'][] = ['label' => 'Productos', 'url' => ['index']];
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
            <dt>Dirección</dt>
            <dd>
                <div>
                    <?php foreach ($model->directors as $key => $director): ?> 
                        <?= "<span>" . Html::encode($director->nombre) .
                        ($key + 1 < count($model->directors) ? "</span>," : "</span>")
                        ?>
                    <?php endforeach?>    
                </div>
            </dd>
            <dt>Guion</dt>
            <dd>
                <div>
                    <?php foreach ($model->guions as $key => $guion): ?> 
                        <?= "<span>" . Html::encode($guion->nombre) .
                        ($key + 1 < count($model->guions) ? "</span>," : "</span>")
                        ?>
                    <?php endforeach?>    
                </div>
            </dd>
            <dt>Fotografía</dt>
            <dd>
                <div>
                    <?php foreach ($model->fotografias as $key => $fotografia): ?> 
                        <?= "<span>" . Html::encode($fotografia->nombre) .
                        ($key + 1 < count($model->fotografias) ? "</span>," : "</span>")
                        ?>
                    <?php endforeach?>    
                </div>
            </dd>
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
            <dt>Sinopsis</dt>
            <dd>
                <div>
                    <?= Html::encode($model->sinopsis)?>
                </div>
            </dd>
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
        </dl>


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
