<?php

namespace common\models\product;

use Yii;
use backend\components\ProductHelper;
use common\models\product\ProductElement;
use yii\helpers\Url;
use kartik\file\FileInput;
use common\models\product\ImagesForm;
use common\components\FileHelper;

/**
 * This is the model class for table "product_property".
 *
 * @property integer $id
 * @property string $name
 * @property string $code
 * @property string $active
 * @property integer $sort
 * @property string $default_value
 * @property string $property_type
 * @property string $implement
 * @property string $multiple
 * @property string $filtrable
 * @property string $required
 * @property string $description
 *
 * @property ProductPropertyValue[] $productPropertyValues
 */
class ProductProperty extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_property';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sort'], 'integer'],
            [['name', 'code'], 'required'],
            [['name'], 'string', 'max' => 64],
            [['code'], 'string', 'max' => 32],
            [['active'], 'string', 'max' => 2],
            [['default_value'], 'string', 'max' => 256],
            [['implement'], 'string', 'max' => 10],
            [['property_type', 'multiple', 'filtrable', 'required', 'description'], 'string', 'max' => 3],
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
            'implement' => 'Свойство принадлежит',
            'multiple' => 'Множественное',
            'filtrable' => 'Используется в фильтре',
            'required' => 'Обязательное',
            'description' => 'Использовать описание',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductPropertyValues()
    {
        return $this->hasMany(ProductPropertyValue::className(), ['property_id' => 'id']);
    }

    static function getEditRowTextProperty($arProp, $valModel) {
        //dump($valModel);
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
                else  $value = $valModel;
            $value->value = ($value->value != '') ? $value->value : $arProp['default_value'];
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
        }
        $sub = ($m_key !== false) ? '['.$m_key.']' : '';
        $value = $valModel->value;
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

    private function showLSectionRow($arProp, $valModel, $m_key=false) {
        $row = '<div class="property-input inline">
                        <select name="properties['.$arProp['id'].']#sub#" class="select-input" />
                            <option value="">...</option>';
        $sectionTree = ProductHelper::getSectionTreeArray();
        $options = '';
        $printValue = $valModel->value;
        foreach($sectionTree as $section){
            $options .= ProductHelper::getOptionTag($section, $printValue);
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
        $productModel = ProductElement::findOne($value);
        $productName = $productModel->name;
        $printRow = str_replace('#productName#', $productName, $printRow);

        echo $printRow;
        echo self::getDescriptionField($arProp, $valModel, $sub);
    }
    
    public function getEditRowFileProperty($arProp, $valModel, $form) {
        $previewImg = [];
        // dump($valModel);
        foreach($valModel as $value) {
            if ($value->value > 0) {
                $src = FileHelper::getProductPath($value->value);
                $previewImg[] = '<img src="/shop' . $src . '" class="property-file-thumb" />';;
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



}
