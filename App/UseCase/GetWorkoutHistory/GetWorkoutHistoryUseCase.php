<?php

declare(strict_types=1);

namespace WorkoutTracker\App\UseCase\GetWorkoutHistory;

use WorkoutTracker\Domain\Repository\WorkoutSessionRepository;

final class GetWorkoutHistoryUseCase
{
    private WorkoutSessionRepository $repository;

    public function __construct(WorkoutSessionRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(GetWorkoutHistoryUseCaseParam $param): GetWorkoutHistoryUseCaseResult
    {
        $sessions = $this->repository->findRecent($param->limit());

        return new GetWorkoutHistoryUseCaseResult($sessions);
    }
}

