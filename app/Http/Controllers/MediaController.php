<?php

namespace App\Http\Controllers;

use App\Models\Director;
use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class MediaController extends Controller
{
    public function store(Request $request)
    {
        // Log the request method and data
    
        if ($request->isMethod('post')) {
    
            $request->validate([
                'title' => 'required',
                'description' => 'required',
                'tags' => 'required|array',
                'length' => 'required',
                'year' => 'required',
                'thumbnail' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // 2MB for thumbnail
                'video_url' => 'required|mimes:mp4,mov,ogg,qt|max:2097152' // 2GB for video
            ]);
    
            $thumbnail = $request->file('thumbnail');
            $thumbnailName = time() . '.' . $thumbnail->getClientOriginalExtension();
            
            // Resize the thumbnail to a fixed resolution, e.g., 300x300
            $resizedThumbnail = Image::make($thumbnail)->resize(300, 300, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
    
            $resizedThumbnail->save(public_path('presentations/images/' . $thumbnailName));
    
            $video = $request->file('video_url');
            $videoName = time() . '.' . $video->getClientOriginalExtension();
            $video->move(public_path('presentations/medias'), $videoName);
    
            $director = $request->director_id;
            if ($request->new_director) {
                $newDirector = Director::create(['name' => $request->new_director]);
                $director = $newDirector->id;
            }
    
            $media = new Media();
            $media->title = $request->title;
            $media->slug = Str::slug($request->title);
            $media->description = $request->description;
            $media->type = 'film';
            $media->director_id = $director;
            $media->length = $request->length;
            $media->year = $request->year;
            $media->thumbnail = 'presentations/images/' . $thumbnailName;
            $media->video_url = 'presentations/medias/' . $videoName;
            $media->save();
    
            $media->tags()->attach($request->tags);
    
            return redirect()->route('profil')->with('success', 'Film added successfully.');
        } else {
            return response('Method not allowed', 405);
        }
    }
}
