<?php

namespace JDecool\Collection\Tests\Units;

use atoum;
use JDecool\Collection\Collection as TestedClass;
use SplFixedArray;

class Collection extends atoum
{
    /**
     * @dataProvider getAllDataProvider
     */
    public function testAll($items, $expected)
    {
        $this
            ->if($this->newTestedInstance($items))
            ->then
                ->array($this->testedInstance->all())
                    ->isEqualTo($expected)
        ;
    }

    public function getAllDataProvider()
    {
        return [
            [[], []],
            [['foo' => 'bar'], ['foo' => 'bar']],
            [new TestedClass(['foo' => 'bar']), ['foo' => 'bar']],
            [SplFixedArray::fromArray(['foo', 'bar']), [0 => 'foo', 1 => 'bar']],
            ["foo bar", ["foo bar"]],
        ];
    }
}
