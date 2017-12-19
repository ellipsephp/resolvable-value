<?php

use Ellipse\Resolvable\Exceptions\ResolvingExceptionInterface;
use Ellipse\Resolvable\Executions\Exceptions\ExecutionFailedException;

describe('ExecutionFailedException', function () {

    it('should implement ResolvingExceptionInterface', function () {

        $test = new ExecutionFailedException;

        expect($test)->toBeAnInstanceOf(ResolvingExceptionInterface::class);

    });

});
