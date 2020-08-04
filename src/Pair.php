<?php


namespace Kojirock5260\TddExample;


class Pair
{
    private string $from;
    private string $to;

    /**
     * Pair constructor.
     * @param string $from
     * @param string $to
     */
    public function __construct(string $from, string $to)
    {
        $this->from = $from;
        $this->to   = $to;
    }

    /**
     * @param Pair $obj
     * @return bool
     */
    public function equals(Pair $obj): bool
    {
        return $this->from === $obj->from && $this->to === $obj->to;
    }

    /**
     * @return int
     */
    public function hashCode(): int
    {
        return 0;
    }
}