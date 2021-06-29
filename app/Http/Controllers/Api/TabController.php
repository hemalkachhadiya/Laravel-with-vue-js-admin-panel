<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tbl_tab;
use App\Http\Resources\TabResource;

class TabController extends Controller
{
    public function index(){
        return TabResource::collection(Tbl_tab::orderBy('position','ASC')->get());
    }
}
