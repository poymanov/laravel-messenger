<?php

namespace App\Services\Chat\Contacts;

use App\Services\Chat\Dtos\DeleteChatDto;
use MichaelRubel\ValueObjects\Collection\Complex\Uuid;

interface DeleteChatDtoFactoryContract
{
    /**
     * @param Uuid $chatId
     * @param int  $userId
     *
     * @return DeleteChatDto
     */
    public function createFromParams(Uuid $chatId, int $userId): DeleteChatDto;
}
