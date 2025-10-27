<?php

declare(strict_types=1);

namespace WorkoutTracker\Domain\Model\WorkoutSession;

use WorkoutTracker\Domain\Model\Exercise\Exercise;
use WorkoutTracker\Domain\Model\Exercise\ExerciseList;
use WorkoutTracker\Domain\Type\ExerciseId;
use WorkoutTracker\Domain\Type\Memo;
use WorkoutTracker\Domain\Type\WorkoutDate;
use WorkoutTracker\Domain\Type\WorkoutSessionId;

final class WorkoutSession
{
    private WorkoutSessionId $id;
    private WorkoutDate $startedAt;
    private ?WorkoutDate $finishedAt;
    private ExerciseList $exercises;
    private Memo $memo;

    private function __construct(
        WorkoutSessionId $id,
        WorkoutDate $startedAt,
        ?WorkoutDate $finishedAt,
        ExerciseList $exercises,
        Memo $memo
    ) {
        $this->id = $id;
        $this->startedAt = $startedAt;
        $this->finishedAt = $finishedAt;
        $this->exercises = $exercises;
        $this->memo = $memo;
    }

    public static function create(?Memo $memo = null): self
    {
        return new self(
            WorkoutSessionId::generate(),
            WorkoutDate::now(),
            null,
            ExerciseList::empty(),
            $memo ?? Memo::empty()
        );
    }

    public static function of(
        string $id,
        string $startedAt,
        ?string $finishedAt,
        array $exercises,
        ?string $memo
    ): self {
        $exerciseObjects = array_map(
            fn(array $exerciseData) => Exercise::of(
                $exerciseData['id'],
                $exerciseData['name'],
                $exerciseData['sets'],
                $exerciseData['memo'] ?? null
            ),
            $exercises
        );

        return new self(
            WorkoutSessionId::of($id),
            WorkoutDate::of($startedAt),
            $finishedAt !== null ? WorkoutDate::of($finishedAt) : null,
            ExerciseList::of($exerciseObjects),
            Memo::of($memo)
        );
    }

    public function id(): WorkoutSessionId
    {
        return $this->id;
    }

    public function startedAt(): WorkoutDate
    {
        return $this->startedAt;
    }

    public function finishedAt(): ?WorkoutDate
    {
        return $this->finishedAt;
    }

    public function exercises(): ExerciseList
    {
        return $this->exercises;
    }

    public function memo(): Memo
    {
        return $this->memo;
    }

    public function isFinished(): bool
    {
        return $this->finishedAt !== null;
    }

    public function addExercise(Exercise $exercise): self
    {
        return new self(
            $this->id,
            $this->startedAt,
            $this->finishedAt,
            $this->exercises->add($exercise),
            $this->memo
        );
    }

    public function updateExercise(Exercise $exercise): self
    {
        return new self(
            $this->id,
            $this->startedAt,
            $this->finishedAt,
            $this->exercises->update($exercise),
            $this->memo
        );
    }

    public function findExercise(ExerciseId $exerciseId): ?Exercise
    {
        return $this->exercises->findById($exerciseId);
    }

    public function finish(): self
    {
        if ($this->isFinished()) {
            throw new \LogicException('このセッションは既に終了しています');
        }
        return new self(
            $this->id,
            $this->startedAt,
            WorkoutDate::now(),
            $this->exercises,
            $this->memo
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id->value(),
            'startedAt' => $this->startedAt->toISOString(),
            'finishedAt' => $this->finishedAt?->toISOString(),
            'exercises' => $this->exercises->toArray(),
            'memo' => $this->memo->value(),
            'isFinished' => $this->isFinished(),
            'exerciseCount' => $this->exercises->count(),
            'totalSetCount' => $this->exercises->totalSetCount(),
            'totalVolume' => $this->exercises->totalVolume(),
        ];
    }
}

