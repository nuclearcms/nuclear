<?php


namespace Reactor\Support\Update;


use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Symfony\Component\HttpFoundation\Response;

class UpdateService {

    /** @var string */
    const releasesURL = 'https://api.github.com/repos/nuclearcms/nuclear/releases';

    /** @var GuzzleClient */
    protected $httpClient;

    /** @var array */
    protected $releases;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->httpClient = new Client();
    }

    /**
     * Returns available releases
     *
     * @return array
     */
    public function getReleases()
    {
        if ($this->releases)
        {
            return $this->releases;
        }

        try
        {
            $response = $this->httpClient->get(static::releasesURL);

            if (Response::HTTP_OK === $response->getStatusCode())
            {
                $this->releases = json_decode($response->getBody());

                return $this->releases;
            }

            return false;
        } catch (RequestException $e)
        {
            return false;
        }
    }

    /**
     * Checks if the nuclear version is the latest
     *
     * @return bool
     */
    public function isNuclearCurrent()
    {
        return (version_compare(
                nuclear_version(),
                $this->getLatestRelease()->tag_name
            ) >= 0);
    }

    /**
     * Returns the latest release
     */
    public function getLatestRelease()
    {
        foreach ($this->getReleases() as $release)
        {
            if ($release->draft === false)
            {
                return $release;
            }
        }

        return null;
    }

    /**
     * Downloads the latest update and stores it in the temporary folder
     *
     * @return string
     */
    public function downloadLatest()
    {
        if ( ! ($downloadURL = session('_update_download_link', null)))
        {
            $downloadURL = $this->getLatestDownloadLink();

            session()->put('_update_download_link', $downloadURL);
        }

        return $this->downloadUpdateFromURL($downloadURL);
    }

    /**
     * Validates the latest update and returns the download link
     *
     * @return string
     */
    public function getLatestDownloadLink()
    {
        $latest = $this->getLatestRelease();

        if ( ! isset($latest->assets[0]) or empty($latest->assets[0]->browser_download_url))
        {
            abort(500, trans('update.no_archive_to_download'));
        }

        return $latest->assets[0]->browser_download_url;
    }

    /**
     * Downloads and stores the update in temporary folder
     *
     * @param string $downloadURL
     * @return string
     */
    protected function downloadUpdateFromURL($downloadURL)
    {
        if ( ! ($fileName = session('_update_download_filename', null)))
        {
            $fileName = tempnam(sys_get_temp_dir(), 'nuclear_update.zip');

            session()->put('_update_download_filename', $fileName);
        }

        $readOffset = session('_update_download_offset', 0);
        $download = fopen($fileName, 'a');

        $eof = $this->downloadRange($download, $downloadURL, $readOffset);
        fclose($download);

        return $eof ? $fileName : false;
    }

    /**
     * Downloads a chunk of the update
     *
     * @param $download
     * @param string $downloadURL
     * @param int $readOffset
     * @return bool
     */
    protected function downloadRange($download, $downloadURL, $readOffset)
    {
        $ch = curl_init();

        curl_setopt_array($ch, [
            CURLOPT_URL            => $downloadURL,
            CURLOPT_RANGE          => 2097152 * $readOffset . '-' . (2097152 * ($readOffset + 1)-1),
            CURLOPT_BINARYTRANSFER => 1,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_FOLLOWLOCATION => 1,
        ]);

        $result = curl_exec($ch);
        $info = curl_getinfo($ch);
        curl_close($ch);

        if ($info['http_code'] == '206')
        {
            fwrite($download, $result);

            session()->put('_update_download_offset', $readOffset + 1);

            return false;
        }

        return true;
    }

    /**
     * Extracts the update in the supplied path
     *
     * @param string $path
     * @param ExtractionService
     * @return string
     */
    public function extractUpdate($path, ExtractionService $extractor)
    {
        return $extractor->extract($path);
    }

    /**
     * Moves the extracted vendor files in the supplied path
     *
     * @param string $path
     * @param ExtractionService $extractor
     */
    public function moveVendor($path, ExtractionService $extractor)
    {
        \Artisan::call('down');

        $extractor->moveVendor($path);

        \Artisan::call('up');
    }

    /**
     * Moves the extracted app files in the supplied path
     *
     * @param string $path
     * @param ExtractionService $extractor
     */
    public function moveUpdate($path, ExtractionService $extractor)
    {
        \Artisan::call('down');

        $extractor->move($path);

        \Artisan::call('up');
    }

    /**
     * Finalizes the update process
     */
    public function finalizeUpdate()
    {
        \Artisan::call('route:cache');
        \Artisan::call('migrate');
        \Artisan::call('optimize', ['--force' => true]);

        $this->reset();
    }

    /**
     * Resets the sessions that updater uses
     */
    public function reset()
    {
        session()->forget('_update_download_link');
        session()->forget('_update_download_filename');
        session()->forget('_update_download_offset');
        session()->forget('_temporary_update_path');
        session()->forget('_extracted_update_path');

        \Artisan::call('cache:clear');
        \Artisan::call('route:clear');
    }

}