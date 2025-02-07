<?php

namespace App\Imports;

use App\Models\MasterList;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class MasterlistImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */

    public function model(array $row)
    {
        $address = explode('-', trim($row['address_of_drawing']));
        $addressValue = $address[1] ?? '';
        $slug = $addressValue . '-' . $row['name_of_machine'];
        $category = $address[0];

        switch ($category) {
            case 'MD':
                $categoryId = 1;
                break;
            case 'ED':
                $categoryId = 2;
                break;
            case 'CD':
                $categoryId = 3;
                break;
            case 'UD':
                $categoryId = 4;
                break;
            default:
                $categoryId = 1;
                break;
        }

        $masterlist = MasterList::where('address_of_drawing', $row['address_of_drawing'])->orderBy('drawing_number', 'desc')->first();
        $dataByCategory = MasterList::where('category_master_list_id', $categoryId)->first();

        $existsData = MasterList::where('slug', $slug)->where('category_master_list_id', $categoryId)->latest()->first();

        if($existsData){ // data dengan slug dan category id sudah ada

            // if(MasterList::where('address_of_drawing', $row['address_of_drawing'])->exists()){

                if(MasterList::where('slug', $slug)->where('category_master_list_id', $categoryId)->where('drawing_number', $row['drawing_no'])->exists()){
                    return null;
                }

                return new MasterList([
                    'drawing_number' => $row['drawing_no'],
                    'address_of_drawing' => $row['address_of_drawing'],
                    'name_of_machine' => $row['name_of_machine'],
                    'drawing_file_contents' => $row['drawing_file_contents'],
                    'remarks' => $row['remarks'],
                    'slug' => $slug,
                    'category_master_list_id' => $masterlist->category_master_list_id,
                ]);
            // }
        } else {
            return new MasterList([
                'drawing_number' => $row['drawing_no'],
                'address_of_drawing' => $row['address_of_drawing'],
                'name_of_machine' => $row['name_of_machine'],
                'drawing_file_contents' => $row['drawing_file_contents'],
                'remarks' => $row['remarks'],
                'slug' => $slug,
                'category_master_list_id' => $categoryId,
            ]);
        }
    }
}
