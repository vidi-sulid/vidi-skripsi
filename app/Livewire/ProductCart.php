<?php

namespace App\Livewire;

use App\Models\Product\Product;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Request;
use Livewire\Component;

class ProductCart extends Component
{

    public $listeners = ['productSelected', 'discountModalRefresh'];

    public $cart_instance;
    public $global_discount;
    public $global_tax;
    public $shipping;
    public $quantity;
    public $check_quantity;
    public $discount_type;
    public $item_discount;
    public $unit_price;
    public $data;

    private $product;

    public function mount($cartInstance, $data = null)
    {
        $this->cart_instance = $cartInstance;

        if ($data) {
            $this->data = $data;

            $this->global_discount = $data->discount_percentage;
            $this->global_tax = $data->tax_percentage;
            $this->shipping = $data->shipping_amount;

            $this->updatedGlobalTax();
            $this->updatedGlobalDiscount();

            $cart_items = Cart::instance($this->cart_instance)->content();

            foreach ($cart_items as $cart_item) {
                $this->check_quantity[$cart_item->id] = [$cart_item->options->stock];
                $this->quantity[$cart_item->id] = $cart_item->qty;
                $this->unit_price[$cart_item->id] = $cart_item->price;
                $this->discount_type[$cart_item->id] = $cart_item->options->product_discount_type;
                if ($cart_item->options->product_discount_type == 'fixed') {
                    $this->item_discount[$cart_item->id] = $cart_item->options->product_discount;
                } elseif ($cart_item->options->product_discount_type == 'percentage') {
                    $this->item_discount[$cart_item->id] = round(100 * ($cart_item->options->product_discount / $cart_item->price));
                }
            }
        } else {
            $this->global_discount = 0;
            $this->global_tax = 0;
            $this->shipping = 0.00;
            $this->check_quantity = [];
            $this->quantity = [];
            $this->unit_price = [];
            $this->discount_type = [];
            $this->item_discount = [];
        }
    }

    public function render()
    {
        $cart_items  = session()->get('cart_items', []);
        return view('livewire.product-cart', [
            'cart_items' => $cart_items
        ]);
    }

    public function productSelected($product)
    {
        $cartItems = session()->get('cart_items', []);
        // Add the product to the cart session
        $id = uniqid();
        $cartItems[$id] = [
            'id'      => $product['code'],
            'name'    => $product['name'],
            'jenis'   => $product['jenis'],
            'keterangan' => $product['keterangan'],
            'nominal' => $product['nominal'], // Adjust as needed
        ];

        session()->put('cart_items', $cartItems);

        // Optionally, you can flash a success message
        session()->flash('message', 'Product added to cart successfully!');
    }

    public function removeItem($row_id)
    {

        $cartItems = session()->get('cart_items', []);
        unset($cartItems[$row_id]);
        session()->put('cart_items', $cartItems);
    }
}