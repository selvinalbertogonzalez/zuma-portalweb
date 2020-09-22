<?php

namespace App\Export;
use Maatwebsite\Excel\Concerns\FromCollection;

class UserExport implements FromCollection {
    public $coll;
    public function __constructor($collection) {
        $this->coll = $collection;
    }

    public function collection() {
        return $this->coll;
    }
}