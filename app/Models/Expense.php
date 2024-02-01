<?php

namespace App\Models;

use Money\Money;
use Money\Currency;
use Illuminate\Database\Eloquent\Model;
use Money\Formatter\IntlMoneyFormatter;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Expense extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'transaction_date' => 'datetime',
        'tags' => 'array'
    ];

    public static $allowedCurrencies = [
        840 => 'USD',
        604 => 'PEN',
    ];

    protected $intlMoneyFormatter;

    public function __construct()
    {
        $this->intlMoneyFormatter = app(IntlMoneyFormatter::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    protected function amount(): Attribute
    {
        return Attribute::make(
            get: function (int $value, array $attributes) {
                $money = new Money($value, new Currency($attributes['currency']));
                return $this->intlMoneyFormatter->format($money);
                
            } 
        );
    }

}
