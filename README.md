![](https://img.shields.io/github/release/php-enspired/storable.svg)  ![](https://img.shields.io/badge/PHP-7.4-blue.svg?colorB=8892BF)  ![](https://img.shields.io/badge/PHP-8.0-blue.svg?colorB=8892BF)  ![](https://img.shields.io/badge/license-GPL_3.0_only-blue.svg)

Be a Storage Hero
=================
```
$entity->saveYourself() // zero . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . .
. . . . . . . . . . . . . . . . . . . . . . . . . . . . . . $storage->i’llSaveYou($entity) // hero!
```

_Storable_ provides a design and groundwork that you can build from while keeping the Database (or whatever storage) away from your domain logic.

dependencies
------------

Requires php 7.4, php 8.0, or later.

ICU support requires the `intl` extension.

installation
------------

Recommended installation method is via [Composer](https://getcomposer.org/): simply `composer require php-enspired/storable`.

a quick taste
-------------
```php
<?php

$parties = $storage->get(Party::class)
  ->find()
  ->upcoming()
  ->scheduledThisWeek()
  ->noInvitationRequired()
  ->withCake()
  ->list();

foreach ($parties as $party) {
  $party->on();
}
```

see more in [the wiki](https://github.com/php-enspired/storable/wiki).

docs
----

_coming soon_

contributing or getting help
----------------------------

I'm on [Freenode at `#php-enspired`](http://webchat.freenode.net?channels=%23php-enspired&uio=d4), or open an issue [on github](https://github.com/php-enspired/storable/issues).  Feedback is welcomed as well.
