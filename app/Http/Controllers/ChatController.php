<?php

namespace App\Http\Controllers;

use App\Http\Requests\Chat\StoreRequest;
use App\Services\Chat\Contacts\ChatServiceContract;
use App\Services\Chat\Factories\CreateChatDtoFactory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Inertia\Response;
use Throwable;

class ChatController
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
            $creatorId = (int) auth()->id();
            $memberId = (int) $request->get('user_id');

            $createChatDto = $this->createChatDtoFactory->createFromParams($creatorId, $memberId);

            $chatId = $this->chatService->create($createChatDto);

            return redirect(route('chats.show', $chatId));
        } catch (Throwable $e) {
            Log::error($e->getMessage());
            throw $e;
        }
    }

    public function show(string $id): Response
    {
        return Inertia::render('Chat/Show');
    }
}
