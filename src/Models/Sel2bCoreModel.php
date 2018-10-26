<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 10/26/2018
 * Time: 1:53 PM
 */

namespace Sel2b\Core\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Sel2b\Core\Libraries\Constant;

abstract class Sel2bCoreModel extends Model
{
    public function getTime()
    {
        return date(Constant::FORMAT_DATE_TIME_DB);
    }

    public static function getTableName()
    {
        return (new static)->getTable();
    }

    public static function getPriKeyName()
    {
        return (new static)->getKeyName();
    }

    public static function getColumnName($column)
    {
        return self::getTableName() . '.' . $column;
    }

    public function getCreatedAtAttribute($attr)
    {
        return Carbon::parse($attr)->format(Constant::FORMAT_DATE_TIME);
    }

    public function getUpdatedAtAttribute($attr)
    {
        return Carbon::parse($attr)->format(Constant::FORMAT_DATE_TIME);
    }

    protected function getDateTimeTypeValue($attr)
    {
        if ($attr instanceof \DateTime) {
            return $attr->format(Constant::FORMAT_DATE_TIME);
        }
        return Carbon::parse($attr)->format(Constant::FORMAT_DATE_TIME);
    }
}