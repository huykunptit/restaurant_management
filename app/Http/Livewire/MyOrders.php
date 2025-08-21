<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\MenuOption;
use App\Models\Transaction;
use App\Models\Table;
use App\Models\TemporaryOrder;
use Illuminate\Support\Facades\Session;

class MyOrders extends Component
{   
    public $myOrders;
    public $submittedOrders;
    public $part;
    public $optionId;
    public $remark;
    public $total;

    protected $listeners = ['prependOrder'];

    public function mount()
    {
        $this->myOrders = TemporaryOrder::with('menu', 'menuOption')->where('user_id', auth()->user()->id)->get();

        $this->submittedOrders = Transaction::with('menu', 'menuOption')->where('user_id', auth()->user()->id)->where('payment_status', 'no')->orderBy('id', 'DESC')->get();

    }   

    public function render()
    {   
        return view('livewire.my-orders');
    }

    public function prependOrder($menu_id, $optionId)
    {
        $selectedMenu = MenuOption::with('menu')->find($optionId);
    
        // Find table_id from reservations based on the user's ID
        $reservation = Reservation::where('user_id', auth()->user()->id)->first();
        $table_id = $reservation ? $reservation->table_id : null;
    
        if (!$table_id) {
            $this->emit('flashError', 'No table associated with this user.');
            return;
        }
    
        $existing = TemporaryOrder::where('user_id', auth()->user()->id)
            ->where('menu_option_id', $optionId)
            ->first();
    
        if ($existing == null) {
            $create = TemporaryOrder::create([
                'user_id' => auth()->user()->id,
                'menu_id' => $selectedMenu->menu->id,
                'menu_option_id' => $selectedMenu->id,
                'quantity' => 1,
                'remarks' => "",
                'table_id' => $table_id, // Save the table_id
            ]);
    
            $this->myOrders->prepend($create);
        } else {
            $existing->quantity = $existing->quantity + 1;
            $existing->save();
        }
    }

    public function increment($id)
    {   
        
        $tempOrder = TemporaryOrder::find($id);

        $tempOrder->quantity = $tempOrder->quantity + 1;

        $tempOrder->save();

    }

    public function decrement($id)
    {
        $tempOrder = TemporaryOrder::find($id);

        $tempOrder->quantity = $tempOrder->quantity - 1;

        $tempOrder->save();
    }

    public function remove($id)
    {   
        $tempOrder = TemporaryOrder::find($id);
        $tempOrder->delete();
    }

    public function submitOrder()
    {   

        $check = TemporaryOrder::where('user_id', auth()->user()->id)->get();

        if($check->isEmpty()){

            $this->remark = "";

            $message = 'Please add an order before submitting!';

            $this->emit('flashError', $message);

        } else{

            TemporaryOrder::query()
            ->where('user_id', auth()->user()->id)
            ->each(function ($oldRecord) {
                $newRecord = $oldRecord->replicate();
                $newRecord->completion_status = 'no';
                $newRecord->payment_status = 'no';
                if (!$newRecord->table_id) {
                    $reservation = Reservation::where('user_id', auth()->user()->id)->first();
                    $newRecord->table_id = $reservation ? $reservation->table_id : null;
                }
                if($this->remark !== null){
                    $newRecord->remarks = $this->remark;
                }
    
                $newRecord->setTable('transactions');
                $newRecord->save();
                $oldRecord->delete();
                
                // Prepend to Submitted Orders
                $lastOrder = Transaction::with('menu', 'menuOption')->where('user_id', auth()->user()->id)->where('payment_status', 'no')->latest('id')->first();
                $this->submittedOrders->prepend($lastOrder);
            });
    
            $this->remark = "";
    
            $message = 'Your order has successfully been submitted!';
    
            $this->emit('flashMessage', $message);

        }
        
    }

    public function loadPart()
    {   
        $this->part = "new";
    }

    public function new()
    {   
        $this->part = "new";
    }

    public function submitted()
    {
        $this->part = "submitted";
    }
}
