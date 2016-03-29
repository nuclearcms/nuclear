<?php

namespace Reactor\Synthesizer;


use Kenarkose\Synthesizer\Processor\ProcessorInterface;
use Reactor\Documents\Media;

class DocumentTagsProcessor implements ProcessorInterface {

    /**
     * @param string $value
     * @param mixed $args
     * @return string
     */
    public function process($value, $args = null)
    {
        list($matches, $ids) = $this->getMatches($value);

        $documents = $this->getDocuments($ids);

        return $this->makeDocuments($matches, $ids, $documents, $value);
    }

    /**
     * Finds all media in given string
     *
     * @param string $text
     * @return array
     */
    protected function getMatches($text)
    {
        preg_match_all('~\[document.+id="([1-9]\d*)"\]~', $text, $matches);

        return $matches;
    }

    /**
     * Finds the media with given ids
     *
     * @param array $ids
     * @return Collection
     */
    protected function getDocuments(array $ids)
    {
        return Media::find($ids);
    }

    /**
     * Replaces the document tags with presenter renders
     *
     * @param array $matches
     * @param array $ids
     * @param Collection|null $documents
     * @param string $text
     * @return string
     */
    protected function makeDocuments(array $matches, array $ids, $documents, $text)
    {
        foreach ($ids as $key => $id)
        {
            $document = $documents->find($id);

            $parsedDocument = '';

            if ( ! is_null($document))
            {
                $parsedDocument = $document->present()->preview;
            }

            $text = str_replace($matches[$key], $parsedDocument, $text);
        }

        return $text;
    }

}