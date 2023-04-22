<?php

namespace App\Services\Chat\Contacts;

use App\Services\Chat\Exceptions\ChatDataNotFoundByChatIdAndUserIdException;
use App\Services\Chat\Exceptions\ChatNotFoundByIdException;
use MichaelRubel\ValueObjects\Collection\Complex\Uuid;

interface ChatShowServiceContract
{
    /**
     * @param Uuid $chatId
     * @param int  $userId
     *
     * @return \App\Services\Chat\Dtos\ChatShowProcessResultDto
     * @throws ChatDataNotFoundByChatIdAndUserIdException
     * @throws ChatNotFoundByIdException
     */
    public function process(Uuid $chatId, int $userId);
}
