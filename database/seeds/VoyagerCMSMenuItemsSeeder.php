<?php

namespace Tjventurini\VoyagerCMS\Seeds;

use TCG\Voyager\Models\Menu;
use Illuminate\Database\Seeder;
use TCG\Voyager\Models\MenuItem;
use Illuminate\Support\Facades\DB;

class VoyagerCMSMenuItemsSeeder extends Seeder
{
    /**
     * Run the voyager cms package database seeders.
     *
     * @return void
     */
    public function run()
    {
        DB::transaction(function () {
            // get the admin menu
            $menu = Menu::where('name', 'admin')->firstOrFail();

            // create the menu item
            $parentItem = MenuItem::updateOrCreate([
                'title' => trans('cms::cms.label'),
            ], [
                'url' => '',
                'menu_id' => $menu->id,
                'target' => '_self',
                'icon_class' => 'voyager-helm',
                'color' => null,
                'parent_id' => null,
                'order' => 99
            ]);

            // add menu item to menu
            $menu->items->add($parentItem);

            // gather the other menu items under
            // the cms menu item

            // pages
            $route = 'voyager.pages.index';
            $menuItem = MenuItem::updateOrCreate([
                'route' => $route,
            ], [
                'menu_id' => $menu->id,
                'parent_id' => $parentItem->id,
                'url' => '',
                'order' => 1,
                'title' => trans('pages::pages.label_singular'),
            ]);

            // posts
            $route = 'voyager.posts.index';
            $menuItem = MenuItem::updateOrCreate([
                'route' => $route,
            ], [
                'menu_id' => $menu->id,
                'parent_id' => $parentItem->id,
                'url' => '',
                'order' => 2,
                'title' => trans('posts::posts.label_singular'),
            ]);

            // content-blocks
            $route = 'voyager.content-blocks.index';
            $menuItem = MenuItem::updateOrCreate([
                'route' => $route,
            ], [
                'menu_id' => $menu->id,
                'parent_id' => $parentItem->id,
                'url' => '',
                'order' => 3,
                'title' => trans('content-blocks::content-blocks.label_singular'),
            ]);

            // tags
            $route = 'voyager.tags.index';
            $menuItem = MenuItem::updateOrCreate([
                'route' => $route,
            ], [
                'menu_id' => $menu->id,
                'parent_id' => $parentItem->id,
                'url' => '',
                'order' => 5,
                'title' => trans('tags::tags.label_singular'),
            ]);
        });
    }
}
