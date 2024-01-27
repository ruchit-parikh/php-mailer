<?php

namespace App\Subscribers\Models;

use Mailer\Contracts\Model;
use App\Subscribers\Entities\Subscriber as SubscriberEntity;

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
