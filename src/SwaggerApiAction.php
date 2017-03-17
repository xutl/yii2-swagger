<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */
namespace xutl\swagger;

use Yii;
use yii\di\Instance;
use yii\base\Action;
use yii\caching\Cache;
use yii\helpers\Json;
use yii\web\Response;

/**
 * Class SwaggerApiAction
 * ~~~
 * public function actions()
 * {
 *     return [
 *         'api' => [
 *             'class' => 'xutl\swagger\SwaggerApiAction',
 *             'scanDir' => [
 *                 Yii::getAlias('@api/swagger'),
 *                 Yii::getAlias('@api/modules'),
 *                 ...
 *             ]
 *         ]
 *     ];
 * }
 * ~~~
 * @package xutl\swagger
 */
class SwaggerApiAction extends Action
{
    /**
     * @var string|array|\Symfony\Component\Finder\Finder The directory(s) or filename(s).
     * If you configured the directory must be full path of the directory.
     */
    public $scanDir;

    /**
     * @var array The options passed to `Swagger`, Please refer the `Swagger\scan` function for more information.
     */
    public $scanOptions = [];

    /**
     * @var Cache|string|null the cache object or the ID of the cache application component that is used to store
     * Cache the \Swagger\Scan
     */
    public $cache = 'cache';

    /**
     * @var string Cache key
     * [[cache]] must not be null
     */
    public $cacheKey = 'api-swagger-cache';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        if ($this->cache !== null) {
            $this->cache = Instance::ensure($this->cache, Cache::className());
        }
        $this->initCors();
    }

    /**
     * Init cors.
     */
    protected function initCors()
    {
        $headers = Yii::$app->getResponse()->getHeaders();
        $headers->set('Access-Control-Allow-Origin', '*');
        $headers->set('Access-Control-Allow-Methods', 'GET, POST, OPTIONS');
        $headers->set('Access-Control-Allow-Headers', 'DNT,X-CustomHeader,Keep-Alive,User-Agent,X-Requested-With,If-Modified-Since,Cache-Control,Content-Type');
    }

    /**
     * 执行操作
     * @return mixed|\Swagger\Annotations\Swagger
     */
    public function run()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if ($this->cache !== null) {
            if (($swagger = $this->cache->get($this->cacheKey)) === false) {
                $swagger = $this->getSwagger();
                $this->cache->set($this->cacheKey, $swagger, 3600);
            }
        } else {
            $swagger = $this->getSwagger();
        }
        Yii::$app->response->content = Json::encode($swagger);
        Yii::$app->end();
    }

    /**
     * Get swagger object
     *
     * @return \Swagger\Annotations\Swagger
     */
    protected function getSwagger()
    {
        return \Swagger\scan($this->scanDir, $this->scanOptions);
    }
}