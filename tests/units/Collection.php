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

    /**
     * @dataProvider getMapDataProvider
     */
    public function testMap($items, $callback, $expected)
    {
        $this
            ->if($this->newTestedInstance($items))
            ->then
                ->object($this->testedInstance->map($callback))
                    ->isInstanceOf('JDecool\Collection\Collection')
                    ->isEqualTo($expected)
        ;
    }

    public function getMapDataProvider()
    {
        $dataSet = [];

        // empty collection
        $dataSet[] = [
            [],
            function ($item) { return '1'; },
            new TestedClass(),
        ];

        // Simple function callback
        $dataSet[] = [
            ['foo', 'bar'],
            function ($item) { return str_rot13($item); },
            new TestedClass(['sbb', 'one']),
        ];

        // Simple function callback with associative array
        $dataSet[] = [
            ['fkey' => 'foo', 'bkey' => 'bar'],
            function ($item) { return str_rot13($item); },
            new TestedClass(['fkey' => 'sbb', 'bkey' => 'one']),
        ];

        // PHP function callback
        $dataSet[] = [
            ['foo', 'bar'],
            'str_rot13',
            new TestedClass(['sbb', 'one']),
        ];

        return $dataSet;
    }
}
