@extends("moonshine::layouts.login")

@section('content')
    <div class="authentication" xmlns:x-slot="http://www.w3.org/1999/html">
        <div class="authentication-logo">
            <a href="/" rel="home">
                <img class="h-16"
                     src="{{ config('moonshine.logo') ?: asset('vendor/moonshine/logo.svg') }}"
                     alt="{{ config('moonshine.title') }}"
                >
            </a>
        </div>
        <div class="authentication-content">
            <div class="authentication-header">
                <h1 class="title">Добро пожаловать</h1>
                <p class="description">
                    Пожалуйста, заполните эти поля
                </p>
            </div>

            <x-moonshine::form
                class="authentication-form"
                action="{{ route('auth.login') }}"
                method="POST"
                :errors="false"
            >
                <div class="form-flex-col">
                    <x-moonshine::form.input-wrapper
                        name="username"
                        label="логин"
                        required
                    >
                        <x-moonshine::form.input
                            id="username"
                            type="username"
                            name="login"
                            @class(['form-invalid' => $errors->has('username')])
                            placeholder="логин"
                            required
                            autofocus
                            value="{{ old('login') }}"
                            autocomplete="username"
                        />
                    </x-moonshine::form.input-wrapper>

                    <x-moonshine::form.input-wrapper
                        name="password"
                        label="пароль"
                        required
                        autocomplete="current-password"
                    >
                        <x-moonshine::form.input
                            id="password"
                            type="password"
                            name="password"
                            @class(['form-invalid' => $errors->has('password')])
                            placeholder="пароль"
                            required
                        />
                    </x-moonshine::form.input-wrapper>

                    <x-moonshine::form.input-wrapper
                        name="remember_me"
                        class="form-group-inline"
                        label="Запомнить меня"
                        :beforeLabel="true"
                    >
                        <x-moonshine::form.input
                            type="hidden"
                            name="remember"
                            value="0"
                        />

                        <x-moonshine::form.input
                            id="remember_me"
                            type="checkbox"
                            name="remember"
                            value="1"
                        />
                    </x-moonshine::form.input-wrapper>
                </div>

                <x-slot:button type="submit" class="btn-lg w-full">
                    Войти
                </x-slot:button>
            </x-moonshine::form>

            <p class="text-center text-2xs">
                {!! config('moonshine.auth.footer', '') !!}
            </p>

            <div class="authentication-footer">
                @include('moonshine::ui.social-auth', [
                    'title' => trans('moonshine::ui.login.or_socials')
                ])
            </div>
        </div>
    </div>
@endsection
