<?php

namespace App\Models;

use Illuminate\Database\Query\Builder as BaseBuilder;


/**
 * Class Builder
 * @package App\Models
 */
class Builder extends BaseBuilder {
    /**
     * @param $column
     * @param $value
     * @return $this
     */
    public function whereNot($column ,$value) {
        $operator = "!=";
        $this->where($column, $operator ,$value);
        return $this;
    }

    /**
     * @param $column
     * @param $value
     * @return $this
     */
    public function whereLargerThen($column, $value) {
        $operator = ">";
        $this->where($column, $operator ,$value);
        return $this;
    }

    /**
     * @param $column
     * @param $value
     * @return $this
     */
    public function whereLargerThenOrEqualTo($column, $value) {
        $operator = ">=";
        $this->where($column, $operator ,$value);
        return $this;
    }

    /**
     * @param $column
     * @param $value
     * @return $this
     */
    public function whereSmallerThen($column, $value) {
        $operator = "<";
        $this->where($column, $operator ,$value);
        return $this;
    }

    /**
     * @param $column
     * @param $value
     * @return $this
     */
    public function whereSmallerThenOrEqualTo($column, $value) {
        $operator = "<=";
        $this->where($column, $operator ,$value);
        return $this;
    }

    /**
     * @param $column
     * @param $value
     * @return $this
     */
    public function whereLike($column, $value) {
        $operator = "LIKE";
        $this->where($column, $operator, "%".$value."%");
        return $this;
}

}
