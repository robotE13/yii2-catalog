<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace robote13\catalog\frontend;

/**
 * Description of WithCategory
 *
 * @author Tartharia
 */
class WithCategory extends \robote13\yii2components\web\Modifier
{
    public function modify(\yii\base\Model $searchModel, \yii\data\ActiveDataProvider $dataProvider)
    {
        $slug = \Yii::$app->request->get('category');
        $category = \robote13\catalog\models\Category::find()->bySlug($slug)->one();
        if(empty($category))
        {
            throw new \yii\web\NotFoundHttpException('Page not found');
        }
        return compact('searchModel','dataProvider','category');
    }
}
