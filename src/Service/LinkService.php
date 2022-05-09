<?php

namespace App\Service;

use App\Entity\ImageLink;
use App\Entity\VideoLink;
use App\Repository\LinkTypeRepository;
use App\Repository\ProviderRepository;
use Embed\Embed;

class LinkService
{
    private $embed;
    private $linkTypeRepository;
    private $providerRepository;

    public function __construct(
        Embed $embed,
        LinkTypeRepository $linkTypeRepository,
        ProviderRepository $providerRepository
    )
    {
        $this->embed = $embed;
        $this->linkTypeRepository = $linkTypeRepository;
        $this->providerRepository = $providerRepository;
    }
    public function createLink(string $url)
    {
        $data = $this->embed->get($url)->getOEmbed()->all();
        $data['original_url'] = $url;

        $link = null;

        switch ($data['type']){
            case 'video':
                $link = new VideoLink($data);

                break;

            case 'photo':
                $link = new ImageLink($data);

                break;
        }

        if($link){
            $link
                ->setType($this->linkTypeRepository->findOneBy(['label' => $data['type']]))
                ->setProvider($this->providerRepository->findOneBy(['name' => $data['provider_name']]))
            ;
        }

        return $link;
    }
}