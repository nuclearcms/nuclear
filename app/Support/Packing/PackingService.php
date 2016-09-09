<?php


namespace Reactor\Support\Packing;


use Chumper\Zipper\Facades\Zipper as ZipperFacade;
use Chumper\Zipper\Zipper;
use Illuminate\Support\Facades\File;
use Spatie\DbDumper\Databases\MySql;

class PackingService {

    /**
     * Creates a backup package
     */
    public function createBackup()
    {
        $this->resetDirectory();

        $zipper = $this->populateZipper(
            $this->getNewZipper('backup'),
            $this->getBackupDirectories(),
            $this->getBackupFiles()
        );

        $this->addDbdumpToPackage($zipper);
    }

    /**
     * Creates a deploy package
     */
    public function createDeployPackage()
    {
        $this->resetDirectory();

        $zipper = $this->populateZipper(
            $this->getNewZipper('deploy'),
            $this->getDeployPackageDirectories(),
            $this->getDeployPackageFiles()
        );

        $this->addDbdumpToPackage($zipper);
    }

    /**
     * Reset directory
     */
    protected function resetDirectory()
    {
        if ( ! app()->runningInConsole())
        {
            chdir('../');
        }
    }

    /**
     * Returns backup directories
     *
     * @return array
     */
    protected function getBackupDirectories()
    {
        $dirs = ['config/', 'database/', 'extension/', 'gen/', 'resources/', 'routes/'];

        $dirs[] = ltrim(public_path(), base_path()) . '/';

        return $dirs;
    }

    /**
     * Returns backup files
     *
     * @return array
     */
    protected function getBackupFiles()
    {
        return ['.env', '.gitattributes', '.gitignore', 'composer.json', 'composer.lock', 'gulpfile.js', 'package.json', 'phpunit.xml', 'readme.md', 'server.php'];
    }

    /**
     * Returns backup directories
     *
     * @return array
     */
    protected function getDeployPackageDirectories()
    {
        return array_merge(
            $this->getBackupDirectories(),
            ['app/', 'bootstrap/', 'storage/', 'vendor/']
        );
    }

    /**
     * Returns backup files
     *
     * @return array
     */
    protected function getDeployPackageFiles()
    {
        return array_merge(
            $this->getBackupFiles(),
            ['artisan']
        );
    }

    /**
     * Creates a new zipper instance
     *
     * @param string $tag
     * @return Zipper
     */
    protected function getNewZipper($tag)
    {
        return ZipperFacade::make('backups/' . date('Y-m-d_His') . '-' . $tag . '.zip');
    }

    /**
     * Add files and folders
     *
     * @param Zipper $zipper
     * @param array $folders
     * @param array $files
     * @return Zipper
     */
    protected function populateZipper(Zipper $zipper, array $folders, array $files)
    {
        foreach ($folders as $folder)
        {
            $zipper->folder('files/' . $folder)->add($folder);
        }

        $zipper->folder('files')->add($files);

        return $zipper;
    }

    /**
     * Adds database dump to the package
     *
     * @param Zipper $zipper
     * @return Zipper
     */
    protected function addDbdumpToPackage(Zipper $zipper)
    {
        $fileName = sys_get_temp_dir() . '/' . date('Y-m-d_His') . '-mysqldump.sql';

        MySql::create()
            ->setDbName(env('DB_DATABASE'))
            ->setUserName(env('DB_USERNAME'))
            ->setPassword(env('DB_PASSWORD'))
            ->dumpToFile($fileName);

        $zipper->folder('database')->add($fileName);

        return $zipper;
    }

}