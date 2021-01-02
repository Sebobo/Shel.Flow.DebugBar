# Experimental PHPDebugBar integration for Neos Flow

Only use this if you know what you are doing 😉

## Hotfix when response is empty

Add the following line

```php
$body->rewind();
```

Before the method `handleHtml` returns (~L174) in the `\Middlewares\Debugbar` class.
