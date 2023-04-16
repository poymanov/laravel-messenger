<?php

namespace App\Services\ChatMessage\Contracts;

use App\Services\ChatMessage\Dtos\ChatMessageDto;

interface ChatMessageDtoFormatterContract
{
    /**
     * @param ChatMessageDto $dto
     *
     * @return array
     */
    public function toArray(ChatMessageDto $dto): array;

    /**
     * @param ChatMessageDto[] $dtos
     *
     * @return array
     */
    public function fromArrayToArray(array $dtos): array;

    /**
     * @param ChatMessageDto $dto
     *
     * @return array
     */
    public function toArrayByDate(ChatMessageDto $dto): array;
}
