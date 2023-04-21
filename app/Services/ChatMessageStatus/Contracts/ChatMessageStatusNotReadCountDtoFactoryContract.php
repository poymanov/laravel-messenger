<?php

namespace App\Services\ChatMessageStatus\Contracts;

use App\Services\ChatMessageStatus\Dtos\ChatMessageStatusNotReadCountDto;
use Illuminate\Support\Collection;

interface ChatMessageStatusNotReadCountDtoFactoryContract
{
    /**
     * @param object $chatMessageStatusCount
     *
     * @return ChatMessageStatusNotReadCountDto
     */
    public function createFromObject(object $chatMessageStatusCount): ChatMessageStatusNotReadCountDto;

    /**
     * @param Collection $chatMessageStatusCounts
     *
     * @return ChatMessageStatusNotReadCountDto[]
     */
    public function createFromObjects(Collection $chatMessageStatusCounts): array;
}
