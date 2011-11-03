<?php

/**
 * This is the model class for table "Rating".
 *
 * The followings are the available columns in table 'Rating':
 * @property integer $id
 * @property integer $user_id
 * @property integer $law_id
 */
class Rating extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Rating the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'rating';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, law_id', 'required'),
			array('user_id, law_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, user_id, law_id', 'safe', 'on'=>'search'),
                        array('user_id', 'isUnique'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'user_id' => 'User',
			'law_id' => 'Law',
		);
	}

        public function isUnique($attribute, $params){    
            $count = Rating::model()->count('law_id = :law AND user_id = :user', array(
               ':law'=>$this->law_id,
               ':user'=>$this->user_id,
            ));
            if($count > 0) {
               $this->addError('id','You already vote.');
            }
        }
        
}