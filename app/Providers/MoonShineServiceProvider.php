<?php

namespace App\Providers;

use App\MoonShine\Resources\UserResource;
use Illuminate\Support\ServiceProvider;
use MoonShine\MoonShine;
use MoonShine\Menu\MenuGroup;
use MoonShine\Menu\MenuItem;
use MoonShine\Resources\MoonShineUserResource;
use MoonShine\Resources\MoonShineUserRoleResource;

class MoonShineServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        app(MoonShine::class)->menu([

                MenuItem::make('Пользователи', new UserResource())
                    ->translatable()
                    ->icon('bookmark'),
            MenuItem::make('Роли', new \Sweet1s\MoonshineRolesPermissions\Resource\RoleResource(), 'heroicons.outline.shield-exclamation'),
        ]);
    }
}
