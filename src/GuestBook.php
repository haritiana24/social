<?php

namespace App;
use \PDO;
/**
 * Author
 * Haritina Randria
 */
class GuestBook{
    private $pdo;
    private $date;
    public function __construct($pdo)
    {
       /*$directory = dirname($file);
       if (!is_dir($directory))
       {
           mkdir($file, 0777, true);
       }
       if (!file_exists($file))
       {
           touch($file);
       }
       */
        $jour = date('d');
        $mois = date('m');
        $annee = date('Y');
        $heure = date('H');
        $minute = date('i');
        $seconde = date('s');
        $this->pdo = $pdo;
        $this->date = $annee . '-' . $mois . '-' . $jour .' '.$heure . ':'. $minute .':'.$seconde;
    }
    
    /**
     * addMessage
     *
     * @param  mixed $message Message by the user
     * @return void (Add the message in the database)
     */
    public function addMessage(Message $message): void
    {
       $req =  $this->pdo->prepare('INSERT INTO messages(username, message, created_at, updated_at) VALUES(:username, :message, :created_at, :updated_at)');
        $req->execute([
            'username' => $message->getUsername(),
            'message' => $message->getMessage(),
            'created_at' => $this->date,
            'updated_at' => $this->date
        ]);
       //file_put_contents($this->file, $message->toJSON() . PHP_EOL,FILE_APPEND);
    }
    
    /**
     * getMessage get message 
     *
     * @return array  (ex : name['username'],name['message])
     */
    public function getMessage(): array
    {
        $req = $this->pdo->query('SELECT * FROM messages ORDER BY id DESC ');
        return $req->fetchAll(PDO::FETCH_ASSOC);
       /* $content = trim(file_get_contents($this->file));
        $lines = explode(PHP_EOL, $content);
        $messages = [];
        foreach ($lines as $line){
            $data = json_decode($line, true);
            $messages[] = new Message($data['username'], $data['message'],
                new DateTime('@' . $data['date']));
        }
        return array_reverse($messages);
       */
    }
}