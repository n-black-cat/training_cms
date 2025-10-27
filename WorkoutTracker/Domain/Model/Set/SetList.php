<?php

declare(strict_types=1);

namespace WorkoutTracker\Domain\Model\Set;

use WorkoutTracker\Domain\Exception\DomainException;

final class SetList
{
    /** @var Set[] */
    private array $sets;

    /**
     * @param Set[] $sets
     */
    private function __construct(array $sets)
    {
        foreach ($sets as $set) {
            if (!$set instanceof Set) {
                throw new DomainException('セットリストにはSetインスタンスのみを含めることができます');
            }
        }
        $this->sets = $sets;
    }

    /**
     * @param Set[] $sets
     */
    public static function of(array $sets): self
    {
        return new self($sets);
    }

    public static function empty(): self
    {
        return new self([]);
    }

    public function add(Set $set): self
    {
        $sets = $this->sets;
        $sets[] = $set;
        return new self($sets);
    }

    public function count(): int
    {
        return count($this->sets);
    }

    /**
     * @return Set[]
     */
    public function all(): array
    {
        return $this->sets;
    }

    public function totalVolume(): float
    {
        $total = 0.0;
        foreach ($this->sets as $set) {
            $total += $set->calculateVolume();
        }
        return $total;
    }

    public function maxWeight(): float
    {
        if (empty($this->sets)) {
            return 0.0;
        }
        $max = 0.0;
        foreach ($this->sets as $set) {
            $weight = $set->weight()->value();
            if ($weight > $max) {
                $max = $weight;
            }
        }
        return $max;
    }

    public function toArray(): array
    {
        return array_map(fn(Set $set) => $set->toArray(), $this->sets);
    }
}

