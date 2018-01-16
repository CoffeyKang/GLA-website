<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Inventory;
use Illuminate\Pagination\Paginator;
use App\Inventory_img;
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
    public function product_list($make,$mycurrentPage){
        
        Paginator::currentPageResolver(function () use ($mycurrentPage) {
            return $mycurrentPage;
        });
        $product_list = Inventory::
        join('inventory_img','inventory.item','inventory_img.item')->
        select(['inventory.item','inventory.onhand','inventory.descrip','inventory.price','inventory.price2','inventory.price3','inventory.price4','inventory_img.img_path'])->where('make',$make)->paginate(20) ;
        
        // foreach ($product_list as $item) {
            /**
             * will check if the img exsits or not
             * if not exits
             * a default img will display
             */
            
        // }
        return $product_list;
    }
}
