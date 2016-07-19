<?php

namespace KoteUtils\Lazy\Generators;

/**
 * Returns generator of integers with optional step.
 *
 * @param int $start
 * @param int $end
 * @param int $step
 * @return \Generator
 * @throws \InvalidArgumentException
 */
function range($start, $end, $step = 1)
{
    if ($step < 0) {
        throw new \InvalidArgumentException("Step could not be negative.");
    }
    if ($start > $end) {
        throw new \InvalidArgumentException("Start could not be greater than end.");
    }
    for ($i = $start; $i <= $end; $i += $step) {
        yield $i;
    }
}

/**
 * Returns generator, that applies function $func to the results of
 * previous $func call. If $func called the first time, it applied
 * to $initial.
 *
 * @param callable $func
 * @param mixed $initial
 * @return \Generator
 */
function doWhile(callable $func, $initial = null)
{
    do {
        yield $initial;
    } while ($initial = $func($initial));
}

/**
 * Merges multiple generators into one generator.
 *
 * @param \Generator[] ...$generators
 * @return \Generator
 */
function merge(\Generator ...$generators)
{
    foreach ($generators as $generator) {
        foreach ($generator as $item) {
            yield $item;
        }
    }
}

/**
 * Returns generator that reads data from stream.
 *
 * @param resource $handle
 * @param int $buffer
 * @return \Generator
 */
function stream($handle, $buffer = 4096)
{
    while ($data = fread($handle, $buffer)) {
        yield $data;
    }
}
