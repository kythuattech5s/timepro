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
    protected $lockfile;
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->lockfile = public_path('videoconvert.lock');
    }
    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        set_time_limit(0);
        $hLock=fopen($this->lockfile, "w+");
        if(!flock($hLock, LOCK_EX | LOCK_NB)){
            die("Already running. Exiting...");
        }
        $itemTvsSecrets = TvsSecret::where('converted', TvsSecret::CONVERTED_WAIT)->first();
        if ($itemTvsSecrets == null) {
            $this->unlockFile($hLock, $this->lockfile);
            return;
        }
        TvsHashFile::where('secret_id',$itemTvsSecrets->id)->delete();
        \modulevideosecurity\managevideo\Models\TvsToken::where('secret_id',$itemTvsSecrets->id)->delete();
        $filePath = $itemTvsSecrets->file_path . $itemTvsSecrets->file_name;
        if (!file_exists(public_path($filePath))) {
            $this->info("Duong dan khong ton tai: ".$filePath);
            $itemTvsSecrets->convert_note = 'Đường dẫn không tồn tại: '.$filePath;
            $itemTvsSecrets->converted = TvsSecret::CONVERTED_FAIL;
            $itemTvsSecrets->save();
            $this->unlockFile($hLock, $this->lockfile);
            return;
        }
        TvsHashFile::where('secret_id',$itemTvsSecrets->id)->delete();
        \modulevideosecurity\managevideo\Models\TvsToken::where('secret_id',$itemTvsSecrets->id)->delete();
        $itemTvsSecrets->converted = TvsSecret::CONVERTED_START;
        $itemTvsSecrets->save();
        try {
            $fileInMediaDiskPath = str_replace('uploads/', '', $filePath);
            $fileSavePath = $itemTvsSecrets->disk_path;
            $encryptionKey = \ProtoneMedia\LaravelFFMpeg\Exporters\HLSExporter::generateEncryptionKey();
            $this->info("Start");
            $lowBitrate = (new \FFMpeg\Format\Video\X264())->setKiloBitrate(static::BITRATES[0]);
            $midBitrate = (new \FFMpeg\Format\Video\X264())->setKiloBitrate(static::BITRATES[1]);
            $highBitrate = (new \FFMpeg\Format\Video\X264())->setKiloBitrate(static::BITRATES[2]);
            $superBitrate = (new \FFMpeg\Format\Video\X264)->setKiloBitrate(static::BITRATES[3]);
        
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
                /*->addFormat($superBitrate, function ($media) {
                    $media->addLegacyFilter(function ($filters) {
                        $filters->resize(new \FFMpeg\Coordinate\Dimension(2560, 1920));
                    });
                })*/
                ->onProgress(function ($process) {
                    $this->info("Process:{$process}%");
                })
                ->toDisk('tvsvideos')
                ->save($fileSavePath . $itemTvsSecrets->playlist_name);
            $itemTvsSecrets->converted = TvsSecret::CONVERTED_COMPLETE;
            $itemTvsSecrets->convert_note .= ' - Convert success';
            $itemTvsSecrets->save();
        } catch (\Exception $e) {
            if ($itemTvsSecrets->number_fail >= 2) {
                $itemTvsSecrets->converted = TvsSecret::CONVERTED_FAIL;
            }
            else{
                $itemTvsSecrets->converted = TvsSecret::CONVERTED_WAIT;
            }
            $itemTvsSecrets->number_fail += 1;
            $itemTvsSecrets->convert_note = $e->getMessage();
            $itemTvsSecrets->save();
            // echo $e->getCommand();
            // echo $e->getErrorOutput();
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
        $this->unlockFile($hLock, $this->lockfile);
    }
    public function unlockFile($hLock, $fileName)
    {
        flock($hLock, LOCK_UN);
        fclose($hLock);
        unlink($fileName);
    }
}
