<?php

/**
 * This is the model class for table "profiles".
 *
 * The followings are the available columns in table 'profiles':
 * @property integer $id
 * @property string $firstname
 * @property string $lastname
 * @property integer $user_id
 * @property string $avatar
 */
class Profiles extends CActiveRecord
{
        
        public $avatar;


        /**
	 * Returns the static model of the specified AR class.
	 * @return Profiles the static model class
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
		return 'profiles';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id', 'required'),
			array('user_id', 'numerical', 'integerOnly'=>true),
			array('firstname, lastname', 'length', 'max'=>255),
                        array('avatar', 'file', 'types' => 'png, gif, jpg', 'allowEmpty' => true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, firstname, lastname, user_id', 'safe', 'on'=>'search'),
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
        
        public function behaviors() {
            return array(
                'bavatar' => array(
                    'class' => 'ext.ImageARBehavior',
                    'attribute' => 'avatar', // this must exist
                    'extension' => 'png, gif, jpg', // possible extensions, comma separated
                    'prefix' => 'img_',
                    'relativeWebRootFolder' => 'uploads/avatars', // this folder must exist
                    //'useImageMagick' => '/usr/bin', # I want to use imagemagick instead of GD, and
                    'formats' => array(
                        'thumb' => array(
                            'suffix' => '_thumb',
                            'process' => array('resize' => array(40, 40)),
                        ),
                        'large' => array(
                            'suffix' => '_full',
                        ),
                        'normal' => array(
                            'process' => array('resize' => array(96, 96)),
                        ),
                    ),
                    'defaultName' => 'default',
                )
            );
        }
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'firstname' => 'Firstname',
			'lastname' => 'Lastname',
			'user_id' => 'User',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('firstname',$this->firstname,true);
		$criteria->compare('lastname',$this->lastname,true);
		$criteria->compare('user_id',$this->user_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}