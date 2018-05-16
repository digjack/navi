<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>板栗云导航</title>
    <link rel="shortcut icon" href="favcion.ico" />
    <link rel="stylesheet" href=" css/iconfont.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <div class="container" id="app">
        <aside class="left-bar" id="leftBar">
            <div class="title">
                <p>@{{site_name}}</p>
            </div>
            <nav class="nav">
                <div class="item active"><a href=""><i class="iconfont icon-daohang2"></i>极客导航</a><i class="line"></i></div>
                <ul class="nav-item" id="navItem">
                    <li><a href="#bbs" class="active"><i class="iconfont icon-shequ"></i>开发社区</a></li>
                    <li><a href="#sill"><i class="iconfont icon-blogger"></i>技术博客</a></li>
                    <li><a href="#docs"><i class="iconfont icon-wendangdocument78"></i>开发文档</a></li>
                    <li><a href="#tools"><i class="iconfont icon-tool"></i>实用工具</a></li>
                    <li><a href="#design"><i class="iconfont icon-designer"></i>设计资源</a></li>
                    <li><a href="#study"><i class="iconfont icon-xuexi1"></i>学无止境</a></li>
                    <li><a href="#operation"><i class="iconfont icon-yunying"></i>网络运营</a></li>
                    <li class="download"><a href=""><i class="iconfont icon-github"></i>源码下载</a></li>
                </ul>
                <div class="item comment"><a target="_blank" href="http://www.zcbboke.com/liuyan.html"><i class="iconfont icon-liuyan"></i>留言</a></div>
            </nav>
        </aside>
        <section class="main">
            <div id="mainContent">
                <!-- 手机端菜单 -->
                <div id="menu-box">
                   <div id="menu">
                       <input type="checkbox" id="menu-form">
                       <label for="menu-form" class="menu-spin">
                        <div class="line diagonal line-1"></div>
                        <div class="line horizontal"></div>
                        <div class="line diagonal line-2"></div>
                      </label>
                    </div>
                </div>
                <div v-for="site_set in sites" class="box">
                    <a href="#" name="bbs"></a>
                    <div class="sub-category">
                        <div><i class="iconfont icon-shequ"></i>@{{ site_set.class }}</div>
                    </div>
                    <div v-for="site in site_set.list">
                        <a target="_blank" href="@{{ site.url }}">
                            <div class="item">
                                <div class="logo"><img src="img/csdn.ico" alt="CNDS"> @{{ site.name }}</div>
                                <div class="desc">@{{ site.summary }}</div>
                            </div>
                        </a>
                    </div>

                </div>
                <!-- 开发社区 -->
                <div class="box">
                    <a href="#" name="bbs"></a>
                    <div class="sub-category">
                        <div><i class="iconfont icon-shequ"></i>开发社区</div>
                    </div>
                    <div>
                        <a target="_blank" href="http://blog.csdn.net/">
                            <div class="item">
                                <div class="logo"><img src="img/csdn.ico" alt="CNDS"> CNDS</div>
                                <div class="desc">中国最大的IT社区和服务平台</div>
                            </div>
                        </a>
                        <a href="https://juejin.im/">
                            <div class="item">
                                <div class="logo"><img src="img/gold-favicon.png" alt="掘金"> 掘金</div>
                                <div class="desc">只有高手分享的中文技术社区</div>
                            </div>
                        </a>
                        <a target="_blank" href="https://github.com/">
                            <div class="item">
                                <div class="logo"><img src="img/github.ico" alt="github"> github</div>
                                <div class="desc">面向开源及私有软件项目的git托管平台</div>
                            </div>
                        </a>
                        <a target="_blank" href="http://stackoverflow.com/">
                            <div class="item">
                                <div class="logo"><img src="img/stackoverflow.ico" alt="stackoverflow"> stackoverflow</div>
                                <div class="desc">国外编程相关的IT技术问答网站</div>
                            </div>
                        </a>
                        <a target="_blank" href="https://segmentfault.com/">
                            <div class="item">
                                <div class="logo"><img src="img/segmentfault.ico" alt="segmentfault"> segmentfault</div>
                                <div class="desc">一个专注于解决编程问题，提高开发技能的社区。</div>
                            </div>
                        </a>
                        <a target="_blank" href="https://www.zhihu.com/">
                            <div class="item">
                                <div class="logo"><img src="img/zhihu.ico" alt="知乎"> 知乎</div>
                                <div class="desc">与世界分享你的知识、经验和见解与世界分享你的知识、经验和见解</div>
                            </div>
                        </a>
                        <a target="_blank" href="https://www.cnblogs.com/">
                            <div class="item">
                                <div class="logo"><img src="img/cnblogs.ico" alt="博客园"> 博客园</div>
                                <div class="desc">博客模式的技术分享社区</div>
                            </div>
                        </a>
                        <a target="_blank" href="https://www.oschina.net/">
                            <div class="item">
                                <div class="logo"><img src="img/oschina.ico" alt="开源中国"> 开源中国</div>
                                <div class="desc">
                                    <div class="info">
                                        目前中国最大的开源技术社区
                                    </div>
                                </div>
                            </div>
                        </a>
                        <a target="_blank" href="https://www.v2ex.com/">
                            <div class="item">
                                <div class="logo"><img src="img/v2ex.png" alt="V2EX"> V2EX</div>
                                <div class="desc">一个关于分享和探索的地方。</div>
                            </div>
                        </a>
                        <a target="_blank" href="https://coding.net/">
                            <div class="item">
                                <div class="logo"><img src="img/coding.png" alt=" Coding"> Coding</div>
                                <div class="desc">中国最大的git平台。</div>
                            </div>
                        </a>
                    </div>
                </div>
                <!-- 技术博客 -->
                <div class="box">
                    <a href="#" name="sill"></a>
                    <div class="sub-category">
                        <div><i class="iconfont icon-blogger"></i>技术博客</div>
                    </div>
                    <div>
                        <a target="_blank" href="http://www.alloyteam.com/">
                            <div class="item">
                                <div class="logo"><img src="img/alloyteam-favicon.jpg" alt="腾讯 AlloyTeam 团队"> 腾讯 AlloyTeam 团队</div>
                                <div class="desc">腾讯Web前端团队，代表作品WebQQ，致力于前端技术的研究</div>
                            </div>
                        </a>
                        <a target="_blank" href="https://isux.tencent.com/">
                            <div class="item">
                                <div class="logo"><img src="img/isux-favicon.jpg" alt="ISUX"> ISUX</div>
                                <div class="desc">腾讯社交用户体验设计，简称ISUX，腾讯设计团队网站</div>
                            </div>
                        </a>
                        <a target="_blank" href="http://fex.baidu.com/">
                            <div class="item">
                                <div class="logo">
                                    <img src="img/fex-favicon.png"> FEX
                                </div>
                                <div class="desc">
                                    百度Web前端研发部出品
                                </div>
                            </div>
                        </a>
                        <a target="_blank" href="http://taobaofed.org/">
                            <div class="item">
                                <div class="logo">
                                    <img src="img/fed-favicon.png"> 淘宝前端团队（FED）
                                </div>
                                <div class="desc">
                                    用技术为体验提供无限可能
                                </div>
                            </div>
                        </a>
                        <a target="_blank" href="https://aotu.io/">
                            <div class="item">
                                <div class="logo">
                                    <img src="img/aotu-favicon.png"> 凹凸实验室
                                </div>
                                <div class="desc">
                                    京东用户体验设计部出品
                                </div>
                            </div>
                        </a>
                        <a target="_blank" href="https://75team.com/">
                            <div class="item">
                                <div class="logo">
                                    <img src="img/75team-favicon.png"> 奇舞团
                                </div>
                                <div class="desc">
                                    奇虎360旗下前端开发团队出品
                                </div>
                            </div>
                        </a>
                        <a target="_blank" href="http://efe.baidu.com/">
                            <div class="item">
                                <div class="logo">
                                    <img src="img/efe-favicon.png"> EFE
                                </div>
                                <div class="desc">
                                    由百度多个遵循统一技术体系的前端团队所组成
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <!-- 参考文档 -->
                <div class="box">
                    <a href="" name="docs"></a>
                    <div class="sub-category">
                        <div><i class="iconfont icon-wendangdocument78"></i>参考文档</div>
                    </div>
                    <div>
                        <a target="_blank" href="http://jquery.cuishifeng.cn/index.html">
                            <div class="item">
                                <div class="logo"><img src="img/jquery.png" alt="jQuery"> jQuery</div>
                                <div class="desc">优秀的JavaScript代码库</div>
                            </div>
                        </a>
                        <a target="_blank" href="http://v3.bootcss.com/">
                            <div class="item">
                                <div class="logo"><img src="img/bootstrap-favicon.png" alt="Bootstrap"> Bootstrap</div>
                                <div class="desc">基于HTML/CSS/Javscript的前端框架</div>
                            </div>
                        </a>
                        <a target="_blank" href="http://v3.bootcss.com/">
                            <div class="item">
                                <div class="logo"><img src="img/vue-favicon.png" alt="Vue.js"> Vue.js</div>
                                <div class="desc">构建数据驱动的web界面的渐进式框架</div>
                            </div>
                        </a>
                    </div>
                </div>
                <!-- 实用工具 -->
                <div class="box">
                    <a href="" name="tools"></a>
                    <div class="sub-category">
                        <div><i class="iconfont icon-tool"></i>实用工具</div>
                    </div>
                    <div>
                        <a target="_blank" href="http://www.ibootstrap.cn/">
                            <div class="item">
                                <div class="no-logo">bootstrap可视化布局</div>
                            </div>
                        </a>
                        <a target="_blank" href="http://www.peise.net/tools/web/">
                            <div class="item">
                                <div class="no-logo">网页配色工具</div>
                            </div>
                        </a>
                        <a target="_blank" href="http://www.uupoop.com/">
                            <div class="item">
                                <div class="no-logo">在线PS</div>
                            </div>
                        </a>
                        <a target="_blank" href="https://dummyimage.com/">
                            <div class="item">
                                <div class="no-logo">动态图像生成器</div>
                            </div>
                        </a>
                        <a target="_blank" href="http://xiuxiu.web.meitu.com/main.html">
                            <div class="item">
                                <div class="no-logo">美图秀秀在线图片处理</div>
                            </div>
                        </a>
                        <a target="_blank" href="https://cli.im/deqr">
                            <div class="item">
                                <div class="no-logo">二维码在线生成</div>
                            </div>
                        </a>
                        <a target="_blank" href="https://www.zybuluo.com/mdeditor">
                            <div class="item">
                                <div class="no-logo">Markdown在线编辑器</div>
                            </div>
                        </a>
                        <a target="_blank" href="http://dwz.wailian.work/">
                            <div class="item">
                                <div class="no-logo">短网址生成</div>
                            </div>
                        </a>
                    </div>
                </div>
                <!-- 设计资源 -->
                <div class="box">
                    <a href="" name="design"></a>
                    <div class="sub-category">
                        <div><i class="iconfont icon-wendangdocument78"></i>设计资源</div>
                    </div>
                    <div>
                        <a target="_blank" href="http://www.uigreat.com/">
                            <div class="item">
                                <div class="logo">
                                    <img src="img/uigreat-favicon.jpg"> UIGREAT
                                </div>
                                <div class="desc">
                                    优秀设计师的贴心伴侣。
                                </div>
                            </div>
                        </a>
                        <a target="_blank" href="http://huaban.com/">
                            <div class="item">
                                <div class="logo">
                                    <img src="img/huaban-favicon.png"> 花瓣
                                </div>
                                <div class="desc">
                                    花瓣，陪你做生活的设计师。
                                </div>
                            </div>
                        </a>
                        <a target="_blank" href="https://dribbble.com/">
                            <div class="item">
                                <div class="logo">
                                    <img src="img/dribbble-favicon.png"> Dribbble
                                </div>
                                <div class="desc">
                                    设计作品的交流平台
                                </div>
                            </div>
                        </a>
                        <a target="_blank" href="https://www.behance.net/">
                            <div class="item">
                                <div class="logo">
                                    <img src="img/behance-favicon.png"> Behance
                                </div>
                                <div class="desc">
                                    系列设计作品开放平台
                                </div>
                            </div>
                        </a>
                        <a target="_blank" href="https://www.pinterest.com/">
                            <div class="item">
                                <div class="logo">
                                    <img src="img/pinterest-favicon.png"> Pinterest
                                </div>
                                <div class="desc">
                                    图片分享类的社交网站
                                </div>
                            </div>
                        </a>
                        <a target="_blank" href="http://www.zcool.com.cn/">
                            <div class="item">
                                <div class="logo">
                                    <img src="img/zcool-favicon.jpg"> 站酷
                                </div>
                                <div class="desc">
                                    打开站酷,发现更好的设计!
                                </div>
                            </div>
                        </a>
                        <a target="_blank" href="https://thefwa.com/">
                            <div class="item">
                                <div class="logo">
                                    <img src="img/thefwa-favicon.png"> FWA
                                </div>
                                <div class="desc">
                                    互动多媒体网站收录平台
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <!-- 学无止境 -->
                <div class="box">
                    <a href="#" name="study"></a>
                    <div class="sub-category">
                        <div><i class="iconfont icon-xuexi1"></i>学无止境</div>
                    </div>
                    <div>
                        <a target="_blank" href="https://www.w3cschool.cn/">
                            <div class="item">
                                <div class="no-logo">w3cschool</div>
                                <div class="desc">学编程，从W3cschool开始</div>
                            </div>
                        </a>
                        <a target="_blank" href="https://www.imooc.com/">
                            <div class="item">
                                <div class="no-logo">慕课网</div>
                                <div class="desc">程序员的梦工厂</div>
                            </div>
                        </a>
                        <a target="_blank" href="http://study.163.com/">
                            <div class="item">
                                <div class="no-logo">网易云课堂</div>
                                <div class="desc">网易公司研发的一款大型在线教育平台服务</div>
                            </div>
                        </a>
                    </div>
                </div>
                <!-- 网络运营 -->
                <div class="box">
                    <a href="" name="operation"></a>
                    <div class="sub-category">
                        <div><i class="iconfont icon-yunying"></i>网络运营</div>
                    </div>
                    <div>
                        <a target="_blank" href="https://mp.weixin.qq.com/">
                            <div class="item">
                                <div class="no-logo">微信公众平台</div>
                            </div>
                        </a>
                        <a target="_blank" href="https://www.toutiao.com/">
                            <div class="item">
                                <div class="no-logo">今日头条号</div>
                            </div>
                        </a>
                        <a target="_blank" href="https://www.jianshu.com/">
                            <div class="item">
                                <div class="no-logo">简书</div>
                            </div>
                        </a>
                        <a target="_blank" href="https://mp.dayu.com/">
                            <div class="item">
                                <div class="no-logo">UC大鱼号</div>
                            </div>
                        </a>
                        <a target="_blank" href="http://baijiahao.baidu.com/builder/author/register/index">
                            <div class="item">
                                <div class="no-logo">百度百家号</div>
                            </div>
                        </a>
                        <a target="_blank" href="https://www.weibo.com/login.php">
                            <div class="item">
                                <div class="no-logo">新浪微博</div>
                            </div>
                        </a>
                        <a target="_blank" href="https://om.qq.com/userAuth/index">
                            <div class="item">
                                <div class="no-logo">腾讯企鹅号</div>
                            </div>
                        </a>
                        <a target="_blank" href="https://www.douban.com/">
                            <div class="item">
                                <div class="no-logo">豆瓣</div>
                            </div>
                        </a>
                    </div>
                </div>
                <footer class="footer">
                    <div class="copyright">
                        <div>
                            Copyright © 2018- 2050
                            <a href="#">板栗云科技</a>
                        </div>
                    </div>
                </footer>
                <div id="fixedBar"><svg class="Zi Zi--BackToTop" title="回到顶部" fill="currentColor" viewBox="0 0 24 24" width="24" height="24"><path d="M16.036 19.59a1 1 0 0 1-.997.995H9.032a.996.996 0 0 1-.997-.996v-7.005H5.03c-1.1 0-1.36-.633-.578-1.416L11.33 4.29a1.003 1.003 0 0 1 1.412 0l6.878 6.88c.782.78.523 1.415-.58 1.415h-3.004v7.005z"></path></svg></div>
            </div>
        </section>
        <script src="js/jquery.js"></script>

        <script>
        var oMenu = document.getElementById('menu');
        var oLeftBar = document.getElementById('leftBar');
        var menuFrom = document.getElementById('menu-form');

        oMenu.onclick = function() {
            if (oLeftBar.offsetLeft == 0) {
                oLeftBar.style.left = -249 + 'px';
            }
            else {
                oLeftBar.style.left = 0;
            }
        }


        // 监听页面宽度变化
        window.onresize = function() {
            judgeWidth();
            // console.log(document.documentElement.clientWidth);
        };

        // 判断页面宽度
        function judgeWidth() {
            if (document.documentElement.clientWidth > 481) {
                oLeftBar.style.left = 0;
            } else {
                oLeftBar.style.left = -249 + 'px';
            }
        }


        var oNavItem = document.getElementById('navItem');
        var aA = oNavItem.getElementsByTagName('a');
        for (var i = 0; i < aA.length; i++) {
            aA[i].onclick = function() {
                for (var j = 0; j < aA.length; j++) {
                    aA[j].className = '';
                }
                this.className = 'active';
                if (oLeftBar.offsetLeft == 0) {
                    if (document.documentElement.clientWidth <= 481) {
                        oLeftBar.style.left = -249 + 'px';
                        menuFrom.checked = false;

                    }
                }
            }
        }


        $(window).scroll(function() {
            if($(window).scrollTop() >= 200){
                $('#fixedBar').fadeIn(300);
            }else{
                $('#fixedBar').fadeOut(300);
            }
        });
        $('#fixedBar').click(function() {
            $('html,body').animate({scrollTop:'0px'},800);
        })
        </script>
        <script src="https://cdn.bootcss.com/vue/2.5.16/vue.min.js"></script>
        <script src="https://cdn.bootcss.com/axios/0.18.0/axios.min.js"></script>
        <script src="{{ URL::asset('js/navi.js') }}"></script>
    </div>

</body>

</html>
