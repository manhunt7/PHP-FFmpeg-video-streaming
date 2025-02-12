<?php

/**
 * This file is part of the PHP-FFmpeg-video-streaming package.
 *
 * (c) Amin Yazdanpanah <contact@aminyazdanpanah.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Streaming;

use FFMpeg\Media\MediaTypeInterface;


/** @mixin  \FFMpeg\Media\Video */
class Media
{
    /** @var \FFMpeg\Media\Video */
    private $media;

    /** @var bool */
    private $is_tmp;

    /**
     * Media constructor.
     * @param MediaTypeInterface $media
     * @param bool $is_tmp
     */
    public function __construct(MediaTypeInterface $media, bool $is_tmp)
    {
        $this->media = $media;
        $this->is_tmp = $is_tmp;
    }

    /**
     * @return DASH
     */
    public function dash(): DASH
    {
        return new DASH($this);
    }

    /**
     * @return HLS
     */
    public function hls(): HLS
    {
        return new HLS($this);
    }

    /**
     * @return StreamToFile
     */
    public function stream2file(): StreamToFile
    {
        return new StreamToFile($this);
    }

    /**
     * @return bool
     */
    public function isTmp(): bool
    {
        return $this->is_tmp;
    }

    /**
     * @param $argument
     * @return Media | \FFMpeg\Media\Video
     */
    private function isInstanceofArgument($argument)
    {
        return ($argument instanceof $this->media) ? $this : $argument;
    }

    /**
     * @param $method
     * @param $parameters
     * @return Media | \FFMpeg\Media\Video
     */
    public function __call($method, $parameters)
    {
        return $this->isInstanceofArgument(
            call_user_func_array([$this->media, $method], $parameters)
        );
    }
}