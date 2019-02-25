<?php
/**
 * @author Nurbek Nurjanov nurbek.nurjanov@mail.ru
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2018 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 */

namespace extended\vendor;

use yii\helpers\Html;


class Carousel extends \yii\bootstrap\Carousel
{
    public function renderIndicators()
    {
        if ($this->showIndicators === false)
            return '';

        $indicators = [];
        for ($i = 0, $count = count($this->items); $i < $count; $i++) {
            $options = ['data-target' => '#' . $this->options['id'], 'data-slide-to' => $i];
            if ($i === 0)
                Html::addCssClass($options, 'active');
            $indicators[] = Html::tag('li', $this->items[$i]['indicatorContent'], $options);
        }

        $ol = Html::tag('ol', implode("\n", $indicators), ['class' => 'carousel-indicators']);
        return Html::tag("div",  $ol, ['class'=>'wrap-indicators',]);
    }

    public function run()
    {
        $this->registerPlugin('carousel');
        return implode("\n", [
                Html::beginTag('div', $this->options),
                $this->renderItems(),
                $this->renderControls(),
                $this->renderIndicators(),
                Html::endTag('div')
            ]) . "\n";
    }
}