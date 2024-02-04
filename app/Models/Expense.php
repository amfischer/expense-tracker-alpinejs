<?php

namespace App\Models;

use Money\Money;
use Money\Currency;
use Money\Parser\DecimalMoneyParser;
use Money\Formatter\IntlMoneyFormatter;
use Illuminate\Database\Eloquent\Model;
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
        'effective_date' => 'datetime',
    ];

    public static $allowedCurrencies = [
        840 => 'USD',
        // 604 => 'PEN',
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
                
            },
            set: function (string $value) {
                return app(DecimalMoneyParser::class)->parse($value, new Currency('USD'))->getAmount();
            }
        );
    }

    protected function fees(): Attribute
    {
        $moneyFormatter = app(IntlMoneyFormatter::class);

        return Attribute::make(
            get: function (int $value, array $attributes) use ($moneyFormatter) {
                $money = new Money($value, new Currency($attributes['currency']));
                return $moneyFormatter->format($money);
                
            },
            set: function (?string $value) {
                if ($value === null) {
                    return 0;
                }

                return app(DecimalMoneyParser::class)->parse($value, new Currency('USD'))->getAmount();
            }
        );
    }

    protected function hasFees(): Attribute
    {
        return new Attribute(
            get: function(mixed $value, array $attr) {
                return $attr['fees'] > 0;
            }
        );
    }

    protected function total(): Attribute
    {
        $moneyFormatter = app(IntlMoneyFormatter::class);

        return new Attribute(
            get: function(mixed $value, array $attr) use ($moneyFormatter) {
                $amount = Money::USD($attr['amount']);
                $fees = Money::USD($attr['fees']);

                $total = $amount->add($fees);

                return $moneyFormatter->format($total);
            }
        );
    }

}
