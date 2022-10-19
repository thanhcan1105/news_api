<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
class ProductsExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Product::all();
    }
    public function headings() :array {
    	return ['id','name','phone','select1','link'
        ,'transaction_id','reference_type','current_group_id','source','campaign','reference_id',
        'str_source_group','str_secondary_source','isdigital'];
    }
}
