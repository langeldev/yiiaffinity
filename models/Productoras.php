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
        return $this->hasMany(ProductosProductoras::className(), ['productora_id' => 'id'])->inverseOf('productora');
    }

    /**
     * Gets query for [[Productos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProductos()
    {
        return $this->hasMany(Productos::className(), ['id' => 'producto_id'])->viaTable('productos_productoras', ['productora_id' => 'id']);
    }
}
