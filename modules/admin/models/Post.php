<?php

namespace app\modules\admin\models;

use Yii;

/**
 * This is the model class for table "post".
 *
 * @property int $id
 * @property string $time_create
 * @property string $time_update
 * @property string $url
 * @property int $type_id
 * @property int $user_id
 * @property string $title
 * @property string $content
 * @property string $description
 * @property int $comments
 * @property string $img
 */
class Post extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'post';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['time_create', 'type_id', 'user_id', 'title', 'content', 'description', 'comments', 'img'], 'required'],
            [['time_create', 'url', 'time_update', 'img'], 'safe'],
            [['type_id', 'user_id', 'comments'], 'integer'],
            [['content'], 'string'],
            [['url', 'title', 'description'], 'string', 'max' => 255],
            [['img'], 'file', 'extensions' => 'png, jpg'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'time_create' => 'Time Create',
            'time_update' => 'Time Update',
            'url' => 'Url',
            'type_id' => 'Type ID',
            'user_id' => 'User ID',
            'title' => 'Title',
            'content' => 'Content',
            'description' => 'Description',
            'comments' => 'Comments',
            'img' => 'Img',
        ];
    }

    public function upload()
    {
        if($this->validate()){
            $newName = date('mdyGis') . '_' . md5(uniqid(rand(),true)) . '.' . $this->img->extension;
            $path = Yii::getAlias('@webroot') . '/files/Posts/' . $newName;
            $this->img->saveAs($path);
            return $newName;
        }else{
            return false;
        }
    }
}
