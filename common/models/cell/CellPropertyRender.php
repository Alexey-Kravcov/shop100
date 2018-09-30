<?php

namespace common\models\cell;

use common\models\cell\CellProperty;


class CellPropertyRender
{

    public function renderBlock($arProperties, $form) {

        extract($arProperties);
        //dump($arPropertyList, true);
        foreach($arPropertyList as $arProperty) {
            $arProp = $arProperty->getAttributes();
            $type = $arProp['property_type'];
            $valModel = $arPropValues[$arProp['id']];

            echo '<div class="property_item">';
            if($type == 'S' || $type == 'F' || $type == 'H' ) {
                echo '<div class="property_title">'.$arProp['name'].'</div>';
            } else {
                echo '<div class="property_title inline">'.$arProp['name'].'</div>';
            }

            // тип - строка
            if($type == "S") {
                CellProperty::getEditRowTextProperty($arProp, $valModel);
            }

            // тип - список
            if($type == "L") {
                $enums = $arEnums[$arProp['id']];
                CellProperty::getEditRowListProperty($arProp, $valModel, $enums);
            }

            // тип - да/нет
            if($type == "B") {
                $value = $valModel[0]->value;
                $checked = ($value > 0) ? 'checked' : '';
                $row .= '<div class="property-input inline">
                            <input type="checkbox" name="properties['.$arProp['id'].']" value="1" '.$checked.' />
                            <input type="hidden" name="properties[false_'.$arProp['id'].']" value="0"  />
                        </div>';
                echo $row;
            }

            // тип - строка
            if($type == "T") {
                CellProperty::getEditRowTextProperty($arProp, $valModel);
            }

            // тип - файл
            if($type == "F") {
                CellProperty::getEditRowFileProperty($arProp, $valModel, $form);
            }

            // тип - HTML текст
            if($type == "H") {
                CellProperty::getEditRowTextProperty($arProp, $valModel);
            }

            // тип - привязка к разделу
            if($type == "LS") {
                $row .= CellProperty::getEditRowLinkProperty($arProp, $valModel);
            }
/*
            // тип - привязка к элементу
            if($type == "LE") {
                $row .= ProductProperty::getEditRowLinkProperty($arProp, $valModel);
            }*/
            echo '</div>';
            //echo $row;
        }
    }

}