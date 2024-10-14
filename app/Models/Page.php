<?php

namespace App\Models;

use App\Concerns\HasSlug;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Page extends Model
{
    use HasFactory;
    use SoftDeletes;
    use HasSlug;

    protected function casts(): array
    {
        return [
            'content' => 'json',
            'published_at' => 'datetime',
        ];
    }

    protected function sluggable(): string
    {
        return 'title';
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('published_at', '<=', now());
    }

    public function scopeUnpublished(Builder $query): Builder
    {
        return $query->where('published_at', '>', now());
    }

    // protected function url(): Attribute
    // {
    //     return Attribute::get(fn () => route('page.show', $this));
    // }
}
