<?php

/**
 * In class file
 *
 * @category   Queries
 * @package    Railway Database
 * @author     Martin Alsinet <martin@alsinet.com.ar>
 * @copyright  2016 @MartinAlsinet
 * @license    MIT License
 * @version    Release: 0.1.0
 * @link       http://github.com/malsinet/railway-database
 */


namespace github\malsinet\Railway\Database\Queries;

use github\malsinet\Railway\Database\Contracts\Query;


/**
 * In class
 *
 * Returns an IN clause ("WHERE $field IN ($val1, $val2, $val3,...)")
 *
 * @category   Queries
 * @package    Railway Database
 * @author     Martin Alsinet <martin@alsinet.com.ar>
 * @copyright  2016 @MartinAlsinet
 * @license    MIT License
 * @version    Release: 0.1.0
 * @link       http://github.com/malsinet/railway-database
 */
final class In implements Query
{
    private $origin;

    private $field;

    private $inValues;

    private $strBind;
    
    public $table;

    public $pk;
    
    public $row;
    
    public function __construct($origin, $field, $inValues, $strBind=false)
    {
        $this->origin   = $origin;
        $this->table    = $origin->table;
        $this->pk       = $origin->pk;
        $this->row      = $origin->row;
        $this->field    = $field;
        $this->inValues = $inValues;
        $this->strBind  = $strBind;
    }

    public function query($row=array())
    {
        if (empty($this->origin)) {
            throw new QueryException("Origin query object cannot be empty");
        }
        if (empty($this->field)) {
            throw new QueryException("In field property cannot be empty");
        }
        if (empty($this->inValues)) {
            throw new QueryException("In values property cannot be empty");
        }
        if (!is_array($this->inValues)) {
            throw new QueryException("In value property must be an array");
        }
        $query  = $this->origin->query($row);
        $clause = "";
        foreach ($this->inValues as $value) {
            $clause.= $this->strBind ? "'{$value}', " : "{$value}, ";
        }
        $clause = preg_replace("/, $/", "", $clause);
        if (preg_match("/ WHERE /i", $query)) {
            $query.= " AND ({$this->field} IN ({$clause}))"; 
        } else {
            $query.= " WHERE ({$this->field} IN ($clause))"; 
        }
        return $query;
    }

}