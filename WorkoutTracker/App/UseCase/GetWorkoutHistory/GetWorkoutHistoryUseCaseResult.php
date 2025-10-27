<?php

declare(strict_types=1);

namespace WorkoutTracker\App\UseCase\GetWorkoutHistory;

use WorkoutTracker\Domain\Model\WorkoutSession\WorkoutSession;

final class GetWorkoutHistoryUseCaseResult
{
    /** @var WorkoutSession[] */
    private array $sessions;

    /**
     * @param WorkoutSession[] $sessions
     */
    public function __construct(array $sessions)
    {
        $this->sessions = $sessions;
    }

    /**
     * @return WorkoutSession[]
     */
    public function sessions(): array
    {
        return $this->sessions;
    }

    public function toArray(): array
    {
        return [
            'sessions' => array_map(fn(WorkoutSession $session) => $session->toArray(), $this->sessions),
            'count' => count($this->sessions),
        ];
    }
}

