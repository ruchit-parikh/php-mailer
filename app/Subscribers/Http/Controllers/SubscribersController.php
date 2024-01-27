<?php

namespace App\Subscribers\Http\Controllers;

use App\Subscribers\Entities\Subscriber;
use App\Subscribers\Exceptions\SubscriberAlreadyExistsException;
use App\Subscribers\Exceptions\SubscriberNotFoundException;
use App\Subscribers\Http\Requests\StoreSubscriberFormRequest;
use App\Subscribers\Http\Responses\SubscriberResource;
use App\Subscribers\Http\Responses\SubscribersCollection;
use App\Subscribers\Repositories\DBSubscribersRepository;
use DateTimeImmutable;
use Mailer\Contracts\Controller;
use Mailer\Http\JsonResponse;
use Mailer\Http\Request;

class SubscribersController extends Controller
{
    /**
     * @param Request $request
     *
     * @return SubscribersCollection
     */
    public function index(Request $request): SubscribersCollection
    {
        $repository = DBSubscribersRepository::getInstance();

        $subscribers = $repository->getPaginated(['page' => $request->query('page'), 'limit' => $request->query('limit')]);

        return new SubscribersCollection($subscribers);
    }

    /**
     * @param StoreSubscriberFormRequest $request
     *
     * @return JsonResponse
     *
     * @throws SubscriberAlreadyExistsException
     */
    public function post(StoreSubscriberFormRequest $request): JsonResponse
    {
        $repository = DBSubscribersRepository::getInstance();

        $subscriber = $repository->findByEmail($request->getEmail());

        // As we are not allowing any upsert if already subscribed
        if ($subscriber) {
            throw new SubscriberAlreadyExistsException($subscriber);
        }

        $subscriber = new Subscriber([
            'first_name' => $request->getFirstName(),
            'last_name' => $request->getLastName(),
            'email' => $request->getEmail(),
            'status' => $request->getStatus(),
            'subscribed_at' => new DateTimeImmutable
        ]);

        return new JsonResponse(['success' => $repository->store($subscriber)]);
    }

    /**
     * @param Request $request
     *
     * @return SubscriberResource
     *
     * @throws SubscriberNotFoundException
     */
    public function show(Request $request): SubscriberResource
    {
        $repository = DBSubscribersRepository::getInstance();
        $subscriber = $repository->find($request->path('subscriber'));

        if ($subscriber) {
            return new SubscriberResource($subscriber);
        }

        throw new SubscriberNotFoundException;
    }
}
