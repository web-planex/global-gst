<?php

namespace App;

use App\Models\Globals\BillItems;
use App\Models\Globals\DebitNoteItems;
use App\Models\Globals\EstimateItems;
use App\Models\Globals\ExpenseItems;
use App\Models\Globals\InvoiceItems;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'email_verified_at', 'password','mobile','google_id','role','status','token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function Bill(){
        return $this->hasMany('App\Models\Globals\Bills','user_id');
    }

    public function CompanySettings(){
        return $this->hasMany('App\Models\Globals\CompanySettings','user_id');
    }

    public function Customers(){
        return $this->hasMany('App\Models\Globals\Customers','user_id');
    }

    public function DebitNote(){
        return $this->hasMany('App\Models\Globals\DebitNote','user_id');
    }

    public function EmailTemplates(){
        return $this->hasMany('App\Models\Globals\EmailTemplates','user_id');
    }

    public function Employees(){
        return $this->hasMany('App\Models\Globals\Employees','user_id');
    }

    public function Estimate(){
        return $this->hasMany('App\Models\Globals\Estimate','user_id');
    }

    public function Expense(){
        return $this->hasMany('App\Models\Globals\Expense','user_id');
    }

    public function ExpenseType(){
        return $this->hasMany('App\Models\Globals\ExpenseType','user_id');
    }

    public function GeneratedInvoiceList(){
        return $this->hasMany('App\Models\Globals\GeneratedInvoiceList','user_id');
    }

    public function Invoice(){
        return $this->hasMany('App\Models\Globals\Invoice','user_id');
    }

    public function InvoiceSetting(){
        return $this->hasMany('App\Models\Globals\InvoiceSetting','user_id');
    }

    public function Payees(){
        return $this->hasMany('App\Models\Globals\Payees','user_id');
    }

    public function PaymentMethod(){
        return $this->hasMany('App\Models\Globals\PaymentMethod','user_id');
    }

    public function PaymentTerms(){
        return $this->hasMany('App\Models\Globals\PaymentMethod','user_id');
    }

    public function PdfZips(){
        return $this->hasMany('App\Models\Globals\PdfZips','user_id');
    }

    public function Product(){
        return $this->hasMany('App\Models\Globals\Product','user_id');
    }

    public function Suppliers(){
        return $this->hasMany('App\Models\Globals\Suppliers','user_id');
    }

    protected static function boot() {
        parent::boot();

        static::deleting(function($data) {
            foreach ($data->Expense as $exp){
                ExpenseItems::where('expense_id',$exp)->delete();
                $exp->delete();
            }

            foreach ($data->Bill as $bill){
                BillItems::where('bill_id',$bill)->delete();
                $bill->delete();
            }

            foreach ($data->Estimate as $est){
                EstimateItems::where('estimate_id',$est)->delete();
                $est->delete();
            }

            foreach ($data->DebitNote as $deb){
                DebitNoteItems::where('debit_note_id',$deb)->delete();
                $deb->delete();
            }

            foreach ($data->Invoice as $inv){
                InvoiceItems::where('invoice_id',$inv)->delete();
                $inv->delete();
            }

            $data->CompanySettings()->delete();
            $data->Customers()->delete();
            $data->EmailTemplates()->delete();
            $data->Employees()->delete();
            $data->ExpenseType()->delete();
            $data->GeneratedInvoiceList()->delete();
            $data->InvoiceSetting()->delete();
            $data->Payees()->delete();
            $data->PaymentMethod()->delete();
            $data->PaymentTerms()->delete();
            $data->PdfZips()->delete();
            $data->Product()->delete();
            $data->Suppliers()->delete();
        });
    }
}
