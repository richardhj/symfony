<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\RateLimiter;

/**
 * @author Wouter de Jong <wouter@wouterj.nl>
 *
 * @experimental in 5.2
 */
final class Reservation
{
    private $timeToAct;
    private $limit;

    /**
     * @param float $timeToAct Unix timestamp in seconds when this reservation should act
     */
    public function __construct(float $timeToAct, Limit $limit)
    {
        $this->timeToAct = $timeToAct;
        $this->limit = $limit;
    }

    public function getTimeToAct(): float
    {
        return $this->timeToAct;
    }

    public function getWaitDuration(): float
    {
        return max(0, (-microtime(true)) + $this->timeToAct);
    }

    public function getLimit(): Limit
    {
        return $this->limit;
    }

    public function wait(): void
    {
        usleep($this->getWaitDuration() * 1e6);
    }
}
