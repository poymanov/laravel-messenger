<?php

namespace App\Services\Chat\Services;

use App\Services\Chat\Contacts\ChatRepositoryContract;
use App\Services\Chat\Contacts\ChatServiceContract;
use App\Services\Chat\Dtos\ChatDto;
use App\Services\Chat\Dtos\CreateChatDto;
use App\Services\Chat\Dtos\DeleteChatDto;
use App\Services\Chat\Exceptions\ChatNotFoundByIdException;
use App\Services\Chat\Exceptions\CreateChatUserNotFoundException;
use App\Services\Chat\Exceptions\DeleteChatNotMemberException;
use App\Services\ChatUser\Contracts\ChatUserServiceContract;
use App\Services\Users\Contracts\UserServiceContract;
use Illuminate\Support\Facades\DB;
use MichaelRubel\ValueObjects\Collection\Complex\Uuid;
use Throwable;

class ChatService implements ChatServiceContract
{
    public function __construct(
        private readonly UserServiceContract $userService,
        private readonly ChatUserServiceContract $chatUserService,
        private readonly ChatRepositoryContract $chatRepository
    ) {
    }

    /**
     * @inheritDoc
     */
    public function create(CreateChatDto $createChatDto): Uuid
    {
        // Если не существует создатель
        if (!$this->userService->isExistsById($createChatDto->creatorId)) {
            throw new CreateChatUserNotFoundException($createChatDto->creatorId);
        }

        // Если не существует участник
        if (!$this->userService->isExistsById($createChatDto->memberId)) {
            throw new CreateChatUserNotFoundException($createChatDto->memberId);
        }

        // Если чат уже создан
        $chatId = $this->chatUserService->findChatIdByMemberIds(
            $createChatDto->creatorId,
            $createChatDto->memberId
        );

        if ($chatId) {
            return $chatId;
        }

        DB::beginTransaction();

        try {
            // Создание чата
            $chatId = $this->chatRepository->create();

            // Создание участников чата
            $this->chatUserService->create($createChatDto->creatorId, $chatId);
            $this->chatUserService->create($createChatDto->memberId, $chatId);

            DB::commit();
        } catch (Throwable $e) {
            DB::rollBack();
            throw $e;
        }

        return $chatId;
    }

    /**
     * @inheritDoc
     */
    public function delete(DeleteChatDto $dto): void
    {
        // Если чат не существует
        if (!$this->chatRepository->isExistsById($dto->chatId)) {
            throw new ChatNotFoundByIdException($dto->chatId);
        }

        // Если пользователь - не участник чата
        if (!$this->chatUserService->isChatMember($dto->userId, $dto->chatId)) {
            throw new DeleteChatNotMemberException($dto->chatId, $dto->userId);
        }

        $this->chatRepository->delete($dto->chatId);
    }

    /**
     * @inheritDoc
     */
    public function getById(Uuid $id): ChatDto
    {
        return $this->chatRepository->getById($id);
    }

    /**
     * @param Uuid  $chatId
     * @param array $chats
     *
     * @return array|null
     */
    public function getCurrentChatFromChats(Uuid $chatId, array $chats): ?array
    {
        foreach ($chats as $chat) {
            if ($chat['chat_id'] === $chatId->value()) {
                return $chat;
            }
        }

        return null;
    }

    /**
     * @inheritDoc
     */
    public function isExistsById(Uuid $id): bool
    {
        return $this->chatRepository->isExistsById($id);
    }
}
