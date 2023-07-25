<?php

namespace Database\Seeders;

use App\models\WebContent;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WebContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        $webContentData = [
            [
                'section' => 'hero',
                'sub_section' => 'video',
                'content_type' => 'link',
                'content' => 'https://youtu.be/IwJS6JU7-xc',
            ],
            [
                'section' => 'hero',
                'sub_section' => 'header',
                'content_type' => 'text',
                'content' => 'Preparate para divertirte a lo grande',
            ],
            [
                'section' => 'about',
                'sub_section' => 'body',
                'content_type' => 'text',
                'content' => "I'm a skilled software developer with experience in Typescript, React, Node, and MongoDB. I'm a skilled software developer with experience in Typescript, React, Node, and MongoDB. I'm a skilled software developer with experience in Typescript, React, Node, and MongoDB.",
            ],
            [
                'section' => 'about',
                'sub_section' => 'image',
                'content_type' => 'image',
                'content' => "link of image created",
            ],
            [
                'section' => 'links',
                'sub_section' => 'tiktok',
                'content_type' => 'link',
                'content' => "TikTok Link",
            ],
            [
                'section' => 'links',
                'sub_section' => 'facebook',
                'content_type' => 'link',
                'content' => "Facebook Link",
            ],
            [
                'section' => 'links',
                'sub_section' => 'instagram',
                'content_type' => 'link',
                'content' => "Instagram Link",
            ],
            [
                'section' => 'links',
                'sub_section' => 'youtube',
                'content_type' => 'link',
                'content' => "Youtube Link",
            ],
            [
                'section' => 'giveaways',
                'sub_section' => 'header',
                'content_type' => 'text',
                'content' => "Participa de Grandes sorteos y Concursos",
            ],
            [
                'section' => 'video',
                'sub_section' => 'video1',
                'content_type' => 'link',
                'content' => "Link of Video",
            ],
            [
                'section' => 'video',
                'sub_section' => 'video2',
                'content_type' => 'link',
                'content' => "Link of Video2",
            ],
            [
                'section' => 'video',
                'sub_section' => 'video3',
                'content_type' => 'link',
                'content' => "Link of Video3",
            ],
            [
                'section' => 'video',
                'sub_section' => 'video4',
                'content_type' => 'link',
                'content' => "Link of Video4",
            ],
            [
                'section' => 'video',
                'sub_section' => 'video5',
                'content_type' => 'link',
                'content' => "Link of Video5",
            ],
            [
                'section' => 'partner',
                'sub_section' => 'header',
                'content_type' => 'text',
                'content' => "Marcas con las cuales he trabajado y he desarrollado un gran afecto.",
            ],

        ];

        // Loop through the data array and create WebContent objects
        foreach ($webContentData as $data) {
            WebContent::create($data);
        }
    }
}
