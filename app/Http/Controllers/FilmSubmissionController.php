<?php

namespace App\Http\Controllers;

use App\Models\FilmSubmission;
use App\Models\Media;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class FilmSubmissionController extends Controller
{
    public function approve(Request $request, $id)
    {
        $submission = FilmSubmission::findOrFail($id);
        $submission->status = $request->status;
        $submission->save();

        if ($request->status == 'approved') {
            $slug = Str::slug($submission->title);

            // Original paths with _submission suffix
            $originalThumbnailPath = $submission->thumbnail;
            $originalVideoPath = $submission->video_url;

            // New paths without _submission suffix
            $newThumbnailPath = 'presentations/images/' . $slug . '.' . pathinfo($originalThumbnailPath, PATHINFO_EXTENSION);
            $newVideoPath = 'presentations/medias/' . $slug . '.' . pathinfo($originalVideoPath, PATHINFO_EXTENSION);

            Log::info('Renaming files', [
                'originalThumbnailPath' => $originalThumbnailPath,
                'newThumbnailPath' => $newThumbnailPath,
                'originalVideoPath' => $originalVideoPath,
                'newVideoPath' => $newVideoPath
            ]);

            try {
                // Rename files to remove _submission
                if (Storage::exists($originalThumbnailPath)) {
                    Storage::move($originalThumbnailPath, $newThumbnailPath);
                    Log::info('Thumbnail file renamed successfully.');
                } else {
                    Log::error('Original thumbnail file not found.');
                }

                if (Storage::exists($originalVideoPath)) {
                    Storage::move($originalVideoPath, $newVideoPath);
                    Log::info('Video file renamed successfully.');
                } else {
                    Log::error('Original video file not found.');
                }

                // Move the data to the Media table
                $media = Media::create([
                    'title' => $submission->title,
                    'slug' => $slug,
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

            } catch (\Exception $e) {
                Log::error('Error during file renaming: ' . $e->getMessage());
                return redirect()->back()->with('error', 'An error occurred while approving the film.');
            }
        }

        // Remove the submission record
        $submission->delete();

        return redirect()->back()->with('status', 'La demande de film a été traitée.');
    }
}
