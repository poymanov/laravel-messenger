<?php

namespace App\Services\ChatMessage\Services;

use App\Events\Chat\NewMessage;
use App\Services\Chat\Contacts\ChatServiceContract;
use App\Services\ChatMessage\Contracts\ChatMessageRepositoryContract;
use App\Services\ChatMessage\Contracts\ChatMessageServiceContract;
use App\Services\ChatMessage\Dtos\ChatMessageCreateDto;
use App\Services\ChatMessage\Dtos\ChatMessageDto;
use App\Services\ChatMessage\Exceptions\ChatMessageChatNotFoundByIdException;
use App\Services\ChatMessageStatus\Contracts\ChatMessageStatusCreateDtoFactoryContract;
use App\Services\ChatMessageStatus\Contracts\ChatMessageStatusServiceContract;
use App\Services\ChatUser\Contracts\ChatUserServiceContract;
use Illuminate\Broadcasting\BroadcastManager;
use Illuminate\Support\Facades\DB;
use MichaelRubel\ValueObjects\Collection\Complex\Uuid;
use Throwable;

class ChatMessageService implements ChatMessageServiceContract
{
    public function __construct(
        private readonly ChatServiceContract $chatService,
        private readonly ChatMessageRepositoryContract $chatMessageRepository,
        private readonly ChatMessageStatusCreateDtoFactoryContract $chatMessageStatusCreateDtoFactory,
        private readonly ChatMessageStatusServiceContract $chatMessageStatusService,
        private readonly ChatUserServiceContract $chatUserService,
        private readonly BroadcastManager $broadcastService
    ) {
    }

    /**
     * @inheritDoc
     */
    public function create(ChatMessageCreateDto $dto): Uuid
    {
        if (!$this->chatService->isExistsById($dto->chatId)) {
            throw new ChatMessageChatNotFoundByIdException($dto->chatId);
        }

        $messageId = $this->chatMessageRepository->create($dto);

        DB::beginTransaction();

        try {
            $chatMembers = $this->chatUserService->findChatMemberIds($dto->chatId);

            foreach ($chatMembers as $chatMember) {
                if ($chatMember === $dto->senderUserId) {
                    continue;
                }

                $createDto = $this->chatMessageStatusCreateDtoFactory->createFromParams($dto->chatId, $messageId, $chatMember);
                $this->chatMessageStatusService->create($createDto);
            }

            $this->broadcastService->event(new NewMessage($dto->chatId, $messageId))->toOthers();

            DB::commit();
        } catch (Throwable $e) {
            DB::commit();
            throw $e;
        }

        return $messageId;
    }

    /**
     * @inheritDoc
     */
    public function findAllByChatId(Uuid $chatId): array
    {
        return $this->chatMessageRepository->findAllByChatId($chatId);
    }

    /**
     * @inheritDoc
     */
    public function getOneById(Uuid $id): ChatMessageDto
    {
        return $this->chatMessageRepository->getOneById($id);
    }
}
