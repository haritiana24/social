<?php 

namespace App;

class HTML {    
    /**
     * nav_item  the item for the navigation 
     *
     * @param  string $lien
     * @param  string $title
     * @param  string $linkClass
     * @return string (ex) <li class="nav-item active"><a href="/contact" class="nav-link> Contact </a>
     */
    public static function nav_item(string $lien, string $title,  string $linkClass): string
    {
        $classe = 'nav-item';
        if ($_SERVER['REQUEST_URI'] === $lien)
        {
            $classe .= ' active';
        }
        return <<<HTML
        <li class="$classe">
            <a class="$linkClass" href="$lien">$title</a>
        </li>
HTML;

    }

    /**
     * nav_menu
     *
     * @param  string  $linkClass
     * @return string
     */
    public static function nav_menu($linkClass = ''):string
    {
        return
            self::nav_item('/', 'Acceuil', $linkClass).
            self::nav_item('/contact', 'Contact', $linkClass);
    }

    public static function checkobx(string $name, string $value, array $data): string {
        $attributes = '';
        if(isset($data[$name]) && in_array($value, $data[$name]))
        {
            $attributes .= ' checked';
        }
        return <<<HTML
        <input type="checkbox" name="{$name}[]" value="$value" $attributes>
HTML;

    }

    public static function radio(string $name, string $value, array $data): string {
        $attributes = '';
        if(isset($data[$name]) && $value === $data[$name])
        {
            $attributes .= ' checked';
        }
        return <<<HTML
        <input type="radio" name="$name" value="$value" $attributes>
HTML;

    }
    
    /**
     * select
     *
     * @param  string $name
     * @param  mixed $value
     * @param  array $options
     * @return string
     */
    public  static function select(string $name, $value, array $options):string
    {
        $html_option = [];
        foreach ($options as $k => $option)
        {
            $attributes = $k === $value ? ' selected' : '';
            $html_option[] = "<option value='$k' $attributes>$option</option>";
        }

        return "<select class='form-control' name='$name'>" . implode($html_option) . "</select>";
    }
    
    /**
     * creneaux_html
     *
     * @param  mixed $creneaux
     * @return void
     */
    public static function creneaux_html($creneaux)
    {
        if (empty($creneaux))
        {
            return "Fermé";
        }
        $phrase = [];
        foreach ($creneaux as $creneau)
        {
            $phrase[] = "de <strong>{$creneau[0]}h</strong> à <strong>{$creneau[1]}h</strong>";
        }
        return 'Ouvert ' . implode(' et ', $phrase);
    }
    
    /**
     * in_creneaux
     *
     * @param  int $heure
     * @param  array $creneaux
     * @return bool
     */
    public static function in_creneaux(int $heure, array $creneaux):bool
    {
        foreach ($creneaux as $creneau)
        {
            $debut = $creneau[0];
            $fin = $creneau[1];
            if ($heure >= $debut && $heure < $fin )
            {
                return true;
            }
        }

        return false;
    }
    
    /**
     * escape
     *
     * @param  mixed $variable
     * @return void
     */
    public static function escape($variable) : void 
    {
        htmlentities($variable);
    }
    
    /**
     * likeText 
     *
     * @param  int||null $postLike
     * @param  string||null $postText
     * @return string
     */
    public static function likeText(?int $postLike, ?string  $postText) : string 
    {
        $user = User::getUserAuth();
        $text = "";
        if(is_null($user)){
            $text = " j'aime ";
        }else{
            if(is_null($postLike)){
            $text =  $postText;
            }elseif ($user->id === $postLike){
                $text =  $postText;
            }else{
                $text = " j'aime";
            }
        }
        return $text;
    }

    
    /**
     * isLiked
     *
     * @param  int $user_id
     * @param  int $post_id
     * @return boolean
     */
    public static function isLiked(int $user_id, int $post_id)
    {
        if($user_id === $post_id){
            return  true;
        }

        return false;
    }
}