<?php

namespace App\Http\Controllers;

use App\Http\Requests\Chat\StoreRequest;
use App\Services\Chat\Contacts\ChatServiceContract;
use App\Services\Chat\Exceptions\ChatNotFoundByIdException;
use App\Services\Chat\Factories\CreateChatDtoFactory;
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
        private readonly CreateChatDtoFactory $createChatDtoFactory
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
            $chatId = Uuid::make($id);

            $chat            = $this->chatService->getById($chatId);
            $currentChatData = $this->chatService->getCurrentChatFromChats(
                $chat->id,
                Inertia::getShared('chats', [])
            );

            if (is_null($currentChatData)) {
                return redirect(route('home'));
            }

            Inertia::share('currentChatId', $chat->id->value());

            return Inertia::render('Chat/Show', [
                'currentChatUsername' => $currentChatData['username'],
            ]);
        } catch (ChatNotFoundByIdException) {
            return redirect(route('home'));
        } catch (Throwable $e) {
            Log::error($e->getMessage());
            throw $e;
        }
    }
}
