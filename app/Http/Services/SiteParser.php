<?php
/**
 * Created by PhpStorm.
 * User: banli
 * Date: 2018/5/22
 * Time: 21:33
 */
namespace App\Http\Services;

use Log;

class SiteParser{

    protected $icoPath;
    protected $title;
    protected $keyword;
    protected $desc;
    protected $url;
    protected $host;
    protected $html;
    protected $icoCategory = "/service/navi/public/ico/";

    public $errMsg;

    function init($url){
        if(strpos($url, 'http') === false){
            $url = 'http://'.$url;
        }

        $urlArr = parse_url($url);
       if(empty($urlArr['host'])){
           $this->errMsg = 'url格式错误';
           return false;
       }
       $this->host = $urlArr['host'];
       $this->initHtmlContent();
       $this->getFaviconFromHtml();
       $this->initFromMeta();
       $this->initTitle();
       return true;
    }
    function initHtmlContent(){
        $host =  $this->host;
        $mainUrl = "http://{$host}";
        $mainPage = "/tmp/siteinfo/{$host}.html";
        $command = "google-chrome-stable --headless --disable-gpu --dump-dom --no-sandbox {$mainUrl} >{$mainPage}";
        exec($command);
        $this->html = file_get_contents($mainPage);
        return true;
    }

    function getFaviconFromHtml(){
        $html = $this->html;
        $url = 'http://'.$this->host;
        $lines = preg_split('/\n|\r\n?/', $html);
        foreach ($lines as $line) {
            if (strpos($line, 'icon') != false) {
                $icoLine = $line;
                break;
            }
        }
        if(empty($icoLine)){
            return false;
        }
        preg_match_all("/href=\"(.*?)\"/i", $icoLine, $matches);
        if(isset($matches[1][0])){
            $favicon = $matches[1][0];

            # check if absolute url or relative path
            $favicon_elems = parse_url($favicon);

            if(!isset($favicon_elems['host'])){
                $favicon = $url . '/' . $favicon;
            }

            if(strpos($favicon, 'http') === false){
                $favicon = 'http:'.$favicon;
            }

            $arr = explode('.', $favicon);
            $suffix = end($arr);
            if(! in_array($suffix, ['ico', 'png', 'img'])){
                return false;
            }

            $localIco =  $this->icoCategory.$this->host.'.'.$suffix;
            $command = "wget {$favicon} -O {$localIco}";
            Log::info($command);
            exec($command);
            $icoUrlPath = '/ico/'.$this->host.'.'.$suffix;
            $this->icoPath = $icoUrlPath;
            return true;
        }
        return false;
    }



    function getWebSiteInfo($url){
        $this->init($url);
        return [
            'url' => $url,
            'ico' => empty($this->icoPath)?'/ico/example.png':$this->icoPath,
            'keywords' => $this->keyword,
            'summary' => $this->desc,
            'name' => $this->title
        ];
    }

    function initFromMeta(){
        $url =  'http://'.$this->host;
        $meta = get_meta_tags($url);
        foreach ($meta as $key => $value){
            if(strpos($key, 'description') !== false){
                $this->desc = $value;
            }
            if(strpos($key, 'title') !== false){
                $this->title = $value;
            }
            if(strpos($key, 'keyword') !== false){
                $this->keyword = $value;
            }
        }
        return true;
    }

    function initTitle(){
        if(! empty($this->title)){
            return true;
        }
        $str = $this->html;
        if(strlen($str)>0){
            $res = preg_match("/<title>(.*)<\/title>/siU", $str, $title_matches);
            if (!$res)
                return false;

            // Clean up title: remove EOL's and excessive whitespace.
            $title = preg_replace('/\s+/', ' ', $title_matches[1]);
            $this->title = trim($title);
            return true;
        }
        return false;
    }
}