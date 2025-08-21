<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Table;
use App\Models\Transaction;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {   
        $filledTables = User::with(['order', 'order.menuOption'])
            ->where('role_id', '3')
            ->get();


        return view('order.index', [
            'filledTables' => $filledTables,
        ]);
    }

    public function complete($id)
    {
        $order = Transaction::where('user_id', $id)
            ->where('completion_status', 'no')
            ->update(['completion_status' => 'yes']);

        if(auth()->user()->hasRole('admin')){
            return redirect()
            ->route('home.admin')
            ->with('success','Order successfully marked as completed');
        }
        
        elseif(auth()->user()->hasRole('staff')){
            return redirect()
            ->route('home.staff')
            ->with('success','Order successfully marked as completed');
        }
    }

    public function paid($id)
    {
        $order = Transaction::where('table_id', $id)
            ->where([
                ['payment_status', 'no'],
            ])
            ->update([
                'payment_status' => 'yes',
                'completion_status' => 'yes',
            ]);

        if(auth()->user()->hasRole('admin')){
            return redirect()
            ->route('home.admin')
            ->with('success','Order successfully marked as paid');
        }
        
        elseif(auth()->user()->hasRole('staff')){
            return redirect()
            ->route('home.staff')
            ->with('success','Order successfully marked as paid');
        }
    }

    public function show($tableId)
    {
        // Find the table
        $table = Table::findOrFail($tableId);
    
        // Get orders associated with the table
        $orders = Transaction::with(['menu', 'menu.category', 'menuOption'])
            ->where('table_id', $tableId)
            ->where('payment_status', 'no')
            ->get();
    
        // Find remarks for any orders associated with the table
        $remark = Transaction::where('table_id', $tableId)
            ->where('payment_status', 'no')
            ->where('remarks', '<>', '')
            ->first();
    
        return view('order.show', [
            'table' => $table,
            'orders' => $orders,
            'remark' => $remark,
        ]);
    }
    
    public function completeSingleOrder($id)
    {

        $order = Transaction::find($id);
        $order->completion_status = "yes";
        $order->save();

        return redirect()
            ->route('order.show', $order->table_id)
            ->with('success','Order successfully marked as complete');
        
    }

    public function cancelSingleOrder($id)
    {

        $order = Transaction::find($id);
        $order->delete();

        return redirect()
            ->route('order.show', $order->table_id)
            ->with('success','Order successfully canceled');
        
    }


    


}