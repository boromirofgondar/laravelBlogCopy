@component('mail::message')
# Introduction

## Thanks for registering with DERPY

### Checkout this code!
```javascript
var s = "JavaScript syntax highlighting";
alert(s);
```


@component('mail::button', ['url' => 'https://reddit.com'])
Hello There
@endcomponent




Thanks,<br>
{{ config('app.name') }}
@endcomponent
