<?php

/**
 * This is the model class for table "protocolo".
 *
 * The followings are the available columns in table 'protocolo':
 * @property string $id
 * @property string $documento
 * @property string $origem
 * @property string $datahora
 * @property string $usuario
 * @property string $observacao
 */
class Protocolo extends CActiveRecord
{	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'protocolo';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('documento, origem', 'required'),
			array('documento', 'length', 'max'=>50),
			array('origem, observacao', 'length', 'max'=>100),
			array('usuario', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, documento, origem', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'us'=>array(self::BELONGS_TO,'User','usuario'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'Protocolo',
			'documento' => 'Documento',
			'origem' => 'Origem',
			'datahora' => 'Data/Hora',
			'usuarioText' => 'Usuário',
			'observacao' => 'Observação',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,false);
		$criteria->compare('documento',$this->documento,true);
		$criteria->compare('origem',$this->origem,true);
		$criteria->order='datahora desc';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Protocolo the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	protected function beforeSave()
	{
		if ($this->isNewRecord)
		{
			$this->usuario=Yii::app()->getModule('user')->user()->id;
			$this->datahora=new CDbExpression('NOW()');
		}
		
		return parent::beforeSave();
	}
	
	public function getUsuarioText()
	{
		$profile = $this->us->profile;
		return $profile->first_name.' '.$profile->last_name.' ('.$profile->unidade->nome.')';
	}
}
