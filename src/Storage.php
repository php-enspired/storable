<?php
/**
 * @package   at.storable
 * @author    Adrian <adrian@enspi.red>
 * @copyright 2015 - 2021
 * @license   GPL-3.0 (only)
 *
 *  This program is free software: you can redistribute it and/or modify it
 *  under the terms of the GNU General Public License, version 3.
 *  The right to apply the terms of later versions of the GPL is RESERVED.
 *
 *  This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY;
 *  without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *  See the GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License along with this program.
 *  If not, see <http://www.gnu.org/licenses/gpl-3.0.txt>.
 */
declare(strict_types = 1);

namespace AT\Storable;

use Pdo;

use AT\Storable\ {
  Error\UnderflowException,
  Handler
};

use Di\ContainerBuilder;
use function Di\create as DiCreate;

use Psr\Container\ {
  ContainerInterface as Container
};

/**
 * Manager for the collection of Handlers.
 */
class Storage {

  /**
   * Creates a Storage instance and default Container.
   *
   * Assumes the Handler constructor signature is preserved and requires only a PDO instance.
   * If this is not the case, you should build and configure your own Container.
   *
   * @param Pdo   $pdo The database connection for Handlers to use
   * @param array $map Storable:Handler classname map
   * @return Storage   A new Storage instance
   */
  public static function createFromMap(Pdo $pdo, array $map) : Storage {
    return new static(
      (new ContainerBuilder())
        ->addDefinitions(
          [Pdo::class => $pdo] + array_map(
            fn ($item) => is_a($item, Handler::class, true) ? DiCreate($item) : $item,
            $map
          )
        )
        ->build()
    );
  }

  /** @var Container Full of Handlers. */
  protected Container $handlers;

  /**
   * @param Container $container Collection of Handlers, indexed by Storable FQCN
   */
  public function __construct(Container $handlers) {
    $this->handlers = $handlers;
  }

  /**
   * Finds a Handler by Storable classname, traversing up its inheritance chain if necessary.
   *
   * @param string $storable    Storable FQCN
   * @throws UnderflowException NO_HANDLER if no appropriate Handler is found
   * @return Handler            A Handler for the Storable
   */
  public function get(string $storable) : Handler {
    $key = $storable;
    do {
      if ($this->handlers->has($key)) {
        $handler = $this->handlers->get($key);
        if ($handler instanceof Handler) {
          return $handler;
        }
      }

      $key = get_parent_class($key);
    } while (! empty($key));

    UnderflowException::throw(UnderflowException::NO_HANDLER, ['storable' => $storable]);
  }
}
