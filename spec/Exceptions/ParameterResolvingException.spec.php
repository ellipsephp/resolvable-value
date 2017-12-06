<?php

use function Eloquent\Phony\Kahlan\mock;

use Ellipse\Resolvable\Exceptions\ResolvingExceptionInterface;
use Ellipse\Resolvable\Exceptions\ParameterResolvingException;

describe('ParameterResolvingException', function () {

    beforeEach(function () {

        $this->parameter = mock(ReflectionParameter::class);

        $delegate = mock([Throwable::class, ResolvingExceptionInterface::class])->get();

        $this->exception = new ParameterResolvingException($this->parameter->get(), $delegate);

    });

    it('should implement ResolvingExceptionInterface', function () {

        expect($this->exception)->toBeAnInstanceOf(ResolvingExceptionInterface::class);

    });

    describe('->parameter()', function () {

        it('should return the parameter', function () {

            $test = $this->exception->parameter();

            expect($test)->toBe($this->parameter->get());

        });

    });

});
