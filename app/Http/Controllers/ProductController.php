<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Exports\ProductExport;
use App\Imports\ProductImport;
use Maatwebsite\Excel\Facades\Excel;
class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!session('isLogin')) {
            return redirect()->route('login');
        }

        $pageItem = $request->query('item')?? 3;
        $len = DB::table('products')->count();
        $pageNumber = ceil($len/$pageItem);
        $products = DB::table('products')->paginate($pageItem);
        return view('product.index', ['products' => $products, 'pageNumber' => $pageNumber]);
    }

    public function add()
    {
        if (!session('isLogin')) {
            return redirect()->route('login');
        }
        return view('product.add');
    }

    public function edit($id)
    {
        if (!session('isLogin')) {
            return redirect()->route('login');
        }
        $product = DB::table('products')->find($id);
        return view('product.edit', ['product' => $product]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $product = $request->validate([
            'name' => 'required|string|max:255',
            'quantity' => 'required|numeric',
        ]);

        Product::create([
            'name' => $product['name'],
            'quantity' => $product['quantity'],
        ]);

        return redirect()->route('product');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = DB::table('products')->find($id);
        return view('product.detail', ['product' => $product]);
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
        $product = $request->validate([
            'name' => 'required|string|max:255',
            'quantity' => 'required|numeric',
        ]);

        $product = DB::table('products')->where('id', $id)->update($product);

        return redirect()->route('product');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->back();
    }

    public function export() 
    {
        return Excel::download(new ProductExport, 'product.csv'); //download file export
        return Excel::store(new ProductExport, 'product.csv'); //lưu file export trên ổ cứng
    }

    public function import(Request $request) 
    {
        $file = $request->file("fileCSV");
        
        $fullPathFile = $file->store('products'); 

        Excel::import(new ProductImport, $fullPathFile);

        return redirect()->back()->with('success', 'Import thành công');
    }
}
