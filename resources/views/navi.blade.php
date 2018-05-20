<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>板栗云导航</title>

    <link rel="shortcut icon" href="favcion.ico" />
    <link rel="stylesheet" href=" css/iconfont.css">
    <link rel="stylesheet" href="css/style.css">
    <link href="https://cdn.bootcss.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/simple.css">
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet">

</head>

<body>
    <div class="container" id="app">
        <aside class="left-bar" id="leftBar">
            <div class="title">
                <p>@{{site_name}}</p>
            </div>
            <nav class="nav">
                <div class="item active"><a href="">添加地址</a><i class="line"></i></div>

                <ul  class="nav-item" id="navItem">
                    <li v-for="(site_set, index) in sites"  >
                        <a v-bind:href="'#' + index" class="active"><i class="iconfont"></i>@{{ site_set.class }}</a>
                    </li>
                </ul>
                <div class="item comment"><a target="_blank" href="#"><i class="iconfont icon-liuyan"></i>留言</a></div>
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
                <div class="input-group id-input">
                    <input type="text" class="form-control" v-model="user_id" placeholder="用户Id:密码(如 xiaodong:123)" aria-label="Recipient's username" aria-describedby="basic-addon2">
                    <div class="input-group-append">
                        <button v-if="login_status == 0 || login_status == 1" class="btn btn-outline-secondary" type="button" @click="Login">登录</button>
                        <button v-if="login_status == 2 || login_status == 1" class="btn btn-outline-secondary" type="button" @click="Logout">注销</button>
                        <button v-if="login_status == 0" class="btn btn-outline-secondary" type="button" @click="Regist">注册</button>
                        <button v-if="login_status == 2" class="btn btn-outline-secondary" data-toggle="modal" data-target="#EditModal" type="button">添加网站</button>
                    </div>
                </div>
                <div v-for="(site_set, index) in sites" class="box">
                    <a href="#" v-bind:name="index"></a>
                    <div class="sub-category">
                        <div><i class="iconfont"></i>@{{ site_set.class }}</div>
                    </div>
                    <div v-for="site in site_set.list">
                        <a target="_blank" v-bind:href="site.url">
                            <div class="item">
                                <div class="logo"><img v-bind:src="site.ico"> @{{ site.name }}</div>
                                <div class="desc">@{{ site.summary }}</div>
                                <a v-if="login_status == 2" id="show-modal" @click="CurrentSite(site)"><i class="icon-edit" data-toggle="modal" data-target="#EditModal"></i></a>
                                <a v-if="login_status == 2" id="show-modal" @click="CurrentSite(site)"><i class="icon-trash" data-toggle="modal" data-target="#DeleteModal"></i></a>
                            </div>
                        </a>
                    </div>
                </div>

{{--修改网站编辑框--}}
            <div class="modal fade" id="EditModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">网站编辑</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form>
                                <div class="form-group">
                                    <label for="recipient-name" class="col-form-label">地址: </label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" v-model="current_site.url">
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-secondary" type="button" @click="SiteGen(current_site.url)">自动生成</button>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="recipient-name" class="col-form-label">网站: </label>
                                    <input type="text" class="form-control" v-model="current_site.name">
                                </div>
                                <div class="form-group">
                                    <label for="recipient-name" class="col-form-label">分类: </label>
                                    <input type="text" class="form-control"  v-model="current_site.class">
                                </div>
                                <div class="form-group">
                                    <label for="message-text" class="col-form-label" > 概要：</label>
                                    <textarea class="form-control" v-model="current_site.summary"></textarea>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">取消</button>
                            <button type="button" class="btn btn-primary" @click="SaveSite()"  data-dismiss="modal">确认</button>
                        </div>
                    </div>
                </div>
            </div>


                {{--删除确认--}}
                <div class="modal fade" id="DeleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">确认</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <label>请确认是否删除网站？</label>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">取消</button>
                                <button type="button" class="btn btn-primary" @click="DeleteSite()" data-dismiss="modal">确认</button>
                            </div>
                        </div>
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
        <script src="https://cdn.bootcss.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
        <script src="{{ URL::asset('js/simple.js') }}"></script>
        <script src="https://cdn.bootcss.com/vue/2.5.16/vue.min.js"></script>
        <script src="https://cdn.bootcss.com/axios/0.18.0/axios.min.js"></script>
        <script src="{{ URL::asset('js/navi.js') }}"></script>
    </div>

</body>

</html>
