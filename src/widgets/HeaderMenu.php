<?php


namespace nullref\fulladmin\widgets;


use yii\base\Widget;
use yii\helpers\Html;

class HeaderMenu extends Widget
{
    public $items;

    /**
     * @param $widget
     * @param $id
     * @return string
     */
    protected function getWigetHtml($widget, $id)
    {
        $content = '';
        if (is_string($widget)) {
            $content = $widget;
        }
        if (is_callable($widget)) {
            $content = call_user_func($widget);
        }
        return Html::tag('li', $content, [
            'id' => 'adminHeaderWiget' . $id,
        ]);
    }

    /**
     * @return string
     */
    public function run()
    {
        $content = [];
        foreach ($this->items as $key => $widget) {
            $content[$key] = $this->getWigetHtml($widget, $key);
        }
        return implode('', $content);
    }
}
