<?php

namespace modulevideosecurity\managevideo\Setting;

interface VideoSettingInferface{

	public function checkHaveAccess($itemTvsSecret);

	public function setKeyUrlResolver($key, $tvsSecret,$sessionId);

	public function setMediaUrlResolver($mediaFilename,$tvsSecret,$sessionId);

    public function setPlaylistUrlResolver($playlistFilename, $tvsSecret,$sessionId);

}