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

namespace AT\Storable\Handler;

use AT\Storable\ {
  Finder,
  Iterator,
  Record,
  Storable
};

/**
 * Interface for Storable Handlers.
 *
 * Handlers are responsible for individual Records and Storables and converting between the two.
 */
interface Handler {

  /**
   * Counts records that match the given conditions.
   *
   * @param Finder $find Conditions to match
   * @return int         Number of matching records
   */
  public function count(Finder $find) : int;

  /**
   * Creates and stores a new record for a Storable.
   *
   * @param Storable $storable
   * @return Handler $this
   */
  public function create(Storable $storable) : Handler;

  /**
   * Deletes a Storable's stored record.
   *
   * @param Storable $storable The Storable to delete
   * @return Handler           $this
   */
  public function delete(Storable $storable) : Handler;

  /**
   * Deletes records that match given conditions.
   *
   * @param Finder $find Conditions to match
   * @return Handler     $this
   */
  public function deleteWhere(Finder $find) : Handler;

  /**
   * Checks whether records exist that match the given conditions.
   *
   * @param Finder $find Conditions to match
   * @return bool        True if records exist; false otherwise
   */
  public function exists(Finder $find) : bool;

  /**
   * Creates a new Finder instance for this Handler.
   *
   * @return Finder
   */
  public function find() : Finder;

  /**
   * Lazily fetches records from storage and loads them into Storables.
   *
   * @param Finder $find Conditions to match
   * @return Iterator
   */
  public function list(Finder $find) : Iterator;

  /**
   * Creates a new Record instance from given data.
   *
   * @param array $data Key:value pairs
   * @throws DomainException UNKNOWN_KEY if data contains unknown key(s)
   * @throws DomainException INVALID if data is not valid for the Record
   * @return Record A new Record instance
   */
  public function newRecord(array $data) : Record;

  /**
   * Creates a new Storable from given Record.
   *
   * @param Record $record Data to build the Storable from
   * @throws DomainException WRONG_RECORD if the Record is of the wrong type
   * @return Storable A new Storable instance
   */
  public function newStorable(Record $record) : Storable;

  public function read(Storable $storable) : Storable;

  /**
   * Updates a Storable's stored record.
   *
   * @param Storable $storable The Storable to update
   * @return Handler           $this
   */
  public function update(Storable $storable) : Handler;

  /**
   * Updates records that match given conditions.
   *
   * @param Finder $find Conditions to match
   * @param Set    $set  Values to update
   * @return Handler     $this
   */
  public function updateWhere(Finder $find, Record $set) : Handler;
}
