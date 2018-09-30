<?php
use common\models\main\MainSettings;
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
		'authManager' => [
			'class' => 'yii\rbac\DbManager',
			'defaultRoles' => ['guest'],
		],
    ],
	'bootstrap' => [
		'class'=> 'common\components\Main',
	],

	//'name' => MainSettings::findOne(['code'=>'SiteName'])->value,
];
