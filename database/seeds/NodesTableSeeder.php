<?php

use Illuminate\Database\Seeder;
use Reactor\Nodes\Node;
use Reactor\Nodes\NodeType;

class NodesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pageNode = NodeType::whereName('basicpage')->first()->getKey();
        $sectionNode = NodeType::whereName('subsection')->first()->getKey();

        $home = new Node;
        $home->setNodeTypeByKey($pageNode);
        $home->fill([
            'en' => [
                'title' => 'Home',
                'node_name' => 'home',
                'source_type' => 'basicpage',
                'content' => 'Here is your **content**!

You can do great things with the [Nuclear CMS](https://github.com/NuclearCMS/Nuclear)!

And it supports [markdown](https://daringfireball.net/projects/markdown/)!'
            ],
            'tr' => [
                'title' => 'Anasayfa',
                'node_name' => 'anasayfa',
                'source_type' => 'basicpage',
                'content' => '**İçeriğiniz** burada!

[Nuclear CMS](https://github.com/NuclearCMS/Nuclear) ile büyük şeyler yapabilirsiniz!

Ayrıca Nuclear [markdown](https://daringfireball.net/projects/markdown/) destekler!'
            ],
            'home' => 1,
            'status' => 50
        ]);
        $home->save();

        $about = new Node;
        $about->setNodeTypeByKey($pageNode);
        $about->fill([
            'en' => [
                'title' => 'About',
                'node_name' => 'about',
                'source_type' => 'basicpage'
            ],
            'tr' => [
                'title' => 'Hakkında',
                'node_name' => 'hakkinda',
                'source_type' => 'basicpage'
            ],
            'status' => 50
        ]);
        $about->appendTo($home);
        $about->save();

        $contact = new Node;
        $contact->setNodeTypeByKey($pageNode);
        $contact->fill([
            'en' => [
                'title' => 'Contact',
                'node_name' => 'contact',
                'source_type' => 'basicpage'
            ],
            'tr' => [
                'title' => 'İletişim',
                'node_name' => 'iletisim',
                'source_type' => 'basicpage'
            ],
            'status' => 50,
            'hides_children' => 1
        ]);
        $contact->appendTo($home);
        $contact->save();

        $address = new Node;
        $address->setNodeTypeByKey($sectionNode);
        $address->fill([
            'en' => [
                'title' => 'Address',
                'node_name' => 'address',
                'source_type' => 'basicpage'
            ],
            'tr' => [
                'title' => 'Adres',
                'node_name' => 'adres',
                'source_type' => 'basicpage'
            ],
            'status' => 50
        ]);
        $address->appendTo($contact);
        $address->save();

        $telephone = new Node;
        $telephone->setNodeTypeByKey($sectionNode);
        $telephone->fill([
            'en' => [
                'title' => 'Telephone',
                'node_name' => 'telephone',
                'source_type' => 'basicpage'
            ],
            'tr' => [
                'title' => 'Telefon',
                'node_name' => 'Telefon',
                'source_type' => 'basicpage'
            ],
            'status' => 50,
            'node_type_id' => $sectionNode,
        ]);
        $telephone->appendTo($contact);
        $telephone->save();
    }
}
