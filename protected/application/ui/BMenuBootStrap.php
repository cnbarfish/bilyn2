<?php

class BMenuBootStrap {

    public $menus = array();
    protected $rudeMenus = array();
    private $importDefaultMenus = false;

    public function __construct() {
        $this->init();
    }

    protected function init() {
        if ($this->importDefaultMenus) {
            Yii::app()->getController()->menu = $this->importMenus(FALSE, FALSE);
        } else {
            /*
            $this->menus['MainMenu'] = array(
                'items' => array(
                    array('label' => 'My Space', 'url' => array('site/index')),
                    array('label' => 'Service Map', 'url' => array('site/serviceMap')),
                    array('label' => 'logout(' . Yii::app()->user->name . ')',
                        'url' => array('/site/logout')))
            );
             * 
             */
        }
    }

    public function importMenus($pathAlias, $menuMetaFiles) {
        if ($menuMetaFiles != false) {
            if ($pathAlias != false && !Yii::getPathOfAlias($pathAlias)) {
                $rudeMenus = require(Yii::getPathOfAlias($pathAlias) . '/' . $menuMetaFiles);
                $this->importDefaultMenus = false;
            } else {
                $rudeMenus = require(Yii::getPathOfAlias('application.applicaiton.meta') . '/' . $menuMetaFiles);
                ;
            }
        } else {
            $rudeMenus = require(Yii::getPathOfAlias('application.application.meta') . '/siteMenus.php');
        }

        return $rudeMenus;
        //	$rudeMenus=require(Yii::getPathOfAlias('application.models').'/siteMenus.php');
        /*
          foreach ($rudeMenus as $name => $menu) {
          $this->menus[$name] = $menu;
          }
         * */
    }

    public function addAttributes(&$menu, $attributes) {
        foreach ($attributes as $name => $attribute) {
            $menu[$name] = $attribute;
        }
    }

    public function addMenuItems(&$menu, $menuItems) {
        foreach ($menuItems as $menuItem) {
            $this->addMenuItem($menu, $menuItem);
        }
    }

    public function addSubMenu(&$menu, $submenu) {
        addMenuItem($menu, $submenu);
    }

    public function addMenuItem(&$menu, $menuItem) {
        //  $items = $menu['items'];
        array_push($menu['items'], $menuItem);
    }

    public function findMenuItems(&$menu, $matchAttributes) {
        $matchItems = array();
        $items = $menu['items'];
        foreach ($items as &$item) {
            $flag = true;
            foreach ($matchAttributes as $key => $value) {
                if (!isset($item[$key]) || !$item[$key] == $value) {
                    $flag = false;
                    break;
                }
            }
            if ($flag) {
                array_push($matchItems, $item);
            }
        }
        return $matchItems;
    }

    public function setMenuItemAttributes(&$menu, $matchAttributes, $setAttributes) {
        $matchItems = $this->findMenuItems($menu, $matchAttributes);

        foreach ($matchItems as &$item) {
            $this->setAttributes($item, $setAttributes);
        }

        return false;
    }

    public function removeMenuItemAttributes(&$menu, $matchAttributes, $removeAttributes) {
        $matchItems = $this->findMenuItems($menu, $matchAttributes);

        foreach ($matchItems as &$item) {
            $this->unsetAttributes($item, $removeAttributes);
        }

        return false;
    }

    public function removeMenuItem($menu, $matchAttributes) {
        $matchItems = $this->findMenuItems($menu, $matchAttributes);

        foreach ($matchItems as &$item) {
            unset($item);
        }
        return false;
    }

    private function setAttributes(&$menuItem, $attributes) {
        foreach ($attributes as $key => $value) {
            $menuItem[$key] = $value;
        }
    }

    private function unsetAttributes(&$menuItem, $attributes) {
        foreach ($attributes as $key => $value) {
            unset($menuItem[$key]);
        }
    }

    public function addMenu($name, $menu) {
        yii::app()->getController()->menu[$name] = $menu;
    }

    public function getMenu($menuName) {

        $menu = yii::app()->getController()->menu[$menuName];
        $this->normalizeUrl($menu);
        $this->setActiveMenu($menu);
        return $menu;

        //return $menu;
    }

    protected function normalizeUrl(&$menu) {
        //$items = $menu['items'];

        foreach ($menu['items'] as &$item) {
            //$url = array();
            if (isset($item['url'])) {
                //array_push($url,$item['url']);
                $item['url'] = CHtml::normalizeUrl($item['url']);
            }
            if (isset($item['items'])) {
                $this->normalizeUrl($item);
            }
        }

        return $menu;
    }

    protected function setActiveMenu(&$menu) {
        $reqString = Yii::app()->getRequest()->getRequestUri();

        foreach ($menu['items'] as &$item) {
            if (isset($item['url'])) {
                $flag = strpos($reqString, $item['url']);
                if (is_int($flag) && $flag >= 0)
                    $item['active'] = TRUE;
                else
                    $item['active'] = FALSE;
            };
        }
    }

}
