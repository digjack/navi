<?php
/**
 * Created by PhpStorm.
 * User: banli
 * Date: 2018/5/22
 * Time: 21:33
 */
namespace App\Http\Services;

class SiteParser{

    protected $icoPath;
    protected $title;
    protected $keyword;
    protected $desc;
    protected $url;
    protected $host;
    protected $html;

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
//       var_dump('http://'.$this->host);die;
       $this->initHtmlContent();
       $this->initFromMeta();
       $this->initFaviconFromStaticUrl();
       $this->initTitle();
       return true;
    }
    function initHtmlContent(){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->host);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        $output = curl_exec($ch);
        curl_close($ch);
        $this->html = $output;
        return true;
    }

    function getWebSiteInfo($url){
        $this->init($url);
        return [
            'url' => $url,
            'ico' => $this->icoPath,
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
            if(strpos($key, 'image') !== false || strpos($key, 'logo') !== false){
                $this->icoPath = $value;
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
//        var_dump($this->html);die;
//        var_dump($str);die;
        if(strlen($str)>0){
            $str = trim(preg_replace('/\s+/', ' ', $str)); // supports line breaks inside <title>
            preg_match("/\<title\>(.*)\<\/title\>/i",$str,$title); // ignore case
            if(empty($title[1])){
                return false;
            }
            $this->title = $title[1];
            return true;
        }
        return false;
    }

    function initFaviconFromStaticUrl(){
        if(! empty($this->icoPath)){
            return true;
        }
        $icoUrl = 'http://'.($this->host)."/favicon.ico";
        $handle = curl_init($icoUrl);
        curl_setopt($handle,  CURLOPT_RETURNTRANSFER, TRUE);

        /* Get the HTML or whatever is linked in $url. */
        curl_exec($handle);

        /* Check for 404 (file not found). */
        $httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);
        if($httpCode == 404) {
            return false;
        }
        $this->icoPath = $icoUrl;
        return true;
    }
}

//$siteInfoClass =new SiteParser();
////$siteInfoClass =new SiteInfo();
//$info = $siteInfoClass->getWebSiteInfo('stackoverflow.com');
//var_dump($info);die;