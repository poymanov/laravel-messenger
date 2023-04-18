<?php

namespace App\Services\ChatMessageStatus\Contracts;

use App\Services\ChatMessageStatus\Dtos\ChatMessageStatusCreateDto;
use MichaelRubel\ValueObjects\Collection\Complex\Uuid;

interface ChatMessageStatusCreateDtoFactoryContract
{
    /**
     * @param Uuid $chatId
     * @param Uuid $messageId
     * @param int  $userId
     *
     * @return ChatMessageStatusCreateDto
     */
    public function createFromParams(Uuid $chatId, Uuid $messageId, int $userId): ChatMessageStatusCreateDto;
}
