<?php

namespace App\Console\Commands;

use App\Models\TemporaryFile;
use Illuminate\Console\Command;

class DeleteTemporaryFile extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'temporary:delete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $temporaryFiles = TemporaryFile::where('created_at', '<', today()->subDay())->get();

        foreach ($temporaryFiles as $temporaryFile) {
            $path = 'temp/' . $temporaryFile->folder;
            if (\Storage::disk(config('filesystems.default'))->exists($path)){
                \Storage::disk(config('filesystems.default'))->deleteDirectory($path);
            }

            $temporaryFile->delete();
        }
    }
}
