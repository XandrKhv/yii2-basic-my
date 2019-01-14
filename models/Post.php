<?php
/**
 * Created by PhpStorm.
 * User: XandrKhv
 * Date: 14.01.2019
 * Time: 16:41
 */

namespace app\models;

use yii\db\ActiveRecord;

class Post extends ActiveRecord
{

    public static function tableName()
    {
        return 'post';
    }
}