<?php

namespace App\Models;

use App\DB;

class Model
{
    protected $db;

    public function __construct()
    {
        $this->db = new DB;
    }

    public function getLastId(string $table)
    {
        $this->db->query("SELECT MAX(id) FROM $table");

        return $this->db->single()->{'MAX(id)'};
    }
}