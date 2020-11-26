<?php

namespace App\Models;

class Repository
{
    public $id;
    public $full_name;
    public $url;
    public $language;

    public function __construct($id, $full_name, $url, $language)
    {
        $this->id = $id;
        $this->full_name = $full_name;
        $this->url = $id;
        $this->language = $language;
    }
}
