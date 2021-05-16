<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "seguidores".
 *
 * @property int $id
 * @property int $usuario_id
 * @property int $seguidor_id
 *
 * @property Usuarios $usuario
 * @property Usuarios $seguidor
 */
class Seguidores extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'seguidores';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['usuario_id', 'seguidor_id'], 'required'],
            [['usuario_id', 'seguidor_id'], 'default', 'value' => null],
            [['usuario_id', 'seguidor_id'], 'integer'],
            [['usuario_id', 'seguidor_id'], 'unique', 'targetAttribute' => ['usuario_id', 'seguidor_id']],
            [['usuario_id'], 'exist', 'skipOnError' => true, 'targetClass' => Usuarios::class, 'targetAttribute' => ['usuario_id' => 'id']],
            [['seguidor_id'], 'exist', 'skipOnError' => true, 'targetClass' => Usuarios::class, 'targetAttribute' => ['seguidor_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'usuario_id' => 'Usuario ID',
            'seguidor_id' => 'Seguidor ID',
        ];
    }

    /**
     * Gets query for [[Usuario]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsuario()
    {
        return $this->hasOne(Usuarios::class, ['id' => 'usuario_id'])->inverseOf('seguidores');
    }

    /**
     * Gets query for [[Seguidor]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSeguidor()
    {
        return $this->hasOne(Usuarios::class, ['id' => 'seguidor_id'])->inverseOf('seguidores0');
    }
}
