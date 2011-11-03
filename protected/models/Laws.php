<?php

/**
 * This is the model class for table "laws".
 *
 * The followings are the available columns in table 'laws':
 * @property integer $id
 * @property string $title
 * @property string $desc
 * @property integer $user_id
 * @property integer $createtime
 * @property integer $approve
 * @property integer $cache_rate
 */
class Laws extends CActiveRecord {
    
    const MAIN_PAGE_RATE = 10;

    /**
     * Returns the static model of the specified AR class.
     * @return Laws the static model class
     */
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'laws';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('title, desc, user_id, createtime', 'required'),
            array('user_id, createtime, approve', 'numerical', 'integerOnly' => true),
            array('title', 'length', 'max' => 60),
            array('cache_rate', 'default', 'value' => 0),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, title, desc, user_id, createtime', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'owner' => array(self::BELONGS_TO, 'Users', 'user_id'),
            'rating' => array(self::STAT, 'Rating', 'law_id'),
			'isVote' => array(self::STAT, 'Rating', 'law_id', 'condition'=>'user_id=:user', 'params'=>array(':user'=>Yii::app()->user->id)),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'title' => 'Название',
            'desc' => 'Описание',
            'user_id' => 'User',
            'createtime' => 'Createtime',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('desc', $this->desc, true);
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('createtime', $this->createtime);

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }

    public function isEdited() {
        return ((Yii::app()->user->id == $this->user_id && !$this->approve) || Yii::app()->user->checkAccess('moderator'));
    }

}