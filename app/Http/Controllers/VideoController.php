<?php

namespace App\Http\Controllers;

use App\Video;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    public function store(Request $request)
    {
        $videoPath = $request->file('video-blob')->storePublicly('videos');

        $videoFile = storage_path().'/app/'.$videoPath;

        $video = Video::create([
            'filename' => $videoPath,
        ]);

        $ffmpeg = \FFMpeg\FFMpeg::create([
            'ffmpeg.binaries'  => '/usr/local/bin/ffmpeg',
            'ffprobe.binaries' => '/usr/local/bin/ffprobe',
            'timeout'          => 3600, // The timeout for the underlying process
            'ffmpeg.threads'   => 12,   // The number of threads that FFMpeg should use
        ]);
        $screenshot = $ffmpeg->open($videoFile);

        $screenshot
            ->frame(\FFMpeg\Coordinate\TimeCode::fromSeconds(1))
            ->save(storage_path('app/screenshots/'.$video->id.'.jpg'));

        return $video;
    }

    public function index()
    {
        return Video::get();
    }
}
