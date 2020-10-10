<?php

namespace App\Http\Controllers;

use App\City;
use App\Repository\CityRepository;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cities = (new CityRepository())->all();
        return view('city.distance')->with('cities',$cities);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('city.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $request->validate(['name' => 'required', 'lat' => 'required', 'log' => 'required']);
            $city = [$request->input('name'), $request->input('lat'), $request->input('log')];
            (new CityRepository())->save($city);
            return response()->json(['message' => 'Cidade Criada com sucesso'], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erro ao salvar a cidade'], 400);
        }
    }
}
