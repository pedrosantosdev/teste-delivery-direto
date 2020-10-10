<?php

namespace App\Http\Controllers;

use App\Repository\VertexRepository;
use App\Services\DistanceService;
use App\Vertex;
use Illuminate\Http\Request;

class VertexController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json((new VertexRepository())->all());
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function calculateRouteBetweenTwoPoints(Request $request)
    {
        $request->validate(['initialCity' => 'required', 'finalCity' => 'required']);
        $vertexs = (new VertexRepository())->all();
        $route = DistanceService::calcDistanceGraph($vertexs, $request->input('initialCity'), $request->input('finalCity'));
        return response()->json($route);
    }
}
