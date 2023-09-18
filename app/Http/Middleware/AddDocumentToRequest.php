<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AddDocumentToRequest
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next)
    {
        $cpfCnpj = $this->getDocument($request);
        //remove all characters except numbers
        $document = preg_replace('/[^0-9]/', '', $cpfCnpj);
        $request->merge(['document' => $document]);
    
        return $next($request);
    }

    private function getDocument($request)
    {
        $document = null;
        $method = $request->getMethod();
        switch ($method) {
            case 'POST':
                $document = $request->input('cpfCnpj');
                break;
            case 'GET':
                $document = $request->get('cpfCnpj');
                break;
            default:
                $document = request()->input('cpfCnpj');
                break;
        }
        return $document;
    }
}
