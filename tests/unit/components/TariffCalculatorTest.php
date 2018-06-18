<?php
namespace tests\components;

use PHPUnit\Framework\TestResult;

class TariffCalculatorTest extends \Codeception\Test\Unit {

    private $calculator;

    public function setUp() {
        $this->calculator = new \app\components\calculator\TariffCalculator();

        parent::setUp();
    }

    /**
     * @dataProvider equalsData
     */
    public function testCalculation($params) {
        $this->assertEquals($this->calculator->getPrice($params->range), $params->total);
    }

    public function equalsData() {
        return [
            '0-1' => [
                'params' => (object)[
                    'range' => [0, 1],
                    'total' => 1,
                ],
            ],
            '2500-2501' => [
                'params' => (object)[
                    'range' => [2500, 2501],
                    'total' => 3,
                ],
            ],
            '3500-3501' => [
                'params' => (object)[
                    'range' => [3500, 3501],
                    'total' => 5,
                ],
            ],
            '5500-5501' => [
                'params' => (object)[
                    'range' => [5500, 5501],
                    'total' => 10,
                ],
            ],
            '0-7000' => [
                'params' => (object)[
                    'range' => [0, 7000],
                    'total' => 30500,
                ],
            ],
            '1500-4200' => [
                'params' => (object)[
                    'range' => [1500,4200],
                    'total' => 7500
                ],
            ],
        ];
    }

    /**
     * @dataProvider exceptionsData
     */
    public function testInvalidCalculationParameters($exception, array $range) {
        $this->expectException($exception);
        $this->calculator->getPrice($range);
    }

    public function exceptionsData() {
        return [
            ['yii\web\BadRequestHttpException', [-1, 4200]],
            ['yii\web\BadRequestHttpException', [1500, 7001]],
            ['yii\web\BadRequestHttpException', [1500, 1]],
            ['yii\web\BadRequestHttpException', [777, 777]],
        ];
    }
}