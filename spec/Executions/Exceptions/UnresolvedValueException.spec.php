<?php

use function Eloquent\Phony\Kahlan\mock;

use Ellipse\Resolvable\Exceptions\ResolvingExceptionInterface;
use Ellipse\Resolvable\Executions\Exceptions\UnresolvedValueException;

describe('UnresolvedValueException', function () {

    it('should implement ResolvingExceptionInterface', function () {

        $test = new UnresolvedValueException;

        expect($test)->toBeAnInstanceOf(ResolvingExceptionInterface::class);

    });

});
