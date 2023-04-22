<?php

namespace App\Http\Controllers;

use App\Http\Requests\Chat\StoreRequest;
use App\Services\Chat\Contacts\ChatServiceContract;
use App\Services\Chat\Factories\CreateChatDtoFactory;
use App\Services\ChatMessage\Contracts\ChatMessageDtoFormatterContract;
use App\Services\ChatMessage\Contracts\ChatMessageServiceContract;
use App\Services\ChatMessageStatus\Contracts\ChatMessageStatusServiceContract;
use App\Services\ChatUser\Contracts\ChatUserServiceContract;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Inertia\Response;
use MichaelRubel\ValueObjects\Collection\Complex\Uuid;
use Throwable;

class ChatController extends Controller
{
    public function __construct(
        private readonly ChatServiceContract $chatService,
        private readonly CreateChatDtoFactory $createChatDtoFactory,
        private readonly ChatMessageServiceContract $chatMessageService,
        private readonly ChatMessageDtoFormatterContract $chatMessageDtoFormatter,
        private readonly ChatUserServiceContract $chatUserService,
        private readonly ChatMessageStatusServiceContract $chatMessageStatusService
    ) {
    }

    /**
     * @param StoreRequest $request
     *
     * @return RedirectResponse
     * @throws Throwable
     * @throws \App\Services\Chat\Exceptions\CreateChatUserNotFoundException
     */
    public function store(StoreRequest $request): RedirectResponse
    {
        try {
            $creatorId = (int)auth()->id();
            $memberId  = (int)$request->get('user_id');

            $createChatDto = $this->createChatDtoFactory->createFromParams($creatorId, $memberId);

            $chatId = $this->chatService->create($createChatDto);

            return redirect(route('chats.show', $chatId));
        } catch (Throwable $e) {
            Log::error($e->getMessage());
            throw $e;
        }
    }

    /**
     * @param string $id
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Foundation\Application|RedirectResponse|\Illuminate\Routing\Redirector|Response
     * @throws Throwable
     */
    public function show(string $id)
    {
        try {
            $authUserId = $this->getAuthUserId(request());
            $chatId     = Uuid::make($id);

            if (!$this->chatService->isExistsById($chatId)) {
                return redirect(route('home'));
            }

            $currentChatData = $this->chatUserService->findOneChatByChatIdAndUserId($chatId, $authUserId);

            if (is_null($currentChatData)) {
                return redirect(route('home'));
            }

            $this->chatMessageStatusService->makeReadByChatIdAndUserId($chatId, $authUserId);

            Inertia::share('currentChatId', $chatId->value());

            $chats = Inertia::getShared('chats');

            $modifiedChats = [];

            foreach ($chats as $chat) {
                if ($chat['chat_id'] === $chatId->value()) {
                    $chat['not_read'] = 0;
                }

                $modifiedChats[] = $chat;
            }

            Inertia::share('chats', $modifiedChats);

            $messages          = $this->chatMessageService->findAllByChatId($chatId);
            $messagesFormatted = $this->chatMessageDtoFormatter->fromArrayToArray($messages);

            return Inertia::render('Chat/Show', [
                'username'   => $currentChatData->userName,
                'avatar_url' => $currentChatData->avatarUrl,
                'messages'   => $messagesFormatted,
            ]);
        } catch (Throwable $e) {
            Log::error($e->getMessage());
            throw $e;
        }
    }
}
