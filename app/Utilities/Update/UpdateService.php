<?php

namespace Reactor\Utilities\Update;


use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\RequestException;
use Symfony\Component\HttpFoundation\Response;

class UpdateService {

    const releasesURL = 'https://api.github.com/repos/nuclearcms/nuclear/releases';

    /**
     * @var GuzzleClient
     */
    protected $httpClient;

    /**
     * Releases cache
     *
     * @var array
     */
    protected $releases;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->httpClient = new GuzzleClient([
            'defaults' => ['debug' => false],
        ]);
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

            if ($response->getStatusCode() === Response::HTTP_OK)
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
        ) === 0);
    }

    /**
     * Returns the latest release
     */
    public function getLatestRelease()
    {
        return current($this->getReleases());
    }

}