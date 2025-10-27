<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use WorkoutTracker\App\UseCase\AddExercise\AddExerciseUseCase;
use WorkoutTracker\App\UseCase\AddExercise\AddExerciseUseCaseParam;
use WorkoutTracker\App\UseCase\CreateWorkoutSession\CreateWorkoutSessionUseCase;
use WorkoutTracker\App\UseCase\CreateWorkoutSession\CreateWorkoutSessionUseCaseParam;
use WorkoutTracker\App\UseCase\GetWorkoutHistory\GetWorkoutHistoryUseCase;
use WorkoutTracker\App\UseCase\GetWorkoutHistory\GetWorkoutHistoryUseCaseParam;
use WorkoutTracker\App\UseCase\RecordSet\RecordSetUseCase;
use WorkoutTracker\App\UseCase\RecordSet\RecordSetUseCaseParam;
use WorkoutTracker\Domain\Repository\WorkoutSessionRepository;
use WorkoutTracker\Domain\Type\WorkoutSessionId;
use WorkoutTracker\Infra\LocalStorage\FileLocalStorage;
use WorkoutTracker\Infra\Repository\LocalStorageWorkoutSessionRepository;

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

function createRepository(): WorkoutSessionRepository
{
    $storageDir = __DIR__ . '/../storage';
    $storage = new FileLocalStorage($storageDir);
    return new LocalStorageWorkoutSessionRepository($storage);
}

function sendResponse(bool $success, $data = null, ?string $error = null): void
{
    echo json_encode([
        'success' => $success,
        'data' => $data,
        'error' => $error,
    ], JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR);
    exit;
}

try {
    $input = json_decode(file_get_contents('php://input'), true, 512, JSON_THROW_ON_ERROR);
    $action = $input['action'] ?? null;

    if (!$action) {
        sendResponse(false, null, 'アクションが指定されていません');
    }

    $repository = createRepository();

    switch ($action) {
        case 'createSession':
            $useCase = new CreateWorkoutSessionUseCase($repository);
            $param = new CreateWorkoutSessionUseCaseParam($input['memo'] ?? null);
            $result = $useCase->execute($param);
            sendResponse(true, $result->toArray());
            break;

        case 'addExercise':
            $useCase = new AddExerciseUseCase($repository);
            $param = new AddExerciseUseCaseParam(
                $input['sessionId'] ?? '',
                $input['exerciseName'] ?? '',
                $input['memo'] ?? null
            );
            $result = $useCase->execute($param);
            sendResponse(true, $result->toArray());
            break;

        case 'recordSet':
            $useCase = new RecordSetUseCase($repository);
            $param = new RecordSetUseCaseParam(
                $input['sessionId'] ?? '',
                $input['exerciseId'] ?? '',
                (float)($input['weight'] ?? 0),
                (int)($input['reps'] ?? 0),
                $input['memo'] ?? null
            );
            $result = $useCase->execute($param);
            sendResponse(true, $result->toArray());
            break;

        case 'getHistory':
            $useCase = new GetWorkoutHistoryUseCase($repository);
            $param = new GetWorkoutHistoryUseCaseParam((int)($input['limit'] ?? 30));
            $result = $useCase->execute($param);
            sendResponse(true, $result->toArray());
            break;

        case 'finishSession':
            $sessionId = WorkoutSessionId::of($input['sessionId'] ?? '');
            $session = $repository->findById($sessionId);
            if ($session === null) {
                sendResponse(false, null, 'セッションが見つかりません');
            }
            $finishedSession = $session->finish();
            $repository->save($finishedSession);
            sendResponse(true, ['session' => $finishedSession->toArray()]);
            break;

        default:
            sendResponse(false, null, '不明なアクション: ' . $action);
    }
} catch (\InvalidArgumentException $e) {
    sendResponse(false, null, $e->getMessage());
} catch (\RuntimeException $e) {
    sendResponse(false, null, $e->getMessage());
} catch (\LogicException $e) {
    sendResponse(false, null, $e->getMessage());
} catch (\Throwable $e) {
    error_log($e->getMessage());
    error_log($e->getTraceAsString());
    sendResponse(false, null, 'サーバーエラーが発生しました');
}

