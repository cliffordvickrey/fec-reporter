<?php

declare(strict_types=1);

namespace CliffordVickrey\FecReporter\Infrastructure\Contract;

use ArrayAccess;
use CliffordVickrey\FecReporter\Exception\FecOutOfBoundsException;
use CliffordVickrey\FecReporter\Infrastructure\Utility\CastingUtilities;
use Countable;
use Iterator;
use JetBrains\PhpStorm\Pure;

use function array_key_exists;
use function current;
use function is_int;
use function is_object;
use function is_string;
use function key;
use function next;
use function reset;

/**
 * @template TKey
 * @template TValue
 * @implements ArrayAccess<TKey, TValue>
 * @implements Iterator<TKey, TValue>
 */
abstract class AbstractCollection implements ArrayAccess, Countable, Iterator
{
    /** @var array<array-key, TValue> */
    protected array $data = [];

    /**
     * @return void
     */
    public function __clone(): void
    {
        $data = [];

        foreach ($this->data as $k => $v) {
            $data[$k] = is_object($v) ? (clone $v) : $v;
        }

        $this->data = $data;
    }

    /**
     * @param TKey $key
     * @return TValue|null
     */
    public function get(mixed $key): mixed
    {
        if ($this->offsetExists($key)) {
            return $this->offsetGet($key);
        }

        return null;
    }

    /**
     * @param TKey $offset
     * @return bool
     */
    #[Pure]
    public function offsetExists(mixed $offset): bool
    {
        return array_key_exists(self::normalizeOffset($offset), $this->data);
    }

    /**
     * @param mixed $offset
     * @return int|string
     */
    #[Pure]
    private static function normalizeOffset(mixed $offset): int|string
    {
        if (is_int($offset) || is_string($offset)) {
            return $offset;
        }

        return CastingUtilities::toString($offset);
    }

    /**
     * @param TKey $offset
     * @return TValue
     */
    public function offsetGet(mixed $offset): mixed
    {
        $normalizedOffset = self::normalizeOffset($offset);

        if (array_key_exists($normalizedOffset, $this->data)) {
            return $this->data[$normalizedOffset];
        }

        throw new FecOutOfBoundsException('Invalid offset');
    }

    /**
     * @return TValue
     */
    public function current(): mixed
    {
        $value = current($this->data);

        if (false === $value) {
            throw new FecOutOfBoundsException('Key is out of bounds');
        }

        return $value;
    }

    /**
     * @return void
     */
    public function next(): void
    {
        next($this->data);
    }

    /**
     * @return bool
     */
    #[Pure]
    public function valid(): bool
    {
        return null !== $this->key();
    }

    /**
     * @return string|int|null
     */
    public function key(): string|int|null
    {
        return key($this->data);
    }

    /**
     * @return void
     */
    public function rewind(): void
    {
        reset($this->data);
    }

    /**
     * @param TKey|null $offset
     * @param TValue $value
     * @return void
     */
    public function offsetSet(mixed $offset, mixed $value): void
    {
        if (null === $offset) {
            $this->data[] = $value;
            return;
        }

        $this->data[self::normalizeOffset($offset)] = $value;
    }

    /**
     * @param mixed $offset
     * @return void
     */
    public function offsetUnset(mixed $offset): void
    {
        unset($this->data[self::normalizeOffset($offset)]);
    }

    /**
     * @return int<0, max>
     */
    public function count(): int
    {
        return count($this->data);
    }
}
