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

namespace AT\Storable\Iterator;

/**
 * Interface for manipulating lists of storables.
 */
interface Iterator extends IteratorAggragate {

  /**
   * Clears the Iterator's caches, if they are in use.
   *
   * @return Iterator $this
   */
  public function clear() : Iterator;

  /**
   * Counts how many Storables are in the Iterator.
   *
   * @return int
   */
  public function count() : int;

  /**
   * Invokes a method on each Storable and returns the results.
   *
   * @param string $method          The Storable method to call
   * @param mixed    ...$args       Method arguments
   * @throws DomainException        If the given method does not exist on the Storable
   * @throws BadMethodCallException If any method invocation throws
   * @return Generator              Yields return values from the method
   */
  public function each(string $method, ...$args) : Generator;

  /**
   * Gets the first Storable from the Iterator.
   *
   * @throws UnderflowException If the Iterator is empty
   * @return Storable
   */
  public function first() : Storable;

  /** @see https://php.net/IteratorAggregate.getIterator */
  public function getIterator() : Generator;

  /**
   * Is this Iterator empty?
   *
   * @return bool True if the Iterator has Storables; false otherwise
   */
  public function isEmpty() : bool;

  /**
   * Gets the last Storable from the Iterator.
   *
   * @throws UnderflowException If the Iterator is empty
   * @return Storable
   */
  public function last() : Storable;

  /**
   * Applies a callback to each Storable and returns the result.
   *
   * @param callable $callback      mixed (Storable $s, mixed ...$args)
   * @param mixed    ...$args       Additional callback arguments
   * @throws BadMethodCallException If callback invocation throws
   * @return Generator              Yields return values from the callback
   */
  public function map(callable $callback, ...$args) : Generator;

  /**
   * Iteratively reduces the Iterator to a single value.
   *
   * @param callable $callback      mixed (mixed $carry, Storable $s)
   * @param mixed    $inital        Initial value for $carry
   * @throws BadMethodCallException If callback invocation throws
   * @return mixed                  Final return value
   */
  public function reduce(callable $callback, $initial = null);

  /**
   * Converts the Iterator to an array of Storables.
   *
   * @return array
   */
  public function toArray() : array;
}
