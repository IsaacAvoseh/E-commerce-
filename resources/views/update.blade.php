<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update</title>
</head>

<body>
    @if (Session::has('success'))
    <div class="alert alert-success">
        {{ Session::get('success') }}
    </div>
    @endif
    <h1>Update Product</h1>

    <form method="post" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control" name="name" id="name" placeholder="Enter Product Name" value="{{ $product->name }}">
        </div>
        <div class="form-group">
            <label for="price">Price</label>
            <input type="text" class="form-control" name="price" id="price" placeholder="Enter Product Price" value="{{ $product->price }}">
        </div>
        <div class=" form-group">
            <label for="discount_price">Discount Price</label>
            <input type="text" class="form-control" name="discount_price" id="discount_price" placeholder="Enter Product Discount Price" value="{{ $product->discount_price }}">
        </div>
        <!-- <div class="form-group">
            <label for="product_code">Product Code</label>
            <input type="text" class="form-control" name="product_code" id="product_code" placeholder="Enter Product Code">
        </div> -->
        <div class="form-group">
            <label for="image">Image</label>
            <input type="file" class="form-control" name="image" id="image" placeholder="Enter Product Image" value="{{ $product->image }}">
        </div>
        <div class="form-group">
            <label for="image_1">Image 1</label>
            <input type="file" class="form-control" name="image_1" id="image_1" placeholder="Enter Product Image 1" value="{{ $product->image1 }}">
        </div>
        <div class="form-group">
            <label for="image_2">Image 2</label>
            <input type="file" class="form-control" name="image_2" id="image_2" placeholder="Enter Product Image 2" value="{{ $product->image2 }}">
        </div>
        <div class="form-group">
            <label for="image_3">Image 3</label>
            <input type="file" class="form-control" name="image_3" id="image_3" placeholder="Enter Product Image 3" value="/images/{{$product->image_3}}">
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea class="form-control" name="description" id="description" rows="3"> {{ $product->description }} </textarea>
        </div>
        <div class="form-group">
            <label for="color">Color</label>
            <input type="text" class="form-control" name="color" id="color" placeholder="Enter Product Color" value="{{ $product->color}}">
        </div>
        <div class="form-group">
            <label for="size">Size</label>
            <input type="text" value="{{ $product->size}}" class="form-control" name="size" id="size" placeholder="Enter Product Size">
        </div>
        <input name="category_id" hidden value="{{ $product->category->id }}" />
        <input name="brand_id" hidden value="{{ $product->brand->id }}" />


        <div class="form-group">
            <label for="featured">Feature ?</label>
            <select name="isfeatured" class="form-control" id="">
                <option value="0">No</option>
                <option value="1">Yes</option>
            </select>

        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>

</body>

</html>