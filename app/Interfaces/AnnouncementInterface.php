<?php

namespace App\Interfaces;

interface AnnouncementInterface 
{
    public function getAllAnnouncements();
    public function getAnnouncementById($AnnoucementId);
    public function deleteAnnouncement($AnnoucementId);
    public function createAnnouncement(array $AnnoucementDetails);
    public function updateAnnouncement($AnnoucementId, array $newDetails);
    public function getAnnouncementsByTown();
}