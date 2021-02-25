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

/**
 * Builds out conditions for finding stored records.
 *
 * Concrete implmentations are meant to expose searchable critera in terms of business logic,
 * rather than presenting a low-level "query builder"-like implementation.
 *
 * For example, instead of something like:
 * @example ```
 * $list = $finder->equals("owner_id", $user->id)
 *   ->greaterThan("scheduled_date", time())
 *   ->lessThan("scheduled_date", strtotime("midnight first day of next week"))
 *   ->greaterThan("reservations", 25)
 *   ->orderBy("scheduled_date ASC reservations DESC")
 *   ->list();
 * foreach ($list as $event) { . . . }
 * ```
 * Finders should instead be like:
 * @example ```
 * $list = $finder->belongsTo($user)
 *   ->isScheduledThisWeek()
 *   ->hasMoreReservationsThan(25)
 *   ->sortSoonest()
 *   ->sortMostReservations()
 *   ->list();
 * foreach ($list as $event) { . . . }
 * ```
 */
interface Finder {

  /** @var string Sort ascending. */
  public const ASC = "asc";

  /** @var string Sort descending. */
  public const DESC = "desc";

  /** @var string Finder requires all conditions match. */
  public const ALL = "all";

  /** @var string Finder requires any conditions match */
  public const ANY = "any";

  /**
   * Counts stored records that match Finder's conditions.
   *
   * @return int Count of matching records
   */
  public function count() : int;

  /**
   * Deletes stored records that match Finder's conditions.
   *
   * @return Finder $this
   */
  public function delete() : Finder;

  /**
   * Do stored records exist that match Finder's conditions?
   *
   * @return bool True if a matching record is stored; false otherwise
   */
  public function exists() : bool;

  /**
   * Lazily fetches Storables from stored records that match Finder's conditions.
   *
   * @return Iterator
   */
  public function list() : Iterator;

  /**
   * Updates stored records that match Finder's conditions.
   *
   * @param Record $set Updates to perform
   * @return Finder     $this
   */
  public function update(Record $set) : Finder;

  /**
   * Adds a subordinate "all" clause to the Finder.
   *
   * @return Finder A new, subordinate Finder instance
   */
  public function withAll() : Finder;

  /**
   * Adds a subordinate "any" clause to the Finder.
   *
   * @return Finder A new, subordinate Finder instance
   */
  public function withAny() : Finder;
}
