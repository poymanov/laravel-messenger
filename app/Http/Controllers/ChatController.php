<?php

namespace App\Http\Controllers;

use App\Http\Requests\Chat\StoreRequest;
use App\Services\Chat\Contacts\ChatServiceContract;
use App\Services\Chat\Contacts\ChatShowServiceContract;
use App\Services\Chat\Contacts\DeleteChatDtoFactoryContract;
use App\Services\Chat\Exceptions\ChatDataNotFoundByChatIdAndUserIdException;
use App\Services\Chat\Exceptions\ChatNotFoundByIdException;
use App\Services\Chat\Exceptions\DeleteChatNotMemberException;
use App\Services\Chat\Factories\CreateChatDtoFactory;
use App\Services\ChatMessage\Contracts\ChatMessageDtoFormatterContract;
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
        private readonly ChatMessageDtoFormatterContract $chatMessageDtoFormatter,
        private readonly ChatShowServiceContract $chatShowService,
        private readonly DeleteChatDtoFactoryContract $deleteChatDtoFactory
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

            $result            = $this->chatShowService->process($chatId, $authUserId);
            $messagesFormatted = $this->chatMessageDtoFormatter->fromArrayToArray($result->messages);

            return Inertia::render('Chat/Show', [
                'username'   => $result->chatData->userName,
                'avatar_url' => $result->chatData->avatarUrl,
                'messages'   => $messagesFormatted,
            ]);
        } catch (ChatNotFoundByIdException|ChatDataNotFoundByChatIdAndUserIdException) {
            return redirect(route('home'));
        } catch (Throwable $e) {
            Log::error($e->getMessage());
            throw $e;
        }
    }

    /**
     * @param string $id
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Foundation\Application|RedirectResponse|\Illuminate\Routing\Redirector
     * @throws ChatNotFoundByIdException
     * @throws DeleteChatNotMemberException
     * @throws Throwable
     */
    public function destroy(string $id)
    {
        try {
            $authUserId = $this->getAuthUserId(request());
            $chatId     = Uuid::make($id);

            $dto = $this->deleteChatDtoFactory->createFromParams($chatId, $authUserId);

            $this->chatService->delete($dto);

            return redirect(route('home'));
        } catch (ChatNotFoundByIdException|DeleteChatNotMemberException) {
            return redirect(route('home'));
        } catch (Throwable $e) {
            Log::error($e->getMessage());
            throw $e;
        }
    }
}
