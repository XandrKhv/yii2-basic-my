<?php
/**
 * Created by PhpStorm.
 * User: XandrKhv
 * Date: 14.01.2019
 * Time: 14:05
 */

namespace app\models;

use yii\db\ActiveRecord;

class Menu extends ActiveRecord
{

    public static function tableName()
    {
        return 'menu';
    }
}