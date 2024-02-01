<?php

namespace App\Models;

use Money\Money;
use Money\Currency;
use Illuminate\Database\Eloquent\Model;
use Money\Formatter\IntlMoneyFormatter;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'expense_tag', 'expense_id', 'tag_id');
    }

    protected function amount(): Attribute
    {
        $moneyFormatter = app(IntlMoneyFormatter::class);

        return Attribute::make(
            get: function (int $value, array $attributes) use ($moneyFormatter) {
                $money = new Money($value, new Currency($attributes['currency']));
                return $moneyFormatter->format($money);
                
            } 
        );
    }

}
