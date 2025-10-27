<?php

declare(strict_types=1);

namespace WorkoutTracker\Infra\LocalStorage;

/**
 * SimpleUuid - UUID生成の簡易実装
 * ramsey/uuidが使えない場合のフォールバック
 */
class SimpleUuid
{
    public static function uuid4(): self
    {
        return new self();
    }

    public function toString(): string
    {
        return sprintf(
            '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0x0fff) | 0x4000,
            mt_rand(0, 0x3fff) | 0x8000,
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff)
        );
    }
}

