<?php

use function Eloquent\Phony\Kahlan\mock;

use Ellipse\Resolvable\Exceptions\ResolvingExceptionInterface;
use Ellipse\Resolvable\Exceptions\ParameterResolvingException;

describe('ParameterResolvingException', function () {

    beforeEach(function () {

        $parameter = mock(ReflectionParameter::class);

        $parameter->__toString->returns('parameter');

        $this->previous = mock([Throwable::class, ResolvingExceptionInterface::class])->get();

        $this->exception = new ParameterResolvingException($parameter->get(), $this->previous);

    });

    it('should implement ResolvingExceptionInterface', function () {

        expect($this->exception)->toBeAnInstanceOf(ResolvingExceptionInterface::class);

    });

    describe('->getPrevious()', function () {

        it('should return the previous exception', function () {

            $test = $this->exception->getPrevious();

            expect($test)->toBe($this->previous);

        });

    });

});
