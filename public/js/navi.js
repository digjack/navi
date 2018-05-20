new Vue({
    el: '#app',
    data: {
        'site_name':'板栗云导航',
        'sites': [],
        'current_site': {},
        'login_status': 0,
        'user_id': '',
        'user': {}
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
            var vm = this;
            axios.get('/list')
                .then(function (response) {
                    vm.sites = response.data;
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
            
        },
        SiteGen: function (url) {
            var vm = this;
            axios.get('/sitegen?url=' + url)
                .then(function (response) {
                    vm.current_site.url = response.data.url;
                    if( !vm.current_site.name ){
                        vm.current_site.name = response.data.name;
                    }
                    if(! vm.current_site.class ){
                        vm.current_site.class = (response.data.class)?response.data.class:'默认';
                    }
                    vm.current_site.url = response.data.url;
                    if(! vm.current_site.summary){
                        response.data.summary;
                    }
                    vm.current_site.ico = response.data.ico;
                    console.log(vm.current_site);
                })
                .catch(function (error) {
                    console.log(error);
                });
        }
        
    },
    created: function (){
        this.initUser();
    }
})
