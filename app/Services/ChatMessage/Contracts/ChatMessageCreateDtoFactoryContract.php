<?php

namespace App\Services\ChatMessage\Contracts;

use App\Services\ChatMessage\Dtos\ChatMessageCreateDto;
use MichaelRubel\ValueObjects\Collection\Complex\Uuid;

interface ChatMessageCreateDtoFactoryContract
{
    /**
     * @param int    $senderUserId
     * @param Uuid   $chatId
     * @param string $text
     *
     * @return ChatMessageCreateDto
     */
    public function createFromParams(int $senderUserId, Uuid $chatId, string $text): ChatMessageCreateDto;
}
