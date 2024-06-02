<?php

namespace App\Http\Controllers;

use App\Models\FilmSubmission;
use App\Models\RoleRequest;
use App\Models\Media;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class FilmSubmissionController extends Controller
{
    public function index()
    {
        $roleRequests = RoleRequest::all();
        $filmSubmissions = FilmSubmission::with(['tags', 'director', 'user'])->get();

        return view('profil', compact('roleRequests', 'filmSubmissions'));
    }

    public function approve(Request $request, $id)
    {
        $submission = FilmSubmission::findOrFail($id);
        $submission->status = $request->status;
        $submission->save();

        if ($request->status == 'approved') {
            $slug = Str::slug($submission->title);

            Log::info('Processing approved submission', [
                'submissionId' => $submission->id,
                'slug' => $slug,
                'thumbnailPath' => $submission->thumbnail,
                'videoPath' => $submission->video_url
            ]);

            try {
                // Move the data to the Media table
                $media = Media::create([
                    'title' => $submission->title,
                    'slug' => $slug,
                    'description' => $submission->description,
                    'type' => 'film',
                    'director_id' => $submission->director_id,
                    'length' => $submission->length,
                    'year' => $submission->year,
                    'thumbnail' => $submission->thumbnail,
                    'video_url' => $submission->video_url,
                ]);

                // Attach tags to the media
                $tags = $submission->tags->pluck('id')->toArray(); // Get tag IDs
                $media->tags()->attach($tags);

            } catch (\Exception $e) {
                Log::error('Error during media creation: ' . $e->getMessage());
                return redirect()->back()->with('error', 'An error occurred while approving the film.');
            }
        } elseif ($request->status == 'rejected') {
            // Delete the thumbnail and video files
            if (Storage::exists($submission->thumbnail)) {
                Storage::delete($submission->thumbnail);
            }

            if (Storage::exists($submission->video_url)) {
                Storage::delete($submission->video_url);
            }

            Log::info('Rejected submission files deleted', [
                'thumbnailPath' => $submission->thumbnail,
                'videoPath' => $submission->video_url
            ]);
        }

        // Remove the submission record
        $submission->delete();

        return redirect()->back()->with('status', 'La demande de film a été traitée.');
    }
}
