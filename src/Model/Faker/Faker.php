<?php 
namespace App\Model\Faker;

class Faker{
    
    // TODO add the all method for the faker data
    private $model;

    public function __construct($model)
    {
        $this->model = $model;
    }

    public function text( int $length): string 
    {
        $text = "";
        for($i = 0; $i< $length; $i++){

        }
        return "";
    }
    public function paragraphs(int $length): string
    {
        return "";
    }

    public function phone() : string
    {
        return "";
    }

    public function email() : string 
    {
         return "";
    }

    public function title() : string 
    {
        return "";
    }
}