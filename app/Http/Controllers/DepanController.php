<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
class DepanController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('index' , compact('categories'));
    }
}
