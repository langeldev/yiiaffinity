<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "musica".
 *
 * @property int $id
 * @property string $nombre
 *
 * @property ProductosMusica[] $productosMusicas
 * @property Productos[] $productos
 */
class Musica extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'musica';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre'], 'required'],
            [['nombre'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nombre' => 'Nombre',
        ];
    }

    /**
     * Gets query for [[ProductosMusicas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProductosMusicas()
    {
        return $this->hasMany(ProductosMusica::class, ['musica_id' => 'id'])->inverseOf('musica');
    }

    /**
     * Gets query for [[Productos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProductos()
    {
        return $this->hasMany(Productos::class, ['id' => 'producto_id'])->viaTable('productos_musica', ['musica_id' => 'id']);
    }

    /**
    * Devuelve una lista con los compositores
    *
    * @return array
    */
    public static function lista()
    {
        return static::find()->select('nombre')->indexBy('id')->column();
    }
}
