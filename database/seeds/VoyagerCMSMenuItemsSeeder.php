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
            $url = route('voyager.pages.index', [], false);
            $menuItem = MenuItem::updateOrCreate([
                'url' => $url,
            ], [
                'menu_id' => $menu->id,
                'parent_id' => $parentItem->id,
                'order' => 1
            ]);

            // posts
            $url = route('voyager.posts.index', [], false);
            $menuItem = MenuItem::updateOrCreate([
                'url' => $url,
            ], [
                'menu_id' => $menu->id,
                'parent_id' => $parentItem->id,
                'order' => 2
            ]);

            // content-blocks
            $url = route('voyager.content-blocks.index', [], false);
            $menuItem = MenuItem::updateOrCreate([
                'url' => $url,
            ], [
                'menu_id' => $menu->id,
                'parent_id' => $parentItem->id,
                'order' => 3
            ]);

            // tags
            $url = route('voyager.tags.index', [], false);
            $menuItem = MenuItem::updateOrCreate([
                'url' => $url,
            ], [
                'menu_id' => $menu->id,
                'parent_id' => $parentItem->id,
                'order' => 5
            ]);
        });
    }
}
