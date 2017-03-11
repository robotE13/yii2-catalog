<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace robote13\catalog;

/**
 * Description of Bootstrap
 *
 * @author Tartharia
 */
class Bootstrap implements \yii\base\BootstrapInterface
{
    public function bootstrap($app)
    {
        if($app instanceof \yii\web\Application)
        {
            $app->i18n->translations['robote13/catalog'] = [
                'class' => 'yii\i18n\PhpMessageSource',
                'sourceLanguage' => 'en-US',
                'basePath' => __DIR__ . '/messages',
                'fileMap'=>[
                    'robote13/catalog'=>'shop-catalog.php'
                ]
            ];
        }
    }
}
