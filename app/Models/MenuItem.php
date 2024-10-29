<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'display', 'status', 'parent_id', 'type', 'type_id', 'external_link', 'order'];

    public function children()
    {
        return $this->hasMany(MenuItem::class, 'parent_id')->with('children'); // Recursively load children
    }

    public function parent()
    {
        return $this->belongsTo(MenuItem::class, 'parent_id');
    }

    public function typeItem()
    {
        if ($this->type === 'module') {
            return $this->belongsTo(Module::class, 'type_id');
        }

        if ($this->type === 'page') {
            return $this->belongsTo(Page::class, 'type_id');
        }

        // Return a default empty relation if type is 'external_link' or invalid
        return $this->belongsTo(Page::class, 'type_id')->whereRaw('1 = 0');
    }
}
