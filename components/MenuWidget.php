<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 10.01.2019
 * Time: 19:05
 */

namespace app\components;
use yii\base\Widget;
use app\models\Menu;
use Yii;


class MenuWidget extends Widget
{
    public $tpl;
    public $data;
    public $tree;
    public $menuHtml;

    public function init()
    {
        parent::init();

        if($this->tpl === null)
        {
            $this->tpl = 'menu';
        }
        $this->tpl .= '.php';
    }

    public function run()
    {
        $this->data = Yii::$app->cache->get('menu-cache');
        if(!$this->data) {
            $this->data = Menu::find()->indexBy('id')->orderBy(['position' => SORT_ASC])->asArray()->all();
            Yii::$app->cache->set('menu', $this->data, 86400);
        }
        $this->tree = $this->getTree();
        $this->menuHtml = $this->getMenuHtml($this->tree);

        return $this->menuHtml;
    }

    protected function getTree()
    {
        $tree = [];

        foreach ($this->data as $id=>&$node)
        {
            if(!$node['parent_id'])
            {
                $tree[$id] = &$node;
            } else {
                $this->data[$node['parent_id']]['childs'][$node['id']] = &$node;
            }
        }

        return $tree;
    }

    protected function getMenuHtml($tree)
    {
        $str = '';

        foreach ($tree as $menu)
        {
            $str .= $this->menuToTemplate($menu);
        }

        return $str;
    }
    protected function menuToTemplate($menu)
    {
        ob_start();
        include __DIR__ . '/menu_tpl/' . $this->tpl;

        return ob_get_clean();
    }
}