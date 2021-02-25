<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Session;
use Auth;
use DB;
use App\Similarity;
use App\Product;

class MethodController extends Controller
{

    public function index()
    {
        return view('pages.methods.index');
    }

    public function store(Request $request)
    {
        $input = $request->all();
        
		/*----------- Membuat Similarity -----------*/

		//Mendapatkan data produk apa saja yang dirating
        $fullProduct = DB::table('reviews')->select("product_id")->groupBy('product_id')->get();

        // memperbarui similarity
	    Similarity::query()->truncate();
		$joins = [];
        $dataSimilarity = [];
		foreach($fullProduct as $value1){
			foreach($fullProduct as $key => $value2){
                // echo $join = @$joins[$value1->product_id][$value2->product_id];
                $join1 = @$joins[$value2->product_id][$value1->product_id];
                $join2 = @$joins[$value1->product_id][$value2->product_id];
				if($value1->product_id != $value2->product_id && ($join1 != true || $joins == []) && ($join2 != true || $salaman == [])){
					$joins[$value1->product_id][$value2->product_id] = true;
					$query = DB::select(DB::raw("
						select 
							SUM((item1.rating-item1.average_rating) * (item2.rating-item2.average_rating)) 
                            / 
                            (SQRT(SUM(POW((item1.rating-item1.average_rating),2))) * (SQRT(SUM(POW((item2.rating-item2.average_rating),2))))) as similarity
						from 
							(SELECT 
                                r.customer_id, 
                                r.product_id, 
                                r.rating, 
                                (ra.total_rating/ra.total_vote) as average_rating 
                            from
                                reviews r, products ra where r.product_id=ra.id and ra.id = ".$value1->product_id."
                            ) as item1,
							(SELECT 
                                r.customer_id, 
                                r.product_id, 
                                r.rating, 
                                (ra.total_rating/ra.total_vote) as average_rating 
                            from 
                                reviews r, products ra 
                            where 
                                r.product_id=ra.id and ra.id = ".$value2->product_id."
                            ) as item2
						where 
							item1.customer_id = item2.customer_id
					"));

                        $data   = new Similarity;
                        $data->product_id_1   = $value1->product_id;
                        $data->product_id_2   = $value2->product_id;
                        $data->similarity     = $query[0]->similarity;
                        $dataSimilarity[$value1->product_id][$value2->product_id] = [
                            'similarity' => $query[0]->similarity
                        ];
                        $data->save();
				}
			}
		}

        // Set data similarity ke dalam 2 dimensi array untuk ditampilkan dalam table
        $tableSimilarity = [];
        $dataProductUp = [];
        foreach($fullProduct as $r){
            $dataProductUp[] = $r->product_id;
        }
        $tableSimilarity[] = array_merge(['#'],$dataProductUp);
        foreach($fullProduct as $r1){
            $dataTableSimilarity = [];
            foreach($fullProduct as $r2){
                $similarity1 = @$dataSimilarity[$r1->product_id][$r2->product_id]['similarity'];
                $similarity2 = @$dataSimilarity[$r2->product_id][$r1->product_id]['similarity'];
                if($similarity1){
                    $finalSimilarity = $similarity1;
                }else if($similarity2){
                    $finalSimilarity = $similarity2;
                }else{
                    $finalSimilarity = $similarity1.$similarity2;
                }
                $dataTableSimilarity[] = $finalSimilarity;
            }
            $tableSimilarity[] = array_merge([$r1->product_id],$dataTableSimilarity);
        }


		/*----------- Menghitung Prediksi -----------*/
		$dataProduct = DB::select(DB::raw("
			SELECT 
				r.customer_id as customer_id, p.id as product_id 
			FROM 
				products p
			LEFT JOIN 
                reviews r ON p.id = r.product_id AND r.customer_id = ".$request->input('customer_id')."
			WHERE 
				r.product_id IS NULL
		"));

        $arrayPrediksi = '<table class="table table-small table-bordered table-hover"><tr><th>Product Name</th><th>Prediction</th></tr>';
		foreach($dataProduct as $value){
			$prediction = DB::select(DB::raw("
			SELECT
				(SUM(r.rating*s.similarity) / SUM(ABS(s.similarity))) as prediction 
			from
				(SELECT product_id_1, product_id_2, similarity from similarities) s,
				(SELECT customer_id, product_id, rating 
				FROM reviews
				where customer_id = ".$request->input('customer_id').") r	
			where 
				(s.product_id_1 = ".$value->product_id." AND  s.product_id_2 = r.product_id) XOR (s.product_id_1 = r.product_id AND s.product_id_2 = ".$value->product_id.")
                AND s.similarity >= 0
			"));
            // $arrayPrediksi[] = [
            //     'product_id' => $value->product_id,
            //     'prediksi' => $prediction[0]->prediction
            // ];
            $arrayPrediksi .= '<tr><td>'.$this->getprdName($value->product_id).'</td><td>'.$prediction[0]->prediction.'</td></tr>';
		}
        $arrayPrediksi .= '</table>';

        if($tableSimilarity){
            $arraySimilarity = '';
            $no = 1;
            foreach ($tableSimilarity as $keyth => $th) {
                $arr_th_sm = '';
                $no2 = 1;
                foreach($th as $r){

                    if($no == 1 || $no2 == 1){
                        $arr_th_sm .= '<th>'.$this->getprdName($r).'</th>';
                    }else{
                        $arr_th_sm .= '<td>'.$r.'</td>';
                    }
                    $no2++;
                }
                $arraySimilarity .= '<tr>'.$arr_th_sm.'</tr>';
                $no++;
            }
            
            return response()->json(
                [
                    'status'            => 'Success',
                    'table_similarity'  => '<table class="table table-small table-bordered table-hover">'.$arraySimilarity.'</table>',
                    'table_prediction'  => $arrayPrediksi,
                ],
                200
            );
        }
    }

    function getprdName($id) {
        if(!empty($id) && $id != "#"){
            $data = DB::table('products')->select('name')->where('id', $id)->first()->name;
        }else{
            $data = "#";
        }
        
        return $data;
    }

}