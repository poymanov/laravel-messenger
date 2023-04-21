<?php

namespace App\Services\ChatMessageStatus\Repositories;

use App\Models\ChatMessageStatus;
use App\Services\ChatMessageStatus\Contracts\ChatMessageStatusNotReadCountDtoFactoryContract;
use App\Services\ChatMessageStatus\Contracts\ChatMessageStatusRepositoryContract;
use App\Services\ChatMessageStatus\Dtos\ChatMessageStatusCreateDto;
use App\Services\ChatMessageStatus\Dtos\ChatMessageStatusNotReadCountDto;
use Illuminate\Support\Facades\DB;

class ChatMessageStatusRepository implements ChatMessageStatusRepositoryContract
{
    public function __construct(private readonly ChatMessageStatusNotReadCountDtoFactoryContract $chatMessageStatusNotReadCountDtoFactory)
    {
    }

    /**
     * @inheritDoc
     */
    public function create(ChatMessageStatusCreateDto $dto): void
    {
        $model             = new ChatMessageStatus();
        $model->chat_id    = $dto->chatId->value();
        $model->message_id = $dto->messageId->value();
        $model->user_id    = $dto->userId;
        $model->saveOrFail();
    }

    /**
     * @param int $userId
     *
     * @return ChatMessageStatusNotReadCountDto[]
     */
    public function getNotReadChatsCountByUserId(int $userId): array
    {
        $counts = DB::table('chat_message_statuses')
            ->select(['chat_id', DB::raw('COUNT(*) as count')])
            ->groupBy(['chat_id'])
            ->where(['user_id' => $userId])->get();

        return $this->chatMessageStatusNotReadCountDtoFactory->createFromObjects($counts);
    }
}
