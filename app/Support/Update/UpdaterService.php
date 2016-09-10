<?php


namespace Reactor\Support\Update;


use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Symfony\Component\HttpFoundation\Response;

class UpdaterService {

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

}