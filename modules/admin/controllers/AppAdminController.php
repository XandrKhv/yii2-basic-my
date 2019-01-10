<?php
/**
 * Created by PhpStorm.
 * User: XandrKhv
 * Date: 10.01.2019
 * Time: 11:40
 */

namespace app\modules\admin\controllers;

use yii\web\Controller;
use yii\filters\AccessControl;


class AppAdminController extends Controller
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

}