<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Prize extends Model
{
    protected $guarded = [
        'id',
    ];

    protected $casts = [
        'is_rejected' => 'bool',
        'sent_at' => 'datetime',
        'prize_amount' => 'int',
    ];

    const PRIZE_TITLE = [
        'bonuses' => 'Bonus points',
        'money' => 'Money',
        'product' => 'Product',
    ];

    public function reject()
    {
        self::update([
            'is_rejected' => true
        ]);
    }

    public function toArray()
    {
        $parentArray = parent::toArray();

        $array = [];
        $array['id'] = $parentArray['id'];
        $array['type'] = $this->prizeType ? $this->prizeType->name : '';
        $array['sum'] = $parentArray['prize_amount'];
        $array['product'] = $this->prizeItem ? $this->prizeItem->name : '';
        $array['title'] = $array['type'] ? self::PRIZE_TITLE[$array['type']] : '';

        return $array;
    }

    public function prizeType()
    {
        return $this->belongsTo(PrizeType::class);
    }

    public function prizeItem()
    {
        return $this->belongsTo(PrizeItem::class);
    }
}
