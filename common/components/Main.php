<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 13.05.2017
 * Time: 22:03
 */

namespace common\components;

use yii\base\BootstrapInterface;
use common\models\main\MainSettings;


class Main implements BootstrapInterface
{
    public function bootstrap($app)
    {
        $app->name = MainSettings::findOne(['code'=>'SiteName'])->value;
        $app->params['adminEmail'] = MainSettings::findOne(['code'=>'AdminEmail'])->value;
        //dump($app);
    }
}