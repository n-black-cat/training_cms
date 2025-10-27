<?php

declare(strict_types=1);

namespace WorkoutTracker\App\UseCase\CreateWorkoutSession;

use WorkoutTracker\Domain\Model\WorkoutSession\WorkoutSession;
use WorkoutTracker\Domain\Repository\WorkoutSessionRepository;
use WorkoutTracker\Domain\Type\Memo;

final class CreateWorkoutSessionUseCase
{
    private WorkoutSessionRepository $repository;

    public function __construct(WorkoutSessionRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(CreateWorkoutSessionUseCaseParam $param): CreateWorkoutSessionUseCaseResult
    {
        $session = WorkoutSession::create(
            $param->memo() ? Memo::of($param->memo()) : null
        );

        $this->repository->save($session);

        return new CreateWorkoutSessionUseCaseResult($session);
    }
}

