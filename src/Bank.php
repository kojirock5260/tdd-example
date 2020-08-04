<?php


namespace Kojirock5260\TddExample;


class Bank
{
    private \ArrayIterator $rates;

    /**
     * Bank constructor.
     */
    public function __construct()
    {
        $this->rates = new \ArrayIterator();
    }

    /**
     * @param Expression $source
     * @param string $to
     * @return Money
     */
    public function reduce(Expression $source, string $to): Money
    {
        return $source->reduce($this, $to);
    }

    /**
     * @param string $from
     * @param string $to
     * @param int $rate
     */
    public function addRate(string $from, string $to, int $rate): void
    {
        $this->rates->offsetSet(serialize(new Pair($from, $to)), $rate);
    }

    /**
     * @param string $from
     * @param string $to
     * @return int
     */
    public function rate(string $from, string $to): int
    {
        if ($from === $to) {
            return 1;
        }

        return $this->rates->offsetGet(serialize(new Pair($from, $to)));
    }
}