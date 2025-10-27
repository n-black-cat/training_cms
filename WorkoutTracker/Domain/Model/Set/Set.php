<?php

declare(strict_types=1);

namespace WorkoutTracker\Domain\Model\Set;

use DateTimeImmutable;
use WorkoutTracker\Domain\Type\Memo;
use WorkoutTracker\Domain\Type\Reps;
use WorkoutTracker\Domain\Type\SetId;
use WorkoutTracker\Domain\Type\Weight;

final class Set
{
    private SetId $id;
    private Weight $weight;
    private Reps $reps;
    private Memo $memo;
    private DateTimeImmutable $completedAt;

    private function __construct(
        SetId $id,
        Weight $weight,
        Reps $reps,
        Memo $memo,
        DateTimeImmutable $completedAt
    ) {
        $this->id = $id;
        $this->weight = $weight;
        $this->reps = $reps;
        $this->memo = $memo;
        $this->completedAt = $completedAt;
    }

    public static function create(Weight $weight, Reps $reps, ?Memo $memo = null): self
    {
        return new self(
            SetId::generate(),
            $weight,
            $reps,
            $memo ?? Memo::empty(),
            new DateTimeImmutable()
        );
    }

    public static function of(
        string $id,
        float $weight,
        int $reps,
        ?string $memo,
        string $completedAt
    ): self {
        return new self(
            SetId::of($id),
            Weight::of($weight),
            Reps::of($reps),
            Memo::of($memo),
            new DateTimeImmutable($completedAt)
        );
    }

    public function id(): SetId
    {
        return $this->id;
    }

    public function weight(): Weight
    {
        return $this->weight;
    }

    public function reps(): Reps
    {
        return $this->reps;
    }

    public function memo(): Memo
    {
        return $this->memo;
    }

    public function completedAt(): DateTimeImmutable
    {
        return $this->completedAt;
    }

    public function calculateVolume(): float
    {
        return $this->weight->value() * $this->reps->value();
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id->value(),
            'weight' => $this->weight->value(),
            'reps' => $this->reps->value(),
            'memo' => $this->memo->value(),
            'completedAt' => $this->completedAt->format('c'),
            'volume' => $this->calculateVolume(),
        ];
    }
}

