<?php

/**
 * RowToQuery class file
 *
 * @category   Database
 * @package    Railway Database
 * @author     Martin Alsinet <martin@alsinet.com.ar>
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
 * @author     Martin Alsinet <martin@alsinet.com.ar>
 * @copyright  2016 @MartinAlsinet
 * @license    MIT License
 * @version    Release: 0.1.0
 * @link       http://github.com/malsinet/railway-database
 */
final class RowTowQuery implements Contracts\Row;
{
    
    public function toFields($row)
    {
        return implode(",", array_keys($row));
    }

    public function toValues($row)
    {
        return implode(",", array_map(function($s){return ":".$s;}, array_keys($row)));
    }

    public function toPredicates($row)
    {
        $preds = "";
        foreach ($row as $field => $value) {
            $preds.= "{$field} = :{$field} AND";
        }
        $preds = preg_replace("/ AND$/", "", $update);
        return $preds;
    }

    public function toBinds($row)
    {
        $binds = array();
        foreach ($row as $field => $value) {
            $binds[":".$field] = $value;
        }
        return $binds;
    }

    public function toUpdate($row, $idField)
    {
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