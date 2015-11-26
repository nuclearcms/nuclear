<?php

namespace Reactor\Documents;


use Intervention\Image\Image as InterventionImage;

class Image extends Media {

    /**
     * @var string
     */
    protected $mediaType = 'image';

    /**
     * Presenter for the model
     *
     * @var string
     */
    protected $presenter = 'Reactor\Http\Presenters\Documents\ImagePresenter';

    /**
     * Edits image according to given action
     *
     * @param string $action
     */
    public function editImage($action)
    {
        $image = $this->loadImage();

        $path = $this->processImage($action, $image);

        $this->changeImage($path);
    }

    /**
     * Retrieves gallery for given media
     *
     * @param string $gallery
     * @return Collection|null
     */
    public static function gallery($gallery)
    {
        if (empty($gallery))
        {
            return null;
        }

        $gallery = json_decode($gallery, true);

        if (is_array($gallery))
        {
            $placeholders = implode(',', array_fill(0, count($gallery), '?'));

            $gallery = static::whereIn('id', $gallery)
                ->orderByRaw('field(id,' . $placeholders . ')', $gallery)
                ->get();
        }

        return (count($gallery) > 0) ? $gallery : null;
    }

    /**
     * Loads the associated image with the model
     *
     * @return Image
     */
    protected function loadImage()
    {
        return \Image::make(
            $this->getFilePath()
        );
    }

    /**
     * Processes the image with given action
     *
     * @param string $action
     * @param InterventionImage $image
     * @return string
     */
    protected function processImage($action, InterventionImage $image)
    {
        list($method, $param) = explode('_', $action);

        if ($method === 'crop')
        {
            $params = explode(',', $param);

            call_user_func_array([$image, 'crop'], $params);
        } else
        {
            call_user_func([$image, $method], $param);
        }

        return $this->saveImage($image);
    }

    /**
     * Saves the processed image
     *
     * @param InterventionImage $image
     * @return string
     */
    protected function saveImage(InterventionImage $image)
    {
        $filename = \Uploader::getNewFileName($this->getFileExtension());

        list($absolutePath, $relativePath) = \Uploader::getUploadPath();

        $image->save($absolutePath . '/' . $filename);

        return $relativePath . '/' . $filename;
    }

    /**
     * Removes the old image file and sets new image path
     *
     * @param string $path
     */
    protected function changeImage($path)
    {
        $this->deleteFile();

        $this->update(compact('path'));
    }

}