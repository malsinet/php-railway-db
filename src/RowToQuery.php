<?php

/**
 * RowToQuery class file
 *
 * @category   Database
 * @package    Railway Database
 * @author     Martin Alsinet <martin@alsinet>
 * @copyright  2016 @MartinAlsinet
 * @license    MIT License
 * @version    Release: 0.1.0
 * @link       http://github.com/malsinet/railway-database
 */


namespace github\malsinet\Railway\Database;


/**
 * RowToQuery class
 *
 * Methods to transform row arrays to Query snippets
 *
 * @category   Database
 * @package    Railway Database
 * @author     Martin Alsinet <martin@alsinet>
 * @copyright  2016 @MartinAlsinet
 * @license    MIT License
 * @version    Release: 0.1.0
 * @link       http://github.com/malsinet/railway-database
 */
final class RowToQuery implements Contracts\Row
{
    
    public function toFields($row)
    {
        if (!is_array($row)) {
            throw new DatabaseException("Row [$row] must be an array");
        }
        return implode(",", array_keys($row));
    }

    public function toValues($row)
    {
        if (!is_array($row)) {
            throw new DatabaseException("Row [$row] must be an array");
        }
        return implode(
            ",",
            array_map(
                function($s){return ":".$s;},
                array_keys($row)
            )
        );
    }

    public function toPredicates($row)
    {
        if (!is_array($row)) {
            throw new DatabaseException("Row [$row] must be an array");
        }
        $preds = "";
        foreach ($row as $field => $value) {
            $preds.= "({$field} = :{$field}) AND ";
        }
        $preds = preg_replace("/ AND $/", "", $preds);
        return $preds;
    }

    public function toBinds($row)
    {
        if (!is_array($row)) {
            throw new DatabaseException("Row [$row] must be an array");
        }
        $binds = array();
        foreach ($row as $field => $value) {
            $binds[":".$field] = $value;
        }
        return $binds;
    }

    public function toUpdate($row, $idField)
    {
        if (!is_array($row)) {
            throw new DatabaseException("Row [$row] must be an array");
        }
        $update = "";
        foreach ($row as $field => $value) {
            if ($field!=$idField) {
                $update.= "{$field} = :{$field}, ";
            }
        }
        $update = preg_replace("/, $/", "", $update);
        return $update;
    }

}