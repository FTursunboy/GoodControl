<?php

namespace App\MoonShine\Resources;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

use Illuminate\Support\Facades\Route;
use MoonShine\Fields\BelongsTo;
use MoonShine\Fields\BelongsToMany;
use MoonShine\Fields\Text;
use MoonShine\Resources\Resource;
use MoonShine\Fields\ID;
use MoonShine\Actions\FiltersAction;

class UserResource extends Resource
{
	public static string $model = User::class;

	public static string $title = 'Users';

    public function fields(): array
    {
        return [
            ID::make()->sortable(),
            Text::make('Имя', 'name'),
            Text::make('Логин', 'login'),
            Text::make('Телефон', 'phone'),
            Text::make('Пароль', 'password'),
            BelongsTo::make('роль' , 'role', 'name')
        ];
    }


    public function rules(Model $item): array
	{
	    return [];
    }

    public function search(): array
    {
        return ['name'];
    }

    public function filters(): array
    {
        return [];
    }

    public function resolveRoutes(): void
    {
        parent::resolveRoutes();

        Route::prefix('resource')->group(function (): void {
            Route::post("{$this->uriKey()}/user-resource", function (User $item) {


                return redirect()->back();
            });
        });
    }
    public function actions(): array
    {
        return [
            FiltersAction::make(trans('moonshine::ui.filters')),
        ];
    }
}
