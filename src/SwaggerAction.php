<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */
namespace xutl\swagger;

use Yii;
use yii\base\Action;

/**
 * Class SwaggerAction
 * ~~~
 * public function actions()
 * {
 *     return [
 *         'index' => [
 *             'class' => 'xutl\swagger\SwaggerAction',
 *             'restUrl' => Url::to(['site/api'], true),
 *             'oauth'=>[
 *                  'clientId' => 'your-client-id',
 *                  'clientSecret' => 'your-client-secret-if-required',
 *                  'realm' => 'your-realms',
 *                  'appName' => 'your-app-name',
 *                  'scopeSeparator' => ' ',
 *                  'additionalQueryStringParams' => [],
 *             ]
 *         ]
 *     ];
 * }
 * ~~~
 * @package xutl\swagger
 */
class SwaggerAction extends Action
{
    /**
     * @var string The rest url configuration.
     */
    public $restUrl;

    /**
     * @var array The OAuth configuration
     */
    public $oauth = [];

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->controller->layout = false;
        if (empty($this->oauth)) {
            $this->oauth = [
                'clientId' => 'your-client-id',
                'clientSecret' => 'your-client-secret-if-required',
                'realm' => 'your-realms',
                'appName' => 'your-app-name',
                'scopeSeparator' => ' ',
                'additionalQueryStringParams' => [],
            ];
        }
    }

    /**
     * @return string
     */
    public function run()
    {
        return $this->controller->render($this->id, [
            'restUrl' => $this->restUrl,
            'oauthConfig' => $this->oauth,
        ]);
    }
}