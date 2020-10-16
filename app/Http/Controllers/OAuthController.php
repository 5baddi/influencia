<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OAuthController extends Controller
{
    public function abilities()
    {
        // Load data
        $permissions = auth()->user()->role()
                            ->with('permissions')
                            ->get()
                            ->pluck('permissions')
                            ->flatten()
                            ->pluck('name')
                            ->toArray();

        // Format permissions to rules
        $rules = array_map(function($item){
            $exploded = explode('_', $item);
            if(!isset($exploded[0], $exploded[1]))
                return;

            return ['subject' => $exploded[0], 'action' => $exploded[1]];
        }, $permissions);

        return response()->success(
            "Abilities feteched successfully.",
            $rules
        );
    }
}
