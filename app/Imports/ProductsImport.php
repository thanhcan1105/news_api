<?php

namespace App\Imports;

use App\Models\Product;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
class ProductsImport implements ToModel,WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function headingRow() : int
    {
        return 1;
    }
    public function model(array $row)
    {
        return new Product([
            'name' => $row['name'],
            'phone' => $row['phone'], 
            'select1' => $row['select1'], 
            'link' => $row['link'], 
            'transaction_id' => $row['transaction_id'], 
            'reference_type' => $row['reference_type'], 
            'current_group_id' => $row['current_group_id'], 
            'source' => $row['source'], 
            'campaign' => $row['campaign'], 
            'reference_id' => $row['reference_id'], 
            'str_source_group' => $row['str_source_group'], 
            'isdigital' => $row['isdigital'], 
        ]);
    }
}
