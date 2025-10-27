<?php

declare(strict_types=1);

namespace WorkoutTracker\App\UseCase\AddExercise;

use WorkoutTracker\Domain\Repository\WorkoutSessionRepository;
use WorkoutTracker\Domain\Type\ExerciseName;
use WorkoutTracker\Domain\Type\Memo;
use WorkoutTracker\Domain\Type\WorkoutSessionId;
use WorkoutTracker\Domain\Model\Exercise\Exercise;

final class AddExerciseUseCase
{
    private WorkoutSessionRepository $repository;

    public function __construct(WorkoutSessionRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(AddExerciseUseCaseParam $param): AddExerciseUseCaseResult
    {
        $session = $this->repository->findById(WorkoutSessionId::of($param->sessionId()));
        if ($session === null) {
            throw new \RuntimeException('セッションが見つかりません');
        }

        if ($session->isFinished()) {
            throw new \LogicException('終了したセッションにはエクササイズを追加できません');
        }

        $exercise = Exercise::create(
            ExerciseName::of($param->exerciseName()),
            $param->memo() ? Memo::of($param->memo()) : null
        );

        $updatedSession = $session->addExercise($exercise);
        $this->repository->save($updatedSession);

        return new AddExerciseUseCaseResult($updatedSession, $exercise);
    }
}

