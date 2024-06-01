<?php

namespace App\Http\Controllers;

use App\Models\Director;
use App\Models\FilmSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Intervention\Image\Facades\Image;

class MediaController extends Controller
{
    public function store(Request $request)
    {
        Log::info('Store method called');
        
        if ($request->isMethod('post')) {
            Log::info('POST method detected');
            
            $validated = $request->validate([
                'title' => 'required',
                'description' => 'required',
                'tags' => 'required|array',
                'length' => 'required',
                'year' => 'required',
                'thumbnail' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'video_url' => 'required|mimes:mp4,mov,ogg,qt|max:2097152'
            ]);

            Log::info('Validation passed');

            try {
                $thumbnail = $request->file('thumbnail');
                $thumbnailName = time() . '.' . $thumbnail->getClientOriginalExtension();
                $resizedThumbnail = Image::make($thumbnail)->resize(300, 300, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
                $resizedThumbnail->save(public_path('presentations/images/' . $thumbnailName));
                Log::info('Thumbnail saved');

                $video = $request->file('video_url');
                $videoName = time() . '.' . $video->getClientOriginalExtension();
                $video->move(public_path('presentations/medias'), $videoName);
                Log::info('Video saved');

                $director = $request->director_id;
                if ($request->new_director) {
                    $existingDirector = Director::where('name', $request->new_director)->first();
                    if ($existingDirector) {
                        $director = $existingDirector->id;
                    } else {
                        $newDirector = Director::create(['name' => $request->new_director]);
                        $director = $newDirector->id;
                    }
                    Log::info('Director processed');
                }

                FilmSubmission::create([
                    'title' => $request->title,
                    'description' => $request->description,
                    'tags' => json_encode($request->tags),
                    'length' => $request->length,
                    'year' => $request->year,
                    'thumbnail' => 'presentations/images/' . $thumbnailName,
                    'video_url' => 'presentations/medias/' . $videoName,
                    'status' => 'pending',
                    'user_id' => auth()->id(),
                    'director_id' => $director,
                ]);

                Log::info('Film submission created');
                return redirect()->route('profil')->with('success', 'Film submitted successfully for review.');
            } catch (\Exception $e) {
                Log::error('Error during film submission: ' . $e->getMessage());
                return redirect()->route('profil')->with('error', 'An error occurred while submitting the film.');
            }
        } else {
            return response('Method not allowed', 405);
        }
    }
}
