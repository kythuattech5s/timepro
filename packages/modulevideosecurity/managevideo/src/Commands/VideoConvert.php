<?php

namespace modulevideosecurity\managevideo\Commands;

use Illuminate\Console\Command;
use \modulevideosecurity\managevideo\Models\TvsSecret;
use \modulevideosecurity\managevideo\Models\TvsHashFile;

class VideoConvert extends Command
{
    public const BITRATES = [250,500,1000,1500];
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tvsvideo:convert';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Convert Video m3u8';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $itemTvsSecrets = TvsSecret::where('converted', 0)->get()->first();
        if (!isset($itemTvsSecrets)) return;
        $filePath = $itemTvsSecrets->file_path . $itemTvsSecrets->file_name;
        $filePath = base_path($filePath);
        if (!file_exists($filePath)) {
            $this->info("Loi roi");
            $itemTvsSecrets->delete();
            return;
        }
        TvsHashFile::where('secret_id',$itemTvsSecrets->id)->delete();
        \modulevideosecurity\managevideo\Models\TvsToken::where('secret_id',$itemTvsSecrets->id)->delete();
        $itemTvsSecrets->converted = 1;
        $itemTvsSecrets->save();
        $fileInMediaDiskPath = str_replace(base_path('public/uploads/'), '', $filePath);
        $fileSavePath = $itemTvsSecrets->disk_path;
        $encryptionKey = \ProtoneMedia\LaravelFFMpeg\Exporters\HLSExporter::generateEncryptionKey();
        $this->info("Start");
        $lowBitrate = (new \FFMpeg\Format\Video\X264())->setKiloBitrate(static::BITRATES[0]);
        $midBitrate = (new \FFMpeg\Format\Video\X264())->setKiloBitrate(static::BITRATES[1]);
        $highBitrate = (new \FFMpeg\Format\Video\X264())->setKiloBitrate(static::BITRATES[2]);
        $superBitrate = (new \FFMpeg\Format\Video\X264)->setKiloBitrate(static::BITRATES[3]);
        try {
            \FFMpeg::fromDisk('uploads')
                ->open($fileInMediaDiskPath)
                ->exportForHLS()
                ->withRotatingEncryptionKey(function ($filename, $contents) use ($fileSavePath) {
                    \Storage::disk('tvsvideos')->put($fileSavePath . $filename, $contents);
                })
                ->setSegmentLength(10)
                ->addFormat($lowBitrate, function ($media) {
                    $media->addFilter('scale=640:480');
                })
                ->addFormat($midBitrate, function ($media) {
                    $media->scale(960, 720);
                })
                ->addFormat($highBitrate, function ($media) {
                    $media->addFilter(function ($filters, $in, $out) {
                        $filters->custom($in, 'scale=1920:1200', $out);
                    });
                })
                ->onProgress(function ($process) {
                    $this->info("Process:{$process}%");
                })
                ->toDisk('tvsvideos')
                ->save($fileSavePath . $itemTvsSecrets->playlist_name);
            $itemTvsSecrets->converted = 2;
            $itemTvsSecrets->save();
        } catch (\ProtoneMedia\LaravelFFMpeg\Exporters\EncodingException $e) {
            echo $e->getMessage();
        }
        \FFMpeg::cleanupTemporaryFiles();
        $this->info("Update Database");
        $dir = \Storage::disk('tvsvideos')->path($fileSavePath);
        $tsFiles = glob($dir . '*.ts', GLOB_BRACE);
        $count = count($tsFiles);
        foreach ($tsFiles as $key => $file) {
            $this->info("Update Database:" . $key . "/" . $count);
            $hash = new TvsHashFile;
            $hash->secret_id = $itemTvsSecrets->id;
            $hash->name = basename($file);
            $hash->path = $itemTvsSecrets->playlist_path;
            $hash->save();
        }
        $this->info("End");
    }
}
