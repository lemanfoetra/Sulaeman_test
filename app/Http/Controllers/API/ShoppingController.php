<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddShoppingRequest;
use App\Http\Resources\ShoppingResource;
use App\Shopping;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ShoppingController extends Controller
{

    public function __construct()
    {
        $this->middleware('jwt.verify');
    }


    public function index()
    {
        return ShoppingResource::collection(Shopping::paginate(10));
    }



    public function submit(AddShoppingRequest $request)
    {
        $shoping = new Shopping();
        $shoping->name = $request->name;
        $shoping->createdate = $request->createdate;
        $shoping->save();
    }



    public function update(AddShoppingRequest $request, $id)
    {
        $data['name'] = $request->name;
        $data['createdate'] = $request->createdate;

        $status = DB::table('shopping')->where('id', $id)->update($data);
        if ($status) {
            return response()->json(
                [
                    'message' => 'Success',
                ],
            );
        }
        return response()->json(
            [
                'message' => 'Gagal',
            ],
        );
    }




    public function delete($id)
    {
        if (Shopping::destroy($id)) {
            return response()->json(
                [
                    'message' => 'Success',
                ],
            );
        }
        return response()->json(
            [
                'message' => 'Gagal',
            ],
        );
    }



    public function product($id)
    {
        $result = DB::table('shopping')->where('id', $id)->get();

        if (count($result) > 0) {
            return response()->json(
                [
                    'shopping'    =>  [
                        'name' => $result[0]->name,
                        'createdate' => $result[0]->createdate,
                    ]
                ],
                200
            );
        }
        return response()->json(
            [
                'message' => 'Data tidak tersedia',
            ],
        );
    }
}
