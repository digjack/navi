/**
 * Created by banli on 2018/5/17.
 */

new Vue({
    el: '#app',
    data: {
        'site_name':'板栗云导航',
        'sites': [],
        'save_site': []
    },
    methods: {
        listSites:function () {
            var vm = this;
            axios.get('/list?user_id=banli')
                .then(function (response) {
                    vm.sites = response.data;
                })
                .catch(function (error) {
                    console.log(error);
                });

        },
        saveSite: function () {
            axios.put('/site', this.save_site)
                .then(function (response) {
                    console.log(response);
                })
                .catch(function (error) {
                    console.log(error);
                });
        }
    },
    created: function (){
        this.listSites()
    }
})
