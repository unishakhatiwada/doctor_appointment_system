<?php

namespace App\Helpers;

use App\Models\MenuItem;
use Illuminate\Support\Collection;

class MenuHelper
{
    /**
     * Get the menu hierarchy for items that are active and visible.
     */
    public static function getMenuHierarchy(): Collection
    {
        // Fetch only the menu items that are active and set to be displayed
        $menuItems = MenuItem::where('status', true)
            ->where('display', 'visible')
            ->orderBy('order')
            ->get()
            ->groupBy('parent_id'); // Group by parent_id to prepare for hierarchy

        return collect(self::buildMenuTree($menuItems));
    }

    /**
     * Recursive method to build the menu tree.
     */
    private static function buildMenuTree($menuItems, $parentId = null): array
    {
        $tree = [];

        if (isset($menuItems[$parentId])) {
            foreach ($menuItems[$parentId] as $menuItem) {
                $menuItem->children = collect(self::buildMenuTree($menuItems, $menuItem->id));
                $tree[] = $menuItem;
            }
        }

        return $tree;
    }

    /**
     * Render menu items recursively as HTML.
     */
    public static function renderMenuItems($menuItems): string
    {
        $html = '';

        foreach ($menuItems as $menuItem) {
            $hasChildren = $menuItem->children->isNotEmpty();

            $html .= '<li class="nav-item ' . ($hasChildren ? 'dropdown' : '') . '">';

            // Adding Bootstrap utility classes for font size and padding
            $html .= '<a href="' . ($menuItem->external_link ?? $menuItem->url) . '" ' .
                'class="nav-link ' . ($hasChildren ? 'dropdown-toggle' : '') . ' fs-4 py-2 px-4" ' .
                ($hasChildren ? 'data-bs-toggle="dropdown" role="button" aria-expanded="false"' : '') . '>' .
                $menuItem->title;

            if ($hasChildren) {
                $html .= ' <span class="caret"></span>';
            }
            $html .= '</a>';

            // Render children recursively
            if ($hasChildren) {
                $html .= '<ul class="dropdown-menu">';
                $html .= self::renderMenuItems($menuItem->children);
                $html .= '</ul>';
            }

            $html .= '</li>';
        }

        return $html;
    }

}
