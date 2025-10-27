<?php

declare(strict_types=1);

namespace WorkoutTracker\App\UseCase\CreateWorkoutSession;

use WorkoutTracker\Domain\Model\WorkoutSession\WorkoutSession;

final class CreateWorkoutSessionUseCaseResult
{
    private WorkoutSession $session;

    public function __construct(WorkoutSession $session)
    {
        $this->session = $session;
    }

    public function session(): WorkoutSession
    {
        return $this->session;
    }

    public function toArray(): array
    {
        return [
            'session' => $this->session->toArray(),
        ];
    }
}

