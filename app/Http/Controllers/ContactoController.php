<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Productor;

class ContactoController extends Controller
{
    public function send(Request $request)
    {
        $validated = $request->validate([
            'productor_id' => 'required|exists:productores,id',
            'nombre' => 'required|string|max:100',
            'email' => 'required|email|max:100',
            'telefono' => 'nullable|string|max:20',
            'mensaje' => 'required|string|max:1000',
        ]);

        $productor = Productor::findOrFail($validated['productor_id']);
        
        // Incrementar contador de contactos
        $productor->increment('contactos');

        // Aquí puedes enviar un correo real
        // Mail::to($productor->email)->send(new ContactoProductor($validated));

        return redirect()->back()
            ->with('success', '¡Mensaje enviado! El productor se pondrá en contacto contigo pronto.');
    }
}