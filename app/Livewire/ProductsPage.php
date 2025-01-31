<?php

namespace App\Livewire;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('Products - DcodeMania')]

class ProductsPage extends Component
{

    use WithPagination;
    #[Url]
    public $selected_categories = [];

    #[Url]
    public $selected_brands =[];

    public function render()
    {
        $productquery = Product::query()->where('is_active',1);

        if(!empty($this->selected_categories)){
            $productquery->whereIn('category_id',$this->selected_categories);
        }
        return view('livewire.products-page',[
            'products' => $productquery->paginate(6),
            'brands' =>Brand::where('is_active',1)->get(['id','name','slug']),
            'categories' =>Category::where('is_active',1)->get(['id','name','slug']),
        ]);
    }
}
