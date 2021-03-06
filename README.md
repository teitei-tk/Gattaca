# gattaca
gattaca is provide Request dispatcher Components

---

[![Build Status](https://travis-ci.org/teitei-tk/Gattaca.svg?branch=master)](https://travis-ci.org/teitei-tk/Gattaca)
[![Latest Stable Version](https://poser.pugx.org/teitei-tk/gattaca/v/stable)](https://packagist.org/packages/teitei-tk/gattaca)

## Dependency
* PHP7 (not 5.\*)
* Symfony\Routing
* Symfony\HttpFoundation

## Usage

* Simple Usage

```php
<?php

require '/path/to/vendor/autoload.php';

namespace YourApp;

use Symfony\Component\Routing\Route;
use Symfony\Component\HttpFoundation\Request;

use Gattca\RequestDispatcher;

RequestDispatcher::new()->addRoute("index", new Route("/", [
    "handler" =>  function(Request $request) {
        return "HelloWorld!";
    }
]))->run();
```

* Class based Usage

```php
<?php

require '/path/to/vendor/autoload.php';

namespace YourApp;

use Symfony\Component\Routing\Route;
use Gattca\RequestDispatcher;

$klass = new class implements ControllerInterface
{
    public function dispatchRequest(Request $request)
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

namespace YourApp;

use Symfony\Component\Routing\Route;
use Gattca\ApiRequestDispatcher;

ApiRequestDispatcher::new()->addRoute("index", new Route("/", [
    "handler" =>  function(Request $request) {
        return "HelloWorld!";
    }
]))->run();

// or

$klass = new class implements ControllerInterface
{
    public function dispatchRequest(Request $request)
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
