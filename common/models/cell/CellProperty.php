<?php

namespace common\models\cell;

use backend\controllers\CellAjaxController;
use Yii;
use common\models\cell\CellPropertySearch;
use common\models\cell\CellPropertyEnum;
use common\models\cell\CellPropertyValue;
use backend\components\ContentHelper;
use common\models\images\ImagesForm;
use kartik\file\FileInput;
use yii\helpers\Html;

/**
 * This is the model class for table "cell_property".
 *
 * @property integer $id
 * @property string $name
 * @property string $code
 * @property integer $active
 * @property integer $sort
 * @property string $default_value
 * @property string $property_type
 * @property string $own
 * @property integer $multiple
 * @property integer $filtrable
 * @property integer $required
 * @property integer $description
 *
 * @property CellPropertyEnum[] $cellPropertyEnums
 * @property CellPropertyValue[] $cellPropertyValues
 */
class CellProperty extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cell_property';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['active', 'sort', 'cell_id', 'multiple', 'filtrable', 'required', 'description'], 'integer'],
            [['name', 'code'], 'string', 'max' => 32],
            [['default_value'], 'string', 'max' => 256],
            [['property_type'], 'string', 'max' => 3],
            [['own'], 'string', 'max' => 10],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'code' => 'Символьный код',
            'active' => 'Активность',
            'sort' => 'Сортировка',
            'default_value' => 'Значение по умолчанию',
            'property_type' => 'Тип свойства',
            'own' => 'Владелец',
            'multiple' => 'Множественное',
            'filtrable' => 'В фильтр',
            'required' => 'Обязательное',
            'description' => 'Использовать описание',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCellPropertyEnums()
    {
        return $this->hasMany(CellPropertyEnum::className(), ['property_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCellPropertyValues()
    {
        return $this->hasMany(CellPropertyValue::className(), ['property_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCellItem()
    {
        return $this->hasOne(CellItem::className(), ['id' => 'cell_id']);
    }


    /*
     *
     */
    public function getPropertyTab($type, $cellID)
    {
        $searchModel = new CellPropertySearch($type, $cellID);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index-property', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'type' => $type,
        ]);
    }
    
    /*
     * 
     */
    public function getTypeArray() {
        $types = [
            'S' => "Строка",
            'L' => "Список",
            'B' => "Да/Нет",
            'T' => "Время",
            'F' => "Файл",
            'H' => "Html-текст",
            'LS' => "Привязка к разделу",
            'LE' => "Привязка к элементу",
        ];

        return $types;
    }

    /*
     *
     */

    public function getListEnumArea($propEnum) {
        $row = '<div class="list-enum-area">
                    <h3>Варианты значений списка</h3>
                    <div class="row center">
                        <div class="col-md-3">Символьный код</div>
                        <div class="col-md-6">Название</div>
                        <div class="col-md-3">По умолчанию</div>
                    </div>
                    <div id="list-row-data">';
        $i = 0;
                            //dump($propEnum, true);
        if(is_array($propEnum)) {
            foreach ($propEnum as $enumModel) {
                $enumAttr = $enumModel->getAttributes();
                $checked = ($enumAttr['by_default'] > 0) ? 'checked' : '';
                $row .= CellPropertyEnum::getEditRowEnum($i, $enumAttr, $checked);
                $i++;
            }
        } elseif($propEnum->code != '') {
            $enumAttr = $propEnum->getAttributes();
            $checked = ($enumAttr['by_default'] > 0) ? 'checked' : '';
            $row .= CellPropertyEnum::getEditRowEnum($i, $enumAttr, $checked);
            $i++;
        }
        $end = $i + 3;
        for($i ; $i < $end; $i++) {
            $row .= '<div class="row">
                         <input type="hidden" name="property-enum['.$i.'][id]" value="0" />
                         <div class="col-md-3">
                            <input type="text" name="property-enum['.$i.'][code]" class="number-input" />
                         </div>
                         <div class="col-md-6">
                            <input type="text" name="property-enum['.$i.'][name]" class="text-input" />
                         </div>
                         <div class="col-md-3 center">
                            <input type="checkbox" name="property-enum['.$i.'][by_default]" value="1" class="by_default" />
                         </div>
                     </div>';
        }
        $row .= '</div>
                <div class="row center">
                    <input type="hidden" name="rows-count" value="'.$i.'" />
                    <a href="" id="more-enum-button" class="btn btn-default"> Ещё </a>
                </div>';
        $row .= '</div>';

        return $row;
    }
    
    /*
     * 
     */

    static function getEditRowTextProperty($arProp, $valModel) {
        // dump($valModel);
        if($arProp['multiple'] > 0) { // свойство множественное
            $printValue = [];
            if(is_array($valModel)) {
                foreach($valModel as $model) {
                    $printValue[$model->multi_id] = $model;
                }
                foreach($printValue as $m_key=>$value) {
                    self::showTextRow($arProp, $m_key, $value);
                    $i = $m_key + 1;
                }
            }
            $end = $i + 3;
            for($i ; $i < $end; $i++) {
                self::showTextRow($arProp, $i);
            }
        } else { // свойство одиночное
            if(is_array($valModel)) $value = $valModel[0];
            else $value = $valModel;
            if(is_object($value)) {
                $value->value = ($value->value != '') ? $value->value : $arProp['default_value'];
            } else {
                $value = new CellPropertyValue();
                $value->value = $arProp['default_value'];
            }
            self::showTextRow($arProp, false, $value );
        }
    }

    private function showTextRow($arProp, $m_key=false, $valModel=false) {
        if($arProp['property_type'] == 'S') {
            $row = '<div class="property-input">
                        <input type="text" name="properties[' . $arProp['id'] . ']#sub#" value="#printValue#" class="text-input" />
                    </div>';
        } elseif($arProp['property_type'] == 'H') {
            $row = '<div class="property-input html-row">
                        <textarea name="properties['.$arProp['id'].']#sub#" class="html-text" >#printValue#</textarea>
                    </div>';
        } elseif($arProp['property_type'] == 'T') {
            $row = '<div class="property-input">
                        <input type="text" name="properties[' . $arProp['id'] . ']#sub#" value="#printValue#" class="text-input datepicker" />
                    </div>';
        }
        $sub = ($m_key !== false) ? '['.$m_key.']' : '';
        if($valModel->value !=0) {
            $value = ($arProp['property_type'] == 'T') ? date('d-m-Y', $valModel->value) : $valModel->value;
        }
        $printRow = str_replace('#sub#', $sub , $row );
        $printRow = str_replace('#printValue#', $value , $printRow );
        echo $printRow;
        echo self::getDescriptionField($arProp, $valModel, $sub);
    }

    private function getDescriptionField($arProp, $modelValue, $sub){
        $desc = '<div class="description-block">
                    <input type="text" name="desc['.$arProp['id'].']#sub#" value="#printDescription#" placeholder="Описание" />
                </div>';
        if($arProp['description'] > 0) {
            $description = $modelValue->description;
            $printDescr = str_replace('#sub#', $sub , $desc );
            $printDescr = str_replace('#printDescription#', $description , $printDescr );
        }
        return $printDescr;
    }

    static function getEditRowListProperty($arProp, $valModel, $enums){
        if($arProp['multiple'] > 0) {
            $printValue = [];
            if(is_array($valModel)) {
                foreach($valModel as $model) {
                    $printValue[$model->multi_id] = $model;
                }
                foreach($printValue as $m_key=>$value) {
                    $keySelect = self::getDefaultListValue($value->value, $enums);
                    self::showListRow($arProp, $valModel[$m_key], $enums, $keySelect, $m_key);
                    $i = $m_key + 1;
                }
                $end = $i + 3;
                for($i ; $i < $end; $i++) {
                    self::showListRow($arProp, $valModel, $enums, false, $i);
                }
            }
        } else {
            $value = $valModel[0]->value;
            $keySelect = self::getDefaultListValue($value, $enums);
            self::showListRow($arProp, $valModel[0], $enums, $keySelect);
        }

    }

    private function getDefaultListValue($value, $enums) {
        if (count($enums) > 0) {
            $keySelect = 0;
            foreach ($enums as $enum) {
                if ($enum->code == $value) $keySelect = $enum->id;
            }
            if ($keySelect == 0) {
                foreach ($enums as $enum) {
                    if ($enum->by_default > 0) $keySelect = $enum->id;
                }
            }
        }
        return $keySelect;
    }

    private function showListRow($arProp, $valModel, $enums, $keySelect=false, $m_key=false) {
        $row = '<div class="property-input inline">
                    <select name="properties['. $arProp['id'] .']#sub#" class="select-input" />
                        <option value="">...</option>';
        if(count($enums)>0) {
            foreach ($enums as $enum) {
                $select = ($enum->id == $keySelect) ? 'selected' : '';
                $row .= '<option value="'.$enum->code.'" '.$select.'>'.$enum->name.'</option>';
            }
        }
        $sub = ($m_key !== false) ? '['.$m_key.']' : '';
        $printRow = str_replace('#sub#', $sub , $row );

        $printRow .= '</select></div>';
        echo $printRow;
// dump($valModel);
        echo self::getDescriptionField($arProp, $valModel, $sub);
    }

    public function getEditRowFileProperty($arProp, $valModel, $form) {
        $previewImg = [];
        // dump($valModel);
        if(is_array($valModel)) {
            foreach ($valModel as $value) {
                if ($value->value > 0) {
                    $src = FileHelper::getProductPath($value->value);
                    $previewImg[] = '<img src="/shop' . $src . '" class="property-file-thumb" />';;
                }
            }
        }
        $propertyImageModel = new ImagesForm();
        $propertyImageModel->$arProp['code'] = '';
        $num = $arProp['id'];

        $row = '<div class="property-input inline">';
        $row .= '<input type="hidden" name="properties['.$num.']" id="file-property-'.$num.'" />';
        $row .= $form->field($propertyImageModel, $arProp['code'])->widget(FileInput::classname(), [
            'attribute' => 'property_'.$arProp['code'].'[]',
            'options' => [
                'accept' => '*',
                'multiple'=>true,
            ],
            'pluginOptions' => [
                'uploadUrl' => \yii\helpers\Url::to('property-image-upload'),
                'uploadExtraData' => [
                    'type' => 'element',
                    'var' => $arProp['code'],
                ],
                'allowedFileExtensions' => ['jpg', 'png', 'gif'],
                'initialPreview' => $previewImg,
                'showUpload' => true,
                'showRemove' => false,
                'dropZoneEnabled' => false,

            ],
            'pluginEvents' => [
                'fileuploaded12' => 'function(event, data, previewId, index) {
                                              jQuery("#file-property-'.$num.'").val(data.response); 
                                              console.log("image"+ index +" = "+ data.response);
                                          }',
                'fileloaded' => 'function(event, file, previewId, index, reader) {
                                            console.log("fileloaded");
                                        }',
            ],
        ])->label(false);
        $row .= '</div>';

        echo $row;
    }

    public function getLinkSetting($arProp, $propEnums) {
        $enums = [];
        if(is_array($propEnums)) {
            foreach ($propEnums as $arEnum) {
                $enums[$arEnum->name] = $arEnum->code;
            }
        }
        $row = '<div class="list-enum-area">
                    <h3>Настройки источника данных</h3>
                    <div class="row">
                        <label class="col-md-3">Тип контента</label>';
        $cellTypesModels = CellType::find()->all();
        $cellTypesArray = [''=>'Выберите тип'];
        foreach($cellTypesModels as $model) {
            $cellTypesArray[$model->id] = $model->name;
        }
        // dump($cellTypesArray, true);
        $row .= Html::dropDownList('link-property-setting[cell-type]', $enums['cell-type'], $cellTypesArray, ['class'=>'select-input cell-type-select' ] );
        $row .= '</div>
                <div class="row">
                    <label class="col-md-3">Ячейка контента</label>
                    <span id="cell-item-container">';
        if($enums['cell-item'] > 0) {
            $itemList = CellAjaxController::getItemModels($enums['cell-type']);
            $row .= Html::dropDownList('link-property-setting[cell-item]', $enums['cell-item'], $itemList, ['class' => 'select-input', 'id' => 'cell-item-select']);
        }
        $row .= '</span></div>
                <div class="row">
                    <label class="col-md-3">Раздел контента</label>
                    <span id="cell-section-container">';
        if($enums['cell-item'] > 0) {
            $sectionList = CellAjaxController::getSectionModels($enums['cell-item']);
            if(is_array($sectionList)) {
                $row .= Html::dropDownList('link-property-setting[cell-section]', $enums['cell-section'], $sectionList, ['class' => 'select-input', 'id' => 'cell-section-select']);
            }
        }
        $row .= '</span></div>';
        $row .= '</div>';

        return $row;
    }

    static function getEditRowLinkProperty($arProp, $valModel) {

        if($arProp['multiple'] > 0) {
            $printValue = [];
            if(is_array($valModel)) {
                foreach($valModel as $model) {
                    $printValue[$model->multi_id] = $model;
                }
                foreach($printValue as $m_key=>$value) {
                    if($arProp['property_type'] == 'LS') self::showLSectionRow($arProp, $value, $m_key);
                    elseif($arProp['property_type'] == 'LE') self::showLElementRow($arProp, $value, $m_key);
                    $i = $m_key + 1;
                }
                $end = $i + 3;
                for($i ; $i < $end; $i++) {
                    if($arProp['property_type'] == 'LS') self::showLSectionRow($arProp, $valModel, $i);
                    elseif($arProp['property_type'] == 'LE') self::showLElementRow($arProp, $valModel, $i);
                }
            }
        } else {
            // dump($valModel);
            if($arProp['property_type'] == 'LS') self::showLSectionRow($arProp, $valModel[0]);
            elseif($arProp['property_type'] == 'LE') self::showLElementRow($arProp, $valModel[0]);
        }
    }

    /*
     *
     */
    public function savePost($model, $type){
        //получение моделей всех свойств типа записи
        $properties = CellProperty::find()
            ->where(['own' => $type, 'active' => 1])
            ->indexBy('id')
            ->all();

        $propertyIDs = array_keys($properties);
        $listPropertyIDs = [];
        foreach ($properties as $property) {
            if ($property['property_type'] == 'L') $listPropertyIDs[] = $property['id'];
        }

        // получение массива объектов значений свойств
        $propValue = CellPropertyValue::find()
            ->where(['property_id' => $propertyIDs, 'owner_id' => $model->id])
            ->indexBy('id')
            ->all();
        $result = [];
        foreach ($propValue as $val) {
            $result[$val->property_id][] = $val;
        }
        $propValue = $result;
        // dump($propValue, true);

        // получение массива всех значений вариантов списка
        /*$listEnums = CellPropertyEnum::find()
            ->where(['property_id' => $listPropertyIDs])
            ->all();
        $result = [];
        foreach ($listEnums as $Enum) {
            $result[$Enum['property_id']][] = $Enum;
        }
        $listEnums = $result;*/

        // формирование итогового массива с данными настроек свойства и его значениями
        $propData = [];
        foreach ($properties as $k => $property) {
            $propData[$k] = $property->getAttributes();
            $propData[$k]['value_model'] = $propValue[$k];
        }

        // получение новых пользовательских данных свойств и их описаний
        $postProperties = Yii::$app->request->post('properties');//dump($postProperties);die();
        $postDescriptions = Yii::$app->request->post('desc');
        if (count($postProperties) > 0) {//dump($_POST);die();
            //фомаирование массива с новыми даннми из POST
            $newData = [];
            foreach ($postProperties as $k => $postProp) {
                if (strpos($k, 'false_')) {
                    $k = str_replace('false_', '', $k);
                    $k = str_replace("'", '', $k);
                    $k = intval($k);
                    if (isset($newData[$k])) continue;
                }
                $newData[$k]['prop'] = $postProp;
                $newData[$k]['desc'] = $postDescriptions[$k];
            }
            // dump($newData);
            // dump($propData, true);

            //сохранение новых данныих
            foreach ($newData as $k => $data) {
                if ($propData[$k]['multiple'] > 0) {
                    foreach ($data['prop'] as $multi_k => $val) {
                        //self::savePropData($k, $model->id, $val, $data['desc'][$multi_k], $propData[$k]['value_model'][$multi_k], $multi_k);
                        self::savePropData($k, $model->id, $val, $data['desc'][$multi_k], $propData[$k], $multi_k);
                    }
                } else {
                    //self::savePropData($k, $model->id, $data['prop'], $data['desc'], $propData[$k]['value_model'][0]);
                    self::savePropData($k, $model->id, $data['prop'], $data['desc'], $propData[$k]);
                }
            } // die();
        }
    }

    private function savePropData($property_id, $owner_id, $value, $desc, $propData, $m_key=0 ) {
        //dump($valueModel, false, $property_id);
        if($propData['property_type'] == 'T') {
            $value = strtotime($value);
        }
        $valueModel = $propData['value_model'][$m_key];
        if( is_object($valueModel) ) {
            if($value != '' || $desc != '') {
                $valueModel->value = $value;
                $valueModel->description = $desc;
                $valueModel->save();
            } else {
                $valueModel->delete();
            }
        } else {
            if($value == '' && $desc == '') return;
            $valueModel = new CellPropertyValue();
            $valueModel->owner_id = $owner_id;
            $valueModel->property_id = $property_id;
            $valueModel->multi_id = $m_key;
            $valueModel->value = $value;
            $valueModel->description = $desc;
            $valueModel->save();
        }
    }


    /*
     *
     */
    private function showLSectionRow($arProp, $valModel, $m_key=false) {
        $row = '<div class="property-input inline">
                        <select name="properties['.$arProp['id'].']#sub#" class="select-input" />
                            <option value="">...</option>';
        $sectionTree = ContentHelper::getSectionTreeArray($arProp['cell_id']);
        $options = '';
        $printValue = $valModel->value;
        foreach($sectionTree as $section){
            $options .= ContentHelper::getOptionTag($section, $printValue);
        }
        $sub = ($m_key !== false) ? '['.$m_key.']' : '';
        $printRow = str_replace('#sub#', $sub , $row );
        $printRow .= $options;
        $printRow .= '</select></div>';
        echo $printRow;
        echo self::getDescriptionField($arProp, $valModel, $sub);
    }

    private function showLElementRow($arProp, $valModel, $m_key=false) {
        $inline = ($arProp['multiple'] > 0) ? '' : 'inline';
        $row = '<div class="property-input '.$inline.'">
                    <input type="text" name="properties['.$arProp['id'].']#sub#" class="number-input" value="#printDescription#" />
                    <a href="#find-element-form" class="fancybox add-element-button">...</a>
                    <span class="product-name">#productName#</span>
                </div>';
        $sub = ($m_key !== false) ? '['.$m_key.']' : '';
        $printRow = str_replace('#sub#', $sub , $row );
        $value = $valModel->value;
        $printRow = str_replace('#printDescription#', $value, $printRow);
        $productModel = CellElement::findOne($value);
        $productName = $productModel->name;
        $printRow = str_replace('#productName#', $productName, $printRow);

        echo $printRow;
        echo self::getDescriptionField($arProp, $valModel, $sub);
    }

}
