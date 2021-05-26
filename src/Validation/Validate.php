<?php 

namespace App\Valiation;

class Validate {
    

    protected $files;
    protected $errors = [];

    public function __construct(array $files)
    {
        $this->files = $files;
    }
}