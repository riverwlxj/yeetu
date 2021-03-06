<?php

/**
 * This is the model class for table "{{answer}}".
 *
 * The followings are the available columns in table '{{answer}}':
 * @property string $id
 * @property string $question_id
 * @property string $content
 * @property string $user_id
 * @property string $create_time
 *
 */
class Answer extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Answer the static model class
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
		return '{{answer}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('content, user_id, create_time,question_id', 'required'),
			array('content', 'length', 'max'=>3000),
			array('user_id, create_time', 'length', 'max'=>11),
			array('shit_status','length','max'=>1),
			array('ding', 'length', 'max'=>6),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, content, user_id, create_time', 'safe', 'on'=>'search'),
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
            'user'=>array(self::BELONGS_TO,'User','user_id'),
            'question'=>array(self::BELONGS_TO,'Question','question_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'content' => '内容',
			'user_id' => '用户',
			'shit_status'=>'乱评论',
			'create_time' => '创建时间',
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('content',$this->content,true);
		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('create_time',$this->create_time,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
	
	public function beforeDelete()
	{
		if ((!empty($this->question->id)) && $this->question->best_id == $this->id) {
			$this->question->best_id = 0;
			if (Question::SOLVED == $this->question->status) {
				$this->question->status = Question::UNSOLVED;
			}
			$this->question->update();
		} 
		return parent::beforeDelete();
	}
	
	/**
	 * 
	 * 以问题的ids删除答案
	 * @param array $ids
	 */
	public function delete_by_quesionIds($ids)
	{
		if (!empty($ids)) {
			$ids = array_map('intval', (array) $ids);
			$this->deleteAll(' question_id IN (:ids) ', array(':ids' => implode(', ', $ids)));
		}
	}
}
