@component('mail::message')
  Gentile <strong>{{ $user->name }}</strong>,

  Siamo lieti di darti il benvenuto nella nostra classe!

  Per accedere al proprio account, può cliccare sul seguente pulsante:

  @component('mail::button', ['url' => route('login')])
    Accedi
  @endcomponent

  Cordiali saluti,<br>
  Classe #65
@endcomponent