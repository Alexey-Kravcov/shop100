<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 04.06.2017
 * Time: 18:58
 */

namespace common\components;

use yii\base\Module;
use common\cms\modules\Menu;

class CmsModule extends Module
{

    function __construct($id, $parent, array $config)
    {
        parent::__construct($id, $parent, $config);
    }

    /*
     * вставка cms-модуля
     */
    function insertModule($moduleName, $options) {
        $module = self::getModuleInstance($moduleName, $options);
        dump($module);
    }

    /*
     * редактирование параметров cms-модуля
     */
    function editModule($options) {

    }

    /*
     * получение объекта запрашиваемого cms-модуля
     */
    function getModuleInstance($moduleName, $options) {
        $arModules = [
                'menu' => 'common\cms\module\Menu',
                ];
        return new $arModules[$moduleName]($options);
    }

}