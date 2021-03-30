<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "productos_directores".
 *
 * @property int $producto_id
 * @property int $director_id
 *
 * @property Directores $director
 * @property Productos $producto
 */
class ProductosDirectores extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'productos_directores';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['producto_id', 'director_id'], 'required'],
            [['producto_id', 'director_id'], 'default', 'value' => null],
            [['producto_id', 'director_id'], 'integer'],
            [['producto_id', 'director_id'], 'unique', 'targetAttribute' => ['producto_id', 'director_id']],
            [['director_id'], 'exist', 'skipOnError' => true, 'targetClass' => Directores::className(), 'targetAttribute' => ['director_id' => 'id']],
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
            'director_id' => 'Director ID',
        ];
    }

    /**
     * Gets query for [[Director]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDirector()
    {
        return $this->hasOne(Directores::className(), ['id' => 'director_id'])->inverseOf('productosDirectores');
    }

    /**
     * Gets query for [[Producto]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProducto()
    {
        return $this->hasOne(Productos::className(), ['id' => 'producto_id'])->inverseOf('productosDirectores');
    }
}
