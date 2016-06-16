<?php

namespace Greenelf\Panel\libs;

use Greenelf\Panel\Link;

class dashboard
{

    public static $dashboardItems;

    public static $urls;

    public static function getItems()
    {
        if (!self::$dashboardItems) {
            self::$dashboardItems = self::create();
        }

        return self::$dashboardItems;
    }

    public static function create()
    {
        self::$urls = config('panel.panelControllers');

        $config = Link::allCached();
        $dashboard = array();

        $appHelper = new AppHelper();

        // Make Dashboard Items
        foreach ($config as $value) {

            $modelName = $value['url'];

            if (in_array($modelName, self::$urls)) {
                $model = "Greenelf\\Panel\\" . $modelName;
            } else {
                $model = $appHelper->getNameSpace() . $modelName;
            }

            $dashboard[] = array(
                'modelName' => $modelName,
                'title' => $value['display'],
                'count' => $model::count(),
                'showListUrl' => 'panel/' . $modelName . '/all',
                'addUrl' => 'panel/' . $modelName . '/edit',
            );
        }

        return $dashboard;
    }
}
