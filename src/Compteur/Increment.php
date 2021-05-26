<?php

namespace App\Compteur;

class Increment{

    /**
     * @var string the path use to recuper the data
     */
    private $file;

    public function __construct(string $file)
    {
        $this->file = $file;
    }
    
    /**
     * addViews add the  view user in the data file
     *
     * @return void
     */
    public function addViews(): void
    {
        $fileDays = $this->file . '-' . date('Y-m-d');
        $this->incrementCompteur($this->file);
        $this->incrementCompteur($fileDays);
    }
    
    /**
     * incrementCompteur
     *
     * @param  string $file
     * @return void
     */
    private function incrementCompteur(string $file) : void
    {
        $compteur = 1;
        if(file_exists($file)){
            $compteur = file_get_contents($file);
            $compteur++;
        }
        file_put_contents($file, $compteur);
    }
    
    /**
     * countViews the total for the visits 
     *
     * @return string
     */
    public function countViews(): string 
    {
        return file_get_contents($this->file);
    }
    
    /**
     * countViewsOnMonth count the user in one month
     *
     * @param  int  $year
     * @param  int $month
     * @return int the number of the users in on month
     */
    public function countViewsOnMonth(int $year, int $month) :  int 
    {
        $month = str_pad($month, 2, '0', STR_PAD_LEFT);
        $file = $this->file . '-'. $year .'-' . $month . '-' . '*';
        $files = glob($file);
        $count = 0;
        foreach($files as $file){
            $count += (int)file_get_contents($file);
        }

        return $count;
    }
    
    /**
     * countViewsDetailsOneMonth
     *
     * @param  int $year
     * @param  int $month
     * @return array
     */
    public function countViewsDetailsOneMonth(int $year,int $month) :array 
    {
        $month = str_pad($month, 2, '0', STR_PAD_LEFT);
        $file = $this->file . '-'. $year .'-' . $month . '-' . '*';
        $files = glob($file);
        $visites = [];
        foreach($files as $file){
            $parths = explode('-', basename($file));
            $visites [] = [
                'annee' => $parths[1],
                'annee' => $parths[1],
                'jour' => $parths[3],
                'visites' => file_get_contents($file)
            ];
        }
        return $visites;
    }
    
}