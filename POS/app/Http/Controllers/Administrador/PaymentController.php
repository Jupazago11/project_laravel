<?php

namespace App\Http\Controllers\Administrador;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    /**
     * Mostrar el historial de pagos de un cliente.
     */
    public function index(Client $client)
    {
        // Asegurarnos de que el cliente pertenezca a la misma empresa
        if ($client->company_id !== Auth::user()->company_id) {
            abort(403);
        }

        $payments = Payment::where('client_id', $client->id)
                           ->orderBy('payment_date', 'desc')
                           ->paginate(10)
                           ->withQueryString();

        return view('administrador.payments.index', compact('client','payments'));
    }

    /**
     * Formulario para crear un nuevo pago.
     */
    public function create(Client $client)
    {
        if ($client->company_id !== Auth::user()->company_id) {
            abort(403);
        }

        return view('administrador.payments.create', compact('client'));
    }

    /**
     * Almacenar un pago.
     */
    public function store(Request $request, Client $client)
    {
        if ($client->company_id !== Auth::user()->company_id) {
            abort(403);
        }

        $data = $request->validate([
            'amount'       => 'required|numeric|min:0.01',
            'payment_date' => 'required|date',
        ]);

        Payment::create([
            'company_id'  => Auth::user()->company_id,
            'client_id'   => $client->id,
            'amount'      => $data['amount'],
            'payment_date'=> $data['payment_date'],
        ]);

        return redirect()
            ->route('administrador.payments.index', $client)
            ->with('success','Abono registrado correctamente.');
    }

    /**
     * Formulario para editar un pago.
     */
    public function edit(Payment $payment)
    {
        // Verificar empresa
        if ($payment->company_id !== Auth::user()->company_id) {
            abort(403);
        }

        return view('administrador.payments.edit', compact('payment'));
    }

    /**
     * Actualizar un pago.
     */
    public function update(Request $request, Payment $payment)
    {
        if ($payment->company_id !== Auth::user()->company_id) {
            abort(403);
        }

        $data = $request->validate([
            'amount'       => 'required|numeric|min:0.01',
            'payment_date' => 'required|date',
        ]);

        $payment->update($data);

        return redirect()
            ->route('administrador.payments.index', $payment->client)
            ->with('success','Abono actualizado correctamente.');
    }

    /**
     * Eliminar un pago.
     */
    public function destroy(Payment $payment)
    {
        if ($payment->company_id !== Auth::user()->company_id) {
            abort(403);
        }

        $client = $payment->client;
        $payment->delete();

        return redirect()
            ->route('administrador.payments.index', $client)
            ->with('success','Abono eliminado correctamente.');
    }
}
