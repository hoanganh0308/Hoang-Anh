composer create-project --prefer-dist laravel/laravel vstore
cd vstore
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=v_store
DB_USERNAME=root
DB_PASSWORD=
CREATE DATABASE v_store;
php artisan make:migration create_item_sales_table --create=item_sale
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemSalesTable extends Migration
{
    public function up()
    {
        Schema::create('item_sale', function (Blueprint $table) {
            $table->id();
            $table->string('item_code', 6);
            $table->string('item_name', 50);
            $table->decimal('quantity');
            $table->date('expired_date')->nullable();
            $table->string('note', 60)->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('item_sale');
    }
}
php artisan migrate
php artisan make:model ItemSale
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemSale extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_code',
        'item_name',
        'quantity',
        'expired_date',
        'note',
    ];
}
php artisan make:controller ItemSaleController
<?php

namespace App\Http\Controllers;

use App\Models\ItemSale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ItemSaleController extends Controller
{
    public function index()
    {
        $items = ItemSale::all();
        return view('items.index', compact('items'));
    }

    public function create()
    {
        return view('items.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'item_code' => 'required|regex:/^[a-zA-Z0-9]+$/',
            'item_name' => 'required|regex:/^[a-zA-Z0-9\s]+$/',
            'quantity' => 'required|numeric',
            'expired_date' => 'nullable|date',
            'note' => 'nullable|string|max:60',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        ItemSale::create($request->all());
        return redirect()->route('items.index')->with('success', 'Item added successfully.');
    }

    public function edit(ItemSale $item)
    {
        return view('items.edit', compact('item'));
    }

    public function update(Request $request, ItemSale $item)
    {
        $validator = Validator::make($request->all(), [
            'item_code' => 'required|regex:/^[a-zA-Z0-9]+$/',
            'item_name' => 'required|regex:/^[a-zA-Z0-9\s]+$/',
            'quantity' => 'required|numeric',
            'expired_date' => 'nullable|date',
            'note' => 'nullable|string|max:60',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $item->update($request->all());
        return redirect()->route('items.index')->with('success', 'Item updated successfully.');
    }
}
<?php

use App\Http\Controllers\ItemSaleController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ItemSaleController::class, 'index'])->name('items.index');
Route::get('/items/create', [ItemSaleController::class, 'create'])->name('items.create');
Route::post('/items', [ItemSaleController::class, 'store'])->name('items.store');
Route::get('/items/{item}/edit', [ItemSaleController::class, 'edit'])->name('items.edit');
Route::put('/items/{item}', [ItemSaleController::class, 'update'])->name('items.update');
<!DOCTYPE html>
<html>
<head>
    <title>Item List</title>
</head>
<body>
    <h1>Item List</h1>
    <a href="{{ route('items.create') }}">Add New Item</a>
    @if(session('success'))
        <p>{{ session('success') }}</p>
    @endif
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Item Code</th>
                <th>Item Name</th>
                <th>Quantity</th>
                <th>Expired Date</th>
                <th>Note</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($items as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->item_code }}</td>
                    <td>{{ $item->item_name }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ $item->expired_date }}</td>
                    <td>{{ $item->note }}</td>
                    <td>
                        <a href="{{ route('items.edit', $item->id) }}">Edit</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
<!DOCTYPE html>
<html>
<head>
    <title>Add New Item</title>
</head>
<body>
    <h1>Add New Item</h1>
    <form action="{{ route('items.store') }}" method="POST">
        @csrf
        <label>Item Code:</label>
        <input type="text" name="item_code" value="{{ old('item_code') }}"><br>
        <label>Item Name:</label>
        <input type="text" name="item_name" value="{{ old('item_name') }}"><br>
        <label>Quantity:</label>
        <input type="number" name="quantity" value="{{ old('quantity') }}"><br>
        <label>Expired Date:</label>
        <input type="date" name="expired_date" value="{{ old('expired_date') }}"><br>
        <label>Note:</label>
        <input type="text" name="note" value="{{ old('note') }}"><br>
        <button type="submit">Add Item</button>
    </form>
    @if ($errors->any())
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
</body>
</html>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Item</title>
</head>
<body>
    <h1>Edit Item</h1>
    <form action="{{ route('items.update', $


