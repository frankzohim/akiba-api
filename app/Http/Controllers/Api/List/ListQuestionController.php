<?php

namespace App\Http\Controllers\Api\List;

use App\Http\Controllers\Controller;
use App\Models\Question;
use Illuminate\Http\Request;

class ListQuestionController extends Controller
{
    public function list(){

        $questions=Question::all();

        return $questions;
    }

    public function filter($id){

        $question=Question::find($id);

        return $question;
    }
}
