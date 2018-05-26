new Vue({
    el: '#app',
    data: {
        site_name:'为简收藏夹',
        sites: [],
        key_words: '',
        current_site: {},
        login_status: 0,
        user_id: '',
        user: {},
        class_option: [],
        regist_info :{}
    },
    methods: {
        initUser: function () {
            var vm = this;
            axios.get('/user')
                .then(function (response) {
                    vm.login_status = response.data.login_status;
                    vm.user_id = response.data.user_id;
                    vm.listSites();
                })
                .catch(function (error) {
                    console.log(error);
                });
        },
        listSites:function () {
            console.log('cc');
            if(this.key_words){
               var url = '/list?key=' + this.key_words;
            }else {
               var url = '/list';
            }
            console.log('bb');

            var vm = this;
            axios.get(url)
                .then(function (response) {
                    vm.sites = response.data;
                    vm.InitClassOption();
                })
                .catch(function (error) {
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
            var vm = this;
            axios.post('/user', {user_id: this.user_id})
                .then(function (response) {
                    console.log(response);
                    vm.login_status = response.data.login_status;
                    vm.listSites();
                })
                .catch(function (error) {
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
            this.class_option.push('default');
            this.sites.forEach(function (item)
            {
                console.log(item);
                vm.class_option.push(item.class);
            })
        },
        ClearCurrentSite: function () {
            this.current_site = {};
            // this.class_option = [];
        }
    },
    created: function (){
        this.initUser();
    }
})
