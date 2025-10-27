<?php

declare(strict_types=1);

namespace WorkoutTracker\Domain\Model\Exercise;

use WorkoutTracker\Domain\Exception\DomainException;
use WorkoutTracker\Domain\Type\ExerciseId;

final class ExerciseList
{
    /** @var Exercise[] */
    private array $exercises;

    /**
     * @param Exercise[] $exercises
     */
    private function __construct(array $exercises)
    {
        foreach ($exercises as $exercise) {
            if (!$exercise instanceof Exercise) {
                throw new DomainException('エクササイズリストにはExerciseインスタンスのみを含めることができます');
            }
        }
        $this->exercises = $exercises;
    }

    /**
     * @param Exercise[] $exercises
     */
    public static function of(array $exercises): self
    {
        return new self($exercises);
    }

    public static function empty(): self
    {
        return new self([]);
    }

    public function add(Exercise $exercise): self
    {
        $exercises = $this->exercises;
        $exercises[] = $exercise;
        return new self($exercises);
    }

    public function findById(ExerciseId $exerciseId): ?Exercise
    {
        foreach ($this->exercises as $exercise) {
            if ($exercise->id()->equals($exerciseId)) {
                return $exercise;
            }
        }
        return null;
    }

    public function update(Exercise $exercise): self
    {
        $exercises = array_map(
            fn(Exercise $ex) => $ex->id()->equals($exercise->id()) ? $exercise : $ex,
            $this->exercises
        );
        return new self($exercises);
    }

    public function count(): int
    {
        return count($this->exercises);
    }

    /**
     * @return Exercise[]
     */
    public function all(): array
    {
        return $this->exercises;
    }

    public function totalSetCount(): int
    {
        $total = 0;
        foreach ($this->exercises as $exercise) {
            $total += $exercise->setCount();
        }
        return $total;
    }

    public function totalVolume(): float
    {
        $total = 0.0;
        foreach ($this->exercises as $exercise) {
            $total += $exercise->totalVolume();
        }
        return $total;
    }

    public function toArray(): array
    {
        return array_map(fn(Exercise $exercise) => $exercise->toArray(), $this->exercises);
    }
}

