<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>Product</title>
</head>

<body>
    <!-- Add new Product form -->
    @if (Session::has('success'))
    <div class="alert alert-success">
        {{ Session::get('success') }}
    </div>
    @endif
    <div class='container col-lg-6'>
        <h2>Add a Product </h2>

        <form method="post" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" name="name" id="name" placeholder="Enter Product Name">
            </div>
            <div class="form-group">
                <label for="price">Price</label>
                <input type="text" class="form-control" name="price" id="price" placeholder="Enter Product Price">
            </div>
            <div class="form-group">
                <label for="discount_price">Discount Price</label>
                <input type="text" class="form-control" name="discount_price" id="discount_price" placeholder="Enter Product Discount Price">
            </div>
            <!-- <div class="form-group">
            <label for="product_code">Product Code</label>
            <input type="text" class="form-control" name="product_code" id="product_code" placeholder="Enter Product Code">
        </div> -->
            <div class="form-group">
                <label for="image">Image</label>
                <input type="file" class="form-control" name="image" id="image" placeholder="Enter Product Image">
            </div>
            <div class="form-group">
                <label for="image_1">Image 1</label>
                <input type="file" class="form-control" name="image_1" id="image_1" placeholder="Enter Product Image 1">
            </div>
            <div class="form-group">
                <label for="image_2">Image 2</label>
                <input type="file" class="form-control" name="image_2" id="image_2" placeholder="Enter Product Image 2">
            </div>
            <div class="form-group">
                <label for="image_3">Image 3</label>
                <input type="file" class="form-control" name="image_3" id="image_3" placeholder="Enter Product Image 3">
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control" name="description" id="description" rows="3"></textarea>
            </div>
            <div class="form-group">
                <label for="color">Color</label>
                <input type="text" class="form-control" name="color" id="color" placeholder="Enter Product Color">
            </div>
            <div class="form-group">
                <label for="size">Size</label>
                <input type="text" class="form-control" name="size" id="size" placeholder="Enter Product Size">
            </div>
            <div class="form-group">
                <label for="brand_id">Brand</label>
                <select class="form-control" name="brand_id" id="brand_id">
                    <option value="">Select Brand</option>
                    @foreach($brands as $brand)
                    <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="category_id">Category</label>
                <select class="form-control" name="category_id" id="category_id">
                    <option value="">Select Category</option>
                    @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="featured">Feature ?</label>
                <select name="isfeatured" class="form-control" id="">
                    <option value="0">No</option>
                    <option value="1">Yes</option>
                </select>

            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>


    <!-- Display list of products -->
    <div class="container-fluid">
        <h2>List of Products</h2>
        <table class="table-responsive">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Discount Price</th>
                    <th>Product Code</th>
                    <th>Image</th>
                    <th>Image 1</th>
                    <th>Image 2</th>
                    <th>Image 3</th>
                    <th>Description</th>
                    <th>Color</th>
                    <th>Size</th>
                    <th>Brand</th>
                    <th>Category</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                <tr>
                    <td>{{ $product->id }}</td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->price }}</td>
                    <td>{{ $product->discount_price }}</td>
                    <td>{{ $product->product_code }}</td>
                    <td><img src="/images/{{$product->image}}" alt="{{ $product->name}}" width="100"></td>
                    <td><img src="/images/{{$product->image_1}}" alt="{{ $product->name }}" width="100"></td>
                    <td><img src="/images/{{$product->image_2}}" alt="{{ $product->name }}" width="100"></td>
                    <td><img src="/images/{{$product->image_3}}" alt="{{ $product->name }}" width="100"></td>
                    <td>{{ $product->description }}</td>
                    <td>{{ $product->color }}</td>
                    <td>{{ $product->size }}</td>
                    <td>{{ $product->brand->name }}</td>
                    <td>{{ $product->category->name }}</td>
                    <td>
                        <a href='' class="btn btn-primary">Edit</a>
                        <form action="" method="post" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger" type="submit">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</body>

</html>