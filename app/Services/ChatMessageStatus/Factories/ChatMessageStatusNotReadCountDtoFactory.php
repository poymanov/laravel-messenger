<?php

namespace App\Services\ChatMessageStatus\Factories;

use App\Services\ChatMessageStatus\Contracts\ChatMessageStatusNotReadCountDtoFactoryContract;
use App\Services\ChatMessageStatus\Dtos\ChatMessageStatusNotReadCountDto;
use Illuminate\Support\Collection;
use MichaelRubel\ValueObjects\Collection\Complex\Uuid;

class ChatMessageStatusNotReadCountDtoFactory implements ChatMessageStatusNotReadCountDtoFactoryContract
{
    /**
     * @inheritDoc
     */
    public function createFromObject(object $chatMessageStatusCount): ChatMessageStatusNotReadCountDto
    {
        $dto = new ChatMessageStatusNotReadCountDto();
        $dto->chatId = Uuid::make($chatMessageStatusCount->chat_id); //@phpstan-ignore-line
        $dto->count = $chatMessageStatusCount->count; //@phpstan-ignore-line

        return $dto;
    }

    /**
     * @inheritDoc
     */
    public function createFromObjects(Collection $chatMessageStatusCounts): array
    {
        $dtos = [];

        foreach ($chatMessageStatusCounts as $chatMessageStatusCount) {
            $dtos[] = $this->createFromObject($chatMessageStatusCount);
        }

        return $dtos;
    }
}
