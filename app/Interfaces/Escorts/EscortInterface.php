<?php

namespace App\Interfaces\Escorts;

interface EscortInterface 
{
    public function getAllEscorts();
    public function getEscortById($EscortId);
    public function deleteEscort($EscortId);
    public function updateEscort($EscortId, array $newDetails);
}