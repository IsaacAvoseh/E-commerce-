<?php

namespace App\Http\Controllers;

use App\Mail\Transactions;
use App\Models\Brand;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Shipping;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use PhpParser\Node\Expr\FuncCall;
use Symfony\Component\VarDumper\Cloner\Data;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('brand', 'category')->get();
        return response()->json([
            'success' => 'Successfully retrieved products!',
            'data' => $products
        ], 200);
    }

    

    public function show($id)
    {
        $product = Product::with('brand', 'category')->find($id);
        return response()->json([
            'success' => 'Successfully retrieved product!',
            'data' => $product
        ], 200);
        // dd($product);

    }

    //get all products by category
    public function getByCategory($id)
    {
        $products = Product::with('brand', 'category')->where('category_id', $id)->get();
        return response()->json([
            'success' => 'Successfully retrieved products!',
            'data' => $products
        ], 200);
    }

    //get all products by brand
    public function getByBrand($id)
    {
        $products = Product::with('brand', 'category')->where('brand_id', $id)->get();
        return response()->json([
            'success' => 'Successfully retrieved products!',
            'data' => $products
        ], 200);
    }

    public function getCategories()
    {
        $categories = Category::all();
        return response()->json([
            'success' => 'Successfully retrieved categories!',
            'data' => $categories
        ], 200);
    }

    public function getBrands()
    {
        $brands = Brand::all();
        return response()->json([
            'success' => 'Successfully retrieved brands!',
            'data' => $brands
        ], 200);
    }

    public function store(Request $request)
    {
      if($request->isMethod('post')){
        //   dd($request->all());
            //add new product with 4 images 
            $request->validate([
                'name' => 'required',
                // 'price' => 'required',
                // 'discount_price' => 'required',
                // 'product_code' => 'required',
                // 'image' => 'required',
                // 'image_1' => 'required',
                // 'image_2' => 'required',
                // 'image_3' => 'required',
                // 'description' => 'required',
                // 'color' => 'required',
                // 'size' => 'required',
                // 'brand_id' => 'required',
                // 'category_id' => 'required',
            ]);

            $product = new Product();
            $product->name = $request->name;
            $product->price = $request->price;
            $product->discount_price = $request->discount_price;
            $product->product_code = strtoupper(substr($request->name, 0, 1)) . rand(100000, 999999);
            $product->description = $request->description;
            $product->color = $request->color;
            $product->size = $request->size;
            $product->brand_id = $request->brand_id;
            $product->category_id = $request->category_id;
            $product->isfeatured = $request->isfeatured;


                $image = $request->file('image');
                $image_1 = $request->file('image_1');
                $image_2 = $request->file('image_2');
                $image_3 = $request->file('image_3');

                $image_name = $image->getClientOriginalName();
                $image_1_name = $image_1->getClientOriginalName();
                $image_2_name = $image_2->getClientOriginalName();
                $image_3_name = $image_3->getClientOriginalName();


                $image->move(public_path('images'), $image_name);
                $image_1->move(public_path('images'), $image_1_name);
                $image_2->move(public_path('images'), $image_2_name);
                $image_3->move(public_path('images'), $image_3_name);

              
        
            $product->image = $image_name;
            $product->image_1 = $image_1_name;
            $product->image_2 = $image_2_name;
            $product->image_3 = $image_3_name;   

         

           $saved = $product->save();

           if($saved){

               return redirect()->back()->with('success', 'Product added successfully!');
           }

      }

        $brands = Brand::all();
        $categories = Category::all();
    
        $products = Product::with('brand')->with('category')->get();

      return view('product', compact('brands', 'categories', 'products'));
    }

    //get featured products
    public function getFeatured()
    {
        $products = Product::with('brand', 'category')->where('isfeatured', 1)->inRandomOrder()->get();
        return response()->json([
            'success' => 'Successfully retrieved featured products!',
            'data' => $products
        ], 200);
    }

    //get latest products
    public function getLatest()
    {
        $products = Product::with('brand', 'category')->orderBy('created_at', 'desc')->limit(6)->get();
        return response()->json([
            'success' => 'Successfully retrieved latest products!',
            'data' => $products
        ], 200);
    }

    //get trending products where product name appears more than three times
 
    public function getTrending()
    {
       $trending = Payment::with('product')->select('product_name', DB::raw('count(*) as total'))->groupBy('product_name')->limit(6)->get();
         return response()->json([
                'success' => 'Successfully retrieved trending products!',
                'data' => $trending
          ], 200);
    }
   


    public function delete($id)
    {

        //find product by id
        $product = Product::find($id);
        $product->delete();
        return response()->json([
            'message' => 'Successfully deleted product!'
        ], 200);
    }

    //add new brand
    public function addBrand(Request $request)
    {
        if ($request->isMethod('post')) {
            // dd($request->all());
            //add new product with 4 images 
            $request->validate([
                'name' => 'required',
                'description' => 'required',
            ]);

            $brand = new Brand();
            $brand->name = $request->name;
            $brand->description = $request->description;

            if (request()->hasFile('image')) {
                $image = $request->file('image');
                $imageName = $image->getClientOriginalName();
                $image->move(public_path('images'), $imageName);
                $brand->image = $imageName;
            }

            $saved = $brand->save();
            if ($saved) {

                return redirect()->back()->with('success', 'Brand added successfully!');
            }
        }

        return view('brand');
    }

    //add new category
    public function addCategory(Request $request)
    {
        if ($request->isMethod('post')) {
            $request->validate([
                'name' => 'required',
                'description' => 'required',
            ]);

            $category = new Category();
            $category->name = $request->name;
            $category->description = $request->description;
            if (request()->hasFile('image')) {
                $image = $request->file('image');
                $imageName = $image->getClientOriginalName();
                $image->move(public_path('images'), $imageName);
                $category->image = $imageName;
            }

            $saved = $category->save();
            if ($saved) {

                return redirect()->back()->with('success', 'Category added successfully!');
            }
        }

        return view('category');
    }



    public function update(Request $request, $id)
    {
        $product = Product::find($id);
        $product->update($request->all());
        return response()->json([
            'message' => 'Successfully updated product!',
            'data' => $product
        ], 200);
    }

    //handle incoming request for cart and save to payment table
    public function initialPaymentDetails(Request $request)
    {
        $data = $request->all();
        //loop through the cart items
        foreach ($data['cart']['items'] as $item) {
            $payment = new Payment();
           
                $payment->product_name = $item['name'];
                $payment->product_code = $item['product_code'];
                $payment->amount = $item['price'];
                $payment->quantity = $item['quantity'];
                $payment->total = $item['itemTotal'];
                $payment->reference = $data['reference'];
                $payment->status = 'pending';
                $payment->total_items = $data['cart']['totalItems'];
                $payment->grand_total = $data['cart']['cartTotal'];
                $payment->user_id = $data['user_id'];
                $payment->shipping_id = $data['shipping_id'];
                $payment->save();
            
        }


        return response()->json([
            'success' => 'Successfully saved payment details!',
            'data' => $payment
        ], 200);
    
    
    
    }

    public function mail()
    {
         return view('mail.transactions');
     }

    //update payment status success or failed
    public function updatePaymentStatus(Request $request)
    {
        $data = $request->all();
     
        $payment = DB::table('payments')->where('reference', $data['reference'])->update(['status' => $data['status']]);
        // Mail::to($order->email)->send(new MailOrder($order));
        
        Mail::to($data['email'])->send(new Transactions($data));

        return response()->json([
            'success' => 'success',
            'data' => $payment
        ], 200);
    }


    public function shippingDetails(Request $request){
        if ($request->isMethod('post')) {
            $shipping = new Shipping();
            $shipping->firstname = $request->firstname;
            $shipping->lastname = $request->lastname;
            $shipping->email = $request->email;
            $shipping->address = $request->address;
            $shipping->address2 = $request->address2;
            $shipping->city = $request->city;
            $shipping->state = $request->state;
            $shipping->zip = $request->zip;
            $shipping->user_id = $request->user_id;
            $saved = $shipping->save();
           if ($saved){
               return response()->json([
                   'success' => 'Successfully saved shipping details!',
                   'data' => $shipping
               ], 200);
           }
        }
        //get shiping details of logged in user
        $shipping = Shipping::where('user_id', Auth::user()->id)->first();
        return response()->json([
            'success' => 'Successfully got shipping details!',
            'data' => $shipping
        ], 200);
    }


    public function shippings(Request $request)
    {
        $shippings = Shipping::all();
        return response()->json([
            'message' => 'Successfully retrieved shipping details!',
            'data' => $shippings
        ], 200);
    }

  public function cart(){
      //save cart items to carts table
        $cart = new Cart();
        
  }

  public function getCart(Request $request){
      $cart = Cart::where('user_id', Auth::user()->id)->get();
      return response()->json([
          'message' => 'Successfully retrieved cart items!',
          'data' => $cart
      ], 200);
  }

    public function addToCart(Request $request){
        $data = $request->all();
        $cart = new Cart();
        $cart->product_name = $data['product_name'];
        $cart->product_code = $data['product_code'];
        $cart->price = $data['price'];
        $cart->quantity = $data['quantity'];
        $cart->total = $data['total'];
        $cart->user_id = Auth::user()->id;
        $saved = $cart->save();
        if ($saved){
            return response()->json([
                'success' => 'Successfully saved cart item!',
                'data' => $cart
            ], 200);
        }
    }

    public function deleteProduct($id){
        $product = Product::find($id);
        $product->delete();
      return back()->with('success', 'Product deleted successfully!'); 
    }

    public function updateProduct(Request $request, $id){
       $product = Product::find($id);
   if($request->isMethod('post')){
            $image = $request->file('image');
            $image_1 = $request->file('image_1');
            $image_2 = $request->file('image_2');
            $image_3 = $request->file('image_3');

            $image_name = $image->getClientOriginalName();
            $image_1_name = $image_1->getClientOriginalName();
            $image_2_name = $image_2->getClientOriginalName();
            $image_3_name = $image_3->getClientOriginalName();


            $image->move(public_path('images'), $image_name);
            $image_1->move(public_path('images'), $image_1_name);
            $image_2->move(public_path('images'), $image_2_name);
            $image_3->move(public_path('images'), $image_3_name);

            $updateProduct = DB::table('products')->where('id', $id)->update([
                'name' => $request->name,
                'price' => $request->price,
                'discount_price' => $request->discount_price,
                'product_code' => strtoupper(substr($request->name, 0, 1)) . rand(100000, 999999),
                'description' => $request->description,
                'color' => $request->color,
                'size' => $request->size,
                'brand_id' => $request->brand_id,
                'category_id' => $request->category_id,
                'isfeatured' => $request->isfeatured,
                'image' => $image_name,
                'image_1' => $image_1_name,
                'image_2' => $image_2_name,
                'image_3' => $image_3_name,

            ]);

          return redirect()->route('product')->with('success', 'Product updated successfully!');
   }

        $brands = Brand::all();
        $categories = Category::all();

   return view('update', compact('product', 'brands', 'categories'));
    
     
    }


}
