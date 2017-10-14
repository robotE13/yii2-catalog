<?php

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
            if(!isset($app->i18n->translations['robote13/catalog']))
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
}
