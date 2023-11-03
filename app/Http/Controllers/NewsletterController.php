<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Newsletter;
use App\Http\Requests\NewsletterStoreRequest;
use App\Http\Resources\NewsletterResource; 
use  Illuminate\Support\Facades\Mail;
use App\Mail\Contact;

class NewsletterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $newsLetter =  Newsletter::all();
       if($newsLetter){
        return NewsletterResource::make(['message' => 'Lista email', 'data' => $newsLetter])->response()->setStatusCode(200);
       }
       return response()->json(['message' => 'Nenhum dado encontrado'], 404);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(NewsletterStoreRequest $request)
    {
        $newslatter = new Newsletter;
        $newslatter->email = $request->email;
        $newslatter->name = $request->name;
        $newslatter->save();

        Mail::to($request->email)->send(mailable: new Contact(
            data: [
            'fromName' => $request->name,
            'fromEmail' => $request->email,
            ]
        ));

        return $newslatter;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
       $newsLetter =  Newsletter::find($id);
       if($newslatter){
        return $newslatter;
       }
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $newsLetter =  Newsletter::find($id);
        if($newsLetter){
         $newsLetter->delete();
         return response()->json([],204);
        }
        return response()->json(['message' => 'Nenhum dado encontrado'], 404);
    }
}
