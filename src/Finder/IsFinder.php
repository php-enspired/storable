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

namespace AT\Storable\Finder;

use AT\Storable\ {
  Error\InvalidArgumentException,
  Finder\Finder,
  Iterator\Iterator,
  Record
};

/**
 * Basic Finder implementation.
 */
trait IsFinder {

  /** @var Handler The Handler this Finder belongs to. */
  protected $handler;

  /** @var string Logical mode for this Finder. */

  /** @var Finder The "root" Finder. */
  protected $top;

  /** @var array[] Tree of conditions. */
  protected $find = [];

  /**
   * @param Handler $handler Handler that owns this Finder
   * @param string  $mode    One of Finder::AND|OR
   * @param Finder  $top     Root Finder, if not this one
   */
  public function __construct(Handler $handler, string $mode = Finder::ALL, Finder $top = null) {
    if (! in_array($mode, [Finder::AND, Finder::OR])) {
      InvalidArgumentException::throw(
        InvalidArgumentException::BAD_FINDER_MODE,
        ["mode" => $mode]
      );
    }

    $this->handler = $handler;
    $this->mode = $mode;
    $this->top = $top ?? $this;
  }

  /** {@inheritDoc} */
  public function count() : int {
    return $this->handler->count($this->top);
  }

  /** {@inheritDoc} */
  public function delete() : Finder {
    $this->handler->deleteWhere($this->top);

    return $this;
  }

  /** {@inheritDoc} */
  public function exists() : bool {
    return $this->handler->exists($this->top);
  }

  /** {@inheritDoc} */
  public function list() : Iterator {
    return $this->handler->list($this->top);
  }

  /** {@inheritDoc} */
  public function update(Record $set) : Finder {
    $this->handler->updateWhere($this->top, $set);
  }

  /** {@inheritDoc} */
  public function withAll() : Finder {
    $subordinate = new static($this->handler, Finder::ALL, $this->top);
    $this->pushSubordinate($subordinate);

    return $subordinate;
  }

  /** {@inheritDoc} */
  public function withAny() : Finder {
    $subordinate = new static($this->handler, Finder::ANY, $this->top);
    $this->pushSubordinate($subordinate);

    return $subordinate;
  }

  /**
   * Adds a condition.
   *
   * @param string $condition SQL fragment
   * @param mixed  ...$params Values to map to parameters
   */
  protected function push(string $condition, ...$params) : void {
    $this->find[] = [$condition, $params];
  }

  /**
   * Adds a subordinate condition.
   *
   * @param Finder $condition Subordinate Finder instance
   */
  protected function pushSubordinate(Finder $finder) : void {
    $this->find[] = $finder;
  }
}

PARAM_BOOL
PARAM_NULL
PARAM_INT
PARAM_STR
PARAM_STR_NATL
PARAM_STR_CHAR
PARAM_LOB
PARAM_STMT
PARAM_INPUT_OUTPUT
