<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class Model
 * @package App\Models
 */
abstract  class Model extends Eloquent {

    /**
     * @return Builder
     */
    public function newBaseQueryBuilder() {
        $conn = $this->getConnection();
        $grammar = $conn->getQueryGrammar();
        return new Builder($conn, $grammar, $conn->getPostProcessor());
    }
}