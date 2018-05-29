<?php
/**
 * Created by PhpStorm.
 * User: banli
 * Date: 2018/5/22
 * Time: 21:33
 */
namespace App\Http\Services;

use Log;
use NicoVerbruggen\ImageGenerator\ImageGenerator;

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
       $this->initFaviconFromStaticUrl();
       $this->initFromMeta();
       $this->initTitle();
       $this->generateSiteImage();
       return true;
    }
    function initHtmlContent(){
        $host =  $this->host;
        $mainUrl = "http://{$host}";
        $mainPage = "/tmp/siteinfo/{$host}.html";
        if(! file_exists($mainPage)){
            $command = "google-chrome-stable --headless --disable-gpu --dump-dom --no-sandbox {$mainUrl} >{$mainPage}";
            Log::info($command);
            exec($command);
        }
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
            if(strpos($favicon, '?')!== false){
                list($favicon, $qs) = explode("?", $favicon, 2);
            }
            $arr = explode('.', $favicon);
            $suffix = end($arr);
            if(! in_array($suffix, ['ico', 'png', 'img'])){
                return false;
            }
            if(! $this->checkUrl($favicon)){
                return false;
            }
            $localIco =  $this->icoCategory.$this->host.'.'.$suffix;
            $command = "wget --no-cookie --no-check-certificate {$favicon} -O {$localIco}";
            exec($command);
            $icoUrlPath = '/ico/'.$this->host.'.'.$suffix;
            $this->icoPath = $icoUrlPath;
            Log::info($command);
            return true;
        }
        return false;
    }

    //get ico from root path
    function initFaviconFromStaticUrl(){
        if(! empty($this->icoPath)){
            return false;
        }
        $icoUrl = 'http://'.($this->host)."/favicon.ico";
        if(! $this->checkUrl($icoUrl)){
            return false;
        }
        $localIco =  $this->icoCategory.$this->host.'.ico';
        $command = "wget --no-cookie --no-check-certificate {$icoUrl} -O {$localIco}";
        exec($command);
        $this->icoPath = '/ico/'.$this->host.'.ico';
        return true;
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
                $this->desc = mb_convert_encoding($value,  'UTF-8', 'UTF-8');
            }
            if(strpos($key, 'title') !== false){
                $this->title = mb_convert_encoding($value,  'UTF-8', 'UTF-8');
            }
            if(strpos($key, 'keyword') !== false){
                $this->keyword = mb_convert_encoding($value,  'UTF-8', 'UTF-8');
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

    //生成网站首字符的图片
    function generateSiteImage(){
        if(empty($this->title)){
            Log::info('没有标题，生成不了图片');
            return false;
        }
        if(! empty($this->icoPath)){
//            var_dump($this->icoPath);die;
            return false;
        }
        // Create a new instance of ImageGenerator
        $generator = new ImageGenerator([
            // Decide on a target size for your image
            'targetSize' => '48x48',
            // Fun fact: if you set null for these, you'll get a random color for each generated placeholder!
            // You can also specify a specific hex color. ("#EEE" or "#EEEEEE" are both accepted)
            'textColorHex' => null,
            'backgroundColorHex' => null,
            // Let's point to a font. If it can't be found, it'll use a fallback (built-in to GD)
            'pathToFont' => "Kaiti.ttf",
            'fontSize' => 25
        ]);

        $char = mb_substr($this->title, 0, 1);
        $localIco =  $this->icoCategory.$this->host.'.png';
        $generator->makePlaceholderImage(
            $char, // The text that will be added to the image
            $localIco // The path where the image will be saved
        );
        $this->icoPath = '/ico/'.$this->host.'.png';
        return true;
    }

    //判断链接是否正常
    public function checkUrl($icoUrl){
        $handle = curl_init($icoUrl);
        curl_setopt($handle,  CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($handle, CURLOPT_FOLLOWLOCATION, TRUE);

        /* Get the HTML or whatever is linked in $url. */
        curl_exec($handle);

        /* Check for 404 (file not found). */
        $httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);
        if($httpCode != 200) {
            return false;
        }
        return true;
    }
}
