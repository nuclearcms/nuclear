<?php

namespace Reactor\Synthesizer;


use Illuminate\Database\Eloquent\Collection;
use Kenarkose\Synthesizer\Processor\ProcessorInterface;
use Reactor\Documents\Image;

class GalleryTagsProcessor implements ProcessorInterface {

    /**
     * @param string $value
     * @param mixed $args
     * @return string
     */
    public function process($value, $args = null)
    {
        list($matches, $idSets) = $this->getMatches($value);

        return $this->makeGalleries($matches, $idSets, $value);
    }

    /**
     * Finds all media in given string
     *
     * @param string $text
     * @return array
     */
    protected function getMatches($text)
    {
        preg_match_all('~\[gallery.+ids="(\d+(?:,\d+)*)"\]~', $text, $matches);

        list($matches, $gallery) = $matches;

        foreach ($gallery as $key => $ids)
        {
            $gallery[$key] = explode(',', $ids);
        }

        return [$matches, $gallery];
    }

    /**
     * Replaces the document tags with gallery render
     *
     * @param array $matches
     * @param array $idSets
     * @param string $text
     * @return string
     */
    protected function makeGalleries(array $matches, array $idSets, $text)
    {
        foreach ($idSets as $key => $ids)
        {
            $slides = get_reactor_gallery($ids);

            $gallery = (count($slides)) ? $this->makeGalleryHTML($slides) : '';
            
            $text = str_replace($matches[$key], $gallery, $text);
        }

        return $text;
    }

    /**
     * Makes gallery HTML
     *
     * @param Collection $slides
     * @return string
     */
    protected function makeGalleryHTML(Collection $slides)
    {
        if ( ! count($slides))
        {
            return '';
        }

        $html = '';

        foreach ($slides as $slide)
        {
            $html .= $this->makeSlideHTML($slide);
        }

        return $this->wrapSlidesHTML($html);
    }

    /**
     * Makes slide HTML
     *
     * @param Image $image
     * @return string
     */
    protected function makeSlideHTML(Image $image)
    {
        $translation = $image->translate();
        $caption = ($translation) ? $translation->caption : '';
        $description = ($translation) ? $translation->description : '';

        return '<li>
            <figure data-original="' . $image->getPublicURL() . '">' .
        $image->present()->thumbnail .
        '<figcaption class="gallery-caption">' . $caption . '</figcaption>
                <p class="gallery-description">' . $description . '</p>
            </figure>
        </li>';
    }

    /**
     * Wraps slides HTML
     *
     * @param string $slides
     * @return string
     */
    protected function wrapSlidesHTML($slides)
    {
        return '<ul class="gallery-inline gallery-lightbox">' . $slides . '</ul>';
    }

}