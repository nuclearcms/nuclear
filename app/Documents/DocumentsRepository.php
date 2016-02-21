<?php

namespace Reactor\Documents;


class DocumentsRepository {

    /**
     * Returns the document by given id
     *
     * @param int $id
     * @return Media
     */
    public function getDocument($id)
    {
        return Media::find($id);
    }

    /**
     * Returns the gallery by given ids
     *
     * @param int|string|array $ids
     * @return Collection
     */
    public function getGallery($ids)
    {
        if (empty($ids)) return null;

        $ids = $this->parseGalleryIds($ids);

        $placeholders = implode(',', array_fill(0, count($ids), '?'));

        $gallery = Image::whereIn('id', $ids)
            ->orderByRaw('field(id,' . $placeholders . ')', $ids)
            ->get();

        return (count($gallery) > 0) ? $gallery : null;
    }

    /**
     * Returns the cover for given ids
     *
     * @param int|string|array $ids
     * @return Media
     */
    public function getCover($ids)
    {
        if (empty($ids)) return null;

        $ids = $this->parseGalleryIds($ids);

        $id = current($ids);

        return Image::find($id);
    }

    /**
     * Parses a gallery array
     *
     * @param int|string|array $ids
     * @return array
     */
    protected function parseGalleryIds($ids)
    {
        if (is_array($ids))
        {
            return $ids;
        }

        if (0 !== (int)$ids)
        {
            return (array)$ids;
        }

        return json_decode($ids, true);
    }

}