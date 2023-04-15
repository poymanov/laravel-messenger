<?php

namespace App\Services\ChatMessage\Repositories;

use App\Models\ChatMessage;
use App\Services\ChatMessage\Contracts\ChatMessageDtoFactoryContract;
use App\Services\ChatMessage\Contracts\ChatMessageRepositoryContract;
use App\Services\ChatMessage\Dtos\ChatMessageCreateDto;
use MichaelRubel\ValueObjects\Collection\Complex\Uuid;

class ChatMessageRepository implements ChatMessageRepositoryContract
{
    public function __construct(private readonly ChatMessageDtoFactoryContract $chatMessageDtoFactory)
    {
    }

    /**
     * @inheritDoc
     */
    public function create(ChatMessageCreateDto $dto): void
    {
        $chatMessage = new ChatMessage();
        $chatMessage->chat_id = $dto->chatId->value();
        $chatMessage->sender_user_id = $dto->senderUserId;
        $chatMessage->text = $dto->text;
        $chatMessage->saveOrFail();
    }

    /**
     * @inheritDoc
     */
    public function findAllByChatId(Uuid $chatId): array
    {
        $chatMessages = ChatMessage::whereChatId($chatId->value())->oldest('created_at')->get();

        return $this->chatMessageDtoFactory->createFromModels($chatMessages);
    }
}
