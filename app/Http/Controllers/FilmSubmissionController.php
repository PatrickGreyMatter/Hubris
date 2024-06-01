<?php

namespace App\Http\Controllers;

use App\Models\FilmSubmission;
use App\Models\Media;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FilmSubmissionController extends Controller
{
    public function approve(Request $request, $id)
    {
        $submission = FilmSubmission::findOrFail($id);
        $submission->status = $request->status;
        $submission->save();

        if ($request->status == 'approved') {
            // Rename thumbnail and video files
            $thumbnailPath = $submission->thumbnail;
            $videoPath = $submission->video_url;

            $newThumbnailPath = str_replace('_submission', '', $thumbnailPath);
            $newVideoPath = str_replace('_submission', '', $videoPath);

            Storage::move($thumbnailPath, $newThumbnailPath);
            Storage::move($videoPath, $newVideoPath);

            // Move the data to the Media table
            $media = Media::create([
                'title' => $submission->title,
                'slug' => Str::slug($submission->title),
                'description' => $submission->description,
                'type' => 'film',
                'director_id' => $submission->director_id,
                'length' => $submission->length,
                'year' => $submission->year,
                'thumbnail' => $newThumbnailPath,
                'video_url' => $newVideoPath,
            ]);

            // Attach tags to the media
            $tags = json_decode($submission->tags);
            $media->tags()->attach($tags);
        }

        // Remove the submission record
        $submission->delete();

        return redirect()->back()->with('status', 'La demande de film a été traitée.');
    }
}
