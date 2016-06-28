<?php 
namespace Maggie\Dashboard\Controllers;

use Symfony\Component\DomCrawler\Crawler;

class NewsController extends BaseController
{
    public $channels;

    public function __construct()
    {
        $this->channels = array(
            'g1globo' => array(
                'title'         => 'G1 - Globo.com',
                'description'   => 'O portal de noticias da globo',
                'url'           => 'http://g1.globo.com/',
                'rss'           => null,
                'method'        => 'url_g1globo'
            ),
            'b9' => array(
                'title'         => 'B9 - Brainstorm 9',
                'description'   => 'B9.com.br cobre a intersecção entre a criatividade, comunicação, cultura digital, inovação e negócios.',
                'url'           => 'http://www.b9.com.br/',
                'rss'           => 'https://feeds.feedburner.com/brainstorm9',
                'method'        => 'rss'
            ),
            'olhardigital' => array(
                'title'         => 'Olhar Digital',
                'description'   => 'O futuro passa primeiro aqui',
                'url'           => 'http://olhardigital.uol.com.br/',
                'rss'           => 'http://olhardigital.uol.com.br/rss',
                'method'        => 'rss'
            )
        );
    }

    public function crawler_catch_image($content) 
    {
        $first_img = '';
        ob_start();
        ob_end_clean();
        $output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $content, $matches);
        $first_img = $matches[1][0];

        if (empty($first_img)) {
            $first_img = get_template_url().'/assets/images/noimage_544x258.png';
        }

        return $first_img;
    }

    public function crawler_url_g1globo($url)
    {
        $html = file_get_contents($this->channels['g1globo']['url']);

        $crawler = new Crawler($html);

        // get g1.globo.com 23th script tag
        $g1_bastion_js = $crawler->filter('script')->extract(array('_text'))[23];

        // clear script to use simple in php
        $g1_bastion_js = explode('n=function', $g1_bastion_js);
        $g1_bastion_js = explode('requireFeed(\'__new__\')', $g1_bastion_js[0]);
        $g1_bastion_js = explode(',', $g1_bastion_js[1]);
        $g1_bastion_js[0] = '';
        $g1_bastion_js = implode(',', $g1_bastion_js);
        $g1_bastion_js = ltrim($g1_bastion_js, ',');
        $g1_bastion_js = trim($g1_bastion_js);
        $g1_bastion_js = rtrim($g1_bastion_js, "}");
        $g1_bastion_js = rtrim($g1_bastion_js, ")");

        //print_r(json_decode($g1_bastion_js));
        //print_r($g1_bastion_js);
        //die();

        $items = array();
        foreach (json_decode($g1_bastion_js)->items as $g1_item) {
            $items[] = array(
                'title' => $g1_item->content->title,
                'short_description' => $g1_item->content->summary,
                'url' => $g1_item->content->url,
                'image_url' => $g1_item->content->image->sizes->M->url,
                'image_w' => $g1_item->content->image->sizes->M->width,
                'image_h' => $g1_item->content->image->sizes->M->height,
                'author' => 'G1',
                'created' => strtotime($g1_item->created),
                'modified' => strtotime($g1_item->modified),
            );
        }

        return $items;
    }

    public function crawler_rss($url)
    {  
        $html = file_get_contents($url);

        $crawler = new Crawler($html);
        $rss_items = array();
        $rss_items = $crawler->filter('channel item')->each(function(Crawler $node, $i){
            $item = array(
                'title' => $node->filter('title')->text(),
                'short_description' => substr(strip_tags($node->filter('description')->text()), 0, 100),
                'url' => $node->filter('guid')->text(),
                'image_url' => $this->crawler_catch_image(html_entity_decode($node->filter('description')->text())),
                'image_w' => null,
                'image_h' => null,
                'author' => '',//$node->filter('dc:creator')->text(),
                'created' => strtotime($node->filter('pubDate')->text()),
                'modified' => strtotime($node->filter('pubDate')->text()),
            );
            return $item;
        });

        return $rss_items;
    }

    public function index($request, $response, $args)
    {
        $data = array();

        $data['posts']['g1globo'] = $this->crawler_url_g1globo($this->channels['g1globo']['url']);

        foreach ($this->channels as $channel => $item) {
            
            if ($item['method']!='rss') 
                continue;

            $data['posts'][$channel] = $this->crawler_rss($this->channels[$channel]['rss']);

        }

        $data['posts']['olhardigital'] = array();

        $data['channels'] = $this->channels;

        view_render('news/index', $data);

        //dd($items);
    }

}