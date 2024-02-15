<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Money\Currency;
use Money\Formatter\DecimalMoneyFormatter;
use Money\Formatter\IntlMoneyFormatter;
use Money\Money;
use Money\Parser\DecimalMoneyParser;

class Expense extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'transaction_date' => 'datetime',
        'effective_date'   => 'datetime',
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
        return Attribute::make(
            get: function (int $value, array $attr) {
                $money = new Money($value, new Currency($attr['currency']));

                return app(DecimalMoneyFormatter::class)->format($money);

            },
            set: function (string $value) {
                return app(DecimalMoneyParser::class)->parse($value, new Currency('USD'))->getAmount();
            }
        );
    }

    protected function amountPretty(): Attribute
    {
        return Attribute::make(
            get: function (mixed $value, array $attr) {
                $money = new Money($attr['amount'], new Currency($attr['currency']));

                return app(IntlMoneyFormatter::class)->format($money);
            }
        );
    }

    protected function fees(): Attribute
    {
        return Attribute::make(
            get: function (int $value, array $attr) {
                $money = new Money($value, new Currency($attr['currency']));

                return app(DecimalMoneyFormatter::class)->format($money);

            },
            set: function (?string $value) {
                if ($value === null) {
                    return 0;
                }

                return app(DecimalMoneyParser::class)->parse($value, new Currency('USD'))->getAmount();
            }
        );
    }

    protected function feesPretty(): Attribute
    {
        return Attribute::make(
            get: function (mixed $value, array $attr) {
                $money = new Money($attr['fees'], new Currency($attr['currency']));

                return app(IntlMoneyFormatter::class)->format($money);
            }
        );
    }

    protected function hasFees(): Attribute
    {
        return Attribute::make(
            get: function (mixed $value, array $attr) {
                return $attr['fees'] > 0;
            }
        );
    }

    protected function total(): Attribute
    {
        return Attribute::make(
            get: function (mixed $value, array $attr) {
                $amount = Money::USD($attr['amount']);
                $fees = Money::USD($attr['fees']);

                $total = $amount->add($fees);

                return app(IntlMoneyFormatter::class)->format($total);
            }
        );
    }

    protected function tagsPretty(): Attribute
    {
        return Attribute::make(
            get: function () {
                $tagsArray = $this->tags->reduce(function (array $carry, Tag $tag) {
                    $carry[] = $tag->name;

                    return $carry;
                }, []);

                return implode(', ', $tagsArray);
            }
        );
    }

    protected function tagIds(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->tags->map(fn (Tag $tag) => $tag->id)->all()
        );
    }
}
