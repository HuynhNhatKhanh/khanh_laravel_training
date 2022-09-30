<?php

namespace App\Http\Controllers;

use App\Models\Test;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function index(){

        // $test = Test::orderBy('id')->get();
        $test = Test::select('id', 'status')
                    ->where('status', '=', 'active')
                    ->where('id', '=', 1)
                    // ->count('status')
                    //->groupBy('status')
                    ->orderByDesc('id')
                    // ->limit(2)
                    // ->offset(2)
                    ->get();
        return $test;
        
    }

    public function add(){

        // $test = new Test;
        // $test->status = 'inactive';
        // $test->save();

        // $test2 = new Test;
        // $test2->status = 'active';
        // $test2->save();
        Test::create(['status' => 'inactive']);
    }

    public function update($id){
        $test = Test::where('id',$id)
                ->update(['status' => 'inactive']);
    }

    public function delete($id){
        // $test = Test::find($id);
        // $test->delete();
        // Test::where('id', $id)->delete();
        Test::destroy([12, 11]);
    }
}
