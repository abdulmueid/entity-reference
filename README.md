## Entity Reference Generator
This library generates Payment References for use with SIMO Banking System (Mozambique)

### Installation
Install using composer
```shell script
composer require abdulmueid/entity-reference
```

### Usage
Here is a sample:
```php
<?php

require_once "vendor/autoload.php";

$entity = '202020';
$amount = '500';
$referencesToGenerate = 10;
$generator = new abdulmueid\EntityReference\Generator();

// Generate a reference
$reference = $generator->generateReference($entity, $amount);

// Validate Reference, should return true
$generator->isReferenceValid($entity, $amount, $reference); // Should return true

// Generate n number of references
// Should return an array with valid references
$references = $generator->generateReferences($entity, $amount, $referencesToGenerate);
```

### Tests
Run tests using phpunit
```shell script
phpunit tests/GeneratorTest.php
```

### License
See [LICENSE.md](LICENSE.md)
