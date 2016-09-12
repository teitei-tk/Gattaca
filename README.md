# Gattaca
Gattaca is provide Request dispatcher Components

---

## Dependency
* PHP7 (not 5.\*)
* Symfony\Routing
* Symfony\HttpFoundation

## Usage

* Simple Usage

```php
<?php

require '/path/to/vendor/autoload.php';

namespace YourApp:

use Symfony\Component\Routing\Route;
use Gattca\RequestDispatcher;

RequestDispatcher::new()->addRoute("index", new Route("/", [
    "handler" =>  function() {
        return "HelloWorld!";
    }
]))->run();
```
