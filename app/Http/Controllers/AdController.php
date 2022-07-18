<?php

namespace App\Http\Controllers;

use App\Ad;
use App\Http\Requests\AdStoreRequest;
use App\Http\Resources\AdResource;
use App\Image;
use Illuminate\Http\Request;

class AdController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sorting = $this->sorting(request()->sort);
        return AdResource::collection(Ad::orderBy($sorting['type'],$sorting['direction'])->paginate(config('paginate.per_page')));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|unique:ads|max:200',
            'description' => 'required|max:1000',
            'price' => ['required','regex:/^(?=.+)(?:[1-9]\d*|0)?(?:\.\d+)?$/'],
            'images' => 'array|max:3'
        ];
        $f = $request->all();
        $validator = \Validator::make($request->all(), $rules);

        if($validator->passes() === false){
            $e = $validator->errors()->messages();
            return response()->json(['id' => null, 'errors' => $e, 'code' => 500]);
        }

        $newAdid = Ad::add($request);
        

        return response()->json(['id' => $newAdid, 'code' => 200]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = new AdResource(Ad::find($id));
        if(!$data->resource){
            return response()->json(['data' => [], 'code' => 404]);
        }
        return $data;
    }

    private function sorting($sort = null)
    {
        if(!$sort){
            return ['type' => 'price', 'direction' => 'asc'];
        }
        
        switch($sort){
            case 'priceUp':
                return ['type' => 'price', 'direction' => 'asc'];
                break;
            case 'priceDown':
                return ['type' => 'price', 'direction' => 'desc'];
                break;
            case 'dateUp':
                return ['type' => 'created_at', 'direction' => 'asc'];
                break;
            case 'dateDown':
                return ['type' => 'created_at', 'direction' => 'desc'];
                break;
        }
    }

}
