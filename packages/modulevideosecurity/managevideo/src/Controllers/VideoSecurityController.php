<?php

namespace modulevideosecurity\managevideo\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use \vanhenry\manager\model\Media;
use modulevideosecurity\managevideo\Models\{TvsSecret, TvsMapItem, TvsHashFile, TvsFileToken, TvsVideoSession, TvsVideoSessionFile, TvsToken};
use \modulevideosecurity\managevideo\Setting\VideoSettingInferface;

class VideoSecurityController extends Controller
{
    protected $videoSetting;
    protected $currentSessionId = 0;
    public function __construct(VideoSettingInferface $videoSetting)
    {
        $this->videoSetting = $videoSetting;
    }
    public function getPlaylist($mediaId)
    {
        $tvsSecret = $this->_retreiveTvsSecret($mediaId);
        $this->authenticate($tvsSecret);
        $fileName = request()->input('info', '');
        $diskPath = $tvsSecret->disk_path;

        if (!empty($fileName)) {
            $this->validateAndRetriveSession();
            $filePath = $diskPath . $fileName;
            $this->currentSessionId = (int)request()->input('session', 0);
        } else {
            $filePath = $diskPath . $tvsSecret->playlist_name;
            $this->currentSessionId = $this->createSessionVideo($mediaId);
        }
        file_put_contents(public_path("test.txt"), $this->makeDynamicHlsPlaylist($tvsSecret, $filePath, $mediaId));
        return $this->makeDynamicHlsPlaylist($tvsSecret, $filePath, $mediaId);
    }
    private function _retreiveTvsSecret($mediaId)
    {
        $tvsSecret = TvsSecret::find($mediaId);
        if (!isset($tvsSecret) || !$tvsSecret->converted) abort(403, 'Forbidden');
        return $tvsSecret;
    }
    protected function authenticate($tvsSecret)
    {
        if (!$this->videoSetting->checkHaveAccess($tvsSecret)) {
            abort(403, 'Forbidden');
        }
    }

    private function makeDynamicHlsPlaylist($tvsSecret, $filePath, $mediaId)
    {
        $sessionId = $this->currentSessionId;
        return \FFMpeg::dynamicHLSPlaylist()
            ->fromDisk('tvsvideos')
            ->open($filePath)
            ->setKeyUrlResolver(function ($key) use ($tvsSecret, $sessionId) {
                return $this->videoSetting->setKeyUrlResolver($key, $tvsSecret, $sessionId);
            })
            ->setMediaUrlResolver(function ($mediaFilename) use ($tvsSecret, $sessionId) {
                return $this->videoSetting->setMediaUrlResolver($mediaFilename, $tvsSecret, $sessionId);
            })
            ->setPlaylistUrlResolver(function ($playlistFilename) use ($tvsSecret, $sessionId) {
                return $this->videoSetting->setPlaylistUrlResolver($playlistFilename, $tvsSecret, $sessionId);
            });
    }

    private function validateAndRetriveSession()
    {
        $this->validateAndGetUserAgent();
        $playbackId = request()->header('X-Playback-Session-Id', '');
        $session = (int)request()->input('session', 0);
        if ($session == 0) abort(403, "Forbidden");
        $videoSession = TvsVideoSession::where('id', $session)->where('playback_id', $playbackId)->first();
        if (!isset($videoSession)) abort(403, "Forbidden");
        return $videoSession;
    }

    /***
	Chưa rõ tại sao bị request 2 lần file m3u8, không hiện ở tab network
	Bắt trong 3s 1 request
     */

    private function createSessionVideo($videoId)
    {
        $playbackId = request()->header('X-Playback-Session-Id', '');
        $ipAddress = request()->ip();
        $agent  = $this->validateAndGetUserAgent();
        $hash = md5($ipAddress . $agent . $videoId . $playbackId);
        $now = \Carbon\Carbon::now();
        $timeBefore = $now->addSeconds(-3);
        $existSession = TvsVideoSession::where('hash', $hash)->where('created_at', '>', $timeBefore)->first();
        if (isset($existSession)) return $existSession->id;
        $session = new TvsVideoSession;
        $session->session_id = session()->getId();
        $session->playback_id = $playbackId;
        $session->ip = $ipAddress;
        $session->video_id = $videoId;
        $session->agent = $agent;
        $session->hash = $hash;
        $session->save();
        $sessionId = $session->id;
        return $sessionId;
    }
    private function isIOS($agent)
    {
        if ($agent == '') abort(403, "Forbidden");
        $iPod    = stripos($agent, "iPod");
        $iPhone  = stripos($agent, "iPhone");
        $iPad    = stripos($agent, "iPad");
        return $iPad || $iPhone || $iPod;
    }
    private function validateAndGetUserAgent()
    {
        $agent = request()->server('HTTP_USER_AGENT', '');
        if ($this->isIOS($agent)) {
            $playbackId = request()->header('X-Playback-Session-Id', '');
            if ($playbackId == '') abort(403, "Forbidden");
        }
        return $agent;
    }

    public function key($key)
    {
        $mediaId = (int)request()->input('sid', 0);
        $tvsSecret = $this->_retreiveTvsSecret($mediaId);
        $this->validateAndRetriveSession();
        return \Storage::disk('tvsvideos')->download($tvsSecret->disk_path . $key);
    }

    public function getFileTs($fileName)
    {
        $this->validateFileTsRequest($fileName);
        $secretId = (int)request()->input('sid', 0);
        $tvsSecret = $this->_retreiveTvsSecret($secretId);
        return \Storage::disk('tvsvideos')->download($tvsSecret->disk_path . $fileName);
    }

    protected function validateFileTsRequest($fileName)
    {
        $agent = request()->server('HTTP_USER_AGENT', '');
        if ($this->isIOS($agent)) {
            $this->validateFileTsIphone();
        } else {
            $this->validateFileTsDesktop($fileName);
        }
    }
    protected function validateFileTsIphone()
    {
        $this->validateAndRetriveSession();
    }
    protected function validateFileTsDesktop($fileName)
    {
        $token = request()->input('token', '');
        $token = $this->decodeToken($token);
        $secretId = (int)request()->input('sid', 0);
        if (empty($token)) abort(403, 'Forbidden');
        $videoSession = $this->validateAndRetriveSession();
        $now = \Carbon\Carbon::now();
        $tvsToken = TvsToken::where("secret_id", $secretId)->where("session_id", $videoSession->id)->where("token", $token)->where("file_name", $fileName)->where('expried_at', '>', $now)->where('used', 0)->first();
        if (!isset($tvsToken)) {
            abort(403, "Forbidden");
        }
        $tvsToken->used = 1;
        $tvsToken->save();
    }
    public function fetch()
    {
        $fileName = request()->input('path', '');
        $sessionId = (int)request()->input('session', 0);
        $secretId = (int)request()->input('sid', 0);
        $hash = $this->_retreiveHashFile($secretId, $fileName);

        $code = 200;
        $currentTime = time();
        $token = $hash->id . $currentTime . $hash->name . $sessionId . $secretId;
        $token = $this->makeToken($token);

        $tvsToken = new TvsToken;
        $tvsToken->secret_id = $hash->secret_id;
        $tvsToken->file_name = $hash->name;
        $tvsToken->path = $hash->path;
        $tvsToken->hash_id = $hash->id;
        $tvsToken->session_id = $sessionId;
        $tvsToken->token = $token;
        $tvsToken->expried_at = \Carbon\Carbon::now()->addSeconds(3);
        $tvsToken->save();
        return response()->json(['code' => $code, 'token' => $token]);
    }

    private function _retreiveHashFile($secretId, $fileName)
    {
        $hash = TvsHashFile::where('secret_id', $secretId)->where('name', $fileName)->first();
        if (!isset($hash)) abort(403, "Forbidden");
        return $hash;
    }
    private function makeToken($rawToken, $length = 8)
    {
        $base = 'abcdefghijklmnopqrstuvwxyz';
        $addToken = array();
        $alphaLength = strlen($base) - 1;
        for ($i = 0; $i < $length; $i++) {
            $n = rand(0, $alphaLength);
            $addToken[] = $base[$n];
        }
        return md5($rawToken) . implode($addToken);
    }


    public function autoConvertTvs()
    {
        \Artisan::call('tvsvideo:convert');
    }

    private function decodeToken($token)
    {

        $result = "";
        for ($i = 0; $i < strlen($token); $i++) {
            if ($i % 3 != 1) {
                $result .= $token[$i];
            }
        }
        $result = str_rot13($result);
        return $result;
    }

    public function point()
    {
    }
    public function press()
    {
    }
}
