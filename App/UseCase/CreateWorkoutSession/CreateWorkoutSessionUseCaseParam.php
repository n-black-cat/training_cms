<?php

declare(strict_types=1);

namespace WorkoutTracker\App\UseCase\CreateWorkoutSession;

final class CreateWorkoutSessionUseCaseParam
{
    private ?string $memo;

    public function __construct(?string $memo = null)
    {
        $this->memo = $memo;
    }

    public function memo(): ?string
    {
        return $this->memo;
    }
}

