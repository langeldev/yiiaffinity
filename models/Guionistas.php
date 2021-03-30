<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "guionistas".
 *
 * @property int $id
 * @property string $nombre
 *
 * @property ProductosGuionistas[] $productosGuionistas
 * @property Productos[] $productos
 */
class Guionistas extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'guionistas';
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
     * Gets query for [[ProductosGuionistas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProductosGuionistas()
    {
        return $this->hasMany(ProductosGuionistas::className(), ['guion_id' => 'id'])->inverseOf('guion');
    }

    /**
     * Gets query for [[Productos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProductos()
    {
        return $this->hasMany(Productos::className(), ['id' => 'producto_id'])->viaTable('productos_guionistas', ['guion_id' => 'id']);
    }
}
