<?php

namespace App\Http\Controllers;

use App\Models\Twitter;
use Illuminate\Http\Request;
use App\Http\Resources\TwitterResources;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Collection;

class TwitterController extends Controller
{
    const DESTINATION_PATH = 'twitter';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $twitter = Twitter::all();

        return response()->json($twitter);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->only(['tweet', 'file']), [
            'tweet' => ['required', 'max: 100'],
            'file' => ['required', 'mimes:jpg,bmp,png'],
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $tweet = $request->tweet;
        $file = $request->file;
        $user_id = $request->user()->id;

        $request = [
            'tweet' => $tweet,
            'uploaded_by_user' => $user_id,
        ];

        if ($file) {
            $file_data = $this->getFileData($file);
            $file->storeAs(self::DESTINATION_PATH, $file_data['file_name'], 'public');
            $file_data = $this->getFileData($file);

            $request = array_merge($request, $file_data);
        }

        $twitter = Twitter::create($request);
        
        return response()->json('Created twitter success');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Twitter  $twitter
     * @return \Illuminate\Http\Response
     */
    public function show(Twitter $twitter): JsonResponse
    {  
        return response()->json($twitter);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Twitter  $twitter
     * @return \Illuminate\Http\Response
     */
    public function edit(Twitter $twitter)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Twitter  $twitter
     * @return \Illuminate\Http\Response
     */
    public function update(Twitter $twitter, Request $request)
    {
        $validator = Validator::make($request->only(['tweet', 'file']), [
            'tweet' => ['required', 'max: 100'],
            'file' => ['required', 'mimes:jpg,bmp,png'],
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $tweet = $request->tweet;
        $file = $request->file;
        $user_id = $request->user()->id;

        $request = [
            'tweet' => $tweet,
            'uploaded_by_user' => $user_id,
        ];

        if ($file) {
            $file_data = $this->getFileData($file);
            $this->deleteFile($file_data['file_name']);
            $file->storeAs(self::DESTINATION_PATH, $file_data['file_name'], 'public');
            $file_data = $this->getFileData($file);

            $request = array_merge($request, $file_data);
        }

        $twitter = $twitter->update($request);
        
        return response()->json("Updated Successfully");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Twitter  $twitter
     * @return \Illuminate\Http\Response
     */
    public function destroy(Twitter $twitter)
    {
        $this->deleteFile($twitter->file_name);
        $twitter->delete();
        return response()->json("Deleted Successfully");
    }

    private function getFileData($file): Array
    {
        $file_name = time().'_'.$file->getClientOriginalName();

        return [
            'file_name' => $file_name,
            'file_path' => self::DESTINATION_PATH
        ];
    }

    private function deleteFile(String $file_name)
    {
        Storage::delete('\/public\/' . self::DESTINATION_PATH . "\/" .$file_name);
    }
}
