<?php

use Illuminate\Database\Seeder;
use Reactor\Nodes\NodeType;
use Nuclear\Hierarchy\Repositories\NodeTypeRepository;
use Nuclear\Hierarchy\Repositories\NodeFieldRepository;

class NodeTypesSeeder extends Seeder
{
    /**
     * Repositories
     */
    protected $nodeTypeRepository;
    protected $nodeFieldRepository;

    /**
     * Constructor
     *
     * @param NodeTypeRepository
     * @param NodeFieldRepository
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
        $nodeTypes = NodeType::all();

        DB::table('node_types')->truncate();
        DB::table('node_fields')->truncate();

        $basicPage = $this->nodeTypeRepository->create([
            'name' => 'basicpage',
            'label' => 'Basic Page'
        ]);

        $pageContent = $this->nodeFieldRepository->create($basicPage->getKey(), [
            'name' => 'content',
            'label' => 'Content',
            'position' => 1,
            'type' => 'markdown'
        ]);

        $subsection = $this->nodeTypeRepository->create([
            'name' => 'subsection',
            'label' => 'Subsection'
        ]);

        $subsectionContent = $this->nodeFieldRepository->create($subsection->getKey(), [
            'name' => 'content',
            'label' => 'Content',
            'position' => 1,
            'type' => 'markdown'
        ]);
    }
}
