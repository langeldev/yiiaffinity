<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Usuarios;
use yii\data\Pagination;

/**
 * UsuariosSearch represents the model behind the search form of `app\models\Usuarios`.
 */
class UsuariosSearch extends Usuarios
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'rol_id'], 'integer'],
            [['login', 'nombre', 'email', 'password', 'auth_key', 'genero', 'pais', 'ciudad'], 'safe'],
            [['anyo_nac'], 'number'],
            [['rol.rol'], 'string']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function attributes()
    {
        return array_merge(parent::attributes(), ['rol.rol']);
    }
    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Usuarios::find()->joinWith('rol');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ]
        ]);

        $dataProvider->sort->attributes['rol.rol'] = [
            'asc' => ['roles.rol' => SORT_ASC],
            'desc' => ['roles.rol' => SORT_DESC],
        ];
        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'anyo_nac' => $this->anyo_nac,
        ]);

        $query->andFilterWhere(['ilike', 'login', $this->login])
            ->andFilterWhere(['ilike', 'nombre', $this->nombre])
            ->andFilterWhere(['ilike', 'email', $this->email])
            ->andFilterWhere(['ilike', 'roles.rol', $this->getAttribute('rol.rol')])
            ->andFilterWhere(['ilike', 'genero', $this->genero])
            ->andFilterWhere(['ilike', 'pais', $this->pais])
            ->andFilterWhere(['ilike', 'ciudad', $this->ciudad]);

        return $dataProvider;
    }

    public function searchAmigos($nombre)
    {
  
        $this->load($nombre);

        $query = Usuarios::find() ->andFilterWhere(['ilike', 'login', $this->nombre])
            ->orFilterWhere(['ilike', 'nombre', $this->nombre])
            ->andWhere(['not in', 'rol_id', 1]);;
  
        $pagination = new Pagination([
            'pageSize' => 6,
            'totalCount' =>  $query->count()
        ]);
        
        $query->limit($pagination->limit)->offset($pagination->offset);

        return ['query' => $query->all(), 'pagination' => $pagination];
    }
}
