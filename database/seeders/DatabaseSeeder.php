<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Supplier;
use App\Models\Product;
use App\Models\StockMovement;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create admin user
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@thriftims.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
            'status' => 'active',
        ]);

        // Create employee user
        $employee = User::create([
            'name' => 'Employee User',
            'email' => 'employee@thriftims.com',
            'password' => bcrypt('password'),
            'role' => 'employee',
            'status' => 'active',
        ]);

        // Create categories
        $categories = [
            ['name' => 'Clothing', 'description' => 'Used clothing items'],
            ['name' => 'Shoes', 'description' => 'Used shoes and footwear'],
            ['name' => 'Accessories', 'description' => 'Bags, belts, scarves, etc.'],
            ['name' => 'Home Goods', 'description' => 'Kitchen items, decor, etc.'],
            ['name' => 'Electronics', 'description' => 'Used electronics'],
            ['name' => 'Books', 'description' => 'Used books and reading materials'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }

        // Create suppliers
        $suppliers = [
            [
                'name' => 'Local Donations',
                'contact_person' => 'Community Center',
                'email' => 'donations@community.com',
                'phone' => '555-0101',
                'address' => '123 Main St',
                'city' => 'Springfield',
                'state' => 'IL',
                'postal_code' => '62701',
                'status' => 'active',
            ],
            [
                'name' => 'Estate Sales Co.',
                'contact_person' => 'John Smith',
                'email' => 'john@estatesales.com',
                'phone' => '555-0202',
                'address' => '456 Oak Ave',
                'city' => 'Chicago',
                'state' => 'IL',
                'postal_code' => '60601',
                'status' => 'active',
            ],
            [
                'name' => 'Wholesale Imports',
                'contact_person' => 'Sarah Johnson',
                'email' => 'sarah@wholesale.com',
                'phone' => '555-0303',
                'address' => '789 Broadway',
                'city' => 'New York',
                'state' => 'NY',
                'postal_code' => '10001',
                'status' => 'active',
            ],
        ];

        foreach ($suppliers as $supplier) {
            Supplier::create($supplier);
        }

        // Create sample products
        $products = [
            [
                'sku' => 'CLT-001',
                'name' => 'Vintage Denim Jacket',
                'description' => 'Classic blue denim jacket in good condition',
                'category_id' => 1,
                'supplier_id' => 1,
                'brand' => 'Levi\'s',
                'size' => 'M',
                'condition' => 'good',
                'purchase_price' => 5.00,
                'selling_price' => 24.99,
                'quantity' => 8,
                'reorder_level' => 3,
                'color' => 'Blue',
                'material' => '100% Cotton',
                'status' => 'active',
            ],
            [
                'sku' => 'CLT-002',
                'name' => 'Casual T-Shirt',
                'description' => 'Comfortable cotton t-shirt, great for everyday wear',
                'category_id' => 1,
                'supplier_id' => 1,
                'brand' => 'Gap',
                'size' => 'L',
                'condition' => 'like-new',
                'purchase_price' => 2.00,
                'selling_price' => 9.99,
                'quantity' => 15,
                'reorder_level' => 5,
                'color' => 'White',
                'material' => 'Cotton Blend',
                'status' => 'active',
            ],
            [
                'sku' => 'SHO-001',
                'name' => 'Leather Oxford Shoes',
                'description' => 'Professional leather shoes, lightly used',
                'category_id' => 2,
                'supplier_id' => 2,
                'brand' => 'Cole Haan',
                'size' => '10',
                'condition' => 'good',
                'purchase_price' => 15.00,
                'selling_price' => 49.99,
                'quantity' => 4,
                'reorder_level' => 2,
                'color' => 'Brown',
                'material' => 'Leather',
                'status' => 'active',
            ],
            [
                'sku' => 'ACC-001',
                'name' => 'Leather Crossbody Bag',
                'description' => 'Vintage leather bag with adjustable strap',
                'category_id' => 3,
                'supplier_id' => 2,
                'brand' => 'Coach',
                'size' => 'One Size',
                'condition' => 'fair',
                'purchase_price' => 10.00,
                'selling_price' => 39.99,
                'quantity' => 2,
                'reorder_level' => 1,
                'color' => 'Tan',
                'material' => 'Leather',
                'status' => 'active',
            ],
            [
                'sku' => 'HOM-001',
                'name' => 'Ceramic Bowl Set',
                'description' => '6-piece vintage ceramic bowl set',
                'category_id' => 4,
                'supplier_id' => 1,
                'brand' => 'Pottery Barn',
                'size' => 'Assorted',
                'condition' => 'good',
                'purchase_price' => 8.00,
                'selling_price' => 24.99,
                'quantity' => 6,
                'reorder_level' => 2,
                'color' => 'Cream',
                'material' => 'Ceramic',
                'status' => 'active',
            ],
            [
                'sku' => 'ELE-001',
                'name' => 'Vintage Radio',
                'description' => 'Retro AM/FM radio, working condition',
                'category_id' => 5,
                'supplier_id' => 3,
                'brand' => 'Sony',
                'size' => 'Small',
                'condition' => 'fair',
                'purchase_price' => 5.00,
                'selling_price' => 19.99,
                'quantity' => 1,
                'reorder_level' => 1,
                'color' => 'Brown',
                'material' => 'Plastic',
                'status' => 'active',
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }

        // Create sample stock movements
        $products = Product::all();

        foreach ($products->take(3) as $product) {
            StockMovement::create([
                'product_id' => $product->id,
                'user_id' => $admin->id,
                'type' => 'in',
                'quantity' => rand(2, 5),
                'reason' => 'purchase',
                'notes' => 'Initial stock purchase',
                'reference_number' => 'PO-' . str_pad($product->id, 4, '0', STR_PAD_LEFT),
            ]);
        }

        // Add some sales movements
        StockMovement::create([
            'product_id' => 1,
            'user_id' => $employee->id,
            'type' => 'out',
            'quantity' => 2,
            'reason' => 'sale',
            'notes' => 'Sold at register',
            'reference_number' => 'INV-001',
        ]);

        StockMovement::create([
            'product_id' => 2,
            'user_id' => $employee->id,
            'type' => 'out',
            'quantity' => 3,
            'reason' => 'sale',
            'notes' => 'Online order',
            'reference_number' => 'ORD-001',
        ]);
    }
}
