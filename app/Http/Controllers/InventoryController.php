<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Inventory;
class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Inventory::all()->take(2);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    /**
     * display products_list
     * @param  make $data [description]
     * @return [type]       [description]
     */
    public function product_list($make){
        
        $product_list = Inventory::where('make',$make)->select(['item','onhand','descrip','price','price2','price3','price4'])->take(50)->get()->toArray() ;

        $paths = [];
        $i = 0;
        foreach ($product_list as $item) {
            
            // $item['path'] = "/images/products/thumb/".$item['item'].".jpg";
            $img_src ="/images/products/thumb/".$item['item'].".jpg";
            
            $paths[$i] = $img_src;
            // $paths[$i] =  file_exists ( $img_src )? "/images/products/thumb/".$item['item'].".jpg" :"default";
            
            $i++;
        }
       

        $lists = array_map(null, $product_list,$paths);

        

        




        return $lists;
    }
}
