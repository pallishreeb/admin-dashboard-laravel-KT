<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Query;
class QueryController extends Controller
{
    public function index()
    {
        $queries = Query::with('product')->get();

        return view('queries.index', compact('queries'));
    }
}
