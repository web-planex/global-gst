<?php

namespace App\Http\Controllers\Globals;

use App\Http\Controllers\Controller;
use App\Models\Globals\Expense;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){
        $data['expense'] = Expense::orderBy('id','DESC')->get();
        return view('expense.index',$data);
    }

    public function create(){
        return view('expense.create');
    }
}
