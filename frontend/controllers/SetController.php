<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace robote13\catalog\frontend\controllers;

/**
 * Description of SetController
 *
 * @author Tartharia
 */
class SetController extends \robote13\yii2components\web\FrontendControllerAbstract
{
    public function getModelClass()
    {
        return 'robote13\catalog\models\Set';
    }

    public function getSearchClass()
    {
        return 'robote13\catalog\forms\SetSearch';
    }

    public function actionView($id)
    {
        $this->findModelCallback = function ($query,$id){
            return $query->bySlug($id);
        };
        return parent::actionView($id);
    }
}
