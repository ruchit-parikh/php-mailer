<?php

namespace App\Subscribers\Models;

use App\Subscribers\Entities\Subscriber as SubscriberEntity;
use Mailer\Contracts\Model;

class Subscriber extends Model
{
    /**
     * @inheritdoc
     */
    protected string $table = 'subscribers';

    /**
     * @inheritdoc
     */
    protected string $entity = SubscriberEntity::class;
}
