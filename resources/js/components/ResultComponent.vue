<template>
    <div>
        <div class="row bg-white p-5">
            <div class="col-12 text-center" v-if="jams_size != 0">
                <p class="font-size-26 font-weight-normal text-danger mb-2">
                    Похоже разлить не получилось(
                </p>
                <p class="font-size-16 font-weight-normal text-danger mb-2">
                    Не хватило банок.
                </p>
                <hr>
            </div>
            <div class="col-12 text-center" v-if="jams_size == 0">
                <p class="font-size-26 font-weight-normal text-success mb-2">
                    Варенье разлито успешно
                </p>
            </div>
            <div class="col-lg-2 col-6" v-for="item in this.total">
                <div class="p-4 text-center">
                    <img class="h-auto" style="width: 60px;" v-if="item.jar.size >= 1000 && item.jar.size != null" :src="storage_url + '/image/large.svg'" alt="">
                    <img class="h-auto" style="width: 60px;" v-if="item.jar.size < 1000 && item.jar.size >= 500 && item.jar.size != null" :src="storage_url + '/image/medium.svg'" alt="">
                    <img class="h-auto" style="width: 60px;" v-if="item.jar.size < 500" :src="storage_url + '/image/small.svg'" alt="">
                </div>
                <div class="form-group">
                  <p class="font-size-14 text-center font-weight-bold mb-1">Название: {{item.jar.name}}</p>
                  <p class="font-size-12 text-center font-weight-normal mb-1">Обьем: {{item.jar.size}} грамм</p>
                  <p class="font-size-12 text-center font-weight-normal mb-1">Тип: {{item.jam_type}}</p>
                  <p class="font-size-12 text-center font-weight-normal mb-1">Заполнено: {{item.size}} грамм</p>
                </div>
            </div>
            <div class="col-12">
                <hr>
            </div>
            <div class="col-12">
                <p class="font-size-20 font-weight-normal text-danger">Варенья осталось: {{jams_size}} грамм</p>
            </div>
            <div class="col-lg-2 col-6" v-for="jam in jams">
                <div class="p-4 text-center">
                    <img class="h-auto" style="width: 60px;" :src="storage_url + '/image/jam.svg'" alt="">
                </div>
                <div class="form-group">
                    <p class="font-size-14 text-center font-weight-bold mb-1">Название: {{jam.name}}</p>
                    <p class="font-size-12 text-center font-weight-normal mb-1">Обьем: {{jam.nominal}} грамм</p>
                    <p class="font-size-12 text-center font-weight-normal mb-1">Остаток: {{jam.size}} грамм</p>
                    <!--<p class="font-size-12 text-center font-weight-normal mb-1">Тип: {{item.jam_type}}</p>-->
                    <!--<p class="font-size-12 text-center font-weight-normal mb-1">Заполнено: {{item.size}} грамм</p>-->
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "ResultComponent",
        data: function () {
            return {
                storage_url: window.location.origin,
                jams: null,
                jars: null,
                total: [],
                jams_size: null,
            }
        },

        mounted() {
            this.load();
            this.result();
        },

        methods:{
            load: function() {
                this.jams = this.$store.state.jams;
                this.jars = this.$store.state.jars;
                this.total = [];
                this.jams.forEach(function callback(item) {
                    item['nominal'] = item.size;
                });
            },
            
            result: function () {
                var jams_size = 0;
                var jars_size = 0;
                var jams = this.jams;

                this.jams.forEach(function callback(item) {
                    jams_size = jams_size + parseInt(item.size);
                });
                this.jars.forEach(function callback(item) {
                    jars_size = jars_size + parseInt(item.size);
                });

                for (var i = 0; i < this.jams.length; i++ )
                {
                    if (this.jars.length == 0)
                    {
                        break;
                    }

                    var check = 0;
                    do {
                        check = 0;
                        var closest = this.jars.reduce(function (prev, curr) {
                            return (Math.abs(curr.size - jams[i].size) <= Math.abs(prev.size - jams[i].size) && Math.abs(curr.size - jams[i].size) >= 0 ? (curr.size >= prev.size ? curr : prev): prev);
                        });
                        this.total.push({
                            jar: closest,
                            jam_type: jams[i].name,
                            size: (jams[i].size >= closest.size ? closest.size : jams[i].size)
                        });
                        // console.log((parseInt(jams[i].size) >= closest.size ? closest.size : jams[i].size));
                        jams_size = jams_size - (parseInt(jams[i].size) >= closest.size ? closest.size : jams[i].size);
                        // console.log(jams_size);
                        jams[i].size = jams[i].size - (jams[i].size >= closest.size ? closest.size : jams[i].size);
                        this.jars.splice(this.jars.indexOf(closest),1);

                        if (this.jars.length == 0 || jams[i].size == 0)
                        {
                            check = 1;
                        }
                    } while (check < 1)

                }
                this.jams_size = jams_size;
            }
        }
    }
</script>

<style scoped>

</style>