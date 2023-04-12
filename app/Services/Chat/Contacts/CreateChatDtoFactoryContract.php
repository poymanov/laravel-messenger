<?php

namespace App\Services\Chat\Contacts;

use App\Services\Chat\Dtos\CreateChatDto;

interface CreateChatDtoFactoryContract
{
    /**
     * @param int $creator
     * @param int $member
     *
     * @return CreateChatDto
     */
    public function createFromParams(int $creator, int $member): CreateChatDto;
}
