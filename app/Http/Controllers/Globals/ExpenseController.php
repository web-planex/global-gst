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
        $data['menu'] = 'Expense';
        $data['expense'] = Expense::orderBy('id','DESC')->get();
        return view('globals.expense.index',$data);
    }

    public function create(){
        $data['menu'] = 'Expense';
        return view('globals.expense.create',$data);
    }
}
