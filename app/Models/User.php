<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password'          => 'hashed',
    ];

    public function expenses(): HasMany
    {
        return $this->hasMany(Expense::class);
    }

    public function categories(): HasMany
    {
        return $this->hasMany(Category::class);
    }

    public function tags(): HasMany
    {
        return $this->hasMany(Tag::class);
    }

    protected function categoriesArray(): Attribute
    {
        return Attribute::make(
            get: function () {
                return $this->categories->reduce(function (array $carry, Category $category) {
                    $carry[$category->id] = $category->name;

                    return $carry;
                }, []);
            }
        );
    }

    protected function categoryIds(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->categories->map(fn (Category $category) => $category->id)->all()
        );
    }

    protected function tagsArray(): Attribute
    {
        return Attribute::make(
            get: function () {
                return $this->tags->reduce(function (array $carry, Tag $tag) {
                    $carry[$tag->id] = $tag->name;

                    return $carry;
                }, []);
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
