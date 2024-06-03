<?php

namespace App\Http\Controllers;

use App\Models\FilmSubmission;
use App\Models\RoleRequest;
use App\Models\Media;
use App\Models\Tag;
use App\Models\Director;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class FilmSubmissionManagementController extends Controller
{
    public function index()
    {
        $roleRequests = RoleRequest::all();
        $filmSubmissions = FilmSubmission::with(['tags', 'director', 'user'])->get();
        $tags = Tag::all();
        $directors = Director::all();

        return view('profil', compact('roleRequests', 'filmSubmissions', 'tags', 'directors'));
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
                // Si un nouveau réalisateur est fourni, le créer
                if ($submission->new_director) {
                    $director = Director::create(['name' => $submission->new_director]);
                    $submission->director_id = $director->id;
                    $submission->save();
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

    public function update(Request $request, $id)
    {
        $submission = FilmSubmission::findOrFail($id);
        
        $validated = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'tags' => 'required|array',
            'length' => 'required',
            'year' => 'required|digits:4',
            'director_id' => 'nullable|exists:directors,id',
            'new_director' => 'nullable|string',
        ]);

        // Mettre à jour les informations de la soumission
        $submission->title = $validated['title'];
        $submission->description = $validated['description'];
        $submission->length = $validated['length'];
        $submission->year = $validated['year'];
        $submission->director_id = $validated['director_id'];
        $submission->new_director = $validated['new_director'];
        $submission->tags()->sync($validated['tags']);
        $submission->save();

        return redirect()->route('profil')->with('success', 'Film submission updated successfully.');
    }
}
