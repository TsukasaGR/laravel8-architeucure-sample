<?php

namespace App\Utils;

use Embed\Embed;
use Illuminate\Support\Facades\Log;
use Exception;

/**
 * URLを元に対象ページのOGP情報を取得するクラス
 */
class Ogp
{
    /** @var Embed $embed */
    private $embed;
    /** @var string $url */
    public $url;
    /** @var string $title */
    public $title;
    /** @var string $description */
    public $description;
    /** @var string $imagePath */
    public $imagePath;

    /**
     * @param string $url
     */
    public function __construct(string $url)
    {
        try {
            $this->embed = new Embed();
            $info = $this->embed->get($url);
            $this->url = $url;
            $this->title = (string)$info->title;
            $this->description = (string)$info->description;
            if ($info->image) {
                $this->imagePath = (string)$info->image;
            }
        } catch (Exception $error) {
            Log::error('OGP取得エラー', ['error' => $error]);
        }
    }

    /**
     * 対象インスタンスを返す
     *
     * @return self
     */
    public function __invoke()
    {
        return $this;
    }
}
