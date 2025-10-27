<?php

declare(strict_types=1);

namespace WorkoutTracker\Domain\Model\Exercise;

use WorkoutTracker\Domain\Model\Set\Set;
use WorkoutTracker\Domain\Model\Set\SetList;
use WorkoutTracker\Domain\Type\ExerciseId;
use WorkoutTracker\Domain\Type\ExerciseName;
use WorkoutTracker\Domain\Type\Memo;

final class Exercise
{
    private ExerciseId $id;
    private ExerciseName $name;
    private SetList $sets;
    private Memo $memo;

    private function __construct(
        ExerciseId $id,
        ExerciseName $name,
        SetList $sets,
        Memo $memo
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->sets = $sets;
        $this->memo = $memo;
    }

    public static function create(ExerciseName $name, ?Memo $memo = null): self
    {
        return new self(
            ExerciseId::generate(),
            $name,
            SetList::empty(),
            $memo ?? Memo::empty()
        );
    }

    public static function of(
        string $id,
        string $name,
        array $sets,
        ?string $memo
    ): self {
        $setObjects = array_map(
            fn(array $setData) => Set::of(
                $setData['id'],
                $setData['weight'],
                $setData['reps'],
                $setData['memo'] ?? null,
                $setData['completedAt']
            ),
            $sets
        );

        return new self(
            ExerciseId::of($id),
            ExerciseName::of($name),
            SetList::of($setObjects),
            Memo::of($memo)
        );
    }

    public function id(): ExerciseId
    {
        return $this->id;
    }

    public function name(): ExerciseName
    {
        return $this->name;
    }

    public function sets(): SetList
    {
        return $this->sets;
    }

    public function memo(): Memo
    {
        return $this->memo;
    }

    public function addSet(Set $set): self
    {
        return new self(
            $this->id,
            $this->name,
            $this->sets->add($set),
            $this->memo
        );
    }

    public function setCount(): int
    {
        return $this->sets->count();
    }

    public function totalVolume(): float
    {
        return $this->sets->totalVolume();
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id->value(),
            'name' => $this->name->value(),
            'sets' => $this->sets->toArray(),
            'memo' => $this->memo->value(),
            'setCount' => $this->setCount(),
            'totalVolume' => $this->totalVolume(),
            'maxWeight' => $this->sets->maxWeight(),
        ];
    }
}

