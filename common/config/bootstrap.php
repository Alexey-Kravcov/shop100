<?php
Yii::setAlias('@common', dirname(__DIR__));
Yii::setAlias('@frontend', dirname(dirname(__DIR__)) . '/frontend');
Yii::setAlias('@backend', dirname(dirname(__DIR__)) . '/backend');
Yii::setAlias('@console', dirname(dirname(__DIR__)) . '/console');

function dump($var, $d=false, $pref = 'Дамп') {
    echo $pref." - <pre>";
    print_r($var);
    echo"</pre>";
    if($d) die();
}

//\Yii::$app->name = \common\models\main\MainSettings::findOne(['code'=>'SiteName'])->getAttribute('value');
//dump(common\models\main\MainSettings::find()->where(['code'=>'SiteName'])->one() );