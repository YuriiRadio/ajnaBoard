<?php

namespace app\modules\user;

use Yii;
use yii\filters\AccessControl;

/**
 * user module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'app\modules\user\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }

    public function behaviors() {
        parent::behaviors();

        return [
            'access' => [
                'class' => AccessControl::className(),
                //'only' => ['login', 'logout', 'signup'],
                'rules' => [
//                    [
//                        'allow' => true,
//                        'actions' => ['login', 'signup'],
//                        'roles' => ['?'],
//                    ],
                    [
                        'allow' => true,
                        //'actions' => ['logout', 'index'],
                        'roles' => ['@'],
//                        'matchCallback' => function ($rule, $action) {
//                            return Yii::$app->user->identity->isAdmin();
//                        }
                    ],
                ],
            ],
        ];
    }
}
