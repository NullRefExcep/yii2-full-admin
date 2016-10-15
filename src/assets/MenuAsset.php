<?php

namespace nullref\fulladmin\assets;

use yii\web\AssetBundle;

class MenuAsset extends AssetBundle
{
    public $sourcePath = '@nullref/admin/assets';
    public $css = [
        'css/side-sub-menu.css',
    ];
    public $js = [
        'js/submenu.js'
    ];
}