<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'image',
        'is_active',
        'is_deleted',
        'parent_id',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function childrenRecursive()
    {
        return $this->children()->with('childrenRecursive');
    }

    public function scopeRoot($query)
    {
        return $query->whereNull('parent_id');
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function getAncestorIds()
    {
        $ids = [];
        $parent = $this->parent;

        while ($parent) {
            $ids[] = $parent->id;
            $parent = $parent->parent;
        }

        return $ids;
    }

    public function getDescendantIds()
    {
        $ids = [];

        foreach ($this->children as $child) {
            $ids[] = $child->id;
            $ids = array_merge($ids, $child->getDescendantIds());
        }

        return $ids;
    }

    public function isAncestorOf(Category $category)
    {
        return in_array($this->id, $category->getAncestorIds());
    }

    public function isDescendantOf(Category $category)
    {
        return in_array($category->id, $this->getAncestorIds());
    }

    public function getDepth()
    {
        return count($this->getAncestorIds());
    }

    public function getTotalChildrenCount()
    {
        $count = $this->children->count();

        foreach ($this->children as $child) {
            $count += $child->getTotalChildrenCount();
        }

        return $count;
    }

    public function getTotalProductsCount()
    {
        $count = $this->products->count();

        foreach ($this->children as $child) {
            $count += $child->getTotalProductsCount();
        }

        return $count;
    }

    public function canBeDeleted()
    {
        return $this->children->count() === 0 && $this->products->count() === 0;
    }

    public static function getTreeOptions($excludeId = null)
    {
        $categories = static::root()->with('childrenRecursive')->get();
        $options = [];

        foreach ($categories as $category) {
            static::buildTreeOptions($category, $options, 0, $excludeId);
        }

        return $options;
    }

    protected static function buildTreeOptions($category, &$options, $level, $excludeId)
    {
        if ($excludeId && $category->id == $excludeId) {
            return;
        }

        $options[$category->id] = str_repeat('— ', $level) . $category->name;

        foreach ($category->children as $child) {
            static::buildTreeOptions($child, $options, $level + 1, $excludeId);
        }
    }
}
