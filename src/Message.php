<?php

namespace App;

use App\Model\Model;

/**
 * @author Hariitana24
 * Haritian Randria
 *
 */

class  Message extends Model{

    const LIMIT_USERNAME = 3;
    const LIMIT_MESSAGE = 10;
    private $username;
    private $message;
    private $date;
    protected static $model = "messages";

    public function __construct(string $username, string $message, ?DateTime $date = null)
    {
        $this->username = $username;
        $this->message = $message;
        $this->date = $date ?: new \DateTime();
    }
    
    /**
     * isValid Connaitre si le champ est vailde ou pas
     *
     * @return bool (ex: true ou false)
     */
    public function  isValid(): bool
    {
        return empty($this->getErrors());
    }
    
    /**
     * getErrors récuperer tous les erreur tapez par l'utilisateur
     *
     * @return array les different sorte d'erreur (ex: formulaire invalid)
     */
    public function getErrors():array
    {
        $errors = [];
        if (strlen($this->username) < self::LIMIT_USERNAME)
        {
            $errors['username'] = 'Votre username est trop court';
        }
        if (strlen($this->message) < self::LIMIT_MESSAGE)
        {
            $errors['message'] = 'Votre message est top court';
        }
        return $errors;
    }
    
    /**
     * toHTML convetrir le message en code html pour l'afficher
     *
     * @return string (ex : <p>Pseudo : Message</p>)
     */
    public function toHTML(): string
    {
        $username = htmlentities($this->username);
        $this->date->setTimezone( new \DateTimeZone('Europe/Paris'));
        $date = $this->date->format('d/m/Y à H:i');
        $message = nl2br(htmlentities($this->message));
        return <<<HTML
         <p>
          <strong><a href="#">{$username}</a></strong> <em> le {$date}</em><br>
          $message
         </p>
HTML;

    }
    
    /**
     * toJSON rendre le message en json  
     *
     * @return string
     */
    public function toJSON():string
    {
       return json_encode([
            'username' => $this->username,
            'message' => $this->message,
            'date' => $this->date->getTimestamp()
        ]);
    }

    public function  getUsername(){
        return $this->username;
    }

    public function getMessage(){
        return $this->message;
    }
}