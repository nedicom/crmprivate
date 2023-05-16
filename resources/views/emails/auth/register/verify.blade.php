@component('mail::message')
    # Подтверждение электронной почты
    Пожалуйста перейдите по следующей ссылке:

    @component('mail::button', ['url' => route('register.verify', ['token' => $user->remember_token])])
        Подтвердите email
    @endcomponent

    Спасибо, <br/>
    {{ config('app.name') }}
@endcomponent
