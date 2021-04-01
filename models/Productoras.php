<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "productoras".
 *
 * @property int $id
 * @property string $nombre
 *
 * @property ProductosProductoras[] $productosProductoras
 * @property Productos[] $productos
 */
class Productoras extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'productoras';
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
     * Gets query for [[ProductosProductoras]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProductosProductoras()
    {
        return $this->hasMany(ProductosProductoras::class, ['productora_id' => 'id'])->inverseOf('productora');
    }

    /**
     * Gets query for [[Productos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProductos()
    {
        return $this->hasMany(Productos::class, ['id' => 'producto_id'])->viaTable('productos_productoras', ['productora_id' => 'id']);
    }

    /**
    * Devuelve una lista con las productoras
    *
    * @return array
    */
    public static function lista()
    {
        return static::find()->select('nombre')->indexBy('id')->column();
    }
}
