<?php

use function Eloquent\Phony\Kahlan\mock;

use Psr\Container\ContainerExceptionInterface;

use Ellipse\Resolvable\Exceptions\ResolvingExceptionInterface;
use Ellipse\Resolvable\Executions\Exceptions\ClassResolvingException;

describe('ClassResolvingException', function () {

    beforeEach(function () {

        $this->previous = mock([Throwable::class, ContainerExceptionInterface::class])->get();

        $this->exception = new ClassResolvingException('class', $this->previous);

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
