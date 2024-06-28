<?php

namespace App\Http\Controllers\Api\List;

use App\Http\Controllers\Controller;
use App\Http\Resources\AnnouncementCategoryResource;
use App\Models\AnnouncementCategory;
use Illuminate\Http\Request;

class ListAdsCategoryController extends Controller
{
    public function list(){
        $categories = AnnouncementCategoryResource::collection(AnnouncementCategory::all());
        return $categories;
    }
}