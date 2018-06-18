<?php
namespace app\components\calculator;

use yii\web\BadRequestHttpException;
use yii\base\Component;


class TariffCalculator extends Component {
    private static $_min = 0;
    private static $_max = 0;

    private $steps = [];

    /**
     * Получение данных тарифа
     * @return array
     */
    private function getTariffData() {
/*
        $result = \Yii::$app->db->createCommand('
            SELECT t.low,
                   t.high,
                   t.price
              FROM tariff t
             ORDER BY trs.low', [])->queryAll();
*/
        $result = \Yii::$app->params['tariff'] ?? null;
        if (!$result) {
            throw new \Exception("Tariff data not found", 500);
        }
        return $result;
    }

    private function loadTariff() {
        $rates = $this->getTariffData();
        $this->steps = [];
        foreach($rates as $rate) {
            list($low, $high, $price) = $rate;

            self::$_min = min(self::$_min, $low);
            self::$_max = max(self::$_max, $high);

            $step = new TariffRateStep($low, $high, $price);

            $this->steps[] = $step;
        }
    }

    public function getPrice(array $range) {

        $this->loadTariff();
        list($start, $end) = $range;

        if (($start < self::$_min) || ($end > self::$_max) || $start >= $end) {
            throw new BadRequestHttpException('Invalid calculation parameters', 400);
        }

        $result = 0;
        foreach($this->steps as $step) {
            $result += $step->getPrice($start, $end);
        }
        return $result;
    }
}