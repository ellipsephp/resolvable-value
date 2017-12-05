<?php

use function Eloquent\Phony\Kahlan\stub;
use function Eloquent\Phony\Kahlan\mock;

use Psr\Container\ContainerInterface;

use Ellipse\Resolvable\ResolvedValueFactory;
use Ellipse\Resolvable\PartiallyResolvedValue;
use Ellipse\Resolvable\Executions\ExecutionInterface;
use Ellipse\Resolvable\Executions\ExecutionWithTypeHint;

describe('ExecutionWithTypeHint', function () {

    beforeEach(function () {

        $this->factory = mock(ResolvedValueFactory::class);
        $this->container = mock(ContainerInterface::class);
        $this->delegate = mock(ExecutionInterface::class);

        $this->execution = new ExecutionWithTypeHint(
            $this->factory->get(),
            $this->container->get(),
            $this->delegate->get()
        );

    });

    it('should implement ExecutionInterface', function () {

        expect($this->execution)->toBeAnInstanceOf(ExecutionInterface::class);

    });

    describe('->__invoke()', function () {

        beforeEach(function () {

            $this->resolvable = stub();

            $this->parameter = mock(ReflectionParameter::class);

            $this->tail = [
                mock(ReflectionParameter::class)->get(),
                mock(ReflectionParameter::class)->get(),
            ];

            $this->placeholders = ['p1', 'p2'];

        });

        context('when the parameter has a class type hint', function () {

            it('should proxy the factory with the instance retrieved with the container ->get() method', function () {

                $instance = new class {};

                $this->class = mock(ReflectionClass::class);

                $this->parameter->getClass->returns($this->class);

                $this->class->getName->returns('class');

                $this->container->get->with('class')->returns($instance);

                $resolved = new PartiallyResolvedValue($this->resolvable, $instance);

                $this->factory->__invoke
                    ->with($resolved, $this->tail, $this->placeholders)
                    ->returns('value');

                $test = ($this->execution)($this->resolvable, $this->parameter->get(), $this->tail, $this->placeholders);

                expect($test)->toEqual('value');

            });

        });

        context('when the parameters do not have a class type hint', function () {

            it('should proxy the delegate', function () {

                $this->parameter->getClass->returns(null);

                $this->delegate->__invoke
                    ->with($this->resolvable, $this->parameter, $this->tail, $this->placeholders)
                    ->returns('value');

                $test = ($this->execution)($this->resolvable, $this->parameter->get(), $this->tail, $this->placeholders);

                expect($test)->toEqual('value');

            });

        });

    });

});
