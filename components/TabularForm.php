<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace robote13\catalog\components;

use Yii;
use yii\base\Model;

/**
 * Description of TabularForm
 *
 * @author Tartharia
 */
class TabularForm extends \sidanval\tabular\TabularForm
{
    /**
     * @param array $data
     * @param null $formName
     * @return bool
     */
    public function load($data, $formName = null, $rootFormName = null)
    {
        $relation = $this->rootModel->getRelation($this->rootModelAttribute);
        $relationCLass = $relation->modelClass;
        $templateModel = Yii::createObject($relationCLass);
        //$templateModelPk = reset($templateModel->primaryKey());

        if($this->withRoot) {
            $this->rootModel->load($data, $rootFormName);
        }

        if($formName === null) {
            $formName = $templateModel->formName();
        }

        if(!isset($data[$formName])) {
            return false;
        }

        $parametersData = $data[$formName];
        $this->models = [];
        foreach ($parametersData as $index => $value) {
            $this->models[$index] = Yii::createObject($relationCLass);
        }
        Model::loadMultiple($this->models, Yii::$app->request->post());

        return true;
    }
}
