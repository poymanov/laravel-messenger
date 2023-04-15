<?php

namespace App\Services\ChatMessage\Contracts;

use App\Services\ChatMessage\Dtos\ChatMessageCreateDto;
use App\Services\ChatMessage\Dtos\ChatMessageDto;
use App\Services\ChatMessage\Exceptions\ChatMessageNotFoundByIdException;
use MichaelRubel\ValueObjects\Collection\Complex\Uuid;
use Throwable;

interface ChatMessageRepositoryContract
{
    /**
     * @param ChatMessageCreateDto $dto
     *
     * @return Uuid
     * @throws Throwable
     */
    public function create(ChatMessageCreateDto $dto): Uuid;

    /**
     * @param Uuid $chatId
     *
     * @return ChatMessageDto[]
     */
    public function findAllByChatId(Uuid $chatId): array;

    /**
     * @param Uuid $id
     *
     * @return ChatMessageDto
     * @throws ChatMessageNotFoundByIdException
     */
    public function getOneById(Uuid $id): ChatMessageDto;
}
