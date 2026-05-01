<?php

namespace App\Jobs;

use App\Models\Gallery\Video;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;

class GenerateVideoThumbnailJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(public Video $video)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $thumbnailName = pathinfo(
            $this->video->file_path,
            PATHINFO_FILENAME
        ) . '.jpg';

        $thumbnailPath = 'gallery/thumbnails/' . $thumbnailName;

        FFMpeg::fromDisk('public')
            ->open($this->video->file_path)
            ->getFrameFromSeconds(1)
            ->export()
            ->toDisk('public')
            ->save($thumbnailPath);

        $this->video->update([
            'thumbnail_path' => $thumbnailPath
        ]);
    }
}
