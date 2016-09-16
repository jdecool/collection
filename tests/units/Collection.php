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
     * @dataProvider getKeysDataProvider
     */
    public function testKeys($items, $expected)
    {
        $this
            ->if($this->newTestedInstance($items))
            ->then
               ->object($this->testedInstance->keys())
                    ->isInstanceOf('JDecool\Collection\Collection')
                    ->isEqualTo($expected)
        ;
    }

    public function getKeysDataProvider()
    {
        return [
            [[], new TestedClass()],
            [['foo' => 'bar', 'john' => 'doe'], new TestedClass(['foo', 'john'])],
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

    /**
     * @dataProvider getContainsDataProvider
     */
    public function testContains($items, $search, $expected)
    {
        $this
            ->if($this->newTestedInstance($items))
            ->then
                ->boolean($this->testedInstance->contains($search))
                    ->isEqualTo($expected)
        ;
    }

    public function getContainsDataProvider()
    {
        return [
            [[], '', false],
            [['foo' => 'bar'], 'foo', false],
            [['foo' => 'bar'], 'bar', true],
            [['foo', 'bar'], 'foo', true],
            [['foo', 'bar'], 'bar', true],
            [['foo', 'bar'], 'toto', false],
        ];
    }

    /**
     * @dataProvider getHasDataProvider
     */
    public function testHas($items, $key, $expected)
    {
        $this
            ->if($this->newTestedInstance($items))
            ->then
                ->boolean($this->testedInstance->has($key))
                    ->isEqualTo($expected)
        ;
    }

    public function getHasDataProvider()
    {
        return [
            [[], '', false],
            [['foo' => 'bar'], 'foo', true],
            [['foo' => 'bar'], 'bar', false],
            [['foo', 'bar'], 'foo', false],
            [['foo', 'bar'], 'bar', false],
            [['foo', 'bar'], 0, true],
            [['foo', 'bar'], 1, true],
        ];
    }

    /**
     * @dataProvider getIsEmptyDataProvider
     */
    public function testIsEmpty($items, $expected)
    {
        $this
            ->if($this->newTestedInstance($items))
            ->then
                ->boolean($this->testedInstance->isEmpty())
                    ->isEqualTo($expected)
        ;
    }

    public function getIsEmptyDataProvider()
    {
        return [
            [[], true],
            [['foo' => 'bar'], false],
            [['foo', 'bar'], false],
        ];
    }

    public function testFilter()
    {
        $this
            ->if($this->newTestedInstance([0, 1, 2, 3]))
            ->then
                ->object($this->testedInstance->filter(function($item) {
                    return $item >= 2;
                }))
                    ->isInstanceOf('JDecool\Collection\Collection')
                    ->isEqualTo(new TestedClass([2 => 2, 3 => 3]))

            ->if($this->newTestedInstance(['a', 'b', 'c', 'd']))
            ->then
                ->object($this->testedInstance->filter(function($item) {
                    return in_array($item, ['a', 'd']);
                }))
                    ->isInstanceOf('JDecool\Collection\Collection')
                    ->isEqualTo(new TestedClass([0 => 'a', 3 => 'd']))
        ;
    }

    /**
     * @dataProvider getFirstDataProvider
     */
    public function testFirst($items, $callback, $expected)
    {
        $this
            ->if($this->newTestedInstance($items))
            ->then
                ->variable($this->testedInstance->first($callback))
                    ->isIdenticalTo($expected)
        ;
    }

    public function getFirstDataProvider()
    {
        $dataSet = [];

        // first value without callback
        $dataSet[] = [
            [0, 1, 2, 3, 1],
            null,
            0,
        ];

        // first value with callback
        $dataSet[] = [
            [0, 1, 2, 1, 3],
            function($item) { return $item == 1; },
            1,
        ];

        // search for first value corresponding to parameter
        $dataSet[] = [
            [['a' => '1', 'foo' => 'a'], ['a' => '2', 'foo' => 'b'], ['a' => '3', 'foo' => 'c'], ['a' => '4', 'foo' => 'b']],
            function($item) { return $item['foo'] == 'b'; },
            ['a' => '2', 'foo' => 'b'],
        ];

        return $dataSet;
    }

    /**
     * @dataProvider getLastDataProvider
     */
    public function testLast($items, $callback, $expected)
    {
        $this
            ->if($this->newTestedInstance($items))
            ->then
               ->variable($this->testedInstance->last($callback))
                    ->isIdenticalTo($expected)
        ;
    }

    public function getLastDataProvider()
    {
        $dataSet = [];

        // last value without callback
        $dataSet[] = [
            [0, 1, 2, 3, 4],
            null,
            4,
        ];

        // last value with callback
        $dataSet[] = [
            [0, 1, 2, 3, 4],
            function($item) { return $item == 1; },
            1,
        ];

        // search for last value corresponding to parameter
        $dataSet[] = [
            [['a' => '1', 'foo' => 'a'], ['a' => '2', 'foo' => 'b'], ['a' => '3', 'foo' => 'c'], ['a' => '4', 'foo' => 'b']],
            function($item) { return $item['foo'] == 'b'; },
            ['a' => '4', 'foo' => 'b'],
        ];

        return $dataSet;
    }

    /**
     * @dataProvider getFlipDataProvider
     */
    public function testFlip($items, $expected)
    {
        $this
            ->if($this->newTestedInstance($items))
            ->then
                ->object($this->testedInstance->flip())
                    ->isInstanceOf('JDecool\Collection\Collection')
                    ->isEqualTo($expected)
        ;
    }

    public function getFlipDataProvider()
    {
        return [
            [
                ['foo' => 'bar', 'john' => 'doe'],
                new TestedClass(['bar' => 'foo', 'doe' => 'john']),
            ],
            [
                [10, 20, 30, 40],
                new TestedClass([10 => 0, 20 => 1, 30 => 2, 40 => 3]),
            ],
        ];
    }

    /**
     * @dataProvider getGetDataProvider
     */
    public function testGet($items, $key, $expected)
    {
        $this
            ->if($this->newTestedInstance($items))
            ->then
                ->variable($this->testedInstance->get($key))
                    ->isEqualTo($expected)
        ;
    }

    public function getGetDataProvider()
    {
        return [
            [
                ['foo' => 'bar', 'john' => 'doe'],
                'foo',
                'bar'
            ],
            [
                ['foo' => 'bar', 'john' => 'doe'],
                'myKey',
                null
            ],
            [
                [10, 20, 30, 40],
                0,
                10
            ],
        ];
    }

    public function testArrayAccess()
    {
        $this
            ->if($this->newTestedInstance(['foo' => 'bar', 'john' => 'doe']))
            ->then
                ->string($this->testedInstance['foo'])
                    ->isEqualTo('bar')
                ->string($this->testedInstance['john'])
                    ->isEqualTo('doe')
        ;
    }

    public function testCountable()
    {
        $this
            ->if($this->newTestedInstance([]))
            ->then
                ->integer(count($this->testedInstance))
                    ->isEqualTo(0)

            ->if($this->newTestedInstance(['foo' => 'bar', 'john' => 'doe']))
            ->then
               ->integer(count($this->testedInstance))
                    ->isEqualTo(2)
        ;
    }

    public function testJsonSerializable()
    {
        $this
            ->if($this->newTestedInstance(['foo' => 'bar', 'john' => 'doe']))
            ->then
                ->string(json_encode($this->testedInstance))
                    ->isEqualTo('{"foo":"bar","john":"doe"}')

            ->given(
                $obj = new \mock\JsonSerializable(),
                $obj->getMockController()->jsonSerialize = function () { return ['john' => 'doe']; }
            )
            ->if($this->newTestedInstance(['foo' => 'bar', 'users' => $obj]))
            ->then
                ->string(json_encode($this->testedInstance))
                    ->isEqualTo('{"foo":"bar","users":{"john":"doe"}}')
        ;
    }

    public function testReduce()
    {
        $this
            ->if($this->newTestedInstance([0, 1, 2, 3]))
            ->then
                ->integer($this->testedInstance->reduce('JDecool\Collection\Tests\Units\sum'))
                    ->isEqualTo(6)
                ->integer($this->testedInstance->reduce(function ($carry, $item) {
                    return $carry + $item;
                }))
                    ->isEqualTo(6)
                ->integer($this->testedInstance->reduce(function ($carry, $item) {
                    return $carry + $item;
                }, 15))
                    ->isEqualTo(21)

            ->if($this->newTestedInstance([
                [
                    'note'  => 5,
                    'coeff' => 1,
                ],
                [
                    'note'  => 8,
                    'coeff' => 2,
                ],
            ]))
            ->then
                ->integer($this->testedInstance->reduce(function ($carry, $item) {
                    return $carry + $item['note'];
                }))
                    ->isEqualTo(13)
        ;
    }
}

function sum($carry, $item)
{
    return $carry + $item;
}
