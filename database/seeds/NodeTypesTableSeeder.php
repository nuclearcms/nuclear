<?php


use Illuminate\Database\Seeder;
use Nuclear\Hierarchy\Repositories\NodeFieldRepository;
use Nuclear\Hierarchy\Repositories\NodeTypeRepository;

class NodeTypesTableSeeder extends Seeder {

    /**
     * Repositories
     */
    protected $nodeTypeRepository;
    protected $nodeFieldRepository;

    /**
     * Constructor
     *
     * @param NodeTypeRepository $nodeTypeRepository
     * @param NodeFieldRepository $nodeFieldRepository
     */
    public function __construct(NodeTypeRepository $nodeTypeRepository, NodeFieldRepository $nodeFieldRepository)
    {
        $this->nodeTypeRepository = $nodeTypeRepository;
        $this->nodeFieldRepository = $nodeFieldRepository;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('node_types')->truncate();
        DB::table('node_fields')->truncate();

        $homePage = $this->nodeTypeRepository->create([
            'name' => 'homepage',
            'label' => trans('install.type_homepage_label')
        ]);

        $pageContent = $this->nodeFieldRepository->create($homePage->getKey(), [
            'name' => 'content',
            'label' => trans('validation.attributes.content'),
            'position' => 1,
            'type' => 'markdown'
        ]);

        $basicPage = $this->nodeTypeRepository->create([
            'name' => 'basicpage',
            'label' => trans('install.type_basicpage_label')
        ]);

        $pageContent = $this->nodeFieldRepository->create($basicPage->getKey(), [
            'name' => 'content',
            'label' => trans('validation.attributes.content'),
            'position' => 1,
            'type' => 'markdown'
        ]);
    }

}