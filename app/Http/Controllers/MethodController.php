<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Session;
use Auth;
use DB;
use App\Similarity;
use App\Product;
use App\Prediction;

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

		// Mendapatkan data produk apa saja yang dirating
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

        // Buat array prediksi
        $arrayPrediksi = [];
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
                order by (SUM(r.rating*s.similarity) / SUM(ABS(s.similarity))) asc
			"));
            if($value->product_id != $request->input('product_id')){
                $arrayPrediksi[] = [
                    'product_id' => $value->product_id,
                    'prediksi' => $prediction[0]->prediction
                ];
            }
		}
        
        // Sort prediksi descending
        usort($arrayPrediksi, function($a, $b) {
            return $a['prediksi'] + $b['prediksi'];
        });

        // Buat table prediksi
        $tablePrediksi = '<table class="table table-small table-bordered table-hover"><tr><th>Product Name</th><th>Prediction</th></tr>';
        foreach($arrayPrediksi as $r){
            $tablePrediksi .= '<tr><td>'.$this->getprdName($r['product_id']).'</td><td>'.$r['prediksi'].'</td></tr>';
        }
        $tablePrediksi .= '</table>';
        
        /*--------------- Menghitung rata-rata MAE ---------------*/
        $averageMAE = $this->hitungMAE([],'');
        /*--------------- Menghitung MAE ---------------*/
        $MAE = $this->hitungMAE(['id'=>$request->input('customer_id')],$request->input('product_id'));

        /*--------------- Menampilkan Data -------------*/
        if($tableSimilarity){
            $arraySimilarity = '';
            $no = 1;
            /*--------------- Buat table similarity -------------*/
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
                    'table_prediction'  => $tablePrediksi,
                    'MAE' => $MAE,
                    'average_MAE' => $averageMAE
                ],
                200
            );
        }
    }

    function hitungMAE($customer_id,$product_id){
        $dataCustomer   = DB::table('customers')
                    ->select(
                        [
                            'id as data_id',
                        ]
                    )->where($customer_id)->get();
        // memperbarui prediksi
        Prediction::query()->truncate();
        foreach($dataCustomer as $c){
            $dataProduct = DB::select(DB::raw("
                SELECT 
                    r.customer_id as customer_id, p.id as product_id 
                FROM 
                    products p
                INNER JOIN 
                    reviews r ON p.id = r.product_id AND r.customer_id = ".$c->data_id."
            "));
            $arrayPrediksiMAE = [];
            foreach($dataProduct as $value){
                if($product_id == '' || $value->product_id == $product_id){
                    $prediction = DB::select(DB::raw("
                    SELECT
                        (SUM(r.rating*s.similarity) / SUM(ABS(s.similarity))) as prediction 
                    from
                        (SELECT product_id_1, product_id_2, similarity from similarities where similarity > 0) s,
                        (SELECT customer_id, product_id, rating 
                        FROM reviews
                        where customer_id = ".$c->data_id.") r	
                    where 
                        (s.product_id_1 = ".$value->product_id." AND  s.product_id_2 = r.product_id) XOR (s.product_id_1 = r.product_id AND s.product_id_2 = ".$value->product_id.")
                    "));
                    $arrayPrediksiMAE[] = [
                        'product_id' => $value->product_id,
                        'prediksi' => $prediction[0]->prediction
                    ];
                
                    $data   = new Prediction;
                    $data->customer_id   = $c->data_id;
                    $data->product_id   = $value->product_id;
                    $data->prediction     = $prediction[0]->prediction;
                    $data->save();
                }
            }
        }
        $dataMAE = DB::select(DB::raw("
            SELECT
                SUM(ABS(p.prediction-r.rating))/COUNT(*) as MAE
            FROM 
                prediction_for_mae p, reviews r 
            WHERE
                p.customer_id = r.customer_id AND p.product_id = r.product_id
        "));
        foreach($dataMAE as $value){
            $MAE = $value->MAE;
        }
        return $MAE;
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
