<?php

namespace App\Services\Chat\Services;

use App\Services\Chat\Contacts\ChatServiceContract;
use App\Services\Chat\Contacts\ChatShowProcessResultDtoFactoryContract;
use App\Services\Chat\Contacts\ChatShowServiceContract;
use App\Services\Chat\Exceptions\ChatDataNotFoundByChatIdAndUserIdException;
use App\Services\Chat\Exceptions\ChatNotFoundByIdException;
use App\Services\ChatMessage\Contracts\ChatMessageServiceContract;
use App\Services\ChatMessageStatus\Contracts\ChatMessageStatusServiceContract;
use App\Services\ChatUser\Contracts\ChatUserServiceContract;
use Inertia\ResponseFactory;
use MichaelRubel\ValueObjects\Collection\Complex\Uuid;

class ChatShowService implements ChatShowServiceContract
{
    public function __construct(
        private readonly ChatServiceContract $chatService,
        private readonly ChatMessageServiceContract $chatMessageService,
        private readonly ChatUserServiceContract $chatUserService,
        private readonly ChatMessageStatusServiceContract $chatMessageStatusService,
        private readonly ChatShowProcessResultDtoFactoryContract $chatShowProcessResultDtoFactory,
        private readonly ResponseFactory $inertiaResponseService
    ) {
    }

    /**
     * @inheritDoc
     */
    public function process(Uuid $chatId, int $userId)
    {
        // Чат не существует
        if (!$this->chatService->isExistsById($chatId)) {
            throw new ChatNotFoundByIdException($chatId);
        }

        $currentChatData = $this->chatUserService->findOneChatByChatIdAndUserId($chatId, $userId);

        // Ошибка получения данных по чату
        if (is_null($currentChatData)) {
            throw new ChatDataNotFoundByChatIdAndUserIdException($chatId, $userId);
        }

        // Сделать все сообщения чата прочитанными
        $this->makeChatMessagesRead($chatId, $userId);

        // Получение всех сообщений чата
        $messages = $this->chatMessageService->findAllByChatId($chatId);

        return $this->chatShowProcessResultDtoFactory->createFromData($currentChatData, $messages);
    }

    /**
     * Сделать все сообщения чата прочитанными
     *
     * @param Uuid $chatId
     * @param int  $userId
     *
     * @return void
     */
    private function makeChatMessagesRead(Uuid $chatId, int $userId): void
    {
        $this->chatMessageStatusService->makeReadByChatIdAndUserId($chatId, $userId);

        $this->inertiaResponseService->share('currentChatId', $chatId->value());

        $chats = $this->inertiaResponseService->getShared('chats');

        $modifiedChats = [];

        foreach ($chats as $chat) {
            if ($chat['chat_id'] === $chatId->value()) {
                $chat['not_read'] = 0;
            }

            $modifiedChats[] = $chat;
        }

        $this->inertiaResponseService->share('chats', $modifiedChats);
    }
}
