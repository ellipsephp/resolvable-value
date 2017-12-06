<?php

use function Eloquent\Phony\Kahlan\mock;

use Psr\Container\ContainerExceptionInterface;

use Ellipse\Resolvable\Exceptions\ResolvingExceptionInterface;
use Ellipse\Resolvable\Executions\Exceptions\ClassResolvingException;

describe('ClassResolvingException', function () {

    it('should implement ResolvingExceptionInterface', function () {

        $delegate = mock([Throwable::class, ContainerExceptionInterface::class])->get();

        $test = new ClassResolvingException($delegate);

        expect($test)->toBeAnInstanceOf(ResolvingExceptionInterface::class);

    });

});
