<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "productos_productoras".
 *
 * @property int $producto_id
 * @property int $productora_id
 *
 * @property Productoras $productora
 * @property Productos $producto
 */
class ProductosProductoras extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'productos_productoras';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['producto_id', 'productora_id'], 'required'],
            [['producto_id', 'productora_id'], 'default', 'value' => null],
            [['producto_id', 'productora_id'], 'integer'],
            [['producto_id', 'productora_id'], 'unique', 'targetAttribute' => ['producto_id', 'productora_id']],
            [['productora_id'], 'exist', 'skipOnError' => true, 'targetClass' => Productoras::className(), 'targetAttribute' => ['productora_id' => 'id']],
            [['producto_id'], 'exist', 'skipOnError' => true, 'targetClass' => Productos::className(), 'targetAttribute' => ['producto_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'producto_id' => 'Producto ID',
            'productora_id' => 'Productora ID',
        ];
    }

    /**
     * Gets query for [[Productora]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProductora()
    {
        return $this->hasOne(Productoras::className(), ['id' => 'productora_id'])->inverseOf('productosProductoras');
    }

    /**
     * Gets query for [[Producto]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProducto()
    {
        return $this->hasOne(Productos::className(), ['id' => 'producto_id'])->inverseOf('productosProductoras');
    }
}
