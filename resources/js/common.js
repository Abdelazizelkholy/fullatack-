export default {
    data() {
        return {}
    },
    methods: {
        async callApi(method, url, dataObj) {
            try {
                return await axios({
                    method: method,
                    url: url,
                    data: dataObj
                });
            } catch (e) {
                return e.response
            }
        },
        i(des, title = "Hey") {
            this.$Notice.info({
                title: title,
                desc: des
            });
        },
        s(des, title = "great") {
            this.$Notice.success({
                title: title,
                desc: des
            });
        },
        w(des, title = "oops") {
            this.$Notice.warning({
                title: title,
                desc: des
            });
        },
        e(des, title = "OopS!") {
            this.$Notice.error({
                title: title,
                desc: des
            });
        },
        swr(des = 'something went wrong , please try again', title = "OopS!") {
            this.$Notice.error({
                title: title,
                desc: des
            });
        }
    }
}