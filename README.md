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

* Class based Usage

```php
<?php

require '/path/to/vendor/autoload.php';

namespace YourApp:

use Symfony\Component\Routing\Route;
use Gattca\RequestDispatcher;

$klass = new class implements ControllerInterface
{
    public function dispatchRequest()
    {
        return "HelloWorld!";
    }
};

RequestDispatcher::new()->addRoute("index", new Route("/", [
    "handler" =>  $klass
]))->run();
```

* Api vendor

```php
<?php

require '/path/to/vendor/autoload.php';

namespace YourApp:

use Symfony\Component\Routing\Route;
use Gattca\ApiRequestDispatcher;

ApiRequestDispatcher::new()->addRoute("index", new Route("/", [
    "handler" =>  function() {
        return "HelloWorld!";
    }
]))->run();

// or

$klass = new class implements ControllerInterface
{
    public function dispatchRequest()
    {
        return "HelloWorld!";
    }
};

ApiRequestDispatcher::new()->addRoute("index", new Route("/", [
    "handler" =>  $klass
]))->run();
```

---

## Licence
MIT
