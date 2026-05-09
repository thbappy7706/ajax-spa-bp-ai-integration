<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    /**
     * Shared product seed (replace with DB query: Product::all()->toArray()).
     */
    private function sampleProducts(): array
    {
        return [
            ['id'=>1,  'name'=>'MacBook Pro 14',       'sku'=>'MBP-14',     'category'=>'Electronics', 'price'=>1999, 'stock'=>42,  'status'=>'Active',   'date'=>'2025-01-15', 'desc'=>'Apple M3 Pro chip'],
            ['id'=>2,  'name'=>'DM Sans Font License', 'sku'=>'FONT-DM',    'category'=>'Software',    'price'=>29,   'stock'=>999, 'status'=>'Active',   'date'=>'2025-02-01', 'desc'=>'Variable font license'],
            ['id'=>3,  'name'=>'Mechanical Keyboard',  'sku'=>'KB-MX1',     'category'=>'Hardware',    'price'=>149,  'stock'=>8,   'status'=>'Active',   'date'=>'2025-02-10', 'desc'=>'TKL, Cherry MX Blue'],
            ['id'=>4,  'name'=>'Design Patterns Book', 'sku'=>'BOOK-DP',    'category'=>'Books',       'price'=>49,   'stock'=>120, 'status'=>'Active',   'date'=>'2025-02-14', 'desc'=>'Gang of Four'],
            ['id'=>5,  'name'=>'USB-C Hub 7-in-1',     'sku'=>'HUB-7C',     'category'=>'Hardware',    'price'=>59,   'stock'=>0,   'status'=>'Draft',    'date'=>'2025-02-20', 'desc'=>'Thunderbolt 4'],
            ['id'=>6,  'name'=>'Figma Team Plan',      'sku'=>'FIG-TEAM',   'category'=>'Software',    'price'=>45,   'stock'=>999, 'status'=>'Active',   'date'=>'2025-03-01', 'desc'=>'Per editor/month'],
            ['id'=>7,  'name'=>'Nike Air Max 270',     'sku'=>'NIKE-270',   'category'=>'Clothing',    'price'=>129,  'stock'=>34,  'status'=>'Active',   'date'=>'2025-03-05', 'desc'=>'Running shoe'],
            ['id'=>8,  'name'=>"Dell 27\" 4K Monitor", 'sku'=>'DEL-27-4K',  'category'=>'Electronics', 'price'=>699,  'stock'=>15,  'status'=>'Active',   'date'=>'2025-03-12', 'desc'=>'IPS 144Hz'],
            ['id'=>9,  'name'=>'React Course 2025',    'sku'=>'CRS-REACT',  'category'=>'Software',    'price'=>89,   'stock'=>999, 'status'=>'Active',   'date'=>'2025-03-18', 'desc'=>'Full-stack React'],
            ['id'=>10, 'name'=>'Standing Desk Frame',  'sku'=>'DESK-SIT',   'category'=>'Hardware',    'price'=>349,  'stock'=>5,   'status'=>'Draft',    'date'=>'2025-04-01', 'desc'=>'Electric adjustable'],
            ['id'=>11, 'name'=>'Levi 501 Jeans',       'sku'=>'LEVI-501',   'category'=>'Clothing',    'price'=>69,   'stock'=>200, 'status'=>'Archived', 'date'=>'2025-04-10', 'desc'=>'Classic straight'],
            ['id'=>12, 'name'=>"iPad Pro 11\"",         'sku'=>'IPAD-P11',   'category'=>'Electronics', 'price'=>999,  'stock'=>22,  'status'=>'Active',   'date'=>'2025-04-22', 'desc'=>'M4 chip'],
        ];
    }

    /**
     * SPA index — full layout OR content fragment (AJAX).
     */
    public function index(Request $request)
    {
        // In production use: $products = Product::all()->toArray();
        $products = $this->sampleProducts();

        if ($request->ajax()) {
            return view('pages.products', compact('products'))->renderSections()['content'];
        }

        return view('pages.products', compact('products'));
    }

    /**
     * Store a new product (JSON API, called by SPA modal).
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'category' => 'required|string',
            'price'    => 'required|numeric|min:0',
            'sku'      => 'nullable|string|max:100',
            'status'   => 'nullable|in:Active,Draft,Archived',
            'stock'    => 'nullable|integer|min:0',
            'desc'     => 'nullable|string',
        ]);

        // In production: $product = Product::create($validated);
        // Returning a mock response here:
        return response()->json(array_merge($validated, ['id' => rand(100, 999)]), 201);
    }

    /**
     * Update an existing product.
     */
    public function update(Request $request, $product)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'category' => 'required|string',
            'price'    => 'required|numeric|min:0',
            'sku'      => 'nullable|string|max:100',
            'status'   => 'nullable|in:Active,Draft,Archived',
            'stock'    => 'nullable|integer|min:0',
            'desc'     => 'nullable|string',
        ]);

        // In production: Product::findOrFail($product)->update($validated);
        return response()->json(array_merge($validated, ['id' => $product]));
    }

    /**
     * Delete a product.
     */
    public function destroy($product)
    {
        // In production: Product::findOrFail($product)->delete();
        return response()->json(['deleted' => true]);
    }

    /**
     * Bulk delete.
     */
    public function bulkDestroy(Request $request)
    {
        $ids = $request->validate(['ids' => 'required|array'])['ids'];
        // In production: Product::whereIn('id', $ids)->delete();
        return response()->json(['deleted' => count($ids)]);
    }
}
