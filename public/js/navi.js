new Vue({
    el: '#app',
    data: {
        site_name:'为简收藏',
        sites: [],
        key_words: '',
        current_site: {},
        login_status: 0,
        user_id: '',
        deep_user_id: '',
        deep_user_password: '',
        user: {},
        class_option: [],
        regist_info :{},
        hot_ids: [],
        hot_sites: [],
        loading: false,
        suggestion: {},
    },
    methods: {
        listSites:function () {
            this.loading = true;
            if(this.key_words){
               var url = '/list?key_word=' + this.key_words;
            }else {
               var url = '/list';
            }

            var vm = this;
            axios.get(url)
                .then(function (response) {
                    vm.sites = response.data;
                    vm.InitClassOption();
                    vm.loading = false;
                })
                .catch(function (error) {
                    vm.loading = false;
                    console.log(error);
                });

        },
        SaveSite: function () {
            var vm = this;
            console.log(this.current_site);
            axios.put('/site', this.current_site)
                .then(function (response) {
                    vm.current_site = {};
                    vm.listSites();
                })
                .catch(function (error) {
                    console.log(error);
                });
        },
        CurrentSite: function (site) {
            this.current_site = site;
        },
        DeleteSite: function () {
            var vm = this;
            console.log (this.current_site);
            axios.delete('/site',{data: {id: this.current_site.id}})
                .then(function (response) {
                    vm.current_site = {};
                    vm.listSites();
                })
                .catch(function (error) {
                    console.log(error);
                });
        },
        Login: function () {
            this.loading = true;
            var vm = this;
            if(! this.user_id){
                this.user_id = "";
            }
            axios.post('/user', {user_id: this.user_id})
                .then(function (response) {
                    console.log(response);
                    vm.login_status = response.data.login_status;
                    if(vm.deep_user_id === vm.user_id.split(":",1)[0]){
                        vm.login_status = 2
                    }
                    if(vm.login_status === 2){
                        vm.deep_user_id = vm.user_id.split(":",1)[0];
                        vm.deep_user_password = vm.user_id.split(":",1)[1];
                    }
                    vm.loading = false;
                    vm.listSites();
                })
                .catch(function (error) {
                    vm.loading = false;
                    console.log(error);
                });

        },
        Logout:function () {
            var vm = this;
            axios.post('/logout')
                .then(function (response) {
                    console.log(response);
                    vm.login_status = 0;
                    vm.listSites();
                })
                .catch(function (error) {
                    console.log(error);
                });
        },
        Regist: function () {
            var vm = this;
            axios.put('/user', this.regist_info)
                .then(function (response) {
                    console.log(response);
                    vm.login_status = response.data.login_status;
                    window.location.href = window.location.pathname + window.location.search + window.location.hash;
                })
                .catch(function (error) {
                    console.log(error);
                });
        },
        SiteGen: function (url) {
            this.loading = true;
            var vm = this;
            axios.get('/sitegen?url=' + url)
                .then(function (response) {
                    vm.current_site.url = response.data.url;
                    vm.current_site.name = response.data.name;
                    vm.current_site.ico = response.data.ico;
                    vm.current_site.summary = response.data.summary;
                    $("#site_title").val(response.data.name);
                    $("#site_description").val(response.data.summary);
                    if(! $("#category-input").val()){
                        $("#category-input").val('默认');
                    }
                    vm.loading = false;
                })
                .catch(function (error) {
                    console.log(error);
                });
        },
        BindClass: function (category) {
            $("#category-input").val(category);
            this.current_site.class = category;
            console.log(this.current_site);
        },
        InitClassOption: function () {
            vm = this;
            this.class_option = [];
            this.sites.forEach(function (item)
            {
                console.log(item);
                vm.class_option.push(item.class);
            })
        },
        ClearCurrentSite: function () {
            this.current_site = {};
            // this.class_option = [];
        },
        AccessId: function (user_id) {
            this.user_id = user_id;
            this.Login();
        },
        ListHotIds: function () {
            vm = this;
            axios.get('/hotids')
                .then(function (response) {
                    vm.hot_ids = response.data;
                })
                .catch(function (error) {
                    console.log(error);
                });
        },
        ListHotSites: function () {
            vm = this;
            axios.get('/hotsites')
                .then(function (response) {
                    vm.hot_sites = response.data;
                })
                .catch(function (error) {
                    console.log(error);
                });
        },
        getQueryVariable: function (variable){
            var query = window.location.search.substring(1);
            var vars = query.split("&");
            for (var i=0;i<vars.length;i++) {
                var pair = vars[i].split("=");
                if(pair[0] == variable){return pair[1];}
            }
            return false;
        },
        initUser: function () {
            vm = this;
            axios.get('/user')
                .then(function (response) {
                    vm.user_id = response.data.user_id;
                    vm.login_status = response.data.login_status;
                    vm.listSites();
                })
                .catch(function (error) {
                    console.log(error);
                });
        },
        PostSuggestion: function () {
            this.loading = true;
            vm = this;
            axios.post('/advise', this.suggestion)
                .then(function (response) {
                    vm.loading = false;
                    console.log(response.data);
                })
                .catch(function (error) {
                    vm.loading = false;
                    console.log(error);
                });
        },
        Click:function (siteId) {
            axios.post('/click', {id:siteId})
                .then(function (response) {
                });
        },
        ImportSite: function () {
            var vm = this;
            this.current_site.user_id = this.deep_user_id;
            axios.put('/site', this.current_site)
                .then(function (response) {
                    vm.current_site = {};
                })
                .catch(function (error) {
                    console.log(error);
                });
        }
    },
    created: function (){
        var userId = this.getQueryVariable('user_id');
        if(userId){
            this.user_id = userId;
            this.Login();
        }else {
            this.initUser();
        }
        this.ListHotIds();
        this.ListHotSites();
    }
})
