<?php


use Illuminate\Database\Seeder;
use Nuclear\Hierarchy\Node;
use Nuclear\Hierarchy\NodeType;

class NodesTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $homepage = NodeType::whereName('homepage')->first()->getKey();
        $basicpage = NodeType::whereName('basicpage')->first()->getKey();

        $home = new Node;
        $home->setNodeTypeByKey($homepage);
        $home->fill([
            'en' => [
                'title' => 'Home',
                'node_name' => 'home',
                'content' => 'Here is your **content**!

You can do great things with the [Nuclear CMS](https://github.com/NuclearCMS/Nuclear){blank}!

And it supports [markdown](https://daringfireball.net/projects/markdown/){blank}!'
            ],
            'tr' => [
                'title' => 'Anasayfa',
                'node_name' => 'anasayfa',
                'content' => '**İçeriğiniz** burada!

[Nuclear CMS](https://github.com/NuclearCMS/Nuclear){blank} ile büyük şeyler yapabilirsiniz!

Ayrıca Nuclear [markdown](https://daringfireball.net/projects/markdown/){blank} destekler!'
            ],
            'home' => 1,
            'status' => 50
        ]);
        $home->save();

        $about = new Node;
        $about->setNodeTypeByKey($basicpage);
        $about->fill([
            'en' => [
                'title' => 'About',
                'node_name' => 'about'
            ],
            'tr' => [
                'title' => 'Hakkında',
                'node_name' => 'hakkinda'
            ],
            'status' => 50
        ]);
        $about->appendToNode($home);
        $about->save();

        $contact = new Node;
        $contact->setNodeTypeByKey($basicpage);
        $contact->fill([
            'en' => [
                'title' => 'Contact',
                'node_name' => 'contact'
            ],
            'tr' => [
                'title' => 'İletişim',
                'node_name' => 'iletisim'
            ],
            'status' => 50
        ]);
        $contact->appendToNode($home);
        $contact->save();

    }

}